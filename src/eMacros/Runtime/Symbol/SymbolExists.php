<?php
namespace eMacros\Runtime\Symbol;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class SymbolExists implements Applicable {
	/**
	 * Checks if the given symbol exists on current environment
	 * Usage: (sym-exists "true") (sym-exists "_value")
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException("SymbolExists: No parameters found.");
		}
		
		$ref = $arguments[0]->evaluate($scope);
		
		if (!is_string($ref) || empty($ref)) {
			throw new \InvalidArgumentException("SymbolExists: Symbol must be specified as a non-empty string.");
		}
		
		return array_key_exists($ref, $scope->symbols);
	}
}
?>