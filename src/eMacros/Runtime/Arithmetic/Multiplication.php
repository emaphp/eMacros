<?php
namespace eMacros\Runtime\Arithmetic;

use eMacros\Runtime\GenericFunction;

class Multiplication extends GenericFunction {
	/**
	 * Obtains the product of all elements on a list
	 * Usage: (* 4 6 2)
	 * Returns: number
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    public function execute(array $arguments) {
        return empty($arguments) ? 1 : array_product($arguments);
    }
}
