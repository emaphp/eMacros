<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
/**
 * 
 * @author emaphp
 * @group comment
 */
class CommentTest extends eMacrosTest {
	public function testComment0() {
		$program = new SimpleProgram(';');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment1() {
		$program = new SimpleProgram('; TEST');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment2() {
		$program = new SimpleProgram('; TEST ;');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment3() {
		$program = new SimpleProgram('; TEST ; ');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment4() {
		$program = new SimpleProgram(' ; TEST ;');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment5() {
		$program = new SimpleProgram(' ; TEST ; ');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment6() {
		$program = new SimpleProgram(';(+ 1 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment7() {
		$program = new SimpleProgram(";(+ 1 1)\n(+ 5 5)");
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testComment8() {
		$program = new SimpleProgram(";(+ 1 1);\n(+ 5 5) ; THE END");
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testComment9() {
		$program = new SimpleProgram(";(+ 1 1);\n(+ 5 5) ; THE END ;");
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testComment10() {
		$program = new SimpleProgram('(+ 5 5) ; THE END ;');
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
}
?>