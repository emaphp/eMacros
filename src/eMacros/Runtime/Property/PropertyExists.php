<?php
namespace eMacros\Runtime\Property;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;

class PropertyExists implements Applicable {
	/**
	 * Key/property to find
	 * @var mixed
	 */
	public $property;
	
	public function __construct($property = null) {
		$this->property = $property;
	}
	
	/**
	 * Checks if the given key/property is available in a array/object
	 * Usage: (#? 5 _array) (#? "name" _obj) (#name? _obj)
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		//get index and value
		if (is_null($this->property)) {
			if (count($arguments) == 0) throw new \BadFunctionCallException("PropertyExists: No parameters found.");
			$key = $arguments[0]->evaluate($scope);
			
			if (count($arguments) == 1) {
				if (!array_key_exists(0, $scope->arguments)) throw new \BadFunctionCallException("PropertyExists: Expected value of type array/object as second parameter but none found.");
				$value = $scope->arguments[0];
			}
			
			else $value = $arguments[1]->evaluate($scope);
		}
		else {
			$key = $this->property;
			
			if (count($arguments) == 0) {
				if (!array_key_exists(0, $scope->arguments)) throw new \BadFunctionCallException("PropertyExists: Expected value of type array/object as first parameter but none found.");
				$value = $scope->arguments[0];
			}
			
			else $value = $arguments[0]->evaluate($scope);
		}
		
		//get index/property
		if (is_array($value)) return array_key_exists($key, $value);
		elseif ($value instanceof \ArrayObject || $value instanceof \ArrayAccess) return $value->offsetExists($key);
		elseif (is_object($value)) {
			//check property existence
			if (!property_exists($value, $key)) {
				//check existence through __isset
				if (method_exists($value, '__isset')) return $value->__isset($key);
				return false;
			}
			
			return true;
		}
		
		throw new \InvalidArgumentException(sprintf("PropertyExists: Expected value of type array/object but %s found instead", gettype($value)));
	}
}
?>