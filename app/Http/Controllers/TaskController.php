<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Libraries\Captcha\CaptchaFactory;
class TaskController extends Controller
{
    //

    public function home()
    {

        $captaha_obj =CaptchaFactory::Captcha('invertedword');
        $image = $captaha_obj->getCaptcha();
        $captaha_value = $captaha_obj->captchaValue();
       // $size = getimagesizefromstring($image['results']);
       //  return  response($image, 200, [
       //      'Content-Type' =>'image/png',
       //  ]);
        return $image;
        return 'Hello, World!';
    }
}
