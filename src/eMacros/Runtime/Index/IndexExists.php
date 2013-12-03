<?php
namespace eMacros\Runtime\Index;

use eMacros\Applicable;
use eMacros\GenericList;
use eMacros\Scope;

class IndexExists implements Applicable {
	/**
	 * Index to find
	 * @var int
	 */
	public $index;
	
	public function __construct($index) {
		$this->index = $index;
	}
	
	/**
	 * Checks if a given index is defined in an array
	 * Usage: (#3? _arr) (#0? _arr) 
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			if (empty($scope->arguments)) {
				throw new \BadFunctionCallException("IndexExists: No parameters found.");
			}
			
			$value = $scope->arguments[0];
		}
		else {
			$value = $arguments[0]->evaluate($scope);
		}
		
		if ($value instanceof \ArrayObject || $value instanceof \ArrayAccess) {
			//array_key_exists does not call offsetExists
			return $value->offsetExists($this->index);
		}
		elseif (is_array($value)) {
			return array_key_exists($this->index, $value);
		}
		
		throw new \InvalidArgumentException(sprintf("IndexExists: A value of type array was expected but %s found instead.", gettype($value)));
	}
}
?>