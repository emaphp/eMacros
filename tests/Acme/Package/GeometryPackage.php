<?php
namespace Acme\Package;

use eMacros\Package\Package;
use Acme\Runtime\Distance;

class GeometryPackage extends Package {
	public function __construct() {
		parent::__construct('Geometry');

		//default distance
		$this['dist'] = new Distance(0, 0);

		//macro style
		$this->macro('@dist:X(\d+)Y(\d+)@', function ($matches) {
			return new Distance(intval($matches[1]), intval($matches[2]));
		});
	}
}