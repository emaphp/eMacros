<?php
namespace Acme\Package;

use eMacros\Package\Package;
use Acme\Runtime\Increment;

class UserPackage extends Package {
	public function __construct() {
		parent::__construct('User');
	
		/**
		 * Incrementar valor de variable
		 * Uso: (inc _x) (inc _y 3)
		*/
		$this['inc'] = new Increment();
	}
}
?>