<?php

namespace App\Services\Scheduler\Exceptions;

use Exception;
use Throwable;

class TeamNotSetOrMinimumNumberException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
