<?php
namespace eMacros\Runtime\Type;

use eMacros\Runtime\GenericFunction;

class IsType extends GenericFunction {
	/**
	 * Callback to invoke
	 * @var callable
	 */
	public $callback;
		
	public function __construct($callback) {
		$this->callback = $callback;
	}
	
	/**
	 * Determines if a value is of a given type
	 * Usage: (integer? 'hey') (string? _val) (null? _val1 _val2)
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		//check number of parameters
		if (empty($arguments)) throw new \BadFunctionCallException("IsType: No arguments found.");
		
		foreach ($arguments as $arg) {
			if (call_user_func($this->callback, $arg) === false) return false;
		}
		
		return true;
	}
}
?>