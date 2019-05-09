<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Libraries\Captcha;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

       // $this->middleware('auth');
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

    public function ses()
    {
        Session::put('test','justatest');
       $result =  Session::get('test');
        return  $result;
    }

    public function getName()
    {

        return 1111;
       $result =  Session::get('test');
        return  $result;
    }

}
