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
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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

        if ($exception instanceof NotFoundHttpException)  {

            return $this->notFoundHttpExceptionJson();

        }elseif ($exception instanceof ValidationException) {

            return $this->validateExceptionJson($exception);

        }elseif ($exception instanceof CustomException)  {

            return $exception->renderCustomExceptionJson();

        }elseif ($exception instanceof ModelNotFoundException) {
          return $this->modelNotFoundExceptionJson();

        } elseif ($exception instanceof MethodNotAllowedHttpException) {

            return $this->methodNotAllowedHttpJson();

            }

        return parent::render($request, $exception);

     }



    public function validateExceptionJson($exception)
    {

        $errMessage = $exception->errors();
        $errMessage = array_column($errMessage,0);
        return $this->renderErrcodeJson('input_errors',$errMessage);

    }


    public function notFoundHttpExceptionJson()
    {
        return $this->renderSyscodeJson('not_find_route');
    }


    public function modelNotFoundExceptionJson()
    {
        return $this->renderSyscodeJson('not_find_model');

    }

    public function methodNotAllowedHttpJson()
    {

        return $this->renderSyscodeJson('method_not_allowed');
    }



}
