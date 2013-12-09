<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
/**
 * 
 * @author emaphp
 * @group callfunc
 */
class CallFuncTest extends eMacrosTest {
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testCallFunc0() {
		$program = new SimpleProgram("(call-func)");
		$program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCallFunc1() {
		$program = new SimpleProgram("(call-func 1)");
		$program->execute(self::$env);
	}
	
	public function testCallFunc2() {
		$program = new SimpleProgram('(call-func "strtoupper" "emma")');
		$result = $program->execute(self::$env);
		$this->assertEquals("EMMA", $result);
	}
	
	public function testCallFunc3() {
		$program = new SimpleProgram('(call-func Array::range 3 7)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(3, 4, 5, 6, 7), $result);
	}
	
	public function testCallFunc4() {
		$program = new SimpleProgram('(call-func + 3 7 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(15, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testCallFuncArray0() {
		$program = new SimpleProgram("(call-func-array)");
		$program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCallFuncArray1() {
		$program = new SimpleProgram("(call-func-array 1)");
		$program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCallFuncArray2() {
		$program = new SimpleProgram("(call-func-array + 1)");
		$program->execute(self::$env);
	}
	
	public function testCallFuncArray3() {
		$program = new SimpleProgram('(call-func-array Array::range (array 3 7))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(3, 4, 5, 6, 7), $result);
	}
	
	public function testCallFuncArray4() {
		$program = new SimpleProgram('(call-func-array "strstr" (array "name@example.com" "@" true))');
		$result = $program->execute(self::$env);
		$this->assertEquals('name', $result);
	}
	
	public function testCallFuncArray5() {
		$program = new SimpleProgram("(call-func-array + (%_))");
		$result = $program->execute(self::$env, 7, 3, 5);
		$this->assertEquals(15, $result);
	}
}
?>