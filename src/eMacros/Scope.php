<?php
namespace eMacros;

class Scope implements \ArrayAccess, \IteratorAggregate {
	/**
	 * Symboil table
	 * @var array
	 */
	public $symbols = array();
	
	/**
	 * Macros list
	 * @var array
	 */
	public $macros = array();
		
	protected static function symbol($symbol) {
		if ($symbol instanceof Symbol) {
			return $symbol->symbol;
		}
		elseif (is_string($symbol)) {
			return $symbol;
		}
		
		throw new \UnexpectedValueException(sprintf("Unexpected value of type '%s'.", is_object($symbol) ? get_class($symbol) : gettype($symbol)));
	}
	
	/**
	 * Obtains a symbol from table
	 * (non-PHPdoc)
	 * @see ArrayAccess::offsetGet()
	 */
	public function offsetGet($symbol) {		
		$sym = self::symbol($symbol);

		//is symbol defined on this scope?
		if (array_key_exists($sym, $this->symbols)) {
			return $this->symbols[$sym];
		}
		else {
			foreach ($this->macros as $regex => $callback) {
				if (preg_match($regex, $sym, $matches)) {
					$this->symbols[$sym] = $callback->__invoke($matches);
					return $this->symbols[$sym];
				}
			}
		}
		
		return null;
	}
	
	public function offsetExists($symbol) {
		return true;
	}
	
	/**
	 * Stores a symbol
	 * Used when setting up a Scope/Package
	 * Ex: $this['.'] = new Concatenation();
	 * (non-PHPdoc)
	 * @see ArrayAccess::offsetSet()
	 */
	public function offsetSet($symbol, $value) {
		$symbol = Symbol::validateSymbol($symbol);
		$this->symbols[$symbol] = $value;
	}
	
	/**
	 * Removes a symbol from table
	 * (non-PHPdoc)
	 * @see ArrayAccess::offsetUnset()
	 */
	public function offsetUnset($symbol) {
		unset($this->symbols[$symbol]);
	}
	
	/**
	 * Obtains a symbol iterator
	 * (non-PHPdoc)
	 * @see IteratorAggregate::getIterator()
	 */
	public function getIterator() {
		$symbols = array();
		
		foreach ($this->listSymbols() as $name) {
			$symbols[$name] = $this[$name];
		}
	
		return new \ArrayIterator($symbols);
	}
	
	/**
	 * Obtains all defined symbols
	 * @return array
	 */
	public function listSymbols() {
		return array_keys($this->symbols);
	}
	
	/**
	 * Adds a new macro
	 * @param string $regex
	 * @param \Closure $handler
	 */
	public function macro($regex, \Closure $handler) {
		$this->macros[$regex] = $handler;
	}
}
?>