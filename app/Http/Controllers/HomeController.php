<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use TusPhp\Tus\Server;
use TusPhp\Tus\Client;


use TusPhp\Exception\TusException;
use TusPhp\Exception\FileException;
use TusPhp\Exception\ConnectionException;

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

    public function upLoadFileServer()
    {

        $uploadPath = public_path();
        $server   = new \TusPhp\Tus\Server();
        $server->setUploadDir($uploadPath);

        $response = $server->serve();


        $response->send();

        exit(0); //

    }



    public function uploadForm()
    {

        return view('index');
    }

    public function client()
    {

        $client = new \TusPhp\Tus\Client('http://apitemplaravel.test/server/');
        // Alert: Sanitize all inputs pr operly in production code
        if ( ! empty($_FILES)) {
            $fileMeta  = $_FILES['tus_file'];
            $uploadKey = hash_file('md5', $fileMeta['tmp_name']);
            try {
                $client->setKey($uploadKey)->file($fileMeta['tmp_name'], 'chunk_a');
                // Upload 50MB starting from 10MB
                $bytesUploaded = $client->seek(10000000)->upload(50000000);
                $partialKey1   = $client->getKey();
                $checksum      = $client->getChecksum();
                // Upload first 10MB
                $bytesUploaded = $client->setFileName('chunk_b')->seek(0)->upload(10000000);
                $partialKey2   = $client->getKey();
                // Upload remaining bytes starting from 60,000,000 bytes (60MB => 50000000 + 10000000)
                $bytesUploaded = $client->setFileName('chunk_c')->seek(60000000)->upload();
                $partialKey3   = $client->getKey();
                $client->setFileName($fileMeta['name'])->concat($uploadKey, $partialKey2, $partialKey1, $partialKey3);
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?state=uploaded');
            } catch (ConnectionException | FileException | TusException $e) {
                header('Location: ' . $_SERVER['HTTP_REFERER'] . '?state=failed');
            }
        }
    }

}
