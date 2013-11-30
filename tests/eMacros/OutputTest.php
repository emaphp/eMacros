<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;

/**
 * 
 * @author emaphp
 * @group output
 */
class OutputTest extends eMacrosTest {
	public function testEcho() {
		$program = new SimpleProgram('(Buffer::start)(echo "Hello" " " "World")(Buffer::get-clean)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("Hello World", $result);
	}
	
	public function testVarDump() {
		$program = new SimpleProgram('(Buffer::start)(var-dump true)(Buffer::get-clean)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("bool(true)\n", $result);
	}
	
	public function testPrintR() {
		$program = new SimpleProgram('(Buffer::start)(print-r (array 1 2 3))(Buffer::get-clean)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("Array\n(\n    [0] => 1\n    [1] => 2\n    [2] => 3\n)\n", $result);
	}
}
?>