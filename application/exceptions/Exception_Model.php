<?php

namespace application\exceptions;

use application\core\Settings;
use application\core\traits\SystemMethods;

class Exception_Model extends \Exception
{
    use SystemMethods;

    protected $messages;

    public function __construct($message = "", $code = 0)
    {
        $this->messages = Settings::getCommonMessages();

        $msg = $this->messages[$code];

        parent::__construct($msg, $code);

        $error = $this->getMessage() ? $message : $this->messages[$this->getCode()];

        $error .= PHP_EOL . "file '" . $this->getFile() . " Line " . $this->getLine() . PHP_EOL;

        $this->writeLog($error, 'main.log');
    }

}
