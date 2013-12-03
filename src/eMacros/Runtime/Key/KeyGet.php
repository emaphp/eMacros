<?php
namespace eMacros\Runtime\Key;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class KeyGet implements Applicable {
	/**
	 * Key to obtain
	 * @var mixed
	 */
	public $key;
	
	public function __construct($key = null) {
		$this->key = $key;
	}
	
	public function apply(Scope $scope, GenericList $arguments) {
		//get index and value
		if (is_null($this->key)) {
			if (count($arguments) == 0) {
				throw new \BadFunctionCallException("KeyGet: No parameters found.");
			}
			
			$key = $arguments[0]->evaluate($scope);
			
			if (count($arguments) == 1) {
				if (!array_key_exists(0, $scope->arguments)) {
					throw new \BadFunctionCallException("KeyGet: Expected value of type array/object as second parameter but none found.");
				}
				
				$value = $scope->arguments[0];
			}
			else {
				$value = $arguments[1]->evaluate($scope);
			}
		}
		else {
			$key = $this->key;
			
			if (count($arguments) == 0) {
				if (!array_key_exists(0, $scope->arguments)) {
					throw new \BadFunctionCallException("KeyGet: Expected value of type array/object as first parameter but none found.");
				}
				
				$value = $scope->arguments[0];
			}
			else {
				$value = $arguments[0]->evaluate($scope);
			}
		}
		
		//get index/property
		if (is_array($value)) {
			if (!array_key_exists($key, $value)) {
				if (is_int($key)) {
					throw new \OutOfBoundsException(sprintf("KeyGet: Key %s does not exists.", strval($key)));
				}
				
				throw new \InvalidArgumentException(sprintf("KeyGet: Key '%s' does not exists.", strval($key)));
			}
				
			return $value[$key];
		}
		elseif ($value instanceof \ArrayObject || $value instanceof \ArrayAccess) {
			if (!$value->offsetExists($key)) {
				if (is_int($key)) {
					throw new \OutOfBoundsException(sprintf("KeyGet: Key %s does not exists.", strval($key)));
				}
				
				throw new \InvalidArgumentException(sprintf("KeyGet: Key '%s' does not exists.", strval($key)));
			}
				
			return $value[$key];
		}
		elseif (is_object($value)) {
			//check property existence
			if (!property_exists($value, $key)) {
				//check existence through __isset
				if (method_exists($value, '__isset') && !$value->__isset($key)) {
					throw new \InvalidArgumentException(sprintf("KeyGet: Property '%s' not found.", strval($key)));
				}
		
				//try calling __get
				if (method_exists($value, '__get')) {
					return $value->__get($key);
				}
		
				throw new \InvalidArgumentException(sprintf("KeyGet: Property '%s' not found.", strval($key)));
			}
				
			//check property access
			$rp = new \ReflectionProperty($value, $key);
				
			if (!$rp->isPublic()) {
				throw new \InvalidArgumentException(sprintf("KeyGet: Cannot access non-public property '%s'.", strval($key)));
			}

			return $value->$key;
		}
		
		throw new \InvalidArgumentException(sprintf("KeyGet: Expected value of type array/object but %s found instead", gettype($value)));
	}
}
?>