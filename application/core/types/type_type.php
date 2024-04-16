<?php

namespace application\core\types;

class Type_Type extends Type_Goods
{
	protected $description;
	protected $attributes;
	
	public function __construct($id, $name, $descr, $attrs)
	{
		parent::__construct($id, $name);
		
		$this->description = $descr;
		$this->attributes = $attrs;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription($descr) {
		$this->description = $descr;
	}
	
	public function getAttributes() {
		return $this->attributes;
	}

	public function setAttributes($attrs) {
		$this->attributes = $attrs;
	}
	
}