<?php

namespace App\Dict;

class ErrorCode
{
    public static $map = [
        0 => [
            "msg"=>"success",
            "tips"=>"成功"
        ],
        //api:1001-10000
        2001 => [
            "msg"=>"code empty",
            "tips"=>"微信code为空"
        ],
        2002 => [
            "msg"=>"code invalid",
            "tips"=>"微信code无效"
        ],
        2003 =>[
            "msg"=>"create user error",
            "tips"=>"用户信息生成出错",
        ],

        2011 =>[
            "msg"=>"weChat message decrypt error",
            "tips"=>"微信解密消息体错误"
        ],
        2012 =>[
            "msg"=>"save error",
            "tips"=>"数据保存出错"
        ],
        2013 =>[
            "msg"=>"token invalid",
            "tips"=>"会话失效"
        ],
        2014 =>[
            "msg"=>"account invalid",
            "tips"=>"账号无效"
        ],
        2015 =>[
            "msg"=>"password invalid",
            "tips"=>"密码无效"
        ],

        3011=>[
            "msg"=>"category not exists",
            "tips"=>"分类不存在"
        ],
        3031=>[
            "msg"=>"token invalid",
            "tips"=>"会话失效",
        ],

        //web:10001-20000
        10001=>[
            "msg"=>"account invalid",
            "tips"=>"账号无效"
        ],
        10002=>[
            "msg"=>"password invalid",
            "tips"=>"密码无效"
        ],
        10003=>[
            "msg"=>"verifyCode invalid",
            "tips"=>"验证码无效"
        ],
        10004=>[
            "msg"=>"account&password not matched",
            "tips"=>"账号与密码不匹配"
        ],
        10021=>[
            "msg"=>"title limit 10-90 chars",
            "tips"=>"标题限10到90个字符"
        ],
        10022=>[
            "msg"=>"abuse invoke api",
            "tips"=>"请勿滥用接口，已被禁止发文章"
        ],
        10023=>[
            "msg"=>"abuse invoke api",
            "tips"=>"请勿滥用接口，已被禁止发文章"
        ],
        10024=>[
            "msg"=>"content empty",
            "tips"=>"内容为空"
        ],
        10025=>[
            "msg"=>"summary succeed 1000 chars",
            "tips"=>"摘要超过1000个字符"
        ],

    ];
}