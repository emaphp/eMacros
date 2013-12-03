<?php
namespace eMacros\Runtime\Key;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class KeyAssign implements Applicable {
	/**
	 * Key/Property name
	 * @var mixed
	 */
	public $key;
	
	public function __construct($key = null) {
		$this->key = $key;
	}
	
	/**
	 * Sets a key/property value
	 * Usage: (@ 'name' "emma" _array) (@surname "doe" _obj)
	 * Returns: the assigned value
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if (is_null($this->key)) {
			if ($nargs == 0) {
				throw new \BadFunctionCallException("KeyAssign: No parameters found.");
			}
			elseif ($nargs == 1) {
				throw new \BadFunctionCallException("KeyAssign: No value specified.");
			}
			elseif ($nargs == 2) {
				throw new \BadFunctionCallException("KeyAssign: No target specified.");
			}
			
			$target = $arguments[2];
			
			if (!($target instanceof Symbol)) {
				throw new \InvalidArgumentException(sprintf("KeyAssign: Expected symbol as last argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[2]), '\\')), 1)));
			}
			
			$property = $arguments[0]->evaluate($scope);
			$value = $arguments[1]->evaluate($scope);
			$ref = $target->symbol;
		}
		else {
			if ($nargs == 0) {
				throw new \BadFunctionCallException("KeyAssign: No parameters found.");
			}
			elseif ($nargs == 1) {
				throw new \BadFunctionCallException("KeyAssign: No target specified.");
			}
			
			$target = $arguments[1];
				
			if (!($target instanceof Symbol)) {
				throw new \InvalidArgumentException(sprintf("KeyAssign: Expected symbol as last argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[1]), '\\')), 1)));
			}
			
			$property = $this->key;
			$value = $arguments[0]->evaluate($scope);
			$ref = $target->symbol;
		}
		
		if (is_array($scope->symbols[$ref]) || $scope->symbols[$ref] instanceof \ArrayAccess || $scope->symbols[$ref] instanceof \ArrayObject) {
			$scope->symbols[$ref][$property] = $value;
			return $value;
		}
		elseif (is_object($scope->symbols[$ref])) {
			if (!property_exists($scope->symbols[$ref], $property)) {
				if ($scope->symbols[$ref] instanceof \stdClass) {
					$scope->symbols[$ref]->$property = $value;
					return $value;
				}
				
				if (method_exists($scope->symbols[$ref], '__set')) {
					$scope->symbols[$ref]->__set($property, $value);
					return $value;
				}
				
				throw new \UnexpectedValueException(sprintf("KeyAssign: Property '$property' not found on class %s.", get_class($scope->symbols[$ref])));
			}
			
			$rp = new \ReflectionProperty($scope->symbols[$ref], $property);
			
			if (!$rp->isPublic()) {
				throw new \UnexpectedValueException(sprintf("KeyAssign: Property '$property' does not have public access on class %s.", get_class($scope->symbols[$ref])));
			}
			
			$scope->symbols[$ref]->$property = $value;
			return $value;
		}
		
		throw new \InvalidArgumentException(sprintf("KeyAssign: Expected array/object as last argument but %s was found instead.", gettype($scope->symbols[$ref])));
	}
}
?>