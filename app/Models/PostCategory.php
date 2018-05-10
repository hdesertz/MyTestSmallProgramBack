<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    protected $table = "post_category";

    protected $fillable = ["name","en_name","description","sort"];
}