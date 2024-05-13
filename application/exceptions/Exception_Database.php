<?php

namespace application\exceptions;

use application\core\Settings;
use application\core\traits\SystemMethods;

class Exception_Database extends \Exception
{
    use SystemMethods;

    protected $messages;

    public function __construct($message = "", $code = 0)
    {
        $this->messages = Settings::getDatabaseMessages();

        $msg = $this->messages[$code];

        parent::__construct($msg, $code);

        $error = $this->getMessage() ? $message : $this->messages[$this->getCode()];

        $error = $msg . $error;

        $error .= PHP_EOL . "file '" . $this->getFile() . " Line " . $this->getLine() . PHP_EOL;

        $this->writeLog($error, 'db.log');
    }

}
