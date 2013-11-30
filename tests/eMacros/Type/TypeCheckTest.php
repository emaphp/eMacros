<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
/**
 * 
 * @author emaphp
 * @group type
 */
class TypeCheckMacrosTest extends eMacrosTest {
	
	/**
	 * bool?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testBool0() {
		$program = new SimpleProgram('(bool?)');
		$result = $program->execute(self::$env);
	}
	
	public function testBool1() {
		$program = new SimpleProgram('(bool? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testBool2() {
		$program = new SimpleProgram('(bool? false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testBool3() {
		$program = new SimpleProgram('(bool? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBool4() {
		$program = new SimpleProgram('(bool? "true")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBool5() {
		$program = new SimpleProgram('(bool? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBool6() {
		$program = new SimpleProgram('(bool? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBool7() {
		$program = new SimpleProgram('(bool? true false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testBool8() {
		$program = new SimpleProgram('(bool? true false 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBool9() {
		$program = new SimpleProgram('(Core::bool? true false 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * boolean?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testBoolean0() {
		$program = new SimpleProgram('(boolean?)');
		$result = $program->execute(self::$env);
	}
	
	public function testBoolean1() {
		$program = new SimpleProgram('(boolean? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testBoolean2() {
		$program = new SimpleProgram('(boolean? false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testBoolean3() {
		$program = new SimpleProgram('(boolean? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBoolean4() {
		$program = new SimpleProgram('(boolean? "true")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBoolean5() {
		$program = new SimpleProgram('(boolean? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBoolean6() {
		$program = new SimpleProgram('(boolean? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBooleab7() {
		$program = new SimpleProgram('(boolean? true false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testBoolean8() {
		$program = new SimpleProgram('(bool? true false 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testBoolean9() {
		$program = new SimpleProgram('(Core::bool? true false 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * int?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testInt0() {
		$program = new SimpleProgram('(int?)');
		$result = $program->execute(self::$env);
	}
	
	public function testInt1() {
		$program = new SimpleProgram('(int? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInt2() {
		$program = new SimpleProgram('(int? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInt3() {
		$program = new SimpleProgram('(int? "4")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInt4() {
		$program = new SimpleProgram('(int? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testInt5() {
		$program = new SimpleProgram('(int? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInt6() {
		$program = new SimpleProgram('(int? 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testInt7() {
		$program = new SimpleProgram('(int? 1 2 null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInt8() {
		$program = new SimpleProgram('(Core::int? 1 2 null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * integer?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testInteger0() {
		$program = new SimpleProgram('(integer?)');
		$result = $program->execute(self::$env);
	}
	
	public function testInteger1() {
		$program = new SimpleProgram('(integer? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInteger2() {
		$program = new SimpleProgram('(integer? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInteger3() {
		$program = new SimpleProgram('(integer? "4")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInteger4() {
		$program = new SimpleProgram('(integer? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testInteger5() {
		$program = new SimpleProgram('(integer? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInteger6() {
		$program = new SimpleProgram('(integer? 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testInteger7() {
		$program = new SimpleProgram('(integer? 1 2 null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testInteger8() {
		$program = new SimpleProgram('(Core::integer? 1 2 null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * string?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testString0() {
		$program = new SimpleProgram('(string?)');
		$result = $program->execute(self::$env);
	}
	
	public function testString1() {
		$program = new SimpleProgram('(string? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testString2() {
		$program = new SimpleProgram('(string? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testString3() {
		$program = new SimpleProgram('(string? "hey")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testString4() {
		$program = new SimpleProgram('(string? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testString5() {
		$program = new SimpleProgram('(string? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testString6() {
		$program = new SimpleProgram('(string? "qwerty" "12345")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testString7() {
		$program = new SimpleProgram('(string? "hey" null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testString8() {
		$program = new SimpleProgram('(Core::string? "hey" null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * float?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testFloat0() {
		$program = new SimpleProgram('(float?)');
		$result = $program->execute(self::$env);
	}
	
	public function testFloat1() {
		$program = new SimpleProgram('(float? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testFloat2() {
		$program = new SimpleProgram('(float? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testFloat3() {
		$program = new SimpleProgram('(float? "hey")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testFloat4() {
		$program = new SimpleProgram('(float? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testFloat5() {
		$program = new SimpleProgram('(float? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testFloat6() {
		$program = new SimpleProgram('(float? 42.25 7.34)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testFloat7() {
		$program = new SimpleProgram('(float? 12.0 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testFloat8() {
		$program = new SimpleProgram('(Core::float? 12.0 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * double?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testDouble0() {
		$program = new SimpleProgram('(double?)');
		$result = $program->execute(self::$env);
	}
	
	public function testDouble1() {
		$program = new SimpleProgram('(double? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testDouble2() {
		$program = new SimpleProgram('(double? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testDouble3() {
		$program = new SimpleProgram('(double? "hey")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testDouble4() {
		$program = new SimpleProgram('(double? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testDouble5() {
		$program = new SimpleProgram('(double? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testDouble6() {
		$program = new SimpleProgram('(double? 42.25 7.34)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testDouble7() {
		$program = new SimpleProgram('(double? 12.0 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testDouble8() {
		$program = new SimpleProgram('(Core::double? 12.0 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * resource?
	 */
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testResource0() {
		$program = new SimpleProgram('(resource?)');
		$result = $program->execute(self::$env);
	}
	
	public function testResource1() {
		$program = new SimpleProgram('(resource? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testResource2() {
		$program = new SimpleProgram('(resource? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testResource3() {
		$program = new SimpleProgram('(resource? "hey")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testResource4() {
		$program = new SimpleProgram('(resource? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testResource5() {
		$program = new SimpleProgram('(resource? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testResource6() {
		$program = new SimpleProgram('(resource? (%0))');
		$result = $program->execute(self::$env, $fp = fopen(__DIR__ . '/../files/resource.db', 'r'));
		fclose($fp);
		$this->assertEquals(true, $result);
	}
	
	public function testResource7() {
		$program = new SimpleProgram('(Core::resource? (%0) (%0))');
		$result = $program->execute(self::$env, $fp = fopen(__DIR__ . '/../files/resource.db', 'r'));
		fclose($fp);
		$this->assertEquals(true, $result);
	}
	
	/**
	 * object?
	 */
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testObject0() {
		$program = new SimpleProgram('(object?)');
		$result = $program->execute(self::$env);
	}
	
	public function testObject1() {
		$program = new SimpleProgram('(object? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testObject2() {
		$program = new SimpleProgram('(object? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testObject3() {
		$program = new SimpleProgram('(object? "hey")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testObject4() {
		$program = new SimpleProgram('(object? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testObject5() {
		$program = new SimpleProgram('(object? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testObject6() {
		$program = new SimpleProgram('(object? (%0))');
		$result = $program->execute(self::$env, $fp = fopen(__DIR__ . '/../files/resource.db', 'r'));
		fclose($fp);
		$this->assertEquals(false, $result);
	}

	public function testObject7() {
		$program = new SimpleProgram('(object? (%0))');
		$result = $program->execute(self::$env, array(1, 2, 3));
		$this->assertEquals(false, $result);
	}
	
	public function testObject8() {
		$program = new SimpleProgram('(object? (%0))');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(true, $result);
	}
	
	public function testObject9() {
		$program = new SimpleProgram('(object? (%0) (%1))');
		$result = $program->execute(self::$env, new \stdClass(), new \stdClass());
		$this->assertEquals(true, $result);
	}
	
	public function testObject10() {
		$program = new SimpleProgram('(object? (%0) (%1))');
		$result = $program->execute(self::$env, new \stdClass(), array(1, 2, 3));
		$this->assertEquals(false, $result);
	}
	
	public function testObject11() {
		$program = new SimpleProgram('(Core::object? (%0) (%1))');
		$result = $program->execute(self::$env, new \stdClass(), array(1, 2, 3));
		$this->assertEquals(false, $result);
	}
	
	/**
	 * array?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArray0() {
		$program = new SimpleProgram('(array?)');
		$result = $program->execute(self::$env);
	}
	
	public function testArray1() {
		$program = new SimpleProgram('(array? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testArray2() {
		$program = new SimpleProgram('(array? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testArray3() {
		$program = new SimpleProgram('(array? "hey")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testArray4() {
		$program = new SimpleProgram('(array? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testArray5() {
		$program = new SimpleProgram('(array? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testArray6() {
		$program = new SimpleProgram('(array? (%0))');
		$result = $program->execute(self::$env, $fp = fopen(__DIR__ . '/../files/resource.db', 'r'));
		fclose($fp);
		$this->assertEquals(false, $result);
	}
	
	public function testArray7() {
		$program = new SimpleProgram('(array? (%0))');
		$result = $program->execute(self::$env, array(1, 2, 3));
		$this->assertEquals(true, $result);
	}
	
	public function testArray8() {
		$program = new SimpleProgram('(array? (%0))');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(false, $result);
	}
	
	public function testArray9() {
		$program = new SimpleProgram('(array? (%0) (%1))');
		$result = $program->execute(self::$env, array(1, 2), array(3, 4));
		$this->assertEquals(true, $result);
	}
	
	public function testArray10() {
		$program = new SimpleProgram('(array? (%0) (%1))');
		$result = $program->execute(self::$env, new \stdClass(), array(1, 2, 3));
		$this->assertEquals(false, $result);
	}
	
	public function testArray11() {
		$program = new SimpleProgram('(Core::array? (%0) (%1))');
		$result = $program->execute(self::$env, new \stdClass(), array(1, 2, 3));
		$this->assertEquals(false, $result);
	}
	
	/**
	 * numeric?
	 */
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testNumeric0() {
		$program = new SimpleProgram('(numeric?)');
		$result = $program->execute(self::$env);
	}
	
	public function testNumeric1() {
		$program = new SimpleProgram('(numeric? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNumeric2() {
		$program = new SimpleProgram('(numeric? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNumeric3() {
		$program = new SimpleProgram('(numeric? "hey")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNumeric4() {
		$program = new SimpleProgram('(numeric? "-4")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNumeric5() {
		$program = new SimpleProgram('(numeric? "5.45")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNumeric6() {
		$program = new SimpleProgram('(numeric? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNumeric7() {
		$program = new SimpleProgram('(numeric? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNumeric8() {
		$program = new SimpleProgram('(numeric? 1 "5.65")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNumeric9() {
		$program = new SimpleProgram('(numeric? 4.5 false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNumeric10() {
		$program = new SimpleProgram('(Core::numeric? 4.5 false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * scalar?
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testScalar0() {
		$program = new SimpleProgram('(scalar?)');
		$result = $program->execute(self::$env);
	}
	
	public function testScalar1() {
		$program = new SimpleProgram('(scalar? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testScalar2() {
		$program = new SimpleProgram('(scalar? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testScalar3() {
		$program = new SimpleProgram('(scalar? true 3.14)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testScalar4() {
		$program = new SimpleProgram('(scalar? "hello" (array))');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * null?
	 */
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testNull0() {
		$program = new SimpleProgram('(null?)');
		$result = $program->execute(self::$env);
	}
	
	public function testNull1() {
		$program = new SimpleProgram('(null? true)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNull2() {
		$program = new SimpleProgram('(null? null)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNull3() {
		$program = new SimpleProgram('(null? "hey")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNull4() {
		$program = new SimpleProgram('(null? 0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNull5() {
		$program = new SimpleProgram('(null? 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNull6() {
		$program = new SimpleProgram('(null? null undefined)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNull7() {
		$program = new SimpleProgram('(null? null false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNull8() {
		$program = new SimpleProgram('(Core::null? null false)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
}
?>