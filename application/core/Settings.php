<?php

namespace application\core;

class Settings 
{
    static private $_instance;
    
    private $templates;
    private $types;

    private $msg_routes;
    private $msg_common;
    private $msg_database;

    private function __construct()
    {
        $this->templates = include ROOT . "/application/settings/templates.php";
        $this->msg_routes = include ROOT . "/application/messages/routes.php";
        $this->msg_common = include ROOT . "/application/messages/common.php";  
        $this->msg_database = include ROOT . "/application/messages/database.php";
        $this->types = include ROOT . "/application/settings/product_types.php";
    }

    private function __clone()
    {
    }

    static public function get($property)
    {
        return self::instance()->$property;
    }

    static public function instance() 
    {
        if (self::$_instance instanceof self) {
            return self::$_instance;
        }

        self::$_instance = new self;

        return self::$_instance;
    }

    static public function getRouteMessages()
    {    
        return self::get('msg_routes');
    }

    static public function getCommonMessages()
    {    
        return self::get('msg_common');    }

    static public function getDatabaseMessages()
    {    
        return self::get('msg_database');
    }

    static public function getAllowedTypes()
    {
        return self::get('types');
    }

    static public function getTemplate($template)
    {
        $tpl = self::get('templates');

        if (!empty($tpl) && !empty($tpl[$template])) {
            return file_get_contents(ROOT . "/application/views/templates/" . $tpl[$template]);
        }

        return '';
    }

}