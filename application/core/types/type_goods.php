<?php

namespace application\core\types;

class Type_Goods extends Type_Base
{
	
	public function __construct($id, $name)
	{
		parent::__construct($id, $name);
	}

	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
}