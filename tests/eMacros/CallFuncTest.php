<?php
namespace eMacros;

use eMacros\Program\Program;
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
		$program = new Program("(call)");
		$program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCallFunc1() {
		$program = new Program("(call 1)");
		$program->execute(self::$env);
	}
	
	public function testCallFunc2() {
		$program = new Program('(call "strtoupper" "emma")');
		$result = $program->execute(self::$env);
		$this->assertEquals("EMMA", $result);
	}
	
	public function testCallFunc3() {
		$program = new Program('(call Array::range 3 7)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(3, 4, 5, 6, 7), $result);
	}
	
	public function testCallFunc4() {
		$program = new Program('(call + 3 7 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(15, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testApplyFunc0() {
		$program = new Program("(apply)");
		$program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testApplyFunc1() {
		$program = new Program("(apply 1)");
		$program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testApplyFunc2() {
		$program = new Program("(apply + 1)");
		$program->execute(self::$env);
	}
	
	public function testApplyFunc3() {
		$program = new Program('(apply Array::range (array 3 7))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(3, 4, 5, 6, 7), $result);
	}
	
	public function testApplyFunc4() {
		$program = new Program('(apply "strstr" (array "name@example.com" "@" true))');
		$result = $program->execute(self::$env);
		$this->assertEquals('name', $result);
	}
	
	public function testApplyFunc5() {
		$program = new Program("(apply + (%_))");
		$result = $program->execute(self::$env, 7, 3, 5);
		$this->assertEquals(15, $result);
	}
}
?>