<?php

namespace App\Shared\Infra\Database;

use App\Shared\Errors\ApiException;
use PDO;
use Exception;

/**
 * Class Connection
 * @package App\Shared\Infra\Database
 */
final class Connection
{
    /**
     * @param $name
     * @return PDO|null
     * @throws ApiException
     * @throws Exception
     */
    public static function open($name): ? PDO
    {
        try {
            $fileConfig = __DIR__ . "/../../Config/$name.ini";

            if (file_exists($fileConfig)) {
                $db = parse_ini_file($fileConfig);
            } else {
                throw new ApiException("File $name not found.");
            }

            $user = $db['user'] ?? NULL;
            $pass = $db['pass'] ?? NULL;
            $name = $db['name'] ?? NULL;
            $host = $db['host'] ?? NULL;
            $type = $db['type'] ?? NULL;

            $conn = null;
            switch ($type) {
                case 'pgsql':
                    $port = '5432';
                    $conn = new PDO("pgsql:dbname=$name;user=$user;password=$pass;
                                 host=$host;port=$port");
                    break;

                case 'mysql':
                    $port = '3306';
                    $conn = new PDO("mysql:host=$host;port=$port;dbname=$name", $user, $pass);
                    break;

                case 'oracle':
                    $port = '1521';
                    // $dbtns = "(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = $host)(PORT = $port)) (CONNECT_DATA = (SERVICE_NAME = $name) (SID = $name)))";
                    $conn = new PDO("oci:dbname=$host:$port/$name;charset=AL32UTF8", $user, $pass);
                    // $conn = new PDO("oci:dbname=$dbtns;charset=AL32UTF8", $user, $pass);
                    $conn->query("ALTER SESSION SET NLS_DATE_FORMAT = 'YYYY-MM-DD'");
                    break;

                default:
                    throw new Exception('[Connection string]: Unexpected value');
            }

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conn->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);

            return $conn;
        } catch (\PDOException $exception) {
            throw new ApiException($exception->getMessage(), 500);
        }
    }    
}