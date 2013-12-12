<?php
namespace Acme;

use eMacros\Environment\Environment;
use eMacros\Package\CorePackage;
use eMacros\Package\StringPackage;

class CustomEnvironment extends Environment {
	public function __construct() {
		$this->import(new CorePackage);
		$this->import(new StringPackage);
		$this->import(new CustomPackage);
	}
}
?>