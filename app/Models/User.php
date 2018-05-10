<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use SoftDeletes;
    protected $table = "user";

    protected $fillable = [
        "name","nickname","gender","avatar_url","created_at","updated_at",
        "deleted_at","last_login_at","banned_at","account","hashed_password","salt",
        "wx_user_info","openid","session_key","unionid","mobile","country_code","email",
        "credit","role_name","signature"
    ];
}