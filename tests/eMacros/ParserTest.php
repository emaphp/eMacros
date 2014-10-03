<?php
namespace eMacros;

use eMacros\Program\Program;

/**
 * 
 * @author emaphp
 * @group parser
 */
class ParserTest extends eMacrosTest {
	public function testEmpty() {
		$program = new Program('');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testEmpty2() {
		$program = new Program('()');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testEmpty3() {
		$program = new Program('( )');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testNotDefined() {
		$program = new Program('not-defined');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testNull() {
		$program = new Program('null');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	/**
	 * @expectedException \UnexpectedValueException
	 */
	public function testNull2() {
		$program = new Program('(null)');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testBoolean() {
		$program = new Program('true');
		$result = $program->execute(self::$env);
		$this->assertTrue($result);
	}
	
	/**
	 * @expectedException \UnexpectedValueException
	 */
	public function testBoolean2() {
		$program = new Program('(true)');
		$result = $program->execute(self::$env);
		$this->assertTrue($result);
	}
	
	public function testInteger() {
		$program = new Program('4');
		$result = $program->execute(self::$env);
		$this->assertEquals(4, $result);
	}
	
	/**
	 * @expectedException \UnexpectedValueException
	 */
	public function testInteger2() {
		$program = new Program('(4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(4, $result);
	}
	
	public function testFloat() {
		$program = new Program('5.75');
		$result = $program->execute(self::$env);
		$this->assertEquals(5.75, $result);
	}
	
	/**
	 * @expectedException \UnexpectedValueException
	 */
	public function testFloat2() {
		$program = new Program('(5.75)');
		$result = $program->execute(self::$env);
		$this->assertEquals(5.75, $result);
	}
	
	public function testString() {
		$program = new Program("'Sup'");
		$result = $program->execute(self::$env);
		$this->assertEquals('Sup', $result);
	}
	
	/**
	 * @expectedException \UnexpectedValueException
	 */
	public function testString2() {
		$program = new Program("('Sup')");
		$result = $program->execute(self::$env);
		$this->assertEquals(5.75, $result);
	}
}
?>