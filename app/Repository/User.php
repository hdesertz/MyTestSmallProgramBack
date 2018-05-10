<?php

namespace App\Repository;

use App\Helpers\PasswordHelper;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\ParameterBag;

class User extends Base
{
    public static function getUserByOpenId($openId)
    {
        return UserModel::query()->where(["openid"=>$openId])->first();
    }
    public static function createUser(ParameterBag $parameterBag)
    {
        return (new UserModel())->fill($parameterBag->all())->save();
    }

    public static function register($userId, $userInfo, $account,$password)
    {
        $user = (new UserModel())->newQuery()->find($userId);
        $userInfoArray = json_decode($userInfo,true);
        $salt = PasswordHelper::genSalt();
        $hashedPassword = PasswordHelper::encrypt($password,$salt);
        $userData = [
            "wx_user_info"=>$userInfo,
            "name"=>$userInfoArray["nickName"],
            "nickname"=>$userInfoArray["nickName"],
            "avatar_url"=>$userInfoArray["avatarUrl"],
            "account"=>$account,
            "hashed_password"=>$hashedPassword,
            "salt"=>$salt
        ];
        return $user->fill($userData)->save();
    }
    public static function login($account, $password)
    {
        $user = DB::table("user")
            ->where(["account"=>$account])->first();
        if(empty($user)){
            return null;
        }
        if(!PasswordHelper::verify($password,$user->salt,$user->hashed_password))
        {
            return null;
        }
        return $user;
    }
}