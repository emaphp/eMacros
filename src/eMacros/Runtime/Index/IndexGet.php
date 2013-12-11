<?php
namespace eMacros\Runtime\Index;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class IndexGet implements Applicable {
	/**
	 * Index to obtain
	 * @var int
	 */
	public $index;
	
	public function __construct($index) {
		$this->index = $index;
	}
	
	/**
	 * Obtains a value with the given index
	 * Usage: (#1 _arr) (#0 _arr)
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			if (empty($scope->arguments)) {
				throw new \BadFunctionCallException("IndexGet: No parameters found.");
			}
			
			$value = $scope->arguments[0];
		}
		else {
			$value = $arguments[0]->evaluate($scope);
		}
		
		if ($value instanceof \ArrayObject || $value instanceof \ArrayAccess) {
			//array_key_exists does not call offsetExists
			if (!$value->offsetExists($this->index)) {
				throw new \OutOfBoundsException(sprintf("IndexGet: No value found at offset %d.", $this->index));
			}
			
			return $value[$this->index];
		}
		elseif (is_array($value)) {
			if (!array_key_exists($this->index, $value)) {
				throw new \OutOfBoundsException(sprintf("IndexGet: No value found at offset %d.", $this->index));
			}
			
			return $value[$this->index];
		}
		
		throw new \InvalidArgumentException(sprintf("IndexGet: A value of type array was expected but %s found instead.", gettype($value)));
	}
}
?>