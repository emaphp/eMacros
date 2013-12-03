<?php
namespace eMacros\Runtime\Type;

use eMacros\Runtime\GenericFunction;

class TypeOf extends GenericFunction {
	/**
	 * Obtains a value type
	 * Usage: (type-of 4)
	 * Returns: string
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		//check number of parameters
		if (empty($arguments)) {
			throw new \BadFunctionCallException("TypeOf: No arguments found.");
		}
		
		return gettype($arguments[0]);
	}
}
?>