<?php
namespace eMacros\Runtime\Collection;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ArrayUnshift implements Applicable {
	/**
	 * Prepends passed elements to the front of the array
	 * Usage: (Array::unshift _arr "apple" "raspberry")
	 * Returns: int
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs == 0) {
			throw new \BadFunctionCallException("ArrayUnshift: No target specified.");
		}
		elseif ($nargs == 1) {
			throw new \BadFunctionCallException("ArrayUnshift: No values specified.");
		}
		
		$target = $arguments[0];
		
		if (!($target instanceof Symbol)) {
			throw new \InvalidArgumentException(sprintf("ArrayUnshift: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		}
		
		$ref = $target->symbol;
		
		$args = array();
		$it = $arguments->getIterator();
		$it->rewind();
		
		for ($it->next(); $it->valid(); $it->next()) {
			$args[] = $it->current()->evaluate($scope);
		}
		
		if (is_array($scope->symbols[$ref])) {
			foreach (array_reverse($args) as $arg) {
				array_unshift($scope->symbols[$ref], $arg);
			}
				
			return count($scope->symbols[$ref]);
		}
		elseif ($scope->symbols[$ref] instanceof \ArrayObject) {			
			$arr = $scope->symbols[$ref]->getArrayCopy();
			
			foreach (array_reverse($args) as $arg) {
				array_unshift($arr, $arg);
			}
			
			$scope->symbols[$ref]->exchangeArray($arr);
			return count($scope->symbols[$ref]);
		}
		
		throw new \InvalidArgumentException(sprintf("ArrayUnshift: Expected array as first argument but %s was found instead.", gettype($scope->symbols[$ref])));
	}
}
?>