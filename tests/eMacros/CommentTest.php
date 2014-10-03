<?php
namespace eMacros;

use eMacros\Program\Program;
/**
 * 
 * @author emaphp
 * @group comment
 */
class CommentTest extends eMacrosTest {
	public function testComment0() {
		$program = new Program(';');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment1() {
		$program = new Program('; TEST');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment2() {
		$program = new Program('; TEST ;');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment3() {
		$program = new Program('; TEST ; ');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment4() {
		$program = new Program(' ; TEST ;');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment5() {
		$program = new Program(' ; TEST ; ');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment6() {
		$program = new Program(';(+ 1 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testComment7() {
		$program = new Program(";(+ 1 1)\n(+ 5 5)");
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testComment8() {
		$program = new Program(";(+ 1 1);\n(+ 5 5) ; THE END");
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testComment9() {
		$program = new Program(";(+ 1 1);\n(+ 5 5) ; THE END ;");
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testComment10() {
		$program = new Program('(+ 5 5) ; THE END ;');
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
}
?>