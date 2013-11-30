<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;
use eMacros\Runtime\Regex\RegexReplace;
use eMacros\Runtime\Regex\RegexReplaceCallback;
use eMacros\Runtime\Regex\RegexMatch;
use eMacros\Runtime\Regex\RegexMatchAll;

class RegexPackage extends Package {
	public function __construct() {
		parent::__construct('Regex');
		
		//functions
		$this['grep'] = new PHPFunction('preg_grep');
		$this['quote'] = new PHPFunction('preg_quote');
		$this['split'] = new PHPFunction('preg_split');
		
		//macros
		$this['match'] = new RegexMatch();
		$this['match-all'] = new RegexMatchAll();
		$this['replace'] = new RegexReplace();
		$this['replace-callback'] = new RegexReplaceCallback();
		
		//predefined contants
		$this['OFFSET_CAPTURE'] = PREG_OFFSET_CAPTURE;
		$this['GREP_INVERT'] = PREG_GREP_INVERT;
		$this['PATTERN_ORDER'] = PREG_PATTERN_ORDER;
		$this['SET_ORDER'] = PREG_SET_ORDER;
		$this['SPLIT_NO_EMPTY'] = PREG_SPLIT_NO_EMPTY;
		$this['SPLIT_DELIM_CAPTURE'] = PREG_SPLIT_DELIM_CAPTURE;
		$this['SPLIT_OFFSET_CAPTURE'] = PREG_SPLIT_OFFSET_CAPTURE;
	}
}
?>