<?php
namespace eMacros\Runtime\Symbol;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Environment\Environment;
use eMacros\Symbol;

class SymbolSet implements Applicable {
	/**
	 * Defines a symbol value
	 * Usage: (sym "value") (sym "counter" 0)
	 * Returns: NULL
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException("SymbolSet: No parameters found.");
		}
		
		$ref = $arguments[0]->evaluate($scope);
		
		if (!is_string($ref) || empty($ref)) {
			throw new \InvalidArgumentException("SymbolSet: Symbol must be specified as a non-empty string.");
		}
		
		Symbol::validateSymbol($ref);
		$value = (count($arguments) > 1) ? $arguments[1]->evaluate($scope) : null;
		$scope->symbols[$ref] = $value;
	}
}
?>