<?php

namespace App\Exceptions;

use Exception;

class GifAlreadyInFavoritesException extends Exception
{
    public function __construct($message = "GIF already in favorites")
    {
        parent::__construct($message);
    }
} 