<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $statusCode =Response::HTTP_OK;



    public function getStatusCode()
    {
        return $this->statusCode;
    }


    public function respond($data,$format='json',$header=[])
    {
        switch ($format)
        {
            case 'json':
                return  response()->json($data,$this->getStatusCode(),$header);
            case 'image':
                $size = getimagesizefromstring($data);
               return response($data, $this->getStatusCode(),array_merge([
                   'Content-Type' =>$size['mime'],
                ],$header));

            case 'download':
                return response()->download($data);


        }

    }

    public function success($data){
        $data = [
            'err_nu' => 0,
            'err_msg' => '',
            'results'=>$data

        ];
        return $this->respond($data);

    }


    public function failed($err_nu,$err_msg,$data){
        $data = [
            'err_nu' => $err_nu,
            'err_msg' => $err_msg,
            'results'=>$data

        ];
        return $this->respond($data);

    }



}
