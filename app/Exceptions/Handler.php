<?php

namespace App\Exceptions;

use Exception;
use App\Tools\ResponseFormatHelper;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class Handler extends ExceptionHandler
{

    use ResponseFormatHelper;
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

          return $this->validateExceptionJson($exception);

        }

        if ($exception instanceof CustomException)  {

            return $exception->renderCustomExceptionJson();

        }
        if ($exception instanceof NotFoundHttpException)  {

            return $this->notFoundHttpExceptionJson($exception);

        }

        return parent::render($request, $exception);

     }



    public function validateExceptionJson($exception)
    {
        $errMessage = [];
        $errMessage = $exception->errors();
        $errMessage = array_column($errMessage,0);

        $err_num = config("syscode.input_errors.0",'-0001');
        $err_msg = config("syscode.input_errors.1",'系统错误信息设置不正确');
        return $this->failed($err_num,$err_msg,$errMessage);
    }

    public function notFoundHttpExceptionJson($exception)
    {

        $err_num = -9994;
        $err_msg = '404找不到路由';
        $errMessage =['请检查路由哦'];
        return $this->formatRespond($err_num,$err_msg,$errMessage,Response::HTTP_NOT_FOUND);
    }

}
