<?php
namespace eMacros;

use eMacros\Program\Program;
/**
 * 
 * @author emaphp
 * @group argument
 */
class ArgumentTest extends eMacrosTest {
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArgument0() {
		$program = new Program('(%)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testArgument1() {
		$program = new Program('(%0)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testArgument2() {
		$program = new Program('(% 1)');
		$result = $program->execute(self::$env);
	}
	
	public function testArgument3() {
		$program = new Program('(% 1)');
		$result = $program->execute(self::$env, 10, 20);
		$this->assertEquals(20, $result);
	}
	
	public function testArgument4() {
		$program = new Program('(%0)');
		$result = $program->execute(self::$env, 'hola');
		$this->assertEquals('hola', $result);
	}
	
	public function testArgument5() {
		$program = new Program('(+ (%0) (%1))');
		$result = $program->execute(self::$env, 23, 54);
		$this->assertEquals(77, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArgumentHas0() {
		$program = new Program('(%?)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testArgumentHas1() {
		$program = new Program('(%? 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testArgumentHas2() {
		$program = new Program('(%0?)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testArgumentHas3() {
		$program = new Program('(%0?)');
		$result = $program->execute(self::$env, 1);
		$this->assertEquals(true, $result);
	}
	
	public function testArgumentHas4() {
		$program = new Program('(if (%0?) (+ 1 (%0)) 0)');
		$result = $program->execute(self::$env, 1);
		$this->assertEquals(2, $result);
	}
	
	public function testArgumentHas5() {
		$program = new Program('(if (%0?) (+ 1 (%0)) 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	/**
	 * ARGUMENT COUNT (%*) 
	 */
	
	public function testArgumentCount0() {
		$program = new Program('(%#)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testArgumentCount1() {
		$program = new Program('(%#)');
		$result = $program->execute(self::$env, 1, 2, 3);
		$this->assertEquals(3, $result);
	}
	
	/**
	 * ARGUMENT LIST (%?)
	 */
	public function testArgumentList0() {
		$program = new Program('(%_)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(), $result);
	}
	
	public function testArgumentList1() {
		$program = new Program('(%_)');
		$result = $program->execute(self::$env, 1, 2, 3);
		$this->assertEquals(array(1, 2, 3), $result);
	}
}
?>