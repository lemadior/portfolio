<?php

namespace application\core\types;

class Type_Fields extends Type_Goods
{
	protected $units;
	
	public function __construct($id, $name, $units) 
	{
		parent::__construct($id, $name);

		$this->units = $units;
	}
	
	public function getUnits() {
		return $this->units;
	}
	
	public function setUnits($units) {
		$this->units = $units;
	}
	
}