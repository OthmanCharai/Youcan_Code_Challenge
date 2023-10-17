<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Lang;
use Throwable;

class Handler extends ExceptionHandler
{

    protected const DEFAULT_CODE = 101;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, \Throwable $exception)
    {
        $this->report($exception);
        if (!$exception instanceof CommonException
            && $request->expectsJson()
        ) {
            if ($exception instanceof ModelNotFoundException) {
                return \response()->json('Record Not Founded', 404);
            }
            $exceptionContent = [
                'message' => Lang::get(
                    'exceptions.exception_' . self::DEFAULT_CODE
                ),
                'exception_code' => self::DEFAULT_CODE
            ];

            // This error need only in prod, i know it's a simple app(product + category),but it's should be extendable
            if (env('LARAVEL_APP_ENV') !== 'production') {
                $exceptionInfo = [
                    'exception message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace()
                ];
                $exceptionContent = array_merge(
                    $exceptionContent,
                    $exceptionInfo
                );
            }
            // we may want to log through a chanel the exceptions content
            return response()->json($exceptionContent, 400);
        } else {
            return parent::render($request, $exception);
        }
    }
}
