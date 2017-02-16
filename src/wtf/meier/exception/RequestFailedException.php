<?php
/**
 * Created by PhpStorm.
 * User: meier
 * Date: 16/02/2017
 * Time: 15:24
 */

namespace wtf\meier\exception;


use Exception;

class RequestFailedException extends \Exception
{
    const DEFAULT_EXCEPTION_NUMBER = 1337;

    public function __construct($message, Exception $previous = null)
    {
        parent::__construct($message, RequestFailedException::DEFAULT_EXCEPTION_NUMBER, $previous);
    }

}