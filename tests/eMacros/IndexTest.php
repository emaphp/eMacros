<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
use Foo\Fizz;

/**
 * 
 * @author emaphp
 * @group index
 */
class IndexTest extends eMacrosTest {
	/**
	 * VALUEEXISTS
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIndexHas0() {
		$program = new SimpleProgram('(#0?)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIndexHas1() {
		$program = new SimpleProgram('(#0? null)');
		$result = $program->execute(self::$env);
	}
	
	public function testIndexHas2() {
		$program = new SimpleProgram('(#0?)');
		$result = $program->execute(self::$env, array(4));
		$this->assertEquals(true, $result);
	}
	
	public function testIndexHas3() {
		$program = new SimpleProgram('(#1?)');
		$result = $program->execute(self::$env, array(4));
		$this->assertEquals(false, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIndexHas4() {
		$program = new SimpleProgram('(#1?)');
		$result = $program->execute(self::$env, true, array(4));
	}
	
	public function testIndexHas5() {
		$program = new SimpleProgram('(#1? (%1))');
		$result = $program->execute(self::$env, true, array(1 => 4));
		$this->assertEquals(true, $result);
	}
	
	public function testIndexHas6() {
		$program = new SimpleProgram('(#1?)');
		$result = $program->execute(self::$env, new Fizz());
		$this->assertEquals(false, $result);
	}
	
	public function testIndexHas7() {
		$program = new SimpleProgram('(#3?)');
		$result = $program->execute(self::$env, new Fizz(array(3 => 1)));
		$this->assertEquals(true, $result);
	}
	
	public function testIndexHas8() {
		$program = new SimpleProgram('(#-1?)');
		$result = $program->execute(self::$env, array(-1 => 4));
		$this->assertEquals(true, $result);
	}
	
	/**
	 * VALUEGET
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testIndexGet0() {
		$program = new SimpleProgram('(#0)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIndexGet1() {
		$program = new SimpleProgram('(#0 null)');
		$result = $program->execute(self::$env);
	}
	
	public function testIndexGet2() {
		$program = new SimpleProgram('(#0)');
		$result = $program->execute(self::$env, array(4));
		$this->assertEquals(4, $result);
	}
	
	/**
	 * @expectedException OutOfBoundsException
	 */
	public function testIndexGet3() {
		$program = new SimpleProgram('(#1)');
		$result = $program->execute(self::$env, array(4));
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIndexGet4() {
		$program = new SimpleProgram('(#1)');
		$result = $program->execute(self::$env, true, array(4));
	}
	
	public function testIndexGet5() {
		$program = new SimpleProgram('(#1 (%1))');
		$result = $program->execute(self::$env, true, array(1 => 4));
		$this->assertEquals(4, $result);
	}
	
	public function testIndexGet6() {
		$program = new SimpleProgram('(#-1 (%1))');
		$result = $program->execute(self::$env, true, array(-1 => 4));
		$this->assertEquals(4, $result);
	}
	
	/**
	 * @expectedException OutOfBoundsException
	 */
	public function testIndexGet7() {
		$program = new SimpleProgram('(#1)');
		$result = $program->execute(self::$env, new Fizz());
	}
	
	public function testIndexGet8() {
		$program = new SimpleProgram('(#3)');
		$result = $program->execute(self::$env, new Fizz(array(3 => 1)));
		$this->assertEquals(1, $result);
	}
	
	public function testIndexGet9() {
		$program = new SimpleProgram('(#-3)');
		$result = $program->execute(self::$env, new Fizz(array(-3 => 1)));
		$this->assertEquals(1, $result);
	}
}
?>