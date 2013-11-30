<?php
namespace eMacros;

class GenericList extends \ArrayObject implements Expression {
	public function evaluate(Scope $scope) {
		//empty list
		if (!isset($this[0])) {
			throw new \BadFunctionCallException("No operation found.");
		}
		
		//determine which function must be called
		$function = $this[0]->evaluate($scope);
				
		if (is_callable($function) && is_object($function)) {
			$parameters = array();
			
			foreach ($this->shift() as $arg) {
				$parameters[] = $arg->evaluate($scope);
			}
	
			return call_user_func_array($function, $parameters);
		}
		
		if ($function instanceof Applicable) {
			return $function->apply($scope, $this->shift());
		}
		
		throw new \UnexpectedValueException(sprintf("Unexpected %s '%s' at the beginning of the list.",
													substr(strrchr(strtolower(get_class($this[0])), '\\'), 1),
													$this[0]->__toString()));
	}
	
	public function shift() {
		if (!isset($this[0])) {
			return;
		}
	
		return new self(array_slice($this->getArrayCopy(), 1));
	}
	
	public function __toString() {
		$sarr = array();
		
		foreach ($this as $expr) {
			$sarr[] = $expr instanceof Expression ? $expr->__toString() : '...';
		}
		
		return '(' . join(' ', $sarr) . ')';
	}
}
?>