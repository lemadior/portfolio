<?php

namespace application\core;

use application\exceptions\Exception_Database;
use Exception;
use mysqli;
use RuntimeException;

class Database
{
    private static $connection = null;

    /**
     * @throws Exception
     */
    private static function getConnection(): ?mysqli
    {
        if (self::$connection === null) {

            @self::$connection = new mysqli(HOST, USER, PASS, DB_NAME);

            if (mysqli_connect_errno()) {
                throw new RuntimeException(mysqli_connect_error(), 1);
            }

            self::$connection->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;

            try {
                self::doQuery("SET NAMES 'UTF8'");
            } catch (Exception $err) {
                throw new RuntimeException($err->getMessage(), 2);
            }
        }

        return self::$connection;
    }

    /**
     * @throws Exception
     */
    public static function getDbLink(): ?mysqli
    {
        return self::getConnection();
    }

    /**
     * @throws Exception_Database
     */
    public static function closeConnection(): bool
    {
        try {
            $db_link = self::getConnection();
        } catch (Exception $err) {
            throw new Exception_Database('Cannot get database connection', 4);
        }

        // If connection already closed
        if ($db_link === null) {
            return true;
        }

        try {
            $db_link->close();
        } catch (Exception $err) {
            throw new Exception_Database($db_link->error, 4);
        }

        self::$connection = null;

        return true;
    }

    /**
     * @throws Exception
     */
    public static function doQuery($query)
    {
        $db_link = self::getConnection();

        if (!$db_link) {
            throw new RuntimeException(mysqli_connect_error(), 1);
        }

        $result = $db_link->query($query);

        if ($db_link->error) {
            throw new RuntimeException($db_link->error, 2);
        }

        return $result;
    }

    // Return associative array

    /**
     * @throws Exception_Database
     */
    public static function getQuery($query): array
    {
        $arr = [];

        try {

            $result = self::doQuery($query);

        } catch (\Exception $err) {
            throw new Exception_Database("[call from getQuery] " . $err->getMessage(), 2);
        }

        while ($row = @$result->fetch_assoc()) {
            $arr[] = $row;
        }

        $result->close();

        return $arr;
    }

    // $table - string
    // $where - array
    // $values - array multidimentional
    /**
     * @throws Exception_Database
     */
    public static function putValue($link, $table, $where, $data): bool
    {
        $fields = '';
        $values = '';

        foreach ($where as $field) {
            $fields .= $field . ",";
        }

        $fields = '(' . rtrim($fields, ',') . ')';

        foreach ($data as $value) {
            $values .= '(';

            foreach ($value as $val) {
                if ($val === null) {
                    $values .= 'NULL,';
                } else {
                    $values .= '"' . $val . '",';
                }
            }

            $values = rtrim($values, ',') . '),';
        }

        $values = rtrim($values, ',');

        $query = "INSERT INTO $table $fields VALUES $values ";

        try {
            self::doQuery($query);
        } catch (Exception $err) {
            throw new Exception_Database("call from putValue: " . $err->getMessage(), 3);
        }

        return true;
    }
}
