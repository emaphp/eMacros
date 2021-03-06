<?php
namespace eMacros\Runtime\Builder;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class InstanceBuilder implements Applicable {
	/**
	 * Creates a new instance from a string
	 * Usage: (instance _class (array 1 2 3))
	 * Returns: object
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) throw new \BadFunctionCallException("InstanceBuilder: No arguments found.");
		$class = $arguments[0]->evaluate($scope);
		if (!is_string($class))
			throw new \InvalidArgumentException(sprintf("InstanceBuilder: Expected string as first argument but %s was found instead.", gettype($class)));
		//get additional arguments
		$list = array_slice($arguments->getArrayCopy(), 1);
		$args = [];
		//build constructor parameters
		foreach ($list as $el)
			$args[] = $el->evaluate($scope);
		$rc = new \ReflectionClass($class);
		return empty($args) ? $rc->newInstance() : $rc->newInstanceArgs($args);
	}
}
?>