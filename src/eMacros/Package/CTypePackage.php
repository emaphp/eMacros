<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;

class CTypePackage extends Package {
	public function __construct() {
		parent::__construct('CType');
		
		//ctype functions
		$this['alnum'] = new PHPFunction('ctype_alnum');
		$this['alpha'] = new PHPFunction('ctype_alpha');
		$this['cntrl'] = new PHPFunction('ctype_cntrl');
		$this['digit'] = new PHPFunction('ctype_digit');
		$this['graph'] = new PHPFunction('ctype_graph');
		$this['lower'] = new PHPFunction('ctype_lower');
		$this['print'] = new PHPFunction('ctype_print');
		$this['punct'] = new PHPFunction('ctype_punct');
		$this['space'] = new PHPFunction('ctype_space');
		$this['upper'] = new PHPFunction('ctype_upper');
		$this['xdigit'] = new PHPFunction('ctype_xdigit');
	}
}
?>
