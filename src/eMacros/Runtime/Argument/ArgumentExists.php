<?php

namespace eMacros\Runtime\Argument;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class ArgumentExists implements Applicable {
	/**
	 * Argument index to check
	 * @var int
	 */
	public $index;
	
	public function __construct($index = null) {
		$this->index = $index;
	}
	
	/**
	 * Checks if a given argument has been provided
	 * Usage: (%1?) (%? _num)
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (is_null($this->index)) {
			if (count($arguments) == 0) throw new \BadFunctionCallException("ArgumentGet: No index specified.");
			$index = intval($arguments[0]->evaluate($scope));
		}
		else $index = $this->index;
		return array_key_exists($index, $scope->arguments);
	}
}
?>