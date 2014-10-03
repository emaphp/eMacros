<?php
namespace eMacros\Program;

use eMacros\Environment\Environment;

class Program extends AbstractProgram {
	public function execute(Environment $env) {
		//set arguments
		$env->arguments = array_slice(func_get_args(), 1);
		$value = null;
	
		foreach ($this->expressions as $expr)
			$value = $expr->evaluate($env);
	
		return $value;
	}
}
?>