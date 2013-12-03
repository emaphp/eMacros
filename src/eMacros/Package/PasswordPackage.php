<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;

class PasswordPackage extends Package {
	public function __construct() {
		parent::__construct('Password');
		
		$this['crypt'] = new PHPFunction('crypt');
		
		//password functions
		if (function_exists('password_hash')) {
			$this['hash'] = new PHPFunction('password_hash');
		}
		
		if (function_exists('password_get_info')) {
			$this['get-info'] = new PHPFunction('password_get_info');
		}
		
		if (function_exists('password_needs_rehash')) {
			$this['needs-rehash'] = new PHPFunction('password_needs_rehash');
		}
		
		if (function_exists('password_verify')) {
			$this['verify'] = new PHPFunction('password_verify');
		}
		
		if (version_compare(phpversion(), '5.5', '>=')) {
			$this['PASSWORD_DEFAULT'] = PASSWORD_DEFAULT;
			$this['PASSWORD_BCRYPT']  = PASSWORD_BCRYPT;
		}
	}
}
?>