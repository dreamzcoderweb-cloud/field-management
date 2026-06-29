<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'failed',
                'statusCode' => 401,
                'message' => 'Unauthenticated.',
            ], 401);
        }

        return redirect()->guest(route('auth.login'));
    }

    public function render($request, Exception|Throwable $e)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'failed',
                'statusCode' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }

        return parent::render($request, $e);
    }


}
