<?php
namespace eMacros\Runtime\Builder;

use eMacros\Runtime\GenericFunction;
use eMacros\Applicable;
use eMacros\GenericList;
use eMacros\Scope;

class ArrayBuilder implements Applicable {
	/**
	 * Builds an array with the specified elements
	 * Usage: (array 1 null "Hello" (-7 56.25) ("key" "val"))
	 * Returns: array
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$values = [];
		
		foreach ($arguments as $arg) {
			if ($arg instanceof GenericList) {
				if (count($arg) < 1) throw new \InvalidArgumentException("ArrayBuilder: No key defined.");
				if (count($arg) < 2) throw new \InvalidArgumentException("ArrayBuilder: No value defined.");
				//obtain symbol pair
				list($key, $value) = $arg;
				$key = $key->evaluate($scope);
				$values[$key] = $value->evaluate($scope);
			}
			else $values[] = $arg->evaluate($scope);
		}
	
		return $values;
	}
}
?>