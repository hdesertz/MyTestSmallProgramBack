<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Helpers\DataCacheHelper;
use Illuminate\Http\Request;
use App\Repository\User as UserRepo;
use App\Repository\Post as PostRepo;
use Parsedown;
class HomeController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct();
    }

    public function index()
    {
        if(session("hasLogin")){
            return redirect("web/create");
        }
        return view('home.index');
    }

    public function create()
    {
        if(!session("hasLogin")){
            return redirect(route("home"));
        }
        return view("home.create",["categoryList"=>DataCacheHelper::getCategoryList()]);
    }

    public function login(Request $request)
    {
        $account = $request->input("account");
        $password = $request->input("password");

        if(empty($account)){
           return  CommonHelper::jsonTips("",-1,10001);
        }
        if( empty($password)){
            return  CommonHelper::jsonTips("",-1,10002);
        }
        $verifyCode = $request->input("verifyCode");
        $savedVCode = session("verifyCode");
        app("session")->remove("verifyCode");

        if(empty($verifyCode)|| strtolower($verifyCode) !== strtolower($savedVCode))
        {
            return  CommonHelper::jsonTips("",-1,10003);
        }
        $user = UserRepo::login($account,$password);
        if(empty($user)){
            return  CommonHelper::jsonTips("",-1,10004);
        }

        app("session")->put("hasLogin", true);
        app("session")->put("user",$user);

        return CommonHelper::jsonTips();
    }

    public function createPost(Request $request)
    {
        if(!$request->session()->get("hasLogin") ||
            !$request->session()->get("user"))
        {
            return redirect(route("home"));
        }
        if($request->session()->get("createPostLock")){
            return CommonHelper::jsonTips("",-1,10022);
        }
        $title = $request->input("title");
        $titleLength = strlen($title);
        if($titleLength>90 || $titleLength<10){
            return CommonHelper::jsonTips("",-1,10021);
        }
        $category = $request->input("category");
        $categoryList = DataCacheHelper::getCategoryList();
        if(!in_array($category, array_column($categoryList,"en_name"), true))
        {
            $request->session()->put("createPostLock",true);
            return CommonHelper::jsonTips("",-1,10023);
        }
        $content = $request->input("content");
        if(empty($content)){
            return CommonHelper::jsonTips("",-1,10024);

        }
        $summary = $request->input("summary");
        if(strlen($summary)>1000){
            return CommonHelper::jsonTips("",-1,10025);
        }
        $user = $request->session()->get("user");
        $mdParser = new Parsedown;
        $mdParser->setSafeMode(true);
        $postId = PostRepo::createPost([
            "title"=>$title,
            "summary"=>$summary,
            "content"=>$content,
            "content_html"=> $mdParser->text($content),
            "category"=>$category,
            "author_id"=>$user->id,
            "author_name"=>$user->name
        ]);

        return CommonHelper::jsonTips($postId);
    }

    public function post($id)
    {
        $post = PostRepo::getPostById($id);
        if(empty($post)){
            return abort(404);
        }
        return view("home.post", ['post'=>$post]);
    }
}
