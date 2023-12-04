<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
//    public function render($request, Throwable $exception)
//    {
//        return parent::render($request, $exception);
//    }

    //Laravel 8 and below:
    public function render($request, Throwable $exception)
    {
        if ($request->wantsJson() || $request->is('api/*')) {
            if ($exception instanceof ModelNotFoundException) {
                return response()->json(['message' => 'Item Not Found'], 404);
            }

            if ($exception instanceof AuthenticationException) {
                return response()->json(['message' => 'unAuthenticated'], 401);
            }

            if ($exception instanceof ValidationException) {
                return response()->json(['message' => 'UnprocessableEntity', 'errors' => []], 422);
            }

            if ($exception instanceof NotFoundHttpException) {
                return response()->json(['message' => 'The requested link does not exist'], 400);
            }
        }

        return parent::render($request, $exception);
    }


    //Laravel 9 and above:
//    public function register()
//    {
//        $this->renderable(function (ModelNotFoundException $e, $request) {
//            if ($request->wantsJson() || $request->is('api/*')) {
//                return response()->json(['message' => 'Item Not Found'], 404);
//            }
//        });
//
//        $this->renderable(function (AuthenticationException $e, $request) {
//            if ($request->wantsJson() || $request->is('api/*')) {
//                return response()->json(['message' => 'unAuthenticated'], 401);
//            }
//        });
//        $this->renderable(function (ValidationException $e, $request) {
//            if ($request->wantsJson() || $request->is('api/*')) {
//                return response()->json(['message' => 'UnprocessableEntity', 'errors' => []], 422);
//            }
//        });
//        $this->renderable(function (NotFoundHttpException $e, $request) {
//            if ($request->wantsJson() || $request->is('api/*')) {
//                return response()->json(['message' => 'The requested link does not exist'], 400);
//            }
//        });
//    }
}
