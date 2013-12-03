<?php
namespace eMacros\Runtime\Environment;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;
use eMacros\Runtime\PHPFunction;

class EnvironmentUse implements Applicable {
	/**
	 * Imports a function into current environment
	 * Usage: (use utf8_decode) (use utf8_encode utf8enc)
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		foreach ($arguments as $name) {
			if ($name instanceof Symbol) {
				$func = $alias = $name->symbol;
			}
			elseif ($name instanceof GenericList) {
				//obtain symbol pair
				list($func, $alias) = $name;
				
				if (!($func instanceof Symbol)) {
					throw new \InvalidArgumentException(sprintf("Use: Expected symbol as first argument, %s found instead.", substr(strtolower(strstr(get_class($func), '\\')), 1)));
				}
				
				if (!($alias instanceof Symbol)) {
					throw new \InvalidArgumentException(sprintf("Use: Expected symbol as second argument, %s found instead.", substr(strtolower(strstr(get_class($alias), '\\')), 1)));
				}
				
				$func = $func->symbol;
				$alias = $alias->symbol;
			}
			else {
				throw new \InvalidArgumentException(sprintf("Use: Unexpected %s %s as argument.", substr(strtolower(strstr(get_class($name), '\\')), 1), $name->__toString()));
			}
			
			if (!function_exists($func)) {
				throw new \UnexpectedValueException("Use: Function $func not found.");
			}
			
			$scope->symbols[$alias] = new PHPFunction($func);
		}
		
		return null;
	}
}
?>