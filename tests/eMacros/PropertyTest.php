<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
use Foo\Fizz;
use Foo\Buzz;
use Foo\FizzBuzz;
/**
 * 
 * @author emaphp
 * @group property
 */
class PropertyTest extends eMacrosTest {
	
	/**
	 * VALUEHAS 
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyHas0() {
		$program = new SimpleProgram('(@test?)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyHas1() {
		$program = new SimpleProgram('(@test?)');
		$result = $program->execute(self::$env, 3);
	}
	
	public function testPropertyHas2() {
		$program = new SimpleProgram('(@test?)');
		$result = $program->execute(self::$env, array());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas3() {
		$program = new SimpleProgram('(@test?)');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas4() {
		$program = new SimpleProgram('(@test?)');
		$result = $program->execute(self::$env, array('test' => 0));
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas5() {
		$program = new SimpleProgram('(@test?)');
		$o = new \stdClass(); $o->test = 0;
		$result = $program->execute(self::$env, $o);
		$this->assertEquals(true, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyHas6() {
		$program = new SimpleProgram('(@test? null)');
		$result = $program->execute(self::$env);
	}
	
	public function testPropertyHas7() {
		$program = new SimpleProgram('(@test? (%0))');
		$result = $program->execute(self::$env, new Fizz);
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas8() {
		$program = new SimpleProgram('(@test? (%0))');
		$result = $program->execute(self::$env, new Fizz(array('test' => 5)));
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas9() {
		$program = new SimpleProgram('(@test? (%0))');
		$result = $program->execute(self::$env, new Buzz());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas10() {
		$program = new SimpleProgram('(@test? (%0))');
		$result = $program->execute(self::$env, new Buzz(array('test' => 5)));
		$this->assertEquals(true, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyHas11() {
		$program = new SimpleProgram('(@?)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyHas12() {
		$program = new SimpleProgram('(@? "name")');
		$result = $program->execute(self::$env);
	}
	
	public function testPropertyHas13() {
		$program = new SimpleProgram('(@? "name")');
		$result = $program->execute(self::$env, array());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas14() {
		$program = new SimpleProgram('(@? "name")');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(false, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyHas15() {
		$program = new SimpleProgram('(@? "name" null)');
		$result = $program->execute(self::$env);
	}
	
	public function testPropertyHas16() {
		$program = new SimpleProgram('(@? "name")');
		$result = $program->execute(self::$env, array('name' => 'emma'));
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas17() {
		$program = new SimpleProgram('(@? 0 (array "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas18() {
		$program = new SimpleProgram('(:= _ph18 0)(@? _ph18 (array "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas19() {
		$o = new \stdClass(); $o->name = "emma";
		$program = new SimpleProgram('(:= _ph19 "name")(@? _ph19 (%0))');
		$result = $program->execute(self::$env, $o);
		$this->assertEquals(true, $result);
	}
	
	/**
	 * VALUEGET
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyGet0() {
		$program = new SimpleProgram('(@test)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet1() {
		$program = new SimpleProgram('(@test)');
		$result = $program->execute(self::$env, 3);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet2() {
		$program = new SimpleProgram('(@test)');
		$result = $program->execute(self::$env, array());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet3() {
		$program = new SimpleProgram('(@test)');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testPropertyGet4() {
		$program = new SimpleProgram('(@test)');
		$result = $program->execute(self::$env, array('test' => 10));
		$this->assertEquals(10, $result);
	}
	
	public function testPropertyGet5() {
		$program = new SimpleProgram('(@test)');
		$o = new \stdClass(); $o->test = 10;
		$result = $program->execute(self::$env, $o);
		$this->assertEquals(10, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet6() {
		$program = new SimpleProgram('(@test null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet7() {
		$program = new SimpleProgram('(@test (%0))');
		$result = $program->execute(self::$env, new Fizz);
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyGet8() {
		$program = new SimpleProgram('(@test (%0))');
		$result = $program->execute(self::$env, new Fizz(array('test' => 5)));
		$this->assertEquals(5, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet9() {
		$program = new SimpleProgram('(@test (%0))');
		$result = $program->execute(self::$env, new Buzz());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyGet10() {
		$program = new SimpleProgram('(@test (%0))');
		$result = $program->execute(self::$env, new Buzz(array('test' => 5)));
		$this->assertEquals(5, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet11() {
		$program = new SimpleProgram('(@publicProperty (%0))');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals(42, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet12() {
		$program = new SimpleProgram('(@privateProperty (%0))');
		$result = $program->execute(self::$env, new Fizz());
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyGet13() {
		$program = new SimpleProgram('(@)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyGet14() {
		$program = new SimpleProgram('(@ "name")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet15() {
		$program = new SimpleProgram('(@ "name")');
		$result = $program->execute(self::$env, array());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet16() {
		$program = new SimpleProgram('(@ "name")');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet17() {
		$program = new SimpleProgram('(@ "name" null)');
		$result = $program->execute(self::$env);
	}
	
	public function testPropertyGet18() {
		$program = new SimpleProgram('(@ "name")');
		$result = $program->execute(self::$env, array('name' => 'emma'));
		$this->assertEquals('emma', $result);
	}
	
	public function testPropertyGet19() {
		$program = new SimpleProgram('(@ 0 (array "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals('emma', $result);
	}
	
	public function testPropertyGet20() {
		$program = new SimpleProgram('(:= _pg20 0)(@ _pg20 (array "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals('emma', $result);
	}
	
	public function testPropertyGet21() {
		$o = new \stdClass(); $o->name = "emma";
		$program = new SimpleProgram('(:= _pg21 "name")(@ _pg21 (%0))');
		$result = $program->execute(self::$env, $o);
		$this->assertEquals('emma', $result);
	}
	
	/**
	 * VALUEAPPEND
	 */
	
	/**
	 * @expectedException BadFunctionCallException 
	 */
	public function testValueAppend0() {
		$program = new SimpleProgram('(@+)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAppend1() {
		$program = new SimpleProgram('(@+ null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValueAppend2() {
		$program = new SimpleProgram('(@+ null null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValueAppend3() {
		$program = new SimpleProgram('(@+ null (%0))');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testValueAppend4() {
		$program = new SimpleProgram('(:= _arr (array))(@+ 10 _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(10), $result);
	}
	
	public function testValueAppend5() {
		$program = new SimpleProgram('(:= _arr (%0))(@+ 10 _arr)(<- _arr)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertTrue(is_object($result));
		$this->assertEquals('Foo\\Fizz', get_class($result));
		$this->assertEquals(10, $result[0]);
	}
	
	public function testValueAppend6() {
		$program = new SimpleProgram('(:= _arr (array))(@+ 10 20 30 _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(10, 20, 30), $result);
	}
	
	public function testValueAppend7() {
		$program = new SimpleProgram('(:= _arr (%0))(@+ 30 40 _arr)(<- _arr)');
		$result = $program->execute(self::$env, new Fizz(array(10, 20)));
		$this->assertTrue(is_object($result));
		$this->assertEquals('Foo\\Fizz', get_class($result));
		$this->assertEquals(10, $result[0]);
		$this->assertEquals(20, $result[1]);
		$this->assertEquals(30, $result[2]);
		$this->assertEquals(40, $result[3]);
	}
	
	/**
	 * VALUE ASSIGN
	 */
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign0() {
		$program = new SimpleProgram('(:= _arr (array))(@=)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign1() {
		$program = new SimpleProgram('(:= _arr (array))(@= "Test")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign2() {
		$program = new SimpleProgram('(:= _arr (array))(@= "name" "x")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValueAssign3() {
		$program = new SimpleProgram('(:= _arr (array))(@= "name" "Test" 3)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign4() {
		$program = new SimpleProgram('(:= _arr (array))(@name=)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign5() {
		$program = new SimpleProgram('(:= _arr (array))(@name= "emma")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValueAssign6() {
		$program = new SimpleProgram('(:= _arr (array))(@name= "emma" 2)');
		$result = $program->execute(self::$env);
	}
	
	public function testValueAssign7() {
		$program = new SimpleProgram('(:= _arr (array))(@= "name" "emma" _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('name' => "emma"), $result);
	}
	
	public function testValueAssign8() {
		$program = new SimpleProgram('(:= _arr (array))(@= -1 1 _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(-1 => 1), $result);
	}
	
	public function testValueAssign9() {
		$o = new \stdClass; $o->test = "testValueAssign9"; 
		$program = new SimpleProgram('(:= _obj (%0))(@= "test" "testValueAssign9" _obj)(<- _obj)');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign10() {
		$o = new FizzBuzz(); $o->publicProperty = "test";
		$program = new SimpleProgram('(:= _obj (%0))(@= "publicProperty" "test" _obj)(<- _obj)');
		$result = $program->execute(self::$env, new FizzBuzz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign11() {
		$o = new Fizz(); $o['publicProperty'] = "testValueAssign11";
		$program = new SimpleProgram('(:= _obj (%0))(@= "publicProperty" "testValueAssign11" _obj)(<- _obj)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign12() {
		$o = new Fizz(); $o[4] = "testValueAssign12";
		$program = new SimpleProgram('(:= _obj (%0))(@= 4 "testValueAssign12" _obj)(<- _obj)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign13() {
		$program = new SimpleProgram('(:= _arr (array))(@name= "emma" _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('name' => "emma"), $result);
	}
	
	public function testValueAssign14() {
		$program = new SimpleProgram('(:= _arr (array))(#-1= 1 _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(-1 => 1), $result);
	}
	
	public function testValueAssign15() {
		$o = new \stdClass; $o->test = "testValueAssign9"; 
		$program = new SimpleProgram('(:= _obj (%0))(@test= "testValueAssign9" _obj)(<- _obj)');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign16() {
		$o = new FizzBuzz(); $o->publicProperty = "test";
		$program = new SimpleProgram('(:= _obj (%0))(@publicProperty= "test" _obj)(<- _obj)');
		$result = $program->execute(self::$env, new FizzBuzz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign17() {
		$o = new Fizz(); $o['publicProperty'] = "testValueAssign11";
		$program = new SimpleProgram('(:= _obj (%0))(@publicProperty= "testValueAssign11" _obj)(<- _obj)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign18() {
		$o = new Fizz(); $o[4] = "testValueAssign12";
		$program = new SimpleProgram('(:= _obj (%0))(#4= "testValueAssign12" _obj)(<- _obj)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals($o, $result);
	}
}
?>