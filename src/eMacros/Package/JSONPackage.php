<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;

class JSONPackage extends Package {
	public function __construct() {
		parent::__construct('JSON');
		
		//json functions
		$this['decode'] = new PHPFunction('json_decode');
		$this['encode'] = new PHPFunction('json_encode');
		
		//constants
		$this['HEX_TAG'] = JSON_HEX_TAG;
		$this['HEX_AMP'] = JSON_HEX_AMP;
		$this['HEX_APOS'] = JSON_HEX_APOS;
		$this['HEX_QUOT'] = JSON_HEX_QUOT;
		$this['FORCE_OBJECT'] = JSON_FORCE_OBJECT;
		$this['NUMERIC_CHECK'] = JSON_NUMERIC_CHECK;
		$this['BIGINT_AS_STRING'] = JSON_BIGINT_AS_STRING;
		$this['PRETTY_PRINT'] = JSON_PRETTY_PRINT;
		$this['UNESCAPED_SLASHES'] = JSON_UNESCAPED_SLASHES;
		$this['UNESCAPED_UNICODE'] = JSON_UNESCAPED_UNICODE;
	}
}
?>