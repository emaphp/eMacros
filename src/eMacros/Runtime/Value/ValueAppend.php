<?php
namespace eMacros\Runtime\Value;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ValueAppend implements Applicable {
	/**
	 * Appends a list of values to an array
	 * Usage: (@+ _array "Hello" " " "World")
	 * Return: the amount of elements in the array
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs == 0) {
			throw new \BadFunctionCallException("ValueAppend: No parameters found.");
		}
		elseif ($nargs == 1) {
			throw new \BadFunctionCallException("ValueAppend: No values to append.");
		}
		
		//check if first parameter is a symbol
		$target = $arguments[0];
		
		if (!($target instanceof Symbol)) {
			throw new \InvalidArgumentException(sprintf("ValueAppend: A symbol was expected as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		}
		
		$ref = $target->symbol;
		
		//check symbol type
		if (is_array($scope->symbols[$ref]) || $scope->symbols[$ref] instanceof \ArrayAccess || $scope->symbols[$ref] instanceof \ArrayObject) {
			for ($i = 1; $i < $nargs; $i++) {
				$scope->symbols[$ref][] = $arguments[$i]->evaluate($scope);
			}
			
			return count($scope->symbols[$ref]);
		}
		
		throw new \InvalidArgumentException(sprintf("ValueAppend: Cannot append values to a %s.", gettype($scope->symbols[$ref])));
	}
}
?>