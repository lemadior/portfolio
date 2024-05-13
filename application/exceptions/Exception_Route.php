<?php

namespace application\exceptions;

use application\core\Settings;
use application\core\traits\SystemMethods;

class Exception_Route extends \Exception
{
    use SystemMethods;

    protected $messages;

    public function __construct($message = "", $code = 0)
    {
        $this->messages = Settings::getRouteMessages();

        parent::__construct($this->messages[0], $code);

        $error = $this->getMessage() ? $message : $this->messages[$this->getCode()];

        $error .= PHP_EOL . "file '" . $this->getFile() . " Line " . $this->getLine() . PHP_EOL;

        $this->writeLog($error, 'route.log');
    }

    public function Error404($msg)
    {
        $_SESSION['page_error'] = $msg;
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('HTTP/1.1 404 Not Found');
        header('Status: 404 Not Found');
        header('Location:' . $host . '404');
    }
}
