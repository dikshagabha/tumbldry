<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;

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

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
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
        // if($request->expectsJson()) {
        //     // check for the stripe exceptions
        //     if ($exception instanceof \Stripe\Error\RateLimit || $exception instanceof \Stripe\Error\InvalidRequest || $exception instanceof \Stripe\Error\Authentication || $exception instanceof \Stripe\Error\ApiConnection || $exception instanceof \Stripe\Error\Base) {
        //         return response()->json(['message' => $exception->getMessage()], 400);
        //     }

        //     return response()->json(['message' => $exception->getMessage()], 400);
        // }
//	dd($exception);  	
 if ($exception instanceof ValidationException) {
	
        
            return response()->json(['errors'=>$exception->errors()], 422);
        }
        return parent::render($request, $exception);
    }

       protected function convertValidationExceptionToResponse(ValidationException $e, $request)
    {
        if ($e->response) {
            return $e->response;
        }

        return response()->json($e->validator->errors()->getMessages(), 422);
    }
}
