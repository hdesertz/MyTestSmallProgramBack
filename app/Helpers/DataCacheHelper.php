<?php

namespace App\Helpers;
use App\Repository\Post as PostRepo;

class DataCacheHelper
{
    /**
     * @var $redis \Predis\Client
     */
    protected static $redis = null;
    public static $customCategoryList =  [
        ["en_name"=>"all","name"=>"全部"],
        ["en_name"=>"good","name"=>"精华"],
        // ["en_name"=>"hot","name"=>"热门"],
    ];
    public static function redis()
    {
        if(self::$redis == null){
            self::$redis = app("redis");
        }
        return self::$redis;
    }
    public static function getCategoryList(){

        $key = "postCategoryList";
        if(empty($rawContent = self::redis()->get($key))) {
            $categoryList = PostRepo::getAllCategory();

            $cateKvList = [];
            foreach ($categoryList as $cate){
                $cateKvList[] = ["en_name"=>$cate["en_name"], "name"=>$cate["name"]];
            }
            self::redis()->set($key,
                json_encode($cateKvList,JSON_UNESCAPED_UNICODE),"ex",30*24*3600);
            return $cateKvList;
        }
        $dbCateList =  json_decode($rawContent, true);
        return $dbCateList;
    }

    public static function combineCategoryList()
    {
        return array_merge(DataCacheHelper::$customCategoryList, DataCacheHelper::getCategoryList());
    }
}