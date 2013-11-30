<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
use eMacros\Package\StringPackage;
/**
 * 
 * @author emaphp
 * @group type
 */
class TypeFunctionsTest extends eMacrosTest {
	/**
	 * EMPTY
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIsEmpty0 () {
		$program = new SimpleProgram('(empty)');
		$result = $program->execute(self::$env);
	}
	
	public function testIsEmpty1 () {
		$program = new SimpleProgram('(empty 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty2 () {
		$program = new SimpleProgram('(empty 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty3 () {
		$program = new SimpleProgram('(empty 0.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty4 () {
		$program = new SimpleProgram('(empty 4.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty5() {
		$program = new SimpleProgram('(empty "")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty6() {
		$program = new SimpleProgram("(empty '')");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty7() {
		$program = new SimpleProgram("(empty '0')");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty8() {
		$program = new SimpleProgram("(empty '0.0')");
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty9() {
		$program = new SimpleProgram("(empty 'false')");
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty10() {
		$program = new SimpleProgram("(empty true)");
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty11() {
		$program = new SimpleProgram("(empty false)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty12() {
		$program = new SimpleProgram("(empty null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty13() {
		$program = new SimpleProgram("(empty undefined)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty14() {
		$program = new SimpleProgram("(Core::empty undefined)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	/**
	 * INSTANCE-OF
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testInstanceOf0() {
		$program = new SimpleProgram("(instance-of)");
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testInstanceOf1() {
		$program = new SimpleProgram("(instance-of null)");
		$result = $program->execute(self::$env);
	}
	
	public function testInstanceOf2() {
		$program = new SimpleProgram("(instance-of null 'stdClass')");
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInstanceOf3() {
		$program = new SimpleProgram("(instance-of (%0) 'stdClass')");
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(true, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInstanceOf4() {
		$program = new SimpleProgram("(instance-of (%0) 'stdClass')");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(false, $result);
	}
	
	public function testInstanceOf41() {
		$program = new SimpleProgram("(instance-of (%0) stdClass)");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(false, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInstanceOf5() {
		$program = new SimpleProgram("(instance-of (%0) 'eMacros\\\Package\\\StringPackage')");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(true, $result);
	}
	
	public function testInstanceOf51() {
		$program = new SimpleProgram("(instance-of (%0) eMacros\\Package\\StringPackage)");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(true, $result);
	}
	
	public function testInstanceOf6() {
		$program = new SimpleProgram("(Core::instance-of (%0) eMacros\\Package\\StringPackage)");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(true, $result);
	}
	
	/**
	 * IS-A
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIsA0() {
		$program = new SimpleProgram('(is-a)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIsA1() {
		$program = new SimpleProgram('(is-a (%0))');
		$result = $program->execute(self::$env, array());
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIsA2() {
		$program = new SimpleProgram('(is-a (%0))');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIsA3() {
		$program = new SimpleProgram('(is-a (%0) null)');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testIsA4() {
		$program = new SimpleProgram('(is-a (%0) "stdClass")');
		$result = $program->execute(self::$env, array());
		$this->assertEquals(false, $result);
	}
	
	public function testIsA5() {
		$program = new SimpleProgram('(is-a (%0) "stdClass")');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(true, $result);
	}
	
	public function testIsA6() {
		$program = new SimpleProgram('(Core::is-a (%0) "stdClass")');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(true, $result);
	}
	
	/**
	 * TYPE-OF
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testTypeOf0() {
		$program = new SimpleProgram("(type-of)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testTypeOf1() {
		$program = new SimpleProgram("(type-of null)");
		$result = $program->execute(self::$env);
		$this->assertEquals("NULL", $result);
	}
	
	public function testTypeOf2() {
		$program = new SimpleProgram("(type-of 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals("integer", $result);
	}
	
	public function testTypeOf3() {
		$program = new SimpleProgram("(type-of 2.5)");
		$result = $program->execute(self::$env);
		$this->assertEquals("double", $result);
	}
	
	public function testTypeOf4() {
		$program = new SimpleProgram("(type-of 'test')");
		$result = $program->execute(self::$env);
		$this->assertEquals("string", $result);
	}
	
	public function testTypeOf5() {
		$program = new SimpleProgram("(type-of undefined)");
		$result = $program->execute(self::$env);
		$this->assertEquals("NULL", $result);
	}
	
	public function testTypeOf6() {
		$program = new SimpleProgram("(type-of 'test' 2)");
		$result = $program->execute(self::$env);
		$this->assertEquals("string", $result);
	}
	
	public function testTypeOf7() {
		$program = new SimpleProgram("(type-of (%0))");
		$result = $program->execute(self::$env, array(1, 2, 3));
		$this->assertEquals("array", $result);
	}
	
	public function testTypeOf8() {
		$program = new SimpleProgram("(type-of (%0))");
		$result = $program->execute(self::$env, new StringPackage('str'));
		$this->assertEquals("object", $result);
	}
	
	public function testTypeOf9() {
		$program = new SimpleProgram("(Core::type-of (%0))");
		$result = $program->execute(self::$env, new StringPackage('str'));
		$this->assertEquals("object", $result);
	}
	
	/**
	 * STRVAL
	 */
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testStrVal0() {
		$program = new SimpleProgram("(strval)");
		$result = $program->execute(self::$env);
	}
	
	public function testStrVal1() {
		$program = new SimpleProgram("(strval 'test')");
		$result = $program->execute(self::$env);
		$this->assertEquals('test', $result);
	}
	
	public function testStrVal2() {
		$program = new SimpleProgram("(strval 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals('1', $result);
	}
	
	public function testStrVal3() {
		$program = new SimpleProgram("(strval 14.65)");
		$result = $program->execute(self::$env);
		$this->assertEquals('14.65', $result);
	}
	
	public function testStrVal4() {
		$program = new SimpleProgram("(strval true)");
		$result = $program->execute(self::$env);
		$this->assertEquals('1', $result);
	}
	
	public function testStrVal5() {
		$program = new SimpleProgram("(strval false)");
		$result = $program->execute(self::$env);
		$this->assertEquals('', $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Notice
	 */
	public function testStrVal6() {
		$program = new SimpleProgram("(strval (%0))");
		$result = $program->execute(self::$env, array(1, 2, 3));
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testStrVal7() {
		$program = new SimpleProgram("(strval (%0))");
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testStrVal8() {
		$program = new SimpleProgram("(strval (%0))");
		$result = $program->execute(self::$env, new Literal('some-literal'));
		$this->assertEquals("'some-literal'", $result);
	}
	
	public function testStrVal9() {
		$program = new SimpleProgram("(strval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals('', $result);
	}
	
	public function testStrVal10() {
		$program = new SimpleProgram("(Core::strval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals('', $result);
	}
	
	/**
	 * FLOATVAL
	 */
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testFloatVal0() {
		$program = new SimpleProgram("(floatval)");
		$result = $program->execute(self::$env);
	}
	
	public function testFloatVal1() {
		$program = new SimpleProgram("(floatval 'test')");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testFloatVal2() {
		$program = new SimpleProgram("(floatval 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testFloatVal3() {
		$program = new SimpleProgram("(floatval 14.65)");
		$result = $program->execute(self::$env);
		$this->assertEquals(14.65, $result);
	}
	
	public function testFloatVal4() {
		$program = new SimpleProgram("(floatval true)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testFloatVal5() {
		$program = new SimpleProgram("(floatval false)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testFloatVal6() {
		$program = new SimpleProgram("(floatval '5.65')");
		$result = $program->execute(self::$env);
		$this->assertEquals(5.65, $result);
	}
	
	public function testFloatVal7() {
		$program = new SimpleProgram("(floatval (%0))");
		$result = $program->execute(self::$env, array(3, 2, 1));
		$this->assertEquals(1.0, $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testFloatVal8() {
		$program = new SimpleProgram("(floatval (%0))");
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testFloatVal9() {
		$program = new SimpleProgram("(floatval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0.0, $result);
	}
	
	public function testFloatVal10() {
		$program = new SimpleProgram("(Core::floatval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0.0, $result);
	}
	
	/**
	 * INTVAL
	 */
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testIntVal0() {
		$program = new SimpleProgram("(intval)");
		$result = $program->execute(self::$env);
	}
	
	public function testIntVal1() {
		$program = new SimpleProgram("(intval 'test')");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testIntVal2() {
		$program = new SimpleProgram("(intval 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testIntVal3() {
		$program = new SimpleProgram("(intval 14.65)");
		$result = $program->execute(self::$env);
		$this->assertEquals(14, $result);
	}
	
	public function testIntVal4() {
		$program = new SimpleProgram("(intval true)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testIntVal5() {
		$program = new SimpleProgram("(intval false)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testIntVal6() {
		$program = new SimpleProgram("(intval '5.65')");
		$result = $program->execute(self::$env);
		$this->assertEquals(5, $result);
	}
	
	public function testIntVal7() {
		$program = new SimpleProgram("(intval (%0))");
		$result = $program->execute(self::$env, array(3, 2, 1));
		$this->assertEquals(1, $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testIntVal8() {
		$program = new SimpleProgram("(intval (%0))");
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testIntVal9() {
		$program = new SimpleProgram("(intval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testIntVal10() {
		$program = new SimpleProgram("(Core::intval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
}
?>