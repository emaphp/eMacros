<?php
namespace eMacros;

use eMacros\Program\Program;

/**
 * 
 * @author emaphp
 * @group value
 */
class ValueTest extends eMacrosTest {
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueSet0() {
		$program = new Program('(:=)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueSet1() {
		$program = new Program('(:= _vs1)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValueSet2() {
		$program = new Program('(:= 5)');
		$result = $program->execute(self::$env);
	}
	
	public function testValueSet3() {
		$program = new Program('(:= _vs3 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(5, $result);
	}
	
	public function testValueSet4() {
		$program = new Program('(:= _vs4 10)_vs4');
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testValueSet5() {
		$program = new Program('(:= _vs5 (+ 4 5))');
		$result = $program->execute(self::$env);
		$this->assertEquals(9, $result);
	}
	
	public function testValueSet6() {
		$program = new Program('(:= _vs6 (+ 14 65))(<- _vs6)');
		$result = $program->execute(self::$env);
		$this->assertEquals(79, $result);
	}
	
	public function testValueSet7() {
		$program = new Program('(:= _vs70 (+ 1 6))(:= _vs71 7)(+ _vs70 _vs71)');
		$result = $program->execute(self::$env);
		$this->assertEquals(14, $result);
	}
	
	public function testValueSet71() {
		$program = new Program('(<- _vs71)');
		$result = $program->execute(self::$env);
		$this->assertEquals(7, $result);
	}
	
	public function testValueUnset71() {
		$program = new Program('(unset _vs71)(<- _vs71)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
}
?>