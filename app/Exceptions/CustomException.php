<?php
/**
 * Created by PhpStorm.
 * User: MengYi
 * Date: 2019/3/30
 * Time: 12:02
 */

namespace App\Exceptions;

use Exception;
use App\Tools\ResponseFormatHelper;
class CustomException extends Exception
{
 use ResponseFormatHelper;

    public function __construct($message = "",$code = 0)
    {

        if(!empty($code)){

            $this->message =$message;

            $this->code = $code;


        }else{

            $this->message = config("errcode.{$message}.1",'错误信息设置不正确');

            $this->code = config("errcode.{$message}.0",'-0002');
        }



    }


    public function renderCustomExceptionJson ()
    {

        return $this->formatRespond($this->getCode(),$this->getMessage(),$this->getMessage());

    }

}