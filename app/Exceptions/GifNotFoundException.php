<?php

namespace App\Exceptions;

use Exception;

class GifNotFoundException extends Exception
{
    public function __construct($message = "GIF not found")
    {
        parent::__construct($message);
    }
} 