<?php
namespace eMacros\Runtime\Value;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class ValueGet implements Applicable {
	public $index;
	
	public function __construct($index = null) {
		$this->index = $index;
	}
	
	public function apply(Scope $scope, GenericList $arguments) {
		//get index and value
		if (is_null($this->index)) {
			if (count($arguments) == 0) {
				throw new \BadFunctionCallException("ValueGet: No parameters found.");
			}
			
			$index = $arguments[0]->evaluate($scope);
			
			if (count($arguments) == 1) {
				if (!array_key_exists(0, $scope->arguments)) {
					throw new \BadFunctionCallException("ValueGet: Expected value of type array/object as second parameter but none found.");
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
					throw new \BadFunctionCallException("ValueGet: Expected value of type array/object as first parameter but none found.");
				}
				
				$value = $scope->arguments[0];
			}
			else {
				$value = $arguments[0]->evaluate($scope);
			}
		}
		
		//get index/property
		if (is_array($value)) {
			if (!array_key_exists($index, $value)) {
				if (is_int($index)) {
					throw new \OutOfBoundsException(sprintf("ValueGet: Index %s does not exists.", strval($index)));
				}
				
				throw new \InvalidArgumentException(sprintf("ValueGet: Index %s does not exists.", strval($index)));
			}
				
			return $value[$index];
		}
		elseif ($value instanceof \ArrayObject || $value instanceof \ArrayAccess) {
			if (!$value->offsetExists($index)) {
				if (is_int($index)) {
					throw new \OutOfBoundsException(sprintf("ValueGet: Index %s does not exists.", strval($index)));
				}
				
				throw new \InvalidArgumentException(sprintf("ValueGet: Index %s does not exists.", strval($index)));
			}
				
			return $value[$index];
		}
		elseif (is_object($value)) {
			//check property existence
			if (!property_exists($value, $index)) {
				//check existence through __isset
				if (method_exists($value, '__isset') && !$value->__isset($index)) {
					throw new \InvalidArgumentException(sprintf("ValueGet: Property '%s' not found.", strval($index)));
				}
		
				//try calling __get
				if (method_exists($value, '__get')) {
					return $value->__get($index);
				}
		
				throw new \InvalidArgumentException(sprintf("ValueGet: Property '%s' not found.", strval($index)));
			}
				
			//check property access
			$rp = new \ReflectionProperty($value, $index);
				
			if (!$rp->isPublic()) {
				throw new \InvalidArgumentException(sprintf("ValueGet: Cannot access non-public property '%s'.", strval($index)));
			}
				
			return $value->$index;
		}
		
		throw new \InvalidArgumentException(sprintf("ValueGet: Expected value of type array/object but %s found instead", gettype($value)));
	}
}
?>