<?php

namespace App\Http\Controllers\api;

use App\Helpers\CommonHelper;
use App\Helpers\TokenHelper;
use App\Helpers\WxaHelper;
use App\Http\Controllers\Controller;
use App\Repository\User as UserRepo;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\ParameterBag;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $code = $request->input("code");
        if (empty($code)) {
            return CommonHelper::jsonTips("",-1,2001);
        }
        $content = WxaHelper::jscode2session($code);
        if (!($content instanceof ParameterBag)) {
            return CommonHelper::jsonTips("",-1,2002);
        }
        $user = UserRepo::getUserByOpenId($content->get("openid"));
        if (empty($user)) {
            //创建用户
            $createUserResult = UserRepo::createUser($content);
            if(!$createUserResult){
                logger("create user error", [$createUserResult, $content]);
                return CommonHelper::jsonTips("",-1,2003);
            }
            $user = UserRepo::getUserByOpenId($content->get("openid"));
        }
        $token = WxaHelper::genToken();
        $tokenContent = $content->all();
        $tokenContent["user_id"] = $user->id;

        TokenHelper::set($token, $tokenContent);
        $userInfo = json_decode($user->wx_user_info, true);
        $userInfo["hasRegister"] = !empty($user->account) && !empty($user->hashed_password);

        return CommonHelper::jsonTips(["token" => $token, "userInfo" => $userInfo]);
    }

    //注意：使用logger只记录服务端错误
    public function register(Request $request)
    {
        $account = $request->input("account");
        if (!preg_match("/^[a-z0-9_]{5,30}/", $account)) {//5-30
            return CommonHelper::jsonTips("",-1,2014);
        }
        $password = $request->input("password");
        $pwdLength = strlen($password);
        if ($pwdLength > 20 || $pwdLength < 8) { //8-20
            return CommonHelper::jsonTips("",-1,2015);
        }
        $wxUserInfo = $request->input("userInfo");
        $userInfo = json_decode($wxUserInfo, true);

        $tokenBody = app()->offsetGet("token");//仅限登录的接口
        if (empty($tokenBody)) {
            return CommonHelper::jsonTips("",-1,2013);
        }
        $errorCode = WxaHelper::decryptData($tokenBody["session_key"], $userInfo["encryptedData"], $userInfo["iv"], $data);
        if ($errorCode != WxaHelper::$OK) {
            $mt = microtime(true);
            logger("WxaHelper::decryptData$mt", [$errorCode,$tokenBody, $userInfo, $data]);
            return CommonHelper::jsonTips("",-1,2011);
        }
        if (!UserRepo::register($tokenBody["user_id"], $data, $account, $password)) {
            logger("UserRepo::register", [$tokenBody, $userInfo, $data, $account, $password]);
            return CommonHelper::jsonTips("",-1,2012);
        }
        return CommonHelper::jsonTips();
    }

}