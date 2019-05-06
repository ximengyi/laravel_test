<?php

namespace App\Tools;
use Symfony\Component\HttpFoundation\Response;

trait ResponseFormatHelper
{

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

        return $this->formatRespond(0,'',$data);

    }


    public function failed($err_nu,$err_msg,$data=''){

       return $this->formatRespond($err_nu,$err_msg,$data);

    }


    public function formatRespond($err_nu,$err_msg,$data='',$status = Response::HTTP_OK )
    {
        $data = [
            'err_nu' => $err_nu,
            'err_msg' => $err_msg,
            'results'=>$data

        ];
        $header [] = $status;

        return $this->respond($data,'json',$header);
    }
}
