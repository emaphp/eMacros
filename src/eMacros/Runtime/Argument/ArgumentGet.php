<?php
namespace eMacros\Runtime\Argument;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class ArgumentGet implements Applicable {
	/**
	 * Argument index to obtain
	 * @var int
	 */
	public $index;
	
	public function __construct($index = null) {
		$this->index = $index;
	}
	
	/**
	 * Obtains argument at given index
	 * Usage: (%0) (% _num)
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (is_null($this->index)) {
			if (count($arguments) == 0) {
				throw new \BadFunctionCallException("ArgumentGet: No index specified.");
			}
			
			$index = intval($arguments[0]->evaluate($scope));
		}
		else {
			$index = $this->index;
		}
		
		if (!array_key_exists($index, $scope->arguments)) {
			throw new \UnexpectedValueException(sprintf("ArgumentGet: No parameter found at index %d.", $index));
		}
		
		return $scope->arguments[$index];
	}
}
?>