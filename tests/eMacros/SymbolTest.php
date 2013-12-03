<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;

/**
 * 
 * @author emaphp
 * @group symbol
 */
class SymbolTest extends eMacrosTest {
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testSymbolSet0() {
		$program = new SimpleProgram('(sym)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSymbolSet1() {
		$program = new SimpleProgram('(sym null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSymbolSet2() {
		$program = new SimpleProgram('(sym "")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testSymbolSet3() {
		$program = new SimpleProgram('(sym ";")');
		$result = $program->execute(self::$env);
	}
	
	public function testSymbolSet4() {
		$program = new SimpleProgram('(sym "_val")');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testSymbolSet5() {
		$program = new SimpleProgram('(sym "_val" 10)');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testSymbolSet6() {
		$program = new SimpleProgram('(sym "_val" 10)(<- _val)');
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testSymbolLookup0() {
		$program = new SimpleProgram('(lookup)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSymbolLookup1() {
		$program = new SimpleProgram('(lookup null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSymbolLookup2() {
		$program = new SimpleProgram('(lookup "")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSymbolLookup3() {
		$program = new SimpleProgram('(lookup "_valsl3")');
		$result = $program->execute(self::$env);
	}
	
	public function testSymbolLookup4() {
		$program = new SimpleProgram('(sym "_valsl4" "test")(lookup "_valsl4")');
		$result = $program->execute(self::$env);
		$this->assertEquals("test", $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testSymbolExists0() {
		$program = new SimpleProgram('(sym-exists)');
		$result = $program->execute(self::$env);
	}
	
	public function testSymbolExists1() {
		$program = new SimpleProgram('(sym-exists "_se1")');
		$result = $program->execute(self::$env);
		$this->assertFalse($result);
	}
	
	public function testSymbolExists2() {
		$program = new SimpleProgram('(sym "_se2" 30)(sym-exists "_se2")');
		$result = $program->execute(self::$env);
		$this->assertTrue($result);
	}
	
	public function testSymbolExists3() {
		$program = new SimpleProgram('(:= _se3 100)(sym-exists "_se3")');
		$result = $program->execute(self::$env);
		$this->assertTrue($result);
	}
}
?>