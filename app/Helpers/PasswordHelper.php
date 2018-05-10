<?php

namespace App\Helpers;


class PasswordHelper
{
    public static function encrypt($rawPassword, $salt)
    {
        return password_hash(md5($rawPassword.$salt),PASSWORD_BCRYPT );
    }
    public static function verify($rawPassword, $salt, $hashedPassword)
    {
        $secondPassword = md5($rawPassword.$salt);
        return password_verify($secondPassword, $hashedPassword);
    }

    public static function genSalt($length = 12)
    {
        $alnum = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";//提高性能，不用动态生成，下同
        $len = 62;
        $str = "";
        for ($i=0;$i<$length;$i++){
            $str .= $alnum{mt_rand(0,$len)};
        }
        return $str;
    }

}