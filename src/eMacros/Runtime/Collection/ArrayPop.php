<?php
namespace eMacros\Runtime\Collection;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ArrayPop implements Applicable {
	/**
	 * Pops and returns the last value of an array
	 * Usage: (Array::pop _arr)
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) throw new \BadFunctionCallException("ArrayPop: No target specified.");
		$target = $arguments[0];
		if (!($target instanceof Symbol))
			throw new \InvalidArgumentException(sprintf("ArrayPop: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		$ref = $target->symbol;
		if (is_array($scope->symbols[$ref])) return array_pop($scope->symbols[$ref]);
		elseif ($scope->symbols[$ref] instanceof \ArrayObject) {
			$arr = $scope->symbols[$ref]->getArrayCopy();
			$value = array_pop($arr);
			if (count($scope->symbols[$ref]->getArrayCopy()) != 0)
				$scope->symbols[$ref]->exchangeArray($arr);
			return $value;
		}
		
		throw new \InvalidArgumentException(sprintf("ArrayPop: Expected array as first argument but %s was found instead.", gettype($scope->symbols[$ref])));
	}	
}
?>