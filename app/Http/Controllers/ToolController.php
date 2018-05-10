<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use Gregwar\Captcha\CaptchaBuilder;
class ToolController extends Controller
{
    public function verifyCode()
    {
        $builder = new CaptchaBuilder;
        $builder->setIgnoreAllEffects(true);//明显提高性能
        $builder->setDistortion(false);
        $builder->build();
        $phrase = $builder->getPhrase();
        app("session")->put("verifyCode",$phrase);
        logger("verifyCode1",[$phrase]);
        return CommonHelper::jsonTips($builder->inline(20));
    }
}