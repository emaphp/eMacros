<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;
use eMacros\Runtime\HTML\ParseString;

class HTMLPackage extends Package {
	public function __construct() {
		parent::__construct('HTML');
		
		//HTML functions
		$this['nl2br'] = new PHPFunction('nl2br');
		$this['special-chars'] = new PHPFunction('htmlspecialchars');
		$this['special-chars-decode'] = new PHPFunction('htmlspecialchars_decode');
		$this['entities'] = new PHPFunction('htmlentities');
		$this['entity-decode'] = new PHPFunction('html_entity_decode');
		$this['strip-tags'] = new PHPFunction('strip_tags');
		
		//macros
		$this['parse-string'] = new ParseString();
		
		//htmlspecialchars flags
		$this['ENT_COMPAT'] = ENT_COMPAT;
		$this['ENT_QUOTES'] = ENT_QUOTES;
		$this['ENT_NOQUOTES'] = ENT_NOQUOTES;
		$this['ENT_IGNORE'] = ENT_IGNORE;
		$this['ENT_SUBSTITUTE'] = ENT_SUBSTITUTE;
		$this['ENT_DISALLOWED'] = ENT_DISALLOWED;
		$this['ENT_HTML401'] = ENT_HTML401;
		$this['ENT_XML1'] = ENT_XML1;
		$this['ENT_XHTML'] = ENT_XHTML;
		$this['ENT_HTML5'] = ENT_HTML5;
	}
}
?>