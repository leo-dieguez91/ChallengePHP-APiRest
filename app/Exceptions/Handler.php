<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\GifNotFoundException;
use App\Exceptions\GifAlreadyInFavoritesException;
use App\Exceptions\GifNotInFavoritesException;
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
    }
}
