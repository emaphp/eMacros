<?php
namespace eMacros\Program;

use eMacros\Environment\Environment;

class TextProgram extends Program {
	public function execute(Environment $env) {
		//set arguments
		$env->arguments = array_slice(func_get_args(), 1);
		
		$values = [];
		
		foreach ($this->expressions as $expr) {
			$values[] = $expr->evaluate($env);
		}
		
		return implode('', $values);
	}
}
?>