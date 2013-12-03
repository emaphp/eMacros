<?php
namespace eMacros\Runtime\Collection;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ArraySort implements Applicable {
	/**
	 * Callback to invoke
	 * @var callable
	 */
	public $callback;
	
	public function __construct($callback) {
		$this->callback = $callback;
	}
	
	/**
	 * Array sort wrapper callback
	 * Usage: (Array::sort _array) (Array::arsort _arr)
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException("ArraySort: No array specified.");
		}
		
		$target = $arguments[0];
		
		if (!($target instanceof Symbol)) {
			throw new \InvalidArgumentException(sprintf("ArraySort: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		}
		
		$ref = $target->symbol;
		
		if (is_array($scope->symbols[$ref])) {
			$func = $this->callback;
			
			if (count($arguments) > 1) {
				return $func($scope->symbols[$ref], $arguments[1]->evaluate($scope));
			}
			
			return $func($scope->symbols[$ref]);
		}
		
		throw new \InvalidArgumentException(sprintf("ArraySort: Expected array as first argument but %s was found instead.", gettype($scope->symbols[$ref])));
	}
}
?>