<?php
namespace eMacros\Runtime\HTML;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ParseString implements Applicable {
	/**
	 * Parses an input string
	 * Usage: (HTML::parse-string "first=value&arr[]=foo+bar&arr[]=baz" _output)
	 * Returns: NULL
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (count($arguments) == 0) {
			throw new \BadFunctionCallException("ParseString: No parameters found.");
		}
		
		$arr = array();
		parse_str($arguments[0]->evaluate($scope), $arr);
		return $arr;
	}
}
?>