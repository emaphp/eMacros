<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
/**
 * 
 * @author emaphp
 * @group builder
 */
class BuilderTest extends eMacrosTest {
	public function testArrayBuilder0() {
		$program = new SimpleProgram('(array)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(), $result);
	}
	
	public function testArrayBuilder1() {
		$program = new SimpleProgram('(array 1 2 null 4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(1, 2, null, 4), $result);
	}
	
	public function testArrayBuilder2() {
		$program = new SimpleProgram('(array ("name" "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array("name" => "emma"), $result);
	}
	
	public function testArrayBuilder3() {
		$program = new SimpleProgram('(array ("name" (%0)))');
		$result = $program->execute(self::$env, "emma");
		$this->assertEquals(array("name" => "emma"), $result);
	}
	
	public function testArrayBuilder4() {
		$program = new SimpleProgram('(array ("name" (to-upper (%0))))');
		$result = $program->execute(self::$env, "emma");
		$this->assertEquals(array("name" => "EMMA"), $result);
	}
	
	public function testArrayBuilder5() {
		$program = new SimpleProgram('(array (5 (%0)))');
		$result = $program->execute(self::$env, "emacros");
		$this->assertEquals(array(5 => 'emacros'), $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testArrayBuilder6() {
		$program = new SimpleProgram('(array ((%0)))');
		$result = $program->execute(self::$env, "emma");
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testArrayBuilder7() {
		$program = new SimpleProgram('(array () 10)');
		$result = $program->execute(self::$env, "emma");
	}
	
	public function testArrayBuilder8() {
		$program = new SimpleProgram('(array 100 200 ((%0) (%1)))');
		$result = $program->execute(self::$env, "key", "value");
		$this->assertEquals(array(100, 200, "key" => "value"), $result);
	}
	
	public function testArrayBuilder9() {
		$program = new SimpleProgram('(Core::array 100 200 ((%0) (%1)))');
		$result = $program->execute(self::$env, "key", "value");
		$this->assertEquals(array(100, 200, "key" => "value"), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testObjectBuilder0() {
		$program = new SimpleProgram('(new)');
		$result = $program->execute(self::$env);
	}
	
	public function testObjectBuilder1() {
		$program = new SimpleProgram('(new \\stdClass)');
		$result = $program->execute(self::$env);
		$this->assertEquals(new \stdClass(), $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testObjectBuilder2() {
		$program = new SimpleProgram('(new "stdClass")');
		$result = $program->execute(self::$env);
		$this->assertEquals(new \stdClass(), $result);
	}
	
	/**
	 * @expectedException \ReflectionException
	 */
	public function testObjectBuilder3() {
		$program = new SimpleProgram('(new null)');
		$result = $program->execute(self::$env);
	}
	
	public function testObjectBuilder4() {
		$program = new SimpleProgram('(new \\ArrayObject)');
		$result = $program->execute(self::$env);
		$this->assertTrue($result instanceof \ArrayObject);
	}
	
	public function testObjectBuilder5() {
		$program = new SimpleProgram('(new \\ArrayObject (array "Hello" "World"))');
		$result = $program->execute(self::$env);
		$this->assertTrue($result instanceof \ArrayObject);
		$this->assertEquals("Hello", $result[0]);
		$this->assertEquals("World", $result[1]);
	}
	
	public function testObjectBuilder6() {
		$program = new SimpleProgram('(Core::new \\ArrayObject (array "Hello" "World"))');
		$result = $program->execute(self::$env);
		$this->assertTrue($result instanceof \ArrayObject);
		$this->assertEquals("Hello", $result[0]);
		$this->assertEquals("World", $result[1]);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testInstanceBuilder0() {
		$program = new SimpleProgram('(instance)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInstanceBuilder1() {
		$program = new SimpleProgram('(instance \\stdClass)');
		$result = $program->execute(self::$env);
		$this->assertEquals(new \stdClass(), $result);
	}
	
	public function testInstanceBuilder2() {
		$program = new SimpleProgram('(instance "stdClass")');
		$result = $program->execute(self::$env);
		$this->assertEquals(new \stdClass(), $result);
	}
	
	public function testInstanceBuilder3() {
		$program = new SimpleProgram('(instance "ArrayObject")');
		$result = $program->execute(self::$env);
		$this->assertTrue($result instanceof \ArrayObject);
	}
	
	public function testInstanceBuilder4() {
		$program = new SimpleProgram('(instance "ArrayObject" (array "Hello" "World"))');
		$result = $program->execute(self::$env);
		$this->assertTrue($result instanceof \ArrayObject);
		$this->assertEquals("Hello", $result[0]);
		$this->assertEquals("World", $result[1]);
	}
	
	public function testInstanceBuilder5() {
		$program = new SimpleProgram('(Core::instance "ArrayObject" (array "Hello" "World"))');
		$result = $program->execute(self::$env);
		$this->assertTrue($result instanceof \ArrayObject);
		$this->assertEquals("Hello", $result[0]);
		$this->assertEquals("World", $result[1]);
	}
}
?>