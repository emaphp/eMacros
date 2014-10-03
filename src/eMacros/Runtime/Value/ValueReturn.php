<?php
namespace eMacros\Runtime\Value;

use eMacros\Runtime\GenericFunction;

class ValueReturn extends GenericFunction {
	/**
	 * Returns a symbol value (lookup operator)
	 * Usage: (<- _var)
	 * Return: symbol associated value
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		return empty($arguments) ? null : $arguments[0];
	}
}
?>