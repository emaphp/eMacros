<?php
namespace eMacros\Runtime\Callback;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class CallFunction implements Applicable {
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) throw new \BadFunctionCallException("CallFunction: No parameters found.");
		$callback = $arguments[0]->evaluate($scope);
		//check for valid callback
		if (!is_callable($callback)) throw new \InvalidArgumentException("CallFunction: Argument is not a valid callback.");
		
		if ($callback instanceof Applicable) {
			$args = $arguments->shift();
			if (is_null($args)) $args = new GenericList();
			return $callback->apply($scope, $args);
		}
		
		//extract parameters
		$args = array_slice($arguments->getArrayCopy(), 1);
		$param_array = [];
		foreach ($args as $arg)
			$param_array[] = $arg->evaluate($scope);
		return call_user_func_array($callback, $param_array);
	}
}
?>