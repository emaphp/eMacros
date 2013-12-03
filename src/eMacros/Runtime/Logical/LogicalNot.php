<?php
namespace eMacros\Runtime\Logical;

use eMacros\Runtime\GenericFunction;

class LogicalNot extends GenericFunction {
	/**
	 * Applies a logical NOT to a given value
	 * Usage: (not (and true true)) (not (or false))
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    public function execute(array $arguments) {
    	if (empty($arguments)) {
    		throw new \BadFunctionCallException("Not: No parameters found.");
    	}
    	
        return !$arguments[0];
    }
}
