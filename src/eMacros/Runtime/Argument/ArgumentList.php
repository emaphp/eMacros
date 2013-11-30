<?php
namespace eMacros\Runtime\Argument;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class ArgumentList implements Applicable {
	/**
	 * Returns argument list
	 * Usage: (%_)
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		return $scope->arguments;
	}
}
?>