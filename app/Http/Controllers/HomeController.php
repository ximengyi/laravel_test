<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Libraries\Captcha;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function session()
    {

        $id = session_id();
        echo $id;
        echo 1222;die;
        return  'fasdf';
    }

    public function getName()
    {

        return  'zhangsan';
    }

}
