<?php
namespace eMacros\Runtime\Collection;

use eMacros\Runtime\GenericFunction;

class Count extends GenericFunction {
	/**
	 * Counts the elements on an array
	 * Usage: (Array::count (array 1 2 3 4 5))
	 * Returns: int
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) throw new \InvalidArgumentException("Count: No parameters found.");
		list($list) = $arguments;
		return is_string($list) ? strlen($list) : count($list);
	}
}
?>