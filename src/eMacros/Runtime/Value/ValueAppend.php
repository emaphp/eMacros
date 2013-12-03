<?php
namespace eMacros\Runtime\Value;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ValueAppend implements Applicable {
	/**
	 * Appends a list of values to an array
	 * Usage: (@+ "Hello" " " "World" _array)
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
			throw new \BadFunctionCallException("ValueAppend: No target specified.");
		}
		
		//check if last parameter is symbol
		$target = $arguments[$nargs - 1];
		
		if (!($target instanceof Symbol)) {
			throw new \InvalidArgumentException(sprintf("ValueAppend: Expected symbol as last argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[$nargs - 1]), '\\')), 1)));
		}
		
		$ref = $target->symbol;
		
		//check symbol type
		if (is_array($scope->symbols[$ref]) || $scope->symbols[$ref] instanceof \ArrayAccess || $scope->symbols[$ref] instanceof \ArrayObject) {
			for ($i = 0; $i < $nargs - 1; $i++) {
				$scope->symbols[$ref][] = $arguments[$i]->evaluate($scope);
			}
			
			return count($scope->symbols[$ref]);
		}
		
		throw new \InvalidArgumentException(sprintf("ValueAppend: Expected array as last argument but %s was found instead.", gettype($scope->symbols[$ref])));
	}
}
?>