<?php
namespace eMacros\Runtime\Callback;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class CallFunctionArray implements Applicable {
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException("CallFunctionArray: No parameters found.");
		}
		
		$callback = $arguments[0]->evaluate($scope);
		
		//check for valid callback
		if (!is_callable($callback)) {
			throw new \InvalidArgumentException("CallFunctionArray: Argument is not a valid callback.");
		}
		
		if (count($arguments) > 1) {
			$args = $arguments[1]->evaluate($scope);
			
			if (!is_array($args)) {
				throw new \InvalidArgumentException(sprintf("CallFunctionArray: An array was expected as second argument but %s found instead.", gettype($args)));
			}
			
			return call_user_func_array($callback, $args);
		}
		
		return call_user_func_array($callback, array());
	}
}
?>