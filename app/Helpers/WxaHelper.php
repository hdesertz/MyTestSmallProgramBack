<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\ParameterBag;

// wei xin app
class WxaHelper
{
    public static $OK = 0;
    public static $IllegalAesKey = -41001;
    public static $IllegalIv = -41002;
    public static $IllegalBuffer = -41003;
    public static $DecodeBase64Error = -41004;

    /**
     * @see <https://developers.weixin.qq.com/miniprogram/dev/api/api-login.html#wxloginobject>
     * @param $code
     * @return ParameterBag|int
     */
    public static function jscode2session($code)
    {
        $wxaConf = config("wxa");
        $url = sprintf("https://api.weixin.qq.com/sns/jscode2session?".
            "appid=%s&secret=%s&js_code=%s&grant_type=authorization_code",
            $wxaConf["appId"],$wxaConf["appSecret"],$code);
        $gzClient = new Client();
        $response = $gzClient->get($url);
        if ($response ->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);
            if(!isset($contentArray["openid"]) || !isset($contentArray["session_key"])) {
                logger("raw jscode2session", [$content]);
                return -1;
            }
            if(empty($contentArray['unionid'])){
                $contentArray['unionid'] = null;
            }
            return new ParameterBag($contentArray);
        }
        return -2;
    }
    public static function genToken()
    {
        return md5(microtime().uniqid());
    }

    /**
     * 检验数据的真实性，并且获取解密后的明文.
     * @param $sessionKey string jscode2session session_key
     * @param $encryptedData string 加密的用户数据
     * @param $iv string 与用户数据一同返回的初始向量
     * @param $data string 解密后的原文
     *
     * @return int 成功0，失败返回对应的错误码
     */
    public static function decryptData($sessionKey,$encryptedData, $iv, &$data )
    {
        $wxaConf = config("wxa");
        if (strlen($sessionKey) != 24) {
            return self::$IllegalAesKey;
        }
        $aesKey=base64_decode($sessionKey);

        if (strlen($iv) != 24) {
            return self::$IllegalIv;
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $dataObj=json_decode( $result );
        if( $dataObj  == NULL )
        {
            return self::$IllegalBuffer;
        }
        if( $dataObj->watermark->appid != $wxaConf["appId"] )
        {
            return self::$IllegalBuffer;
        }
        $data = $result;
        return self::$OK;
    }

}