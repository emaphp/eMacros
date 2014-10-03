<?php
namespace eMacros\Exception;

class ParseException extends \Exception {
	public $code, $offset, $sourceFile;
	
	public function __construct($code, $offset, $file = null) {
		$this->code = $code;
		$this->offset = $offset;
		$this->sourceFile = $file;
		
		//build message
		$this->message = is_null($file) ?  sprintf("Parse error found on line %d, column %d.", $this->getSourceLine(), $this->getSourceColumn())
		: sprintf("Parse error on file '%s' (Line %d, Column %d).", $file, $this->getSourceLine(), $this->getSourceColumn());
	}
	
	public function getSourceFile() {
		return $this->sourceFile;
	}
	
	public function getSourceLine() {
		if ($this->offset <= 0)
			return 1;

		return substr_count($this->code, "\n", 0, $this->offset) + 1;
	}
	
	public function getSourceColumn() {
		$pos = strrpos(substr($this->code, 0, $this->offset), "\n");
		return $this->offset - ($pos === false ? -1 : $pos);
	}
}
?>