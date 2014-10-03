<?php
namespace eMacros;

use eMacros\Program\Program;
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
		$program = new Program('(empty)');
		$result = $program->execute(self::$env);
	}
	
	public function testIsEmpty1 () {
		$program = new Program('(empty 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty2 () {
		$program = new Program('(empty 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty3 () {
		$program = new Program('(empty 0.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty4 () {
		$program = new Program('(empty 4.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty5() {
		$program = new Program('(empty "")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty6() {
		$program = new Program("(empty '')");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty7() {
		$program = new Program("(empty '0')");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty8() {
		$program = new Program("(empty '0.0')");
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty9() {
		$program = new Program("(empty 'false')");
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty10() {
		$program = new Program("(empty true)");
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIsEmpty11() {
		$program = new Program("(empty false)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty12() {
		$program = new Program("(empty null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty13() {
		$program = new Program("(empty undefined)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIsEmpty14() {
		$program = new Program("(Core::empty undefined)");
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
		$program = new Program("(instance-of)");
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testInstanceOf1() {
		$program = new Program("(instance-of null)");
		$result = $program->execute(self::$env);
	}
	
	public function testInstanceOf2() {
		$program = new Program("(instance-of null 'stdClass')");
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInstanceOf3() {
		$program = new Program("(instance-of (%0) 'stdClass')");
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(true, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInstanceOf4() {
		$program = new Program("(instance-of (%0) 'stdClass')");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(false, $result);
	}
	
	public function testInstanceOf41() {
		$program = new Program("(instance-of (%0) stdClass)");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(false, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testInstanceOf5() {
		$program = new Program("(instance-of (%0) 'eMacros\\\Package\\\StringPackage')");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(true, $result);
	}
	
	public function testInstanceOf51() {
		$program = new Program("(instance-of (%0) eMacros\\Package\\StringPackage)");
		$result = $program->execute(self::$env, new StringPackage('string'));
		$this->assertEquals(true, $result);
	}
	
	public function testInstanceOf6() {
		$program = new Program("(Core::instance-of (%0) eMacros\\Package\\StringPackage)");
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
		$program = new Program('(is-a)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIsA1() {
		$program = new Program('(is-a (%0))');
		$result = $program->execute(self::$env, array());
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIsA2() {
		$program = new Program('(is-a (%0))');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIsA3() {
		$program = new Program('(is-a (%0) null)');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testIsA4() {
		$program = new Program('(is-a (%0) "stdClass")');
		$result = $program->execute(self::$env, array());
		$this->assertEquals(false, $result);
	}
	
	public function testIsA5() {
		$program = new Program('(is-a (%0) "stdClass")');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(true, $result);
	}
	
	public function testIsA6() {
		$program = new Program('(Core::is-a (%0) "stdClass")');
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
		$program = new Program("(type-of)");
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testTypeOf1() {
		$program = new Program("(type-of null)");
		$result = $program->execute(self::$env);
		$this->assertEquals("NULL", $result);
	}
	
	public function testTypeOf2() {
		$program = new Program("(type-of 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals("integer", $result);
	}
	
	public function testTypeOf3() {
		$program = new Program("(type-of 2.5)");
		$result = $program->execute(self::$env);
		$this->assertEquals("double", $result);
	}
	
	public function testTypeOf4() {
		$program = new Program("(type-of 'test')");
		$result = $program->execute(self::$env);
		$this->assertEquals("string", $result);
	}
	
	public function testTypeOf5() {
		$program = new Program("(type-of undefined)");
		$result = $program->execute(self::$env);
		$this->assertEquals("NULL", $result);
	}
	
	public function testTypeOf6() {
		$program = new Program("(type-of 'test' 2)");
		$result = $program->execute(self::$env);
		$this->assertEquals("string", $result);
	}
	
	public function testTypeOf7() {
		$program = new Program("(type-of (%0))");
		$result = $program->execute(self::$env, array(1, 2, 3));
		$this->assertEquals("array", $result);
	}
	
	public function testTypeOf8() {
		$program = new Program("(type-of (%0))");
		$result = $program->execute(self::$env, new StringPackage('str'));
		$this->assertEquals("object", $result);
	}
	
	public function testTypeOf9() {
		$program = new Program("(Core::type-of (%0))");
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
		$program = new Program("(strval)");
		$result = $program->execute(self::$env);
	}
	
	public function testStrVal1() {
		$program = new Program("(strval 'test')");
		$result = $program->execute(self::$env);
		$this->assertEquals('test', $result);
	}
	
	public function testStrVal2() {
		$program = new Program("(strval 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals('1', $result);
	}
	
	public function testStrVal3() {
		$program = new Program("(strval 14.65)");
		$result = $program->execute(self::$env);
		$this->assertEquals('14.65', $result);
	}
	
	public function testStrVal4() {
		$program = new Program("(strval true)");
		$result = $program->execute(self::$env);
		$this->assertEquals('1', $result);
	}
	
	public function testStrVal5() {
		$program = new Program("(strval false)");
		$result = $program->execute(self::$env);
		$this->assertEquals('', $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Notice
	 */
	public function testStrVal6() {
		$program = new Program("(strval (%0))");
		$result = $program->execute(self::$env, array(1, 2, 3));
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testStrVal7() {
		$program = new Program("(strval (%0))");
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testStrVal8() {
		$program = new Program("(strval (%0))");
		$result = $program->execute(self::$env, new Literal('some-literal'));
		$this->assertEquals("'some-literal'", $result);
	}
	
	public function testStrVal9() {
		$program = new Program("(strval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals('', $result);
	}
	
	public function testStrVal10() {
		$program = new Program("(Core::strval null)");
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
		$program = new Program("(floatval)");
		$result = $program->execute(self::$env);
	}
	
	public function testFloatVal1() {
		$program = new Program("(floatval 'test')");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testFloatVal2() {
		$program = new Program("(floatval 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testFloatVal3() {
		$program = new Program("(floatval 14.65)");
		$result = $program->execute(self::$env);
		$this->assertEquals(14.65, $result);
	}
	
	public function testFloatVal4() {
		$program = new Program("(floatval true)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testFloatVal5() {
		$program = new Program("(floatval false)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testFloatVal6() {
		$program = new Program("(floatval '5.65')");
		$result = $program->execute(self::$env);
		$this->assertEquals(5.65, $result);
	}
	
	public function testFloatVal7() {
		$program = new Program("(floatval (%0))");
		$result = $program->execute(self::$env, array(3, 2, 1));
		$this->assertEquals(1.0, $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testFloatVal8() {
		$program = new Program("(floatval (%0))");
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testFloatVal9() {
		$program = new Program("(floatval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0.0, $result);
	}
	
	public function testFloatVal10() {
		$program = new Program("(Core::floatval null)");
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
		$program = new Program("(intval)");
		$result = $program->execute(self::$env);
	}
	
	public function testIntVal1() {
		$program = new Program("(intval 'test')");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testIntVal2() {
		$program = new Program("(intval 1)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testIntVal3() {
		$program = new Program("(intval 14.65)");
		$result = $program->execute(self::$env);
		$this->assertEquals(14, $result);
	}
	
	public function testIntVal4() {
		$program = new Program("(intval true)");
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testIntVal5() {
		$program = new Program("(intval false)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testIntVal6() {
		$program = new Program("(intval '5.65')");
		$result = $program->execute(self::$env);
		$this->assertEquals(5, $result);
	}
	
	public function testIntVal7() {
		$program = new Program("(intval (%0))");
		$result = $program->execute(self::$env, array(3, 2, 1));
		$this->assertEquals(1, $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testIntVal8() {
		$program = new Program("(intval (%0))");
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testIntVal9() {
		$program = new Program("(intval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testIntVal10() {
		$program = new Program("(Core::intval null)");
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
}
?>