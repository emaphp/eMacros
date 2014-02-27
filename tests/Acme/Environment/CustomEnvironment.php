<?php
namespace Acme\Environment;

use eMacros\Environment\Environment;
use eMacros\Package\CorePackage;
use eMacros\Package\StringPackage;
use Acme\Package\CustomPackage;

class CustomEnvironment extends Environment {
	public function __construct() {
		$this->import(new CorePackage);
		$this->import(new StringPackage);
		$this->import(new CustomPackage);
	}
}
?>