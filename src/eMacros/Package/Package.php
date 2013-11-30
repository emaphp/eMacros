<?php
namespace eMacros\Package;

use eMacros\Scope;

abstract class Package extends Scope {
	/**
	 * Package id
	 * @var string
	 */
	public $id;
	
	public function __construct($id) {
		$this->id = $id;
	}
}
?>