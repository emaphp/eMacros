<?php
namespace eMacros\Runtime\Value;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ValueSet implements Applicable {
	/**
	 * Sets a symbol value
	 * Usage: (:= _var "Hello World")
	 * Returns: the assigned value
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) throw new \BadFunctionCallException("ValueSet: No parameters found.");
		if (!($arguments[0] instanceof Symbol))
			throw new \InvalidArgumentException(sprintf("ValueSet: Expected symbol as first argument, %s found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));	
		if (count($arguments) < 2) throw new \BadFunctionCallException("ValueSet: A value must be provided.");
		$value = $arguments[1]->evaluate($scope);
		return $scope->symbols[$arguments[0]->symbol] = $value;
	}
}
?>