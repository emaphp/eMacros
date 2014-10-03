<?php
namespace eMacros\Runtime\Logical;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class LogicalOr implements Applicable {
	/**
	 * Applies a logical OR to all operands
	 * Usage: (or true true) (or false false false)
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
    public function apply(Scope $scope, GenericList $operands) {
    	if (count($operands) == 0) throw new \BadFunctionCallException("And: No parameters found.");
    	
        foreach ($operands as $form) {
            if ($value = $form->evaluate($scope)) return $value;
        }

        return $value;
    }
}
