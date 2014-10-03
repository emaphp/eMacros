<?php
namespace eMacros\Runtime\Logical;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class LogicalIf implements Applicable {
	/**
	 * If control structure implementation
	 * Usage: (if (== (%#) 0) "No parameters found" (. (%#) " parameters found"))
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
    public function apply(Scope $scope, GenericList $args) {
    	if (count($args) == 0) throw new \BadFunctionCallException("If: No parameters found.");
        $index = $args[0]->evaluate($scope) ? 1 : 2;
        return isset($args[$index]) ? $args[$index]->evaluate($scope) : null;
    }
}
