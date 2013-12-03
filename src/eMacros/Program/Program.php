<?php
namespace eMacros\Program;

use eMacros\Parser;
use eMacros\Environment\Environment;
use eMacros\GenericList;

abstract class Program {
	/**
	 * Program internal expressions
	 * @var \eMacros\GenericList
	 */
	public $expressions;
	
	public function __construct($program) {
		$this->expressions = Parser::parse($program, true);
	}
	
	public function offsetGet($offset) {
		return $this->expressions[$offset];
	}
	
	public function offsetExists($offset) {
		return array_key_exists($offset, $this->expressions);
	}
	
	public function offsetSet($_, $__) {
		throw new \BadMethodCallException('Program object is immutable');
	}
	
	public function offsetUnset($_) {
		throw new \BadMethodCallException('Program object is immutable');
	}
	
	public function getIterator() {
		return new \ArrayIterator($this->expressions);
	}
	
	public function count() {
		return count($this->expressions);
	}
	
	public abstract function execute(Environment $env);
}
?>