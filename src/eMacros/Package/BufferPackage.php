<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;

class BufferPackage extends Package {
	public function __construct() {
		parent::__construct('Buffer');
		
		$this['start'] = new PHPFunction('ob_start');
		$this['list-handlers'] = new PHPFunction('ob_list_handlers');
		$this['get-status'] = new PHPFunction('ob_get_status');
		$this['get-level'] = new PHPFunction('ob_get_level');
		$this['get-length'] = new PHPFunction('ob_get_length');
		$this['get-flush'] = new PHPFunction('ob_get_flush');
		$this['get-contents'] = new PHPFunction('ob_get_contents');
		$this['get-clean'] = new PHPFunction('ob_get_clean');
		$this['flush'] = new PHPFunction('ob_flush');
		$this['end-flush'] = new PHPFunction('ob_end_flush');
		$this['end-clean'] = new PHPFunction('ob_end_clean');
		$this['clean'] = new PHPFunction('ob_clean');
		
		//status constants
		$this['START'] = PHP_OUTPUT_HANDLER_START;
		$this['WRITE'] = PHP_OUTPUT_HANDLER_WRITE;
		$this['FINAL'] = PHP_OUTPUT_HANDLER_FINAL;
		$this['CLEAN'] = PHP_OUTPUT_HANDLER_CLEAN;
		$this['FLUSH'] = PHP_OUTPUT_HANDLER_FLUSH;
		
		$this['STD_FLAGS'] = PHP_OUTPUT_HANDLER_STDFLAGS;
		$this['REMOVABLE'] = PHP_OUTPUT_HANDLER_REMOVABLE;
		$this['FLUSHABLE'] = PHP_OUTPUT_HANDLER_FLUSHABLE;
		$this['CLEANABLE'] = PHP_OUTPUT_HANDLER_CLEANABLE;
	}
}
?>