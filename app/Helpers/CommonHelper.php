<?php

namespace App\Helpers;

use App\Dict\ErrorCode;

class CommonHelper
{
    public static function jsonTips($data = "",$code = 0,  $errorCode = 0)
    {
        if($code === 0){
            $body = [
                "code"=>$code,
                "msg"=>ErrorCode::$map[$errorCode]["msg"],
                "tips"=>ErrorCode::$map[$errorCode]["tips"],
                "data"=>$data
            ];
        } else {
            $body = [
                "code"=>$code,
                "msg"=>"{$errorCode}:".ErrorCode::$map[$errorCode]["msg"],
                "tips"=>ErrorCode::$map[$errorCode]["tips"],
                "data"=>$data
            ];
        }
        return response(json_encode($body, JSON_UNESCAPED_UNICODE),
            200,["content-type"=>"application/json"]);
    }
}