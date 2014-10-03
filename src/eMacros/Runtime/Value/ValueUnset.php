<?php

namespace eMacros\Runtime\Value;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ValueUnset implements Applicable {
	/**
	 * Removes a symbol from scope
	 * Usage: (unset _var)
	 * Returns: null
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) throw new \BadFunctionCallException("ValueUnset: No parameters found.");
		if (!($arguments[0] instanceof Symbol))
			throw new \InvalidArgumentException(sprintf("ValueUnset: Expected symbol as first argument, %s found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		unset($scope->symbols[$arguments[0]->symbol]);
	}
}
?>