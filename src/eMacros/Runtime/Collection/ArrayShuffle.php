<?php
namespace eMacros\Runtime\Collection;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ArrayShuffle implements Applicable {
	/**
	 * Randomizes the order of the elements in an array
	 * Usage: (Array::shuffle _arr)
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException("ArrayShuffle: No target specified.");
		}
		
		$target = $arguments[0];
		
		if (!($target instanceof Symbol)) {
			throw new \InvalidArgumentException(sprintf("ArrayShuffle: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		}
		
		$ref = $target->symbol;
		
		if ($scope->symbols[$ref] instanceof \ArrayObject) {
			$arr = $scope->symbols[$ref]->getArrayCopy();
			$value = shuffle($arr);
			$scope->symbols[$ref]->exchangeArray($arr);
			return $value;
		}
		
		return shuffle($scope->symbols[$ref]);
	}
}
?>