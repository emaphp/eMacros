<?php
namespace eMacros\Runtime\Collection;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ArrayWalk implements Applicable {
	/**
	 * Applies the user-defined callback function to each element of an array.
	 * Usage: (Array::walk _arr _callback)
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs == 0) {
			throw new \BadFunctionCallException("ArrayWalk: No target specified.");
		}
		elseif ($nargs == 1) {
			throw new \BadFunctionCallException("ArrayWalk: No callback specified.");
		}
		
		$target = $arguments[0];
		
		if (!($target instanceof Symbol)) {
			throw new \InvalidArgumentException(sprintf("ArrayWalk: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		}
		
		$ref = $target->symbol;
		
		if (is_array($scope->symbols[$ref]) || $scope->symbols[$ref] instanceof \ArrayObject) {
			$op = $arguments[1]->evaluate($scope);
			
			if (is_callable($op)) {
				$userdata = $nargs > 2 ? $arguments[2]->evaluate($scope) : null;
				return array_walk($scope->symbols[$ref], $op, $userdata);
			}
			
			throw new \InvalidArgumentException("ArrayWalk: Expected callable as second argument.");
		}
		
		throw new \InvalidArgumentException(sprintf("ArrayWalk: Expected array as first argument but %s was found instead.", gettype($scope->symbols[$ref])));
	}
}
?>