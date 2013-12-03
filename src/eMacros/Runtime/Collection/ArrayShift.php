<?php
namespace eMacros\Runtime\Collection;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ArrayShift implements Applicable {
	/**
	 * Shifts the first value of an array off and returns it
	 * Usage: (Array::shift _arr)
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException();
		}
		
		$target = $arguments[0];
		
		if (!($target instanceof Symbol)) {
			throw new \InvalidArgumentException(sprintf("ArrayShift: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		}
		
		$ref = $target->symbol;
		
		if (is_array($scope->symbols[$ref])) {
			return array_shift($scope->symbols[$ref]);
		}
		elseif ($scope->symbols[$ref] instanceof \ArrayObject) {
			$arr = $scope->symbols[$ref]->getArrayCopy();
			$value = array_shift($arr);
			
			if (count($scope->symbols[$ref]->getArrayCopy()) != 0) {
				$scope->symbols[$ref]->exchangeArray($arr);
			}
			
			return $value;
		}
		
		return null;
	}
}
?>