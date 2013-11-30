<?php
namespace eMacros\Runtime\Logical;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class LogicalOr implements Applicable {
    public function apply(Scope $scope, GenericList $operands) {
    	if (count($operands) == 0) {
    		throw new \BadFunctionCallException("And: No parameters found.");
    	}
    	
        foreach ($operands as $form) {
            if ($value = $form->evaluate($scope)) {
            	return $value;
            }
        }

        return $value;
    }
}
