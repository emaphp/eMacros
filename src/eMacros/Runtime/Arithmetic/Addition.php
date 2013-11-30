<?php
namespace eMacros\Runtime\Arithmetic;

use eMacros\Runtime\GenericFunction;

class Addition extends GenericFunction {
	/**
	 * Obtains the sum of all elements on a list
	 * Usage: (+ 4 5 7)
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    protected function execute(array $arguments) {
        return array_sum($arguments);
    }
}
