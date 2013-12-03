<?php
namespace eMacros\Runtime\Arithmetic;

use eMacros\Runtime\GenericFunction;

class Subtraction extends GenericFunction {
	/**
	 * Obtains the result of subtracting the first element on a list by the rest of the elements.
	 * Usage: (- 120 30 50)
	 * Returns: number
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    public function execute(array $arguments) {
    	if (empty($arguments)) {
    		throw new \InvalidArgumentException("Subtraction: At least 1 argument is required");
    	}
    	
    	//emulate CLISP: (- 3) = -3
    	if (!isset($arguments[1])) {
    		return -$arguments[0];
    	}
    	
    	//obtain first argument
        $result = array_shift($arguments);
        
        foreach ($arguments as $value) {
            $result -= $value;
        }

        return $result;
    }
}
