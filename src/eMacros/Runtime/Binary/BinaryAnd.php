<?php
namespace eMacros\Runtime\Binary;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class BinaryAnd implements Applicable {
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