<?php
namespace eMacros\Runtime\Output;

use eMacros\Runtime\GenericFunction;

class OutputEcho extends GenericFunction {
	public function execute(array $arguments) {
		foreach ($arguments as $arg) {
			echo $arg;
		}
	}
}
?>