<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Container\Container;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];


    //
    // public function __construct(Container $container)
    // {
    //
    //     parent::__construct();
    //
    // }



    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
        if ($exception instanceof CustomException) {
            throw $exception;
        }

    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {

        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'error' => 'Resource not found.'
            ],404);
        }

        if ($exception instanceof ValidationException) {

          return $this->ValidateExceptionJson(-99,$exception);

        }

        if ($exception instanceof CustomException)  {

            return $exception->renderCustomExceptionJson();

        }

        return parent::render($request, $exception);
     }









    public function ValidateExceptionJson($err_nu,$exception)
    {
        $errMessage = [];
        $errMessage = array_values($exception->errors());
        // foreach ($exception->errors() as $item)
        // {
        //     $errMessage [] = $item;
        // }
        $response = [
            'err_nu'=>$err_nu,
            'err_msg'=>"输入格式有误",
            'results'=>$errMessage
        ];

        return response()->json($response, $exception->status);
    }


}
