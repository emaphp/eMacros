<?php
namespace eMacros\Runtime\Binary;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class BinaryAnd implements Applicable {
	/**
	 * Applies the binary AND to a list of operands
	 * Usage: (& 11 5 1)
	 * Returns: number
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException("BinaryAnd: No parameters found.");
		}
		
		$it = $arguments->getIterator();
		$it->rewind();
		
		if (!$it->valid()) {
			return 0;
		}
		
		$value = $it->current()->evaluate($scope);
		
		for ($it->next(); $it->valid(); $it->next()) {
			$value &= $it->current()->evaluate($scope);
		}
		
		return $value;
	}
}
?>