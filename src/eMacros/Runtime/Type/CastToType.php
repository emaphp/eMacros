<?php
namespace eMacros\Runtime\Type;

use eMacros\Runtime\GenericFunction;

class CastToType extends GenericFunction {
	/**
	 * Expected type
	 * @var string
	 */
	public $type;
	
	public function __construct($type) {
		$this->type = $type;
	}
	
	/**
	 * Casts a value to a especified type
	 * Usage: (as-string 2)
	 * Returns: the casted value 
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) {
			throw new \BadFunctionCallException("CastToType: No parameters found.");
		}
		
		$value = $arguments[0];
		
		switch ($this->type) {
			case 'bool':
			case 'boolean':
				$value = (bool) $value;
			break;

			case 'int':
			case 'integer':
				$value = (int) $value;
			break;
			
			case 'float':
			case 'double':
			case 'real':
				$value = (double) $value;
			break;
			
			case 'string':
				$value = (string) $value;
			break;
			
			case 'array':
				$value = (array) $value;
			break;
			
			case 'object':
				$value = (object) $value;
			break;
			
			case 'unset':
			case 'null':
				$value = null;
			break;
			
			case 'binary':
				$value = (binary) $value;
			break;
		}
		
		return $value;
	}
}
?>