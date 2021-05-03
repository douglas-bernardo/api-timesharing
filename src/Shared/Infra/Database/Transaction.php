<?php

namespace App\Shared\Infra\Database;

use PDO;
use Exception;
use Psr\Log\LoggerInterface;

final class Transaction 
{
    /**
     * @var PDO|null
     */
    private static ?PDO $conn;
    /**
     * @var LoggerInterface|null
     */
    private static ?LoggerInterface $logger;

    /**
     * Transaction constructor.
     */
    private function __construct(){}

    /**
     * @throws Exception
     */
    public static function open($database): void
    {
        if(empty(self::$conn))
        {
            self::$conn = Connection::open($database);
            self::$conn->beginTransaction();
            self::$logger = null;
        }
    }

    /**
     * @return PDO
     */
    public static function get(): PDO
    {
        return self::$conn;
    }

    /**
     *
     */
    public static function rollback(): void
    {
        if (self::$conn){
            self::$conn->rollback();
            self::$conn = NULL;
        }
    }

    /**
     *
     */
    public static function close(): void
    {
        if (self::$conn){
            self::$conn->commit();
            self::$conn = NULL;
        }
    }

    /**
     * @param LoggerInterface $logger
     */
    public static function setLogger(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    /**
     * @param $message
     */
    public static function log($message): void
    {
        if (self::$logger) {
            self::$logger->info($message);
        }
    }
}