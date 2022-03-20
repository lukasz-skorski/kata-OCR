<?php

namespace App\Ocr\Domain\SignSchema\Exceptions;

use Exception;
use Throwable;

class InvalidCharLengthException extends Exception
{
    protected $message = "The char should be one character";

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
