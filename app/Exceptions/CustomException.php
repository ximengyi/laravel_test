<?php
/**
 * Created by PhpStorm.
 * User: MengYi
 * Date: 2019/3/30
 * Time: 12:02
 */

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{


    public function __construct($message = "",$code = 0)
    {

        if(!empty($code)){

            $this->message =$message;

            $this->code = $code;


        }else{

            $this->message = config("errcode.{$message}.1",'错误信息设置不正确');

            $this->code = config("errcode.{$message}.0",'00001');
        }



    }


    public function renderCustomExceptionJson ()
    {

        $response = [
            'err_nu'=> $this->getCode(),
            'err_msg'=>$this->getMessage(),
            'results'=>$this->getMessage()
        ];

        return response()->json($response, 200);

    }

}