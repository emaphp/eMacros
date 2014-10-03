<?php
namespace eMacros\Runtime\Output;

use eMacros\Runtime\GenericFunction;

class OutputEcho extends GenericFunction {
	/**
	 * Outputs a value
	 * Usage: (echo "Hello World") (echo "Hello" " " "World")
	 * Returns: NULL
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		foreach ($arguments as $arg) echo $arg;
	}
}
?>