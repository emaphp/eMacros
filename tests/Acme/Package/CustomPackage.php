<?php
namespace Acme\Package;

use eMacros\Package\Package;

class CustomPackage extends Package {
	public function __construct() {
		//debemos especificar un ID de paquete
		parent::__construct('Custom');
	
		$this['MY_CONSTANT'] = 42;
		$this['message'] = "this is a custom package";
	}
}
?>