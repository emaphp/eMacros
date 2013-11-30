<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;

class HashPackage extends Package {
	public function __construct() {
		parent::__construct('Hash');
		
		//hashing functions
		$this['md5'] = new PHPFunction('md5');
		$this['md5-file'] = new PHPFunction('md5_file');
		$this['sha1'] = new PHPFunction('sha1');
		$this['sha1-file'] = new PHPFunction('sha1_file');
		
		//hash only
		$this['hash'] = new PHPFunction('hash');
		$this['file'] = new PHPFunction('hash_file');
		$this['init'] = new PHPFunction('hash_init');
		$this['update'] = new PHPFunction('hash_update');
		$this['final'] = new PHPFunction('hash_final');
	}
}
?>