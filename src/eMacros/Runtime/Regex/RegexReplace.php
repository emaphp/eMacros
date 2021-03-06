<?php
namespace eMacros\Runtime\Regex;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class RegexReplace implements Applicable {
	/**
	 * Replaces all matches specified by a pattern on a given subject
	 * Usage: (Regex::replace "/(\\w+) (\\d+), (\\d+)/i" "${1}1,$3" "April 15, 2003")
	 * Returns: array | string
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		if ($nargs < 3) throw new \BadFunctionCallException("RegexReplace: Function expects at least 3 parameters.");
		$args = [];
		
		for ($i = 0; $i < $nargs; $i++) {
			if ($i == 4) break;
			$args[] = $arguments[$i]->evaluate($scope);
		}
		
		if ($nargs < 4) return call_user_func_array('preg_replace', $args);
		else {
			$target = $arguments[4];
			if (!($target instanceof Symbol))
				throw new \InvalidArgumentException(sprintf("RegexReplace: Expected symbol as fourth parameter but %s was found instead.", substr(strtolower(strstr(get_class($arguments[4]), '\\')), 1)));
			$result = preg_replace($args[0], $args[1], $args[2], $args[3], $count);
			$scope->symbols[$target->symbol] = $count;
			return $result;
		}
	}
}
?>