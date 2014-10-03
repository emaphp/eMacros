<?php
namespace eMacros\Runtime\Logical;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class LogicalAnd implements Applicable {
	/**
	 * Applies a logical AND to all operands
	 * Usage: (and true true) (and true true false)
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
    public function apply(Scope $scope, GenericList $operands) {
    	if (count($operands) == 0) throw new \BadFunctionCallException("And: No parameters found.");
    	
        foreach ($operands as $expr) {
            if (!$value = $expr->evaluate($scope)) return $value;
        }

        return $value;
    }
}
