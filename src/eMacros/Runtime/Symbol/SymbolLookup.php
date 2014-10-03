<?php
namespace eMacros\Runtime\Symbol;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class SymbolLookup implements Applicable {
	/**
	 * Obtains a symbol value from current environment
	 * Usage: (lookup "_value")
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) throw new \BadFunctionCallException("SymbolLookup: No parameters found.");
		$ref = $arguments[0]->evaluate($scope);
		if (!is_string($ref) || empty($ref)) throw new \InvalidArgumentException("SymbolLookup: Symbol must be specified as a non-empty string.");
		if (!array_key_exists($ref, $scope->symbols))
			throw new \InvalidArgumentException(sprintf("SymbolLookup: Symbol %s does not exists on current environment.", $ref));
		return $scope->symbols[$ref];
	}
}
?>