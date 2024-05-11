<?php

namespace application\core;

use application\exceptions\Exception_Database;

class Database
{
    static private $connection = NULL;

    private static function getConnection()
    {
        if (self::$connection === NULL) {
            
            @self::$connection = new \mysqli(HOST, USER, PASS, DB_NAME);
           
            if (mysqli_connect_errno()) {
                throw new \Exception(mysqli_connect_error(), 1);
                return NULL;
            }

            self::$connection->report_mode = MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR;

            try {
                self::doQuery("SET NAMES 'UTF8'");
            } catch (\Exception $err) {
                throw new \Exception($err->getMessage(), 2);
            }
        }

        return self::$connection;
    }

    public static function getDbLink()
    {
        return self::getConnection();
    }

    public static function closeConnection() : bool
    {
        try {
            $db_link = self::getConnection();
        } catch (\Exception $err) {
            throw new Exception_Database($db_link->error, 4);
            return false;
        } 

        if ($db_link === NULL) return true; // If connection already closed 

        try {
            $db_link->close();
        } catch (\Exception $err) {
            throw new Exception_Database($db_link->error, 4);
            return false;
        } 

        self::$connection = NULL;

        return true;
    }

    public static function doQuery($query)
    {
        $db_link = self::getConnection();
 
        if (!$db_link) {
            throw new \Exception(mysqli_connect_error(), 1);
            return NULL;
        } 
  
        $result = $db_link->query($query);

        if ($db_link->error) {
            throw new \Exception($db_link->error, 2);
            return NULL;
        }

        return $result;
    }

    // Return associative array
    public static function getQuery($query)
    {
        $arr = [];

        try {

            $result = self::doQuery($query);
            
        } catch (\Exception $err) {
            throw new Exception_Database("[call from getQuery] " . $err->getMessage(), 2);
            return null;
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
    public static function putValue($link, $table, $where, $data)
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
        } catch (\Exception $err) {
            throw new Exception_Database("call from putValue: " . $err->getMessage(), 3);
            return false;
        }

        return true;
    }


}
