<?php

namespace App\Exceptions;

use App\Enums\ExceptionLevel;
use Exception;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;

abstract class CommonException extends Exception
{
    // Default Status code
    protected const DEFAULT_CODE = 100;

    // Exception level
    protected string $level;

    //Exception code
    protected $code;

    // Exception Message
    protected $message;

    // Original Exception if available
    protected Exception $originalException;

    public function __construct(
        int       $code = self::DEFAULT_CODE,
        string    $level = ExceptionLevel::ERROR,
        array     $exceptionMessageParameters = [],
        Exception $originalException = null
    )
    {
        $this->level = $level;
        $this->code = $code;

        // Get message in user's lang
        $message = Lang::get(
            "exceptions.exception_{$this->code}",
            $exceptionMessageParameters
        );

        // If no message is defined, default message is used
        if (!$message) {
            $message = Lang::get('exceptions.exception_' . self::DEFAULT_CODE);
        }

        $this->message = $message;
        $this->originalException = $originalException;

        // Each exception is logged, even if not thrown
        $logMessage = "$code : $message";
        if ($originalException) {
            $originalMessage = $originalException->getMessage();
            $logMessage .= " (original : $originalMessage)";
        }

        Log::log($this->level, $logMessage);

        // Continue object initialization
        parent::__construct($this->message, $this->code);
    }

}
