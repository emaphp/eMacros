<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;

class FilePackage extends Package {
	public function __construct() {
		parent::__construct('File');
		
		/**
		 * File functions
		 */
		$this['open'] = new PHPFunction('fopen');
		$this['close'] = new PHPFunction('fclose');
		$this['exists'] = new PHPFunction('file_exists');
		$this['get-contents'] = new PHPFunction('file_get_contents');
		$this['put-contents'] = new PHPFunction('file_put_contents');
		$this['read'] = new PHPFunction('fread');
		$this['write'] = new PHPFunction('fwrite');
		$this['file'] = new PHPFunction('file');
		$this['size'] = new PHPFunction('filesize');
		$this['basename'] = new PHPFunction('basename');
		$this['dirname'] = new PHPFunction('dirname');
		$this['parse-ini-file'] = new PHPFunction('parse_ini_file');
		$this['parse-ini-string'] = new PHPFunction('parse_ini_string');
		$this['pathinfo'] = new PHPFunction('pathinfo');
		$this['realpath'] = new PHPFunction('realpath');
		$this['stat'] = new PHPFunction('stat');
		
		/**
		 * Directory functions
		 */
		$this['scandir'] = new PHPFunction('scandir');
		
		/**
		 * Macros
		 */
		$this->macro('/^is-(dir|executable|file|link|readable|uploaded-file|writable|writeable)$/', function ($matches) {
			return new PHPFunction('is_' . str_replace('-', '_', $matches[1]));
		});
		
		/**
		 * Constants
		 */
		$this['FILE_USE_INCLUDE_PATH']   = FILE_USE_INCLUDE_PATH;
		$this['FILE_IGNORE_NEW_LINES']   = FILE_IGNORE_NEW_LINES;
		$this['FILE_SKIP_EMPTY_LINES']   = FILE_SKIP_EMPTY_LINES;
		$this['INI_SCANNER_NORMAL']      = INI_SCANNER_NORMAL;
		$this['INI_SCANNER_RAW']         = INI_SCANNER_RAW;
		$this['PATHINFO_DIRNAME']        = PATHINFO_DIRNAME;
		$this['PATHINFO_BASENAME']       = PATHINFO_BASENAME;
		$this['PATHINFO_EXTENSION']      = PATHINFO_EXTENSION;
		$this['PATHINFO_FILENAME']       = PATHINFO_FILENAME;
		$this['SCANDIR_SORT_ASCENDING']  = SCANDIR_SORT_ASCENDING;
		$this['SCANDIR_SORT_DESCENDING'] = SCANDIR_SORT_DESCENDING;
		$this['SCANDIR_SORT_NONE']       = SCANDIR_SORT_NONE;
	}
}
?>