<?php
namespace eMacros\Runtime\Arithmetic;

use eMacros\Runtime\GenericFunction;

class Division extends GenericFunction {
	/**
	 * Obtains the result of dividing the first element on a list by the rest of the elements.
	 * Usage: (/ 4 2)
	 * Special case: (/ 5) = 1/5
	 * Returns: number
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    public function execute(array $arguments) {
    	if (empty($arguments)) {
    		//no parameters
    		throw new \InvalidArgumentException("Division: At least 1 argument is required.");
    	}
    	
    	//emulate CLISP: (/ 4) = 1/4
    	if (!isset($arguments[1])) {
    		return 1 / $arguments[0];
    	}
    	
    	//get first value
    	$result = array_shift($arguments);
    	
		foreach ($arguments as $value) {
			$result /= $value;
		}
		
		return $result;
    }
}
