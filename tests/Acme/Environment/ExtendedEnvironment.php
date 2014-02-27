<?php
namespace Acme\Environment;

use eMacros\Environment\Environment;
use eMacros\Package\CorePackage;
use eMacros\Package\StringPackage;
use eMacros\Package\ArrayPackage;
use eMacros\Package\RequestPackage;
use eMacros\Package\DatePackage;
use eMacros\Package\HashPackage;
use eMacros\Package\MathPackage;
use eMacros\Package\RegexPackage;
use eMacros\Package\FilePackage;
use eMacros\Package\FilterPackage;
use eMacros\Package\HTMLPackage;
use eMacros\Package\CTypePackage;
use eMacros\Package\PasswordPackage;
use eMacros\Package\JSONPackage;
use eMacros\Package\BufferPackage;

class ExtendedEnvironment extends Environment {
	public function __construct() {
		$this->import(new CorePackage);
		$this->import(new StringPackage);
		$this->import(new ArrayPackage);
		$this->import(new RegexPackage);
		$this->import(new DatePackage);
		$this->import(new HTMLPackage);
		$this->import(new RequestPackage);
		$this->import(new MathPackage);
		$this->import(new HashPackage);
		$this->import(new PasswordPackage);
		$this->import(new FilePackage);
		$this->import(new FilterPackage);
		$this->import(new CTypePackage);
		$this->import(new JSONPackage);
		$this->import(new BufferPackage);
	}
}
?>