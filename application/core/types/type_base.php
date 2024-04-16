<?php

namespace application\core\types;

abstract class Type_Base{
    
    protected $id;
    protected $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    abstract public function setId($id);
    abstract public function getId();

    abstract public function setName($name);
    abstract public function getName();
}