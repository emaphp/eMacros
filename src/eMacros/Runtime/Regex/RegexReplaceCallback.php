<?php
namespace eMacros\Runtime\Regex;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class RegexReplaceCallback implements Applicable {
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs < 3) {
			throw new \BadFunctionCallException("RegexReplaceCallback: Function expects at least 3 parameters.");
		}
		
		$args = array();
		
		for ($i = 0; $i < $nargs; $i++) {
			if ($i == 4) break;
			$args[] = $arguments[$i]->evaluate($scope);
		}
		
		if (!is_callable($args[1])) {
			throw new \InvalidArgumentException("RegexReplaceCallback: Second parameter is not a valid callback.");
		}
		
		if ($nargs < 4) {
			return call_user_func_array('preg_replace_callback', $args);
		}
		else {
			$target = $arguments[4];
				
			if (!($target instanceof Symbol)) {
				throw new \InvalidArgumentException(sprintf("RegexReplaceCallback: Expected symbol as fourth parameter but %s was found instead.", substr(strtolower(strstr(get_class($arguments[4]), '\\')), 1)));
			}
				
			$ref = $target->symbol;
				
			$result = preg_replace_callback($args[0], $args[1], $args[2], $args[3], $count);
			$scope->symbols[$ref] = $count;
			return $result;
		}
	}
}
?>