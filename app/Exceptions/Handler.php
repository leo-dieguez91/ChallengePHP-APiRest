<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use App\Exceptions\GifNotFoundException;
use App\Exceptions\GifAlreadyInFavoritesException;
use App\Exceptions\GifNotInFavoritesException;
use Illuminate\Auth\AuthenticationException;
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
        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'status' => 'error'
                ], 401);
            }
        });

        $this->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $e->errors(),
            ], 422);
        });

        $this->renderable(function (GifNotFoundException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        });

        $this->renderable(function (GifAlreadyInFavoritesException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 409);
        });

        $this->renderable(function (GifNotInFavoritesException $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 404);
        });

        $this->renderable(function (Throwable $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => $e->getMessage(),
                    'status' => 'error'
                ], 500);
            }
        });
    }
}
