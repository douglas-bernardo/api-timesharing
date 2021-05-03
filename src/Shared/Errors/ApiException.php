<?php


namespace App\Shared\Errors;


use App\Shared\Facades\Log\Log;
use Exception;
use Throwable;

/**
 * Class ApiException
 * @package App\Shared\Errors
 */
class ApiException extends Exception
{
    /**
     * ApiException constructor.
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     * @throws Exception
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->writeLog($message);
    }

    /**
     * @throws Exception
     */
    private function writeLog($message)
    {
        $logger = Log::getInstance();
        $logger->warning($message, ['trace' => $this->getTrace()]);
    }
}