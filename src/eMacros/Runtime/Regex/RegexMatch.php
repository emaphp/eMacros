<?php
namespace eMacros\Runtime\Regex;

use eMacros\Applicable;
use eMacros\Symbol;
use eMacros\Scope;
use eMacros\GenericList;

class RegexMatch implements Applicable {
	/**
	 * Returns the amount of matches found on the given subject
	 * Usage: (Regex::match "/([\d]{4})-([\d]{2})-([\d]{2})/" "2013-11-20" _matches Regex::OFFSET_CAPTURE 4)
	 * Returns: int
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs < 2) throw new \BadFunctionCallException("RegexMatch: Function expects at least 2 parameters.");
		if ($nargs == 2) return preg_match($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope));
		else {
			$target = $arguments[2];
			if (!($target instanceof Symbol))
				throw new \InvalidArgumentException(sprintf("RegexMatch: Expected symbol as third argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[2]), '\\')), 1)));
			$ref = $target->symbol;
			if ($nargs == 3) return preg_match($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope), $scope->symbols[$ref]);
			elseif ($nargs == 4) return preg_match($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope), $scope->symbols[$ref], $arguments[3]->evaluate($scope));
			return preg_match($arguments[0]->evaluate($scope), $arguments[1]->evaluate($scope), $scope->symbols[$ref], $arguments[3]->evaluate($scope), $arguments[4]->evaluate($scope));
		}
	}
}
?>