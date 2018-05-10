<?php

namespace App\Helpers;


class TokenHelper
{
    public static $tokenExpire = 3600*24; //seconds

    /**
     * @param $token string
     * @param $value array
     * @return mixed
     */
    public static function set($token,$value)
    {
        $tokenKey = "token:".$token;
        /**
         * @var $redis \Illuminate\Redis\Connections\Connection
         */
        $redis = app("redis");
        return $redis->set($tokenKey,json_encode($value), 'ex',self::$tokenExpire);
    }

    /**
     * @param $token string
     * @return array|null
     */
    public static function get($token)
    {
        $tokenKey = "token:".$token;
        /**
         * @var $redis \Illuminate\Redis\Connections\Connection
         */
        $redis = app("redis");
        $redisRawContent =  $redis->get($tokenKey);
        if(empty($redisRawContent)){
            return null;
        }
        return json_decode($redisRawContent, true);
    }
}