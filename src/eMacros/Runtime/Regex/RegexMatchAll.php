<?php
namespace eMacros\Runtime\Regex;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class RegexMatchAll implements Applicable {
	/**
	 * Returns the amount of matches found on the given subject
	 * Usage: (Regex::match-all "/([\d]{2})/" "34,4,12,52" _matches Regex::SET_ORDER 3)
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
	
		if ($nargs < 2) {
			throw new \BadFunctionCallException("RegexMatchAll: Function expects at least 2 parameters.");
		}
	
		if ($nargs == 2) {
			return preg_match_all($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope));
		}
		else {
			$target = $arguments[2];
				
			if (!($target instanceof Symbol)) {
				throw new \InvalidArgumentException(sprintf("RegexMatchAll: Expected symbol as third argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[2]), '\\')), 1)));
			}
				
			$ref = $target->symbol;
				
			if ($nargs == 3) {
				return preg_match_all($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope), $scope->symbols[$ref]);
			}
			elseif ($nargs == 4) {
				return preg_match_all($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope), $scope->symbols[$ref], $arguments[3]->evaluate($scope));
			}
			else {
				return preg_match_all($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope), $scope->symbols[$ref], $arguments[3]->evaluate($scope), $arguments[4]->evaluate($scope));
			}
		}
	}
}
?>