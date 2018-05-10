<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "post";

    protected $fillable = [
        "title","summary","content",
        "author_id","author_name","created_at","updated_at","deleted_at",
        "category","is_top","is_good","reply_count","visit_count"
    ];
}