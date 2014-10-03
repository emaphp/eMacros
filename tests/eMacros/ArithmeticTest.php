<?php
namespace eMacros;

use eMacros\Program\Program;

/**
 * 
 * @author emaphp
 * @group arithmetic
 */
class ArithmeticTest extends eMacrosTest {
	
	/**
	 * ADDITION
	 */
	
	public function testAddition0() {
		$program = new Program('(+)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testAddition1() {
		$program = new Program('(+ 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	public function testAddition2() {
		$program = new Program('(+ -3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-3, $result);
	}
	
	public function testAddition3() {
		$program = new Program('(+ 5 6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(11, $result);
	}
	
	public function testAddition4() {
		$program = new Program('(+ 5 -6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-1, $result);
	}
	
	public function testAddition5() {
		$program = new Program('(+ -5 6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testAddition6() {
		$program = new Program('(+ -5 -6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-11, $result);
	}
	
	public function testAddition7() {
		$program = new Program('(+ 2 4 6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(12, $result);
	}
	
	/**
	 * SUBTRACTION
	 */
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testSubtraction0() {
		$program = new Program('(-)');
		$result = $program->execute(self::$env);
	}
	
	public function testSubtraction1() {
		$program = new Program('(- 4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-4, $result);
	}
	
	public function testSubtraction2() {
		$program = new Program('(- -3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result);
	}
	
	public function testSubtraction3() {
		$program = new Program('(- 5 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	public function testSubtraction4() {
		$program = new Program('(- 5 -6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(11, $result);
	}
	
	public function testSubtraction5() {
		$program = new Program('(- -5 6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-11, $result);
	}
	
	public function testSubtraction6() {
		$program = new Program('(- -5 -6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testSubtraction7() {
		$program = new Program('(- 15 6 9)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	/**
	 * MULTIPLICATION
	 */
	public function testMultiplication0() {
		$program = new Program('(*)');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testMultiplication1() {
		$program = new Program('(* 6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(6, $result);
	}
	
	public function testMultiplication2() {
		$program = new Program('(* -5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-5, $result);
	}
	
	public function testMultiplication3() {
		$program = new Program('(* 5 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testMultiplication4() {
		$program = new Program('(* 5 -4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-20, $result);
	}
	
	public function testMultiplication5() {
		$program = new Program('(* -5 -4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(20, $result);
	}
	
	public function testMultiplication6() {
		$program = new Program('(* 5 2 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(30, $result);
	}
	
	/**
	 * DIVISION
	 */
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testDivision0() {
		$program = new Program('(/)');
		$result = $program->execute(self::$env);
	}
	
	public function testDivision1() {
		$program = new Program('(/ 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0.5, $result);
	}
	
	public function testDivision2() {
		$program = new Program('(/ -2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-0.5, $result);
	}
	
	public function testDivision3() {
		$program = new Program('(/ 6 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	public function testDivision4() {
		$program = new Program('(/ 6 -3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-2, $result);
	}
	
	public function testDivision5() {
		$program = new Program('(/ -6 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-2, $result);
	}
	
	public function testDivision6() {
		$program = new Program('(/ -6 -3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	public function testDivision7() {
		$program = new Program('(/ 54 6 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(4.5, $result);
	}
	
	/**
	 * MODULUS
	 */
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testModulus0() {
		$program = new Program('(mod)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testModulus1() {
		$program = new Program('(mod)');
		$result = $program->execute(self::$env);
	}
	
	public function testModulus2() {
		$program = new Program('(mod 10 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testModulus3() {
		$program = new Program('(mod 10 -4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	public function testModulus4() {
		$program = new Program('(mod -10 4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-2, $result);
	}
	
	public function testModulus5() {
		$program = new Program('(mod -10 -4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(-2, $result);
	}
	
	public function testModulus6() {
		$program = new Program('(mod 10 4 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
}
?>