<?php
namespace eMacros\Program;

use eMacros\Environment\Environment;

class SimpleProgram extends Program {
	public function execute(Environment $env) {
		//set arguments
		$env->arguments = array_slice(func_get_args(), 1);
		
		$value = null;
	
		foreach ($this->expressions as $expr) {
			//store program result
			$value = $expr->evaluate($env);
		}
	
		return $value;
	}
}
?>