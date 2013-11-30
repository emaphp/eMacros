<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;
use eMacros\Runtime\String\StringReplace;
use eMacros\Runtime\String\StringScan;

class StringPackage extends Package {
	public function __construct() {
		parent::__construct('String');
		
		//conversion
		$this['bin2hex'] = new PHPFunction('bin2hex');
		$this['hex2bin'] = new PHPFunction('hex2bin');
		$this['explode'] = new PHPFunction('explode');
		$this['implode'] = new PHPFunction('implode');
		$this['split'] = new PHPFunction('str_split');
		$this['getcsv'] = new PHPFunction('str_getcsv');
		
		//string functions
		$this['chr'] = new PHPFunction('chr');
		$this['ord'] = new PHPFunction('ord');
		$this['count-chars'] = new PHPFunction('count_chars');
		$this['repeat'] = new PHPFunction('str_repeat');
		$this['word-count'] = new PHPFunction('str_word_count');
		$this['cmp'] = new PHPFunction('strcmp');
		$this['len'] = new PHPFunction('strlen');
		$this['pos'] = new PHPFunction('strpos');
		$this['ipos'] = new PHPFunction('stripos');
		$this['str'] = new PHPFunction('strstr');
		$this['istr'] = new PHPFunction('stristr');
		$this['pbrk'] = new PHPFunction('strpbrk');
		$this['tok'] = new PHPFunction('strtok');
		
		//modification
		$this['addcslashes'] = new PHPFunction('addcslashes');
		$this['stripcslashes'] = new PHPFunction('stripcslashes');
		$this['substr'] = new PHPFunction('substr');
		$this['trim'] = new PHPFunction('trim');
		$this['ltrim'] = new PHPFunction('ltrim');
		$this['rtrim'] = new PHPFunction('rtrim');
		$this['pad'] = new PHPFunction('str_pad');
		$this['reverse'] = new PHPFunction('strrev');
		$this['shuffle'] = new PHPFunction('str_shuffle');
		$this['replace'] = new StringReplace('str_replace');
		$this['ireplace'] = new StringReplace('str_ireplace');
		
		//case
		$this['lcfirst'] = new PHPFunction('lcfirst');
		$this['ucfirst'] = new PHPFunction('ucfirst');
		$this['ucwords'] = new PHPFunction('ucwords');
		$this['to-lower'] = new PHPFunction('strtolower');
		$this['to-upper'] = new PHPFunction('strtoupper');
		
		//format
		$this['number-format'] = new PHPFunction('number_format');
		$this['sprintf'] = new PHPFunction('sprintf');
		$this['sscanf'] = new StringScan();
		
		//pad constants
		$this['PAD_LEFT'] = STR_PAD_LEFT;
		$this['PAD_RIGHT'] = STR_PAD_RIGHT;
		$this['PAD_BOTH'] = STR_PAD_BOTH;
	}
}
?>