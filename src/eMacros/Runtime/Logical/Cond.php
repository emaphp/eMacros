<?php
namespace eMacros\Runtime\Logical;

use eMacros\Applicable;
use eMacros\GenericList;
use eMacros\Scope;

class Cond implements Applicable {
	/**
	 * Returns a value depending on a condition
	 * Usage: (cond ((is-integer? (%0)) 'Integer') ((is-string? (%0)) 'String') (true 'Unexpected type'))
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		foreach ($arguments as $pair) {
			list($condition, $body) = $pair;
			if ($condition->evaluate($scope)) return $body->evaluate($scope);
		}
	}
}
?>