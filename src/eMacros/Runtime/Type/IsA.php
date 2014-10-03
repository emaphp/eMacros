<?php
namespace eMacros\Runtime\Type;

use eMacros\Runtime\GenericFunction;

class IsA extends GenericFunction {
	/**
	 * Determines if a given value is an instance of a specified class
	 * Usage: (is-a "ArrayObject" _value)
	 * Returns: boolean 
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) throw new \BadFunctionCallException("IsA: No parameters found.");
		if (!array_key_exists(1, $arguments)) throw new \BadFunctionCallException("IsA: No classname has been specified.");
		if (!is_string($arguments[1]))
			throw new \InvalidArgumentException(sprintf("IsA: Expected a value of type string as second argument, %s found instead.", gettype($arguments[1])));
		if (!is_object($arguments[0])) return false;
		return is_a($arguments[0], $arguments[1]);
	}
}
?>