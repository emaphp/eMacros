<?php
namespace eMacros;

class Symbol implements Expression {
	/**
	 * Symbol expression
	 * @var string
	 */
	public $symbol;
	
	/**
	 * Symbol package
	 * @var NULL|string
	 */
	public $package;
	
	/**
	 * Package prefix regex
	 * @var string
	 */
	const PACKAGE_PREFIX = '/^([a-z|A-Z|_][\w]+)::/';
	
	/**
	 * Symbol validation regex
	 * @var string
	 */
	const PATTERN = '{^[^\s\d(){}\[\]"\';][^\s\'"(){}\[\];]*$}';

	public static function validateSymbol($symbol) {
		if (!is_string($symbol))
			throw new \UnexpectedValueException(sprintf("Symbol: unexpected value of type '%s'.", gettype($symbol)));
		
		if (!preg_match(self::PATTERN, $symbol))
			throw new \UnexpectedValueException(sprintf("Symbol: '%s' is not a valid symbol.", $symbol));
	
		return $symbol;
	}
	
	public function __construct($symbol) {
		//obtain package, if any
		if (preg_match(self::PACKAGE_PREFIX, $symbol, $matches)) {
			$this->package = $matches[1];
			$symbol = substr($symbol, strlen($this->package) + 2);
		}

		$this->symbol = self::validateSymbol($symbol);
	}
	
	public function evaluate(Scope $scope) {
		return $scope[$this];
	}
	
	public function __toString() {
		return $this->symbol;
	}
}
?>