<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Helpers\CommonHelper;
use App\Helpers\DataCacheHelper;
use App\Repository\Post as PostRepo;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getCategoryList()
    {
        return CommonHelper::jsonTips( DataCacheHelper::combineCategoryList());
    }

    public function getPosts(Request $request)
    {
        $page = $request->input("page");//从1开始
        $pageSize = (int)$request->input("pageSize", 10);
        if ($pageSize < 1 || $pageSize > 20) {
            $pageSize = 10;
        }
        $category = $request->input("category");
        $categoryList = DataCacheHelper::combineCategoryList();
        $categoryKv = array_column($categoryList, "name", "en_name");
        if (!in_array($category, array_keys($categoryKv), true)) {
            return CommonHelper::jsonTips("",-1,3011);
        }
        $posts = PostRepo::getPostsPageByCate($page, $pageSize, $category);
        foreach ($posts as &$post) {
            unset($post->content);//删除 content 字段，影响接口性能
        }
        return CommonHelper::jsonTips($posts);
    }

    public function getPost(Request $request)
    {
        $id = (int)$request->input("id");
        $tokenBody = app()->offsetGet("token");//仅限登录的接口
        if (empty($tokenBody["user_id"])) {
            $userId = null;
        } else {
            $userId = $tokenBody["user_id"];
        }
        //更新访问次数
        PostRepo::incrementField($id, "visit_count");
        $post = PostRepo::getPostById($id, $userId);
        if(empty($post)){
            return abort(404);
        }
        if (empty($post->uc_id)) {
            $post->uc_id = null;//保持结构一致
        }
        $categoryKv = array_column(DataCacheHelper::getCategoryList(),"name","en_name");
        $post->category_name = $categoryKv[$post->category];

        return CommonHelper::jsonTips($post);
    }

    public function toggleCollectPost(Request $request)
    {
        $id = (int)$request->input("id");
        $tokenBody = app()->offsetGet("token");//仅限登录的接口

        if (empty($tokenBody["user_id"])) {
            $userId = null;
        } else {
            $userId = $tokenBody["user_id"];
        }
        if (empty($userId)) {
            return CommonHelper::jsonTips("",-1,3011);
        }
        $collectResult = PostRepo::togglePostCollection($id, $userId);
        return CommonHelper::jsonTips(0, $collectResult);
    }
}