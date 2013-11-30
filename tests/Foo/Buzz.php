<?php
namespace Foo;

class Buzz {
	private $values;
	
	public function __construct($values = null) {
		$this->values = is_array($values) ? $values : array();
	}
	
	public function __isset($property) {
		return array_key_exists($property, $this->values);
	}
	
	public function __get($property) {
		return $this->values[$property];
	}
}
?>