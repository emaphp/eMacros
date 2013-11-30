<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
/**
 * 
 * @author emaphp
 * @group logical
 */
class LogicalTest extends eMacrosTest {
	/**
	 * NOT
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testNot0() {
		$program = new SimpleProgram('(not)');
		$result = $program->execute(self::$env);
	}
	
	public function testNot1() {
		$program = new SimpleProgram('(not true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNot2() {
		$program = new SimpleProgram('(not false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNot3() {
		$program = new SimpleProgram('(not 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNot4() {
		$program = new SimpleProgram('(not 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNot5() {
		$program = new SimpleProgram('(not "")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNot6() {
		$program = new SimpleProgram('(not "test")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNot7() {
		$program = new SimpleProgram('(not true false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * AND
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testAnd0() {
		$program = new SimpleProgram('(and)');
		$result = $program->execute(self::$env);
	}
	
	public function testAnd1() {
		$program = new SimpleProgram('(and true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testAnd2() {
		$program = new SimpleProgram('(and true false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testAnd3() {
		$program = new SimpleProgram('(and true true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testAnd4() {
		$program = new SimpleProgram('(and true 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testAnd5() {
		$program = new SimpleProgram('(and true false 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testAnd6() {
		$program = new SimpleProgram('(and true null 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	/**
	 * OR
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testOr0() {
		$program = new SimpleProgram('(or)');
		$result = $program->execute(self::$env);
	}
	
	public function testOr1() {
		$program = new SimpleProgram('(or true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testOr2() {
		$program = new SimpleProgram('(or true false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testOr3() {
		$program = new SimpleProgram('(or false false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testOr4() {
		$program = new SimpleProgram('(or true 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testOr5() {
		$program = new SimpleProgram('(or 1 false true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testOr6() {
		$program = new SimpleProgram('(or null true 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testOr7() {
		$program = new SimpleProgram('(or null 0 "")');
		$result = $program->execute(self::$env);
		$this->assertEquals('', $result);
	}
	
	/**
	 * IF
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIf0() {
		$program = new SimpleProgram('(if)');
		$result = $program->execute(self::$env);
	}
	
	public function testIf1() {
		$program = new SimpleProgram('(if true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testIf2() {
		$program = new SimpleProgram('(if false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testIf3() {
		$program = new SimpleProgram("(if true 'T')");
		$result = $program->execute(self::$env);
		$this->assertEquals('T', $result);
	}
	
	public function testIf4() {
		$program = new SimpleProgram("(if false 'T')");
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testIf5() {
		$program = new SimpleProgram("(if false 'T' 'F')");
		$result = $program->execute(self::$env);
		$this->assertEquals('F', $result);
	}
	
	/**
	 * Binary operators
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testBinaryOr1() {
		$program = new SimpleProgram("(|)");
		$result = $program->execute(self::$env);
	}
	
	public function testBinaryOr2() {
		$program = new SimpleProgram("(| 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testBinaryOr3() {
		$program = new SimpleProgram("(| 1 0)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testBinaryOr4() {
		$program = new SimpleProgram("(| 0 0)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testBinaryOr5() {
		$program = new SimpleProgram("(| 0 0 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testBinaryOr6() {
		$program = new SimpleProgram("(| 8 5)");
		$result = $program->execute(self::$env);
		$this->assertEquals(13, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testBinaryAnd1() {
		$program = new SimpleProgram("(&)");
		$result = $program->execute(self::$env);
	}
	
	public function testBinaryAnd2() {
		$program = new SimpleProgram("(& 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testBinaryAnd3() {
		$program = new SimpleProgram("(& 1 0)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testBinaryAnd4() {
		$program = new SimpleProgram("(& 1 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testBinaryAnd5() {
		$program = new SimpleProgram("(& 1 1 0)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testBinaryAnd6() {
		$program = new SimpleProgram("(& 10 5)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testBinaryAnd7() {
		$program = new SimpleProgram("(& 15 3)");
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result);
	}
	
	public function testCond0() {
		$program = new SimpleProgram('(cond)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testCond1() {
		$program = new SimpleProgram('(cond (true "hola"))');
		$result = $program->execute(self::$env);
		$this->assertEquals("hola", $result);
	}
	
	public function testCond2() {
		$program = new SimpleProgram('(cond (false "hola"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testCond3() {
		$program = new SimpleProgram('(cond (true "hello") (true "hola"))');
		$result = $program->execute(self::$env);
		$this->assertEquals("hello", $result);
	}
	
	public function testCond4() {
		$program = new SimpleProgram('(:= _tc3 17)(cond ((>= _tc3 18) "Legal") (true "Not legal."))');
		$result = $program->execute(self::$env);
		$this->assertEquals("Not legal.", $result);
	}
}
?>