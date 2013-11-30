<?php
namespace Foo;

class FizzBuzz {
	public $publicProperty = true;
	
	public function __call($method, $arguments) {
		if ($method == 'testMethod') {
			return implode('.', $arguments);
		}
		
		return null;
	}
}
?>