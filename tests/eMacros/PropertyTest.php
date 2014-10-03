<?php
namespace eMacros;

use eMacros\Program\Program;
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
		$program = new Program('(#test?)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyHas1() {
		$program = new Program('(#test?)');
		$result = $program->execute(self::$env, 3);
	}
	
	public function testPropertyHas2() {
		$program = new Program('(#test?)');
		$result = $program->execute(self::$env, array());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas3() {
		$program = new Program('(#test?)');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas4() {
		$program = new Program('(#test?)');
		$result = $program->execute(self::$env, array('test' => 0));
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas5() {
		$program = new Program('(#test?)');
		$o = new \stdClass(); $o->test = 0;
		$result = $program->execute(self::$env, $o);
		$this->assertEquals(true, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyHas6() {
		$program = new Program('(#test? null)');
		$result = $program->execute(self::$env);
	}
	
	public function testPropertyHas7() {
		$program = new Program('(#test? (%0))');
		$result = $program->execute(self::$env, new Fizz);
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas8() {
		$program = new Program('(#test? (%0))');
		$result = $program->execute(self::$env, new Fizz(array('test' => 5)));
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas9() {
		$program = new Program('(#test? (%0))');
		$result = $program->execute(self::$env, new Buzz());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas10() {
		$program = new Program('(#test? (%0))');
		$result = $program->execute(self::$env, new Buzz(array('test' => 5)));
		$this->assertEquals(true, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyHas11() {
		$program = new Program('(#?)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyHas12() {
		$program = new Program('(#? "name")');
		$result = $program->execute(self::$env);
	}
	
	public function testPropertyHas13() {
		$program = new Program('(#? "name")');
		$result = $program->execute(self::$env, array());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyHas14() {
		$program = new Program('(#? "name")');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals(false, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyHas15() {
		$program = new Program('(#? "name" null)');
		$result = $program->execute(self::$env);
	}
	
	public function testPropertyHas16() {
		$program = new Program('(#? "name")');
		$result = $program->execute(self::$env, array('name' => 'emma'));
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas17() {
		$program = new Program('(#? 0 (array "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas18() {
		$program = new Program('(:= _ph18 0)(#? _ph18 (array "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testPropertyHas19() {
		$o = new \stdClass(); $o->name = "emma";
		$program = new Program('(:= _ph19 "name")(#? _ph19 (%0))');
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
		$program = new Program('(#test)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet1() {
		$program = new Program('(#test)');
		$result = $program->execute(self::$env, 3);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet2() {
		$program = new Program('(#test)');
		$result = $program->execute(self::$env, array());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet3() {
		$program = new Program('(#test)');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	public function testPropertyGet4() {
		$program = new Program('(#test)');
		$result = $program->execute(self::$env, array('test' => 10));
		$this->assertEquals(10, $result);
	}
	
	public function testPropertyGet5() {
		$program = new Program('(#test)');
		$o = new \stdClass(); $o->test = 10;
		$result = $program->execute(self::$env, $o);
		$this->assertEquals(10, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet6() {
		$program = new Program('(#test null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet7() {
		$program = new Program('(#test (%0))');
		$result = $program->execute(self::$env, new Fizz);
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyGet8() {
		$program = new Program('(#test (%0))');
		$result = $program->execute(self::$env, new Fizz(array('test' => 5)));
		$this->assertEquals(5, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet9() {
		$program = new Program('(#test (%0))');
		$result = $program->execute(self::$env, new Buzz());
		$this->assertEquals(false, $result);
	}
	
	public function testPropertyGet10() {
		$program = new Program('(#test (%0))');
		$result = $program->execute(self::$env, new Buzz(array('test' => 5)));
		$this->assertEquals(5, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet11() {
		$program = new Program('(#publicProperty (%0))');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals(42, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet12() {
		$program = new Program('(#privateProperty (%0))');
		$result = $program->execute(self::$env, new Fizz());
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyGet13() {
		$program = new Program('(#)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testPropertyGet14() {
		$program = new Program('(# "name")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet15() {
		$program = new Program('(# "name")');
		$result = $program->execute(self::$env, array());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet16() {
		$program = new Program('(# "name")');
		$result = $program->execute(self::$env, new \stdClass());
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testPropertyGet17() {
		$program = new Program('(# "name" null)');
		$result = $program->execute(self::$env);
	}
	
	public function testPropertyGet18() {
		$program = new Program('(# "name")');
		$result = $program->execute(self::$env, array('name' => 'emma'));
		$this->assertEquals('emma', $result);
	}
	
	public function testPropertyGet19() {
		$program = new Program('(# 0 (array "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals('emma', $result);
	}
	
	public function testPropertyGet20() {
		$program = new Program('(:= _pg20 0)(# _pg20 (array "emma"))');
		$result = $program->execute(self::$env);
		$this->assertEquals('emma', $result);
	}
	
	public function testPropertyGet21() {
		$o = new \stdClass(); $o->name = "emma";
		$program = new Program('(:= _pg21 "name")(# _pg21 (%0))');
		$result = $program->execute(self::$env, $o);
		$this->assertEquals('emma', $result);
	}
	
	/**
	 * VALUE ASSIGN
	 */
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign0() {
		$program = new Program('(:= _arr (array))(#=)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign1() {
		$program = new Program('(:= _arr (array))(#= "Test")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign2() {
		$program = new Program('(:= _arr (array))(#= "name" "x")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValueAssign3() {
		$program = new Program('(:= _arr (array))(#= "name" 3 "Test")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign4() {
		$program = new Program('(:= _arr (array))(#name=)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testValueAssign5() {
		$program = new Program('(:= _arr (array))(#name= "emma")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValueAssign6() {
		$program = new Program('(:= _arr (array))(#name= 2 "emma")');
		$result = $program->execute(self::$env);
	}
	
	public function testValueAssign7() {
		$program = new Program('(:= _arr (array))(#= "name" _arr "emma")(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('name' => "emma"), $result);
	}
	
	public function testValueAssign8() {
		$program = new Program('(:= _arr (array))(#= -1 _arr 1)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(-1 => 1), $result);
	}
	
	public function testValueAssign9() {
		$o = new \stdClass; $o->test = "testValueAssign9"; 
		$program = new Program('(:= _obj (%0))(#= "test" _obj "testValueAssign9")(<- _obj)');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign10() {
		$o = new FizzBuzz(); $o->publicProperty = "test";
		$program = new Program('(:= _obj (%0))(#= "publicProperty" _obj "test")(<- _obj)');
		$result = $program->execute(self::$env, new FizzBuzz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign11() {
		$o = new Fizz(); $o['publicProperty'] = "testValueAssign11";
		$program = new Program('(:= _obj (%0))(#= "publicProperty" _obj "testValueAssign11")(<- _obj)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign12() {
		$o = new Fizz(); $o[4] = "testValueAssign12";
		$program = new Program('(:= _obj (%0))(#= 4 _obj "testValueAssign12")(<- _obj)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign13() {
		$program = new Program('(:= _arr (array))(#name= _arr "emma")(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('name' => "emma"), $result);
	}
	
	public function testValueAssign14() {
		$program = new Program('(:= _arr (array))(#-1= _arr 1)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(-1 => 1), $result);
	}
	
	public function testValueAssign15() {
		$o = new \stdClass; $o->test = "testValueAssign9"; 
		$program = new Program('(:= _obj (%0))(#test= _obj "testValueAssign9")(<- _obj)');
		$result = $program->execute(self::$env, new \stdClass());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign16() {
		$o = new FizzBuzz(); $o->publicProperty = "test";
		$program = new Program('(:= _obj (%0))(#publicProperty= _obj "test")(<- _obj)');
		$result = $program->execute(self::$env, new FizzBuzz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign17() {
		$o = new Fizz(); $o['publicProperty'] = "testValueAssign11";
		$program = new Program('(:= _obj (%0))(#publicProperty= _obj "testValueAssign11")(<- _obj)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals($o, $result);
	}
	
	public function testValueAssign18() {
		$o = new Fizz(); $o[4] = "testValueAssign12";
		$program = new Program('(:= _obj (%0))(#4= _obj "testValueAssign12")(<- _obj)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals($o, $result);
	}
}
?>