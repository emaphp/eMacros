<?php

namespace eMacros\Runtime\String;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class StringReplace implements Applicable {
	public $callback;
	
	public function __construct($callback) {
		$this->callback = $callback;
	}
	
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs < 3) {
			throw new \BadFunctionCallException("StringReplace: Function expects at least 3 parameters.");
		}
		
		if ($nargs == 3) {
			return call_user_func($this->callback, $arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope), $arguments[2]->evaluate($scope));
		}
		else {
			$target = $arguments[3];
			
			if (!($target instanceof Symbol)) {
				throw new \InvalidArgumentException(sprintf("StringReplace: Expected symbol as fourth argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[3]), '\\')), 1)));
			}
			
			$ref = $target->symbol;
			
			$func = $this->callback;
			return $func($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope), $arguments[2]->evaluate($scope), $scope->symbols[$ref]);
		}
	}
}
?>