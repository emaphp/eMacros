<?php
namespace eMacros\Runtime\Type;

use eMacros\Runtime\GenericFunction;

class IsEmpty extends GenericFunction {
	/**
	 * Determines if a value evaluates to empty
	 * Usage: (is-empty value)
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) {
			throw new \BadFunctionCallException('IsEmpty: No parameters found.');
		}
		
		foreach ($arguments as $arg) {
			if (!empty($arg)) {
				return false;
			}
		}
			
		return true;
	}
}
?>