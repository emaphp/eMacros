<?php
namespace eMacros\Runtime\Property;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class PropertyAssign implements Applicable {
	/**
	 * Key/Property name
	 * @var mixed
	 */
	public $property;
	
	public function __construct($property = null) {
		$this->property = $property;
	}
	
	/**
	 * Sets a key/property value
	 * Usage: (#= 'name' _obj "emma") (#surname= _obj "doe")
	 * Returns: the assigned value
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if (is_null($this->property)) {
			if ($nargs == 0) {
				throw new \BadFunctionCallException("PropertyAssign: No key defined.");
			}
			elseif ($nargs == 1) {
				throw new \BadFunctionCallException("PropertyAssign: No target specified.");
			}
			elseif ($nargs == 2) {
				throw new \BadFunctionCallException("PropertyAssign: No value specified.");
			}
			
			$target = $arguments[1];
			
			if (!($target instanceof Symbol)) {
				throw new \InvalidArgumentException(sprintf("PropertyAssign: Expected symbol as second argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[1]), '\\')), 1)));
			}
			
			$property = $arguments[0]->evaluate($scope);
			$value = $arguments[2]->evaluate($scope);
			$ref = $target->symbol;
		}
		else {
			if ($nargs == 0) {
				throw new \BadFunctionCallException("PropertyAssign: No target found.");
			}
			elseif ($nargs == 1) {
				throw new \BadFunctionCallException("PropertyAssign: No value specified.");
			}
			
			$target = $arguments[0];
				
			if (!($target instanceof Symbol)) {
				throw new \InvalidArgumentException(sprintf("PropertyAssign: Expected symbol as last argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
			}
			
			$property = $this->property;
			$value = $arguments[1]->evaluate($scope);
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
				
				throw new \UnexpectedValueException(sprintf("PropertyAssign: Property '$property' not found on class %s.", get_class($scope->symbols[$ref])));
			}
			
			$rp = new \ReflectionProperty($scope->symbols[$ref], $property);
			
			if (!$rp->isPublic()) {
				$rp->setAccessible(true);
			}
			
			$rp->setValue($scope->symbols[$ref], $value);
			return $value;
		}
		
		throw new \InvalidArgumentException(sprintf("PropertyAssign: Expected array/object as last argument but %s was found instead.", gettype($scope->symbols[$ref])));
	}
}
?>