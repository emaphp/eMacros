<?php
namespace eMacros\Runtime\Type;

use eMacros\Applicable;
use eMacros\Symbol;
use eMacros\Scope;
use eMacros\GenericList;

class IsInstanceOf implements Applicable {
	/**
	 * Determines if a value is an instance of a given class
	 * Usage: (instance-of Acme\CustomClass _obj)
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		//check number of parameters
		if (count($arguments) == 0) throw new \BadFunctionCallException("IsInstanceOf: No arguments found.");
		if (count($arguments) == 1) throw new \BadFunctionCallException("IsInstanceOf: No class specified.");
		//obtain instance
		$instance = $arguments[0]->evaluate($scope);
		if (!is_object($instance)) return false;
		if (!($arguments[1] instanceof Symbol))
			throw new \InvalidArgumentException(sprintf("InstanceOf: Expected symbol as second argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[1]), '\\')), 1)));
		return (new \ReflectionClass($arguments[1]->symbol))->isInstance($instance);
	}
}
?>