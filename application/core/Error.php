<?php

namespace application\core;

class Error
{
    protected static bool $error = false;

    public static function getError(): String
    {
        $err = '';

        if (!empty($_SESSION['common_error'])) {
            $err = $_SESSION['common_error'];
            $_SESSION['common_error'] = '';
            self::$error = false;
        }

        return $err;
    }

    public static function isError(): bool
    {
        return self::$error;
    }

    public static function setError($err): void
    {
        self::$error = true;
        $_SESSION['common_error'] = $err;
    }
}
