<?php
namespace eMacros\Environment;

use eMacros\Scope;
use eMacros\Package\Package;
use eMacros\Symbol;

class Environment extends Scope {
	/**
	 * Imported packages
	 * @var array
	 */
	public $packages = array();
	
	/**
	 * Program arguments
	 * @var array
	 */
	public $arguments = array();
	
	/**
	 * Validates a aymbol
	 * @param \eMacros\Symbol $symbol
	 * @throws \UnexpectedValueException
	 * @return array
	 */
	protected static function symbol($symbol) {
		if ($symbol instanceof Symbol) {
			return array($symbol->symbol, $symbol->package);
		}
	
		throw new \UnexpectedValueException(sprintf("Unexpected value of type '%s'.", is_object($symbol) ? get_class($symbol) : gettype($symbol)));
	}
	
	/**
	 * Imports a package to current symbol table
	 * @param Package $package
	 * @param string $id
	 */
	public function import(Package $package, $id = null) {
		$id = is_null($id) ? $package->id : $id;
		
		//load symbols
		$this->symbols = array_merge($package->symbols, $this->symbols);
		
		//load macros
		$this->macros = array_merge($package->macros, $this->macros);
					
		//store package
		$this->packages[$id] = $package;
	}
	
	/**
	 * Determines if a given package has been imported
	 * @param string $packageId
	 * @return boolean
	 */
	public function hasPackage($packageId) {
		return in_array($packageId, array_keys($this->packages));
	}
	
	/**
	 * Obtains a symbol from environment table
	 * (non-PHPdoc)
	 * @see \eMacros\Scope::offsetGet()
	 */
	public function offsetGet($symbol) {
		list($sym, $pck) = self::symbol($symbol);
		
		if (!is_null($pck)) {
			//check package
			if (!array_key_exists($pck, $this->packages)) {
				throw new \UnexpectedValueException(sprintf("Package '%s' not found.", $pck));
			}
			
			return $this->packages[$pck]->offsetGet($sym);
		}
		
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
	}
}
?>