<?php
namespace Source\Database;

use Exception;

final class ConnectOracle
{
    private static $stmt;
    private const TNS = " 
    (DESCRIPTION =
        (ADDRESS_LIST =
          (ADDRESS = (PROTOCOL = TCP)(HOST = " . CONF_DB_OCI_HOST . ")(PORT = " . CONF_DB_OCI_PORT . "))
        )
        (CONNECT_DATA =
          (SERVICE_NAME = " . CONF_DB_OCI_SERVICE_NAME . ")
        )
      )
           ";

    private static $conn;

    public static function connectOracleDB()
    {
        if (empty(self::$conn)) {
            if(!self::$conn = @oci_connect(CONF_DB_OCI_USER, CONF_DB_OCI_PASS, self::TNS, 'AL32UTF8')){
                $e = oci_error();
                throw new Exception("Erro ao conectar ao servidor usando a extensão OCI - " . $e['message']);
            }   
        }
        return self::$conn;
    }

    public static function parse($connection, string $sql_text)
    {        
        if (!$stmt = @oci_parse($connection, $sql_text)) {
            self::$stmt = $stmt;
            $e = oci_error($stmt);
            throw new Exception("Erro ao preparar consulta - " . $e['message']);
        }
        return $stmt;
    }

    public static function execute($statement)
    {
        if (!@oci_execute($statement)) {
            $e = oci_error($statement);
            throw new Exception("Erro na consulta - " . $e['message']);
            //return json_encode(['status' => 'error', 'data' => $e['message']]);
        }
        return true;
    }

    public static function closeCMConnection(): void
    {
        oci_close(self::$conn);
    }
}