<?php
namespace eMacros\Runtime;

class PHPFunction extends GenericFunction {
	public $callback;
	
	public function __construct($callback) {
		if (!is_callable($callback)) {
			throw new \UnexpectedValueException('PHPFunction: Argument is not a valid callback.');
		}
		
		$this->callback = $callback;
	}
	
	public function execute(array $arguments) {
		return call_user_func_array($this->callback, $arguments);
	}
}
?>