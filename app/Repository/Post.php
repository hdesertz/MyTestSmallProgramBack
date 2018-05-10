<?php

namespace App\Repository;


use App\Helpers\DataCacheHelper;
use App\Models\PostCategory;
use Illuminate\Support\Facades\DB;

class Post
{
    public static function getAllCategory()
    {
        return (new PostCategory())->newQuery()
            ->orderBy("sort","desc")
            ->orderBy("en_name","desc")
            ->get()->toArray();
    }

    public static function getPostsPageByCate($page,$pageSize,$category)
    {
        $postQuery = DB::table("post")
            ->leftJoin("user","post.author_id", "=","user.id")
            ->whereNull("post.deleted_at")
            ->select("post.*","user.avatar_url");

        $dbCateList = DataCacheHelper::getCategoryList();

        if($category === "good"){//精选
            $postQuery = $postQuery->where("post.is_good", "=",1);
        } elseif(in_array($category, array_column($dbCateList,"en_name"),true)){
            $postQuery = $postQuery->where("post.category","=", $category);
        }
        $postQuery =  $postQuery->skip(($page-1)*$pageSize)->take($pageSize)
            ->orderBy("id","desc");
        return $postQuery
            ->get();
    }
    public static function getPostById($id,$userId = null)
    {
        $query = DB::table("post");

        $query = $query->leftJoin("user","post.author_id","=","user.id")
            ->addSelect("user.name AS author_name","user.avatar_url AS author_avatar_url");
        if(!empty($userId)){
            $query = $query->leftJoin("user_collection", function ($join) use($userId){
                $join->on('post.id', '=', 'user_collection.post_id')
                    ->on("user_collection.user_id","=",DB::raw($userId));
            })
            ->addSelect("user_collection.post_id AS uc_id");
        }
        $query = $query->whereNull("post.deleted_at")
            ->where("post.id","=",$id)
            ->addSelect("post.*");
        return $query->first();
    }
    public static function incrementField($id,$field)
    {
        if(!in_array($field, ["visit_count","reply_count"], true)){
            return false;
        }
        return DB::table("post")->where(["id"=>$id])
            ->increment($field);
    }
    public static function togglePostCollection($id,$userId)
    {
        $query = DB::table("user_collection")
            ->where(["post_id"=>$id, "user_id"=>$userId,]);
        $exists = $query->exists();
        if($exists){
             $query->delete();
             return false;
        } else {
             DB::table("user_collection")
                ->insert(["post_id"=>$id, "user_id"=>$userId,"created_at"=>date("Y-m-d H:i:s")]);
             return true;
        }
    }
    public static function createPost($attr)
    {
        $attr['created_at'] = date("Y-m-d H:i:s");
        return DB::table("post")->insertGetId($attr);
    }
}