<?php
namespace eMacros\Runtime\Value;

use eMacros\Runtime\GenericFunction;

class ValueReturn extends GenericFunction {
	public function execute($arguments) {
		if (empty($arguments)) {
			return null;
		}
		
		return $arguments[0];
	}
}
?>