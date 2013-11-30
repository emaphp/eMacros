<?php
namespace Foo;

class Fizz extends \ArrayObject {
	public $publicProperty = 42;
	private $privateProperty;
	
	public function publicMethod() {
		return 'This is a public method.';
	}
	
	public function anotherMethod($name, $greeting = 'Hello') {
		return $greeting . ' ' . $name . '!';
	}
	
	private function privateMethod() {
		
	}
}
?>