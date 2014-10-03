<?php
namespace eMacros\Runtime\Collection;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ArrayPush implements Applicable {
	/**
	 * Pushes the given parameter onto the end of an array
	 * Usage: (Array::push _arr 20 10)
	 * Returns: int
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		if ($nargs == 0) throw new \BadFunctionCallException("ArrayPush: No target specified.");
		elseif ($nargs == 1) throw new \BadFunctionCallException("ArrayPush: No values specified.");
		$target = $arguments[0];
		if (!($target instanceof Symbol))
			throw new \InvalidArgumentException(sprintf("ArrayPush: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		$ref = $target->symbol;
		
		if (is_array($scope->symbols[$ref]) || $scope->symbols[$ref] instanceof \ArrayObject) {
			$args = [];
			$it = $arguments->getIterator();
			$it->rewind();
			for ($it->next(); $it->valid(); $it->next())
				$args[] = $it->current()->evaluate($scope);
			
			if (is_array($scope->symbols[$ref])) {
				foreach ($args as $arg)
					array_push($scope->symbols[$ref], $arg);
			}
			else {
				$arr = $scope->symbols[$ref]->getArrayCopy();
				foreach ($args as $arg)
					array_push($arr, $arg);
				$scope->symbols[$ref]->exchangeArray($arr);
			}
			
			return count($scope->symbols[$ref]);
		}
		
		throw new \InvalidArgumentException(sprintf("ArrayPush: Expected array as first argument but %s was found instead.", gettype($scope->symbols[$ref])));
	}
}
?>