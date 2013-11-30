<?php
namespace eMacros\Runtime\String;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class StringScan implements Applicable {
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs == 0) {
			throw new \BadFunctionCallException("StringScan: No parameters found.");
		}
		elseif ($nargs == 1) {
			throw new \BadFunctionCallException("StringScan: No format specified.");
		}
		
		$str = $arguments[0]->evaluate($scope);
		$format = $arguments[1]->evaluate($scope);
		
		if ($nargs > 2) {
			$arr = sscanf($str, $format);
			
			for ($i = 0, $n = count($arr); $i < $n && $i < $nargs - 2; $i++) {
				$target = $arguments[$i + 2];
				
				if (!($target instanceof Symbol)) {
					throw new \InvalidArgumentException(sprintf("StringScan: Unexpected %s found as additional parameter.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
				}
				
				$ref = $target->symbol;
				$scope->symbols[$ref] = $arr[$i];
			}
			
			return count($arr);
		}
		else {
			return sscanf($str, $format);
		}
	}
}
?>