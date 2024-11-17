<?php

namespace App\Exceptions;

use Exception;

class GifNotInFavoritesException extends Exception
{
    public function __construct()
    {
        parent::__construct('GIF not found in favorites');
    }
} 