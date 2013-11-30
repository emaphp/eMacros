<?php

namespace eMacros\Runtime\Value;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class ValueExists implements Applicable {
	public $index;
	
	public function __construct($index = null) {
		$this->index = $index;
	}
	
	public function apply(Scope $scope, GenericList $arguments) {
		//get index and value
		if (is_null($this->index)) {
			if (count($arguments) == 0) {
				throw new \BadFunctionCallException("ValueExists: No parameters found.");
			}
				
			$index = $arguments[0]->evaluate($scope);
				
			if (count($arguments) == 1) {
				if (!array_key_exists(0, $scope->arguments)) {
					throw new \BadFunctionCallException("ValueExists: Expected value of type array/object as second parameter but none found.");
				}
		
				$value = $scope->arguments[0];
			}
			else {
				$value = $arguments[1]->evaluate($scope);
			}
		}
		else {
			$index = $this->index;
				
			if (count($arguments) == 0) {
				if (!array_key_exists(0, $scope->arguments)) {
					throw new \BadFunctionCallException("ValueExists: Expected value of type array/object as first parameter but none found.");
				}
		
				$value = $scope->arguments[0];
			}
			else {
				$value = $arguments[0]->evaluate($scope);
			}
		}
		
		//get index/property
		if (is_array($value)) {
			return array_key_exists($index, $value);
		}
		elseif ($value instanceof \ArrayObject || $value instanceof \ArrayAccess) {
			return $value->offsetExists($index);
		}
		elseif (is_object($value)) {
			//check property existence
			if (!property_exists($value, $index)) {
				//check existence through __isset
				if (method_exists($value, '__isset')) {
					return $value->__isset($index);
				}
		
				return false;
			}
			
			return true;
		}
		
		throw new \InvalidArgumentException(sprintf("ValueExists: Expected value of type array/object but %s found instead", gettype($value)));
	}
}

?>