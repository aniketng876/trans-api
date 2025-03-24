<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

    public function render($request, Throwable $exception)
    {
        // Handle Model Not Found Exception (404)
        if ($exception instanceof ModelNotFoundException) {
            return response()->json([
                'success' => false,
                'error' => 'Resource not found'
            ], 404);
        }

        // Handle Route Not Found Exception (404)
        if ($exception instanceof NotFoundHttpException) {
            return response()->json([
                'success' => false,
                'error' => 'Route not found'
            ], 404);
        }

        // Handle Validation Errors (422)
        if ($exception instanceof ValidationException) {
            return response()->json([
                'success' => false,
                'errors' => $exception->errors()
            ], 422);
        }

        // Handle Authentication Exception (401)
        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'success' => false,
                'error' => 'Unauthenticated'
            ], 401);
        }

        // Handle Custom API Exceptions
        if ($exception instanceof HttpResponseException) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ], $exception->getCode() ?: 500);
        }

        // Catch All Other Exceptions (500)
        return response()->json([
            'success' => false,
            'error' => 'Something went wrong',
            'message' => $exception->getMessage()
        ], 500);
    }
}
