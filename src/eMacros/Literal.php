<?php
namespace eMacros;

class Literal implements Expression {
	/**
	 * Literal value
	 * @var mixed
	 */
	public $value;

    public function __construct($value) {
        if (!in_array(gettype($value), array('integer', 'double', 'string'))) {
            throw new \UnexpectedValueException(sprintf("Literal: Unexpected value of type '%s'.", gettype($value)));
        }
        
        $this->value = $value;
    }

    public function evaluate(Scope $scope) {
        return $this->value;
    }
	
	public function isInteger() {
		return is_int($this->value);
	}
	
	public function isReal() {
		return is_float($this->value);
	}
	
	public function isString() {
		return is_string($this->value);
	}
	
	public function __toString() {
		return var_export($this->value, true);
	}
}
?>