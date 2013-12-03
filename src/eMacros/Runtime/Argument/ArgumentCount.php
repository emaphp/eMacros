<?php
namespace eMacros\Runtime\Argument;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class ArgumentCount implements Applicable {
	/**
	 * Returns the number of available arguments
	 * Usage: (%#)
	 * Returns: int
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		return count($scope->arguments);
	}
}
?>