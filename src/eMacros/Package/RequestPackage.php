<?php
namespace eMacros\Package;

class RequestPackage extends Package {
	public function __construct() {
		parent::__construct('Request');
		
		global $_GET, $_POST, $_REQUEST, $_SESSION, $_COOKIE, $_FILES;
		
		$this['GET']     = $_GET;
		$this['POST']    = $_POST;
		$this['REQUEST'] = $_REQUEST;
		$this['SESSION'] = $_SESSION;
		$this['COOKIE']  = $_COOKIE;
		$this['FILES']   = $_FILES;
	}
}
?>