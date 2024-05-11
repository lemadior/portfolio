<?php

namespace application\core;

class Error
{
    static protected $error;

    public function __construct()
    {
        self::$error = false;
    }

    // static public function throwError($err)
    // {
    //     self::setError($err);
    //     return self::showError();
    // }

    static public function getError(): String
    {
        $err = '';
        if (!empty($_SESSION['common_error'])) {
            $err = $_SESSION['common_error'];
            $_SESSION['common_error'] = '';
            self::$error = false;
            // return implode(' ', self::$error);
        }

        return $err;

    }

    static public function isError() {
        return self::$error;
    }

    static public function setError($err)
    {
        self::$error = true;
        $_SESSION['common_error'] = $err;
    }

}