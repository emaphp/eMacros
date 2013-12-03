<?php
namespace eMacros\Runtime\Method;

use eMacros\Runtime\GenericFunction;

class MethodInvoke extends GenericFunction {
	/**
	 * Method name
	 * @var string
	 */
	public $method;
	
	public function __construct($method = null) {
		$this->method = $method;
	}
	
	/**
	 * Invokes a method with the given arguments
	 * Usage: (->format (new Datetime) "Y-m-d")
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) {
			throw new \BadFunctionCallException('MethodInvoke: No parameters found.');
		}
		
		if (is_null($this->method)) {
			if (!isset($arguments[1])) {
				throw new \BadFunctionCallException('MethodInvoke: No instance defined.');
			}
			
			//check method type
			if (!is_string($arguments[0])) {
				throw new \InvalidArgumentException(sprintf("MethodInvoke: A value of type string was expected as first argument but %s found instead.", gettype($arguments[0])));
			}
			
			//check istance type
			if (!is_object($arguments[1])) {
				throw new \InvalidArgumentException(sprintf("MethodInvoke: A value of type object was expected but %s found instead.", gettype($arguments[1])));
			}
			
			$method = $arguments[0];
			$instance = $arguments[1];
			$parameters = array_slice($arguments, 2);
		}
		else {
			if (!is_object($arguments[0])) {
				throw new \InvalidArgumentException(sprintf("MethodInvoke: A value of type object was expected but %s found instead.", gettype($arguments[0])));
			}
			
			$method = $this->method;
			$instance = $arguments[0];
			$parameters = array_slice($arguments, 1);
		}

		//check method existence
		if (!method_exists($instance, $method)) {
			if (!method_exists($instance, '__call')) {
				throw new \InvalidArgumentException(sprintf("MethodInvoke: Method '$method' was not found on instance of '%s'.", get_class($instance)));
			}
			
			return call_user_func(array($instance, '__call'), $method, $parameters);
		}
		
		//check method access and required parameters
		$rm = new \ReflectionMethod($instance, $method);
		
		if (!$rm->isPublic()) {
			throw new \BadMethodCallException(sprintf("Method '%s' does not have public access.", $method));
		}
		
		if ($rm->getNumberOfRequiredParameters() > count($parameters)) {
			throw new \BadMethodCallException(sprintf("Method '%s' expects at least %d argument(s).", $method, $rm->getNumberOfRequiredParameters()));
		}
		
		return call_user_func_array(array($instance, $method), $parameters);
	}
}
?>