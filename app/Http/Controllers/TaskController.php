<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\Register;
use App\Libraries\Captcha\CaptchaFactory;
use Illuminate\Support\Facades\Mail;
class TaskController extends Controller
{
    //

    public function home()
    {

        $captaha_obj =CaptchaFactory::Captcha('invertedword');
        $image = $captaha_obj->getCaptcha();
        $captaha_value = $captaha_obj->captchaValue();
        return  $this->respond($image,'image');
    }

    public function send(Request $request)
    {


       $sendUser =  $request->input('email','laomeng820@163.com');

       $res =  Mail::to('laomeng820@163.com')->send(new Register());
       
       if($res){
           
           echo '发送成功';
       }

    }
}


// app_path()
//
// app_path函数返回app目录的绝对路径：
// $path = app_path();
//
// 你还可以使用app_path函数为相对于app目录的给定文件生成绝对路径：
// $path = app_path('Http/Controllers/Controller.php');
//
// base_path()
//
// base_path函数返回项目根目录的绝对路径：
// $path = base_path();
//
// 你还可以使用base_path函数为相对于应用目录的给定文件生成绝对路径：
// $path = base_path('vendor/bin');
//
// config_path()
//
// config_path函数返回应用配置目录的绝对路径：
// $path = config_path();
//
// database_path()
//
// database_path函数返回应用数据库目录的绝对路径：
// $path = database_path();
//
// public_path()
//
// public_path函数返回public目录的绝对路径：
// $path = public_path();
//
// storage_path()
//
// storage_path函数返回storage目录的绝对路径：
// $path = storage_path();
//
// 还可以使用storage_path函数生成相对于storage目录的给定文件的绝对路径：
// $path = storage_path('app/file.txt');
//
// 获取laravel项目的路径的内置帮助函数基本都在这了