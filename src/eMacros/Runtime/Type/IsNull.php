<?php
namespace eMacros\Runtime\Type;

use eMacros\Runtime\GenericFunction;

class IsNull extends GenericFunction {
	/**
	 * Determines if a given value is null
	 * Usage: (is-null (post 'email'))
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) {
			throw new \BadFunctionCallException('IsNull: No parameters found.');
		}
		
		foreach ($arguments as $arg) {
			if (!is_null($arg)) {
				return false;
			}
		}
			
		return true;
	}
}
?>