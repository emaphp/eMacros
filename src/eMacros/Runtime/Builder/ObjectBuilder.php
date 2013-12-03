<?php
namespace eMacros\Runtime\Builder;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ObjectBuilder implements Applicable {
	/**
	 * Creates a new instance from a symbol
	 * Usage: (new ArrayObject (array 1 2 3))
	 * Returns: object
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException("ObjectBuilder: No arguments found.");
		}
		
		$class = $arguments[0];
		
		if (!($class instanceof Symbol)) {
			throw new \InvalidArgumentException(sprintf("ObjectBuilder: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		}
		
		$class = $class->symbol;
		
		//get additional arguments
		$list = array_slice($arguments->getArrayCopy(), 1);
		$args = array();
		
		//build constructor parameters
		foreach ($list as $el) {
			$args[] = $el->evaluate($scope);
		}
		
		$rc = new \ReflectionClass($class);
		return empty($args) ? $rc->newInstance() : $rc->newInstanceArgs($args);
	}
}
?>