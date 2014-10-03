<?php
namespace eMacros\Runtime\Property;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class PropertyGet implements Applicable {
	/**
	 * Property to obtain
	 * @var mixed
	 */
	public $property;
	
	public function __construct($property = null) {
		$this->property = $property;
	}
	
	/**
	 * Obtains a key/property in an array/object
	 * Usage: (# 'name' _obj) (# 3 _array) (#name _obj)
	 * Returns: Key/property value
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		//get index and value
		if (is_null($this->property)) {
			if (count($arguments) == 0) throw new \BadFunctionCallException("PropertyGet: No parameters found.");
			$key = $arguments[0]->evaluate($scope);
			
			if (count($arguments) == 1) {
				if (!array_key_exists(0, $scope->arguments)) throw new \BadFunctionCallException("PropertyGet: Expected value of type array/object as second parameter but none found.");
				$value = $scope->arguments[0];
			}
			else $value = $arguments[1]->evaluate($scope);
		}
		else {
			$key = $this->property;
			
			if (count($arguments) == 0) {
				if (!array_key_exists(0, $scope->arguments)) throw new \BadFunctionCallException("PropertyGet: Expected value of type array/object as first parameter but none found.");
				$value = $scope->arguments[0];
			}
			else $value = $arguments[0]->evaluate($scope);
		}
		
		//get index/property
		if (is_array($value)) {
			if (!array_key_exists($key, $value)) {
				if (is_int($key)) throw new \OutOfBoundsException(sprintf("PropertyGet: Key %s does not exists.", strval($key)));
				throw new \InvalidArgumentException(sprintf("PropertyGet: Key '%s' does not exists.", strval($key)));
			}
				
			return $value[$key];
		}
		elseif ($value instanceof \ArrayObject || $value instanceof \ArrayAccess) {
			if (!$value->offsetExists($key)) {
				if (is_int($key)) throw new \OutOfBoundsException(sprintf("PropertyGet: Key %s does not exists.", strval($key)));
				throw new \InvalidArgumentException(sprintf("PropertyGet: Key '%s' does not exists.", strval($key)));
			}
				
			return $value[$key];
		}
		elseif (is_object($value)) {
			//check property existence
			if (!property_exists($value, $key)) {
				//check existence through __isset
				if (method_exists($value, '__isset') && !$value->__isset($key)) throw new \InvalidArgumentException(sprintf("PropertyGet: Property '%s' not found.", strval($key)));
				//try calling __get
				if (method_exists($value, '__get')) return $value->__get($key);
				throw new \InvalidArgumentException(sprintf("PropertyGet: Property '%s' not found.", strval($key)));
			}
				
			//check property access
			$rp = new \ReflectionProperty($value, $key);
			if (!$rp->isPublic()) $rp->setAccessible(true);
			return $rp->getValue($value);
		}
		
		throw new \InvalidArgumentException(sprintf("PropertyGet: Expected value of type array/object but %s found instead", gettype($value)));
	}
}
?>