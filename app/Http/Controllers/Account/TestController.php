<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    //

    public function home()
    {
        return 'success, !';
    }
    public function index()
    {
        return 'success, index!';
    }
}
