<?php
namespace eMacros;

use eMacros\Program\Program;
use Foo\Fizz;
use Foo\Bar;

/**
 * 
 * @author emaphp
 * @group class
 */
class ClassTest extends eMacrosTest {
	public function testPropertyExists1() {
		$a = new \stdClass();
		$a->b = 1; $a->c = 2; $a->name = 'obj';
		$program = new Program('(property-exists (%0) "name")');
		$result = $program->execute(self::$env, $a);
		$this->assertTrue($result);
	}
	
	public function testPropertyExists2() {
		$a = new \stdClass();
		$a->b = 1; $a->c = 2; $a->name = 'obj';
		$program = new Program('(property-exists (%0) "surname")');
		$result = $program->execute(self::$env, $a);
		$this->assertFalse($result);
	}
	
	public function testMethodExists1() {
		$program = new Program('(method-exists (%0) "publicMethod")');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertTrue($result);
	}
	
	public function testMethodExists2() {
		$program = new Program('(method-exists (%0) "protectedMethod")');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertFalse($result);
	}
	
	public function testSubclass1() {
		$program = new Program('(is-subclass-of (%0) "ArrayObject")');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertTrue($result);
	}
	
	public function testSubclass2() {
		$program = new Program('(is-subclass-of (%0) "mysqli")');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertFalse($result);
	}
	
	public function testParentClass1() {
		$program = new Program('(get-parent-class (%0))');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals("ArrayObject", $result);
	}
	
	public function testObjectVars1() {
		$a = new \stdClass();
		$a->b = 1; $a->c = 2; $a->name = 'obj';
		$program = new Program('(get-object-vars (%0))');
		$result = $program->execute(self::$env, $a);
		$this->assertEquals(array('b' => 1, 'c' => 2, 'name' => 'obj'), $result);
	}
	
	public function testGetClass1() {
		$program = new Program('(get-class (%0))');
		$result = $program->execute(self::$env, new Bar());
		$this->assertEquals('Foo\Bar', $result);
	}
	
	public function testGetClassVars1() {
		$program = new Program('(get-class-vars "Foo\\\Fizz")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('publicProperty' => 42), $result);
	}
	
	public function testGetClassMethods1() {
		$program = new Program('(get-class-methods "Foo\\\Buzz")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('__construct', '__isset', '__get'), $result);
	}
	
	public function testClassAlias1() {
		$program = new Program('(class-alias "Foo\\\Fizz" "fizz")(new fizz)');
		$result = $program->execute(self::$env);
		$this->assertInstanceOf("Foo\\Fizz", $result);
	}
	
	public function testClassAlias2() {
		$program = new Program('(class-alias "Foo\\\Fizz" "ffizz")(instance "ffizz")');
		$result = $program->execute(self::$env);
		$this->assertInstanceOf("Foo\\Fizz", $result);
	}
}
?>