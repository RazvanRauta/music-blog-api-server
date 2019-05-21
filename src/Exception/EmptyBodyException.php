<?php

/**
 * @author Razvan Rauta
 * 21.05.2019
 * 21:50
 */

namespace App\Exception;

use Throwable;

class EmptyBodyException extends \Exception
{
    public function __construct(
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct('The body of the POST/PUT method cannot be empty', $code, $previous);
    }
}
