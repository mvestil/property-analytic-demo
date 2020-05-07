<?php

namespace App\Exceptions;

use Exception;

/**
 * Class ValidationException
 */
class ValidationException extends Exception
{
    /**
     * @var string
     */
    public $severity = 'warning';
}
