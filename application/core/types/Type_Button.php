<?php

namespace application\core\types;

class Type_Button extends Type_Base
{
	protected $action;

	public function __construct($id, $name, $action)
	{
		parent::__construct($id, $name);
		$this->action = $action;
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

	public function getAction() {
		return $this->action;
	}
	
	public function seAction($action) {
		$this->name = $action;
	}
}