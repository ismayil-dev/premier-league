<?php

namespace App\Services\Exceptions;

use Exception;
use Throwable;

class NoTeamAvailableGenerateFixtureException extends Exception
{
    /**
     * {@inheritDoc}
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
