<?php
namespace eMacros\Runtime\HTML;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ParseString implements Applicable {
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