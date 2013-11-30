<?php
namespace eMacros\Runtime\Logical;

use eMacros\Runtime\GenericFunction;

class LogicalNot extends GenericFunction {
    protected function execute(array $arguments) {
    	if (empty($arguments)) {
    		throw new \BadFunctionCallException("Not: No parameters found.");
    	}
    	
        return !$arguments[0];
    }
}
