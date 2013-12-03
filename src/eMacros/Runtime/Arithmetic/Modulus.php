<?php
namespace eMacros\Runtime\Arithmetic;

use eMacros\Runtime\GenericFunction;

class Modulus extends GenericFunction {
	/**
	 * Caculates the modulus between 2 values
	 * Usage: (mod -1 5)
	 * Returns: number
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    public function execute(array $arguments) {
    	if (empty($arguments)) {
    		//no arguments
    		throw new \BadFunctionCallException("Modulus: No arguments found.");
    	}
    	
    	if (!isset($arguments[1])) {
    		//not enough arguments
    		throw new \BadFunctionCallException("Modulus: At least 2 arguments are required");
    	}
    	
        return $arguments[0] % $arguments[1];
    }
}
