<?php
namespace eMacros;

use eMacros\Program\Program;
use Foo\Fizz;
use Foo\FizzBuzz;
use Test\ArrayTest;
/**
 * 
 * @author emaphp
 * @group method
 */
class MethodTest extends eMacrosTest {
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testMethod0() {
		$program = new Program('(->method)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMethod1() {
		$program = new Program('(->method null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMethod2() {
		$program = new Program('(->method (%0))');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	/**
	 * @expectedException BadMethodCallException
	 */
	public function testMethod3() {
		$program = new Program('(->privateMethod (%0))');
		$result = $program->execute(self::$env, new Fizz());
	}
	
	public function testMethod4() {
		$program = new Program('(->publicMethod (%0))');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals('This is a public method.', $result);
	}
	
	public function testMethod5() {
		$program = new Program('(->anotherMethod (%0) (%1))');
		$result = $program->execute(self::$env, new Fizz(), 'Emma');
		$this->assertEquals('Hello Emma!', $result);
	}
	
	public function testMethod6() {
		$program = new Program('(->anotherMethod (%0) (%1) "Hey")');
		$result = $program->execute(self::$env, new Fizz(), 'Emma');
		$this->assertEquals('Hey Emma!', $result);
	}
	
	/**
	 * @expectedException BadMethodCallException
	 */
	public function testMethod7() {
		$program = new Program('(->anotherMethod (%0))');
		$result = $program->execute(self::$env, new Fizz());
	}
	
	public function testMethod8() {
		$program = new Program('(->anotherMethod (%0))');
		$result = $program->execute(self::$env, new FizzBuzz());
		$this->assertEquals(null, $result);
	}
	
	public function testMethod9() {
		$program = new Program('(->testMethod (%0) "Hello" "World")');
		$result = $program->execute(self::$env, new FizzBuzz());
		$this->assertEquals("Hello.World", $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testMethod10() {
		$program = new Program('(->)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testMethod11() {
		$program = new Program('(-> "doSomething")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testMethod12() {
		$program = new Program('(-> "doSomething" (%0))');
		$result = $program->execute(self::$env, array());
	}
	
	public function testMethod13() {
		$program = new Program('(:= _m13 "publicMethod")(-> _m13 (%0))');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals('This is a public method.', $result);
	}
	
	public function testMethod14() {
		$program = new Program('(-> "anotherMethod" (%0) "emma")');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals('Hello emma!', $result);
	}
	
	public function testMethod15() {
		$program = new Program('(-> "anotherMethod" (%0) "emma" "Bye")');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals('Bye emma!', $result);
	}
	
	public function testMethod16() {
		$program = new Program('(:= _arr (new Test\ArrayTest))(->setElems _arr (array 1 2 3))(->getElems _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(1, 2, 3), $result);
	}
}
?>