<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
use eMacros\Program\ListProgram;

/**
 * 
 * @author emaphp
 * @group environment
 */
class EnvironmentTest extends eMacrosTest {
	public function testUse0() {
		$program = new SimpleProgram('(use)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testUse1() {
		$program = new SimpleProgram('(use chop)(chop " Hello World   ")');
		$result = $program->execute(self::$env);
		$this->assertEquals(" Hello World", $result);
	}
	
	public function testUse2() {
		$o = new \stdClass(); $o->name = "emma"; $o->language = "emacros";
		$program = new SimpleProgram('(use (get_object_vars vars))(vars (%0))');
		$result = $program->execute(self::$env, $o);
		$this->assertEquals(array("name" => "emma", "language" => "emacros"), $result);
	}
	
	public function testUse3() {
		$o = new \stdClass(); $o->name = "emma"; $o->language = "emacros";
		$program = new ListProgram('(use chop (get_object_vars vars))(vars (%0))(chop (%1))');
		$result = $program->execute(self::$env, $o, "   Sup World   ");
		$this->assertEquals(array("name" => "emma", "language" => "emacros"), $result[1]);
		$this->assertEquals("   Sup World", $result[2]);
	}
	
	public function testUse4() {
		$o = new \stdClass(); $o->name = "emma"; $o->language = "emacros";
		$program = new ListProgram('(Core::use chop (get_object_vars vars))(vars (%0))(chop (%1))');
		$result = $program->execute(self::$env, $o, "   Sup World   ");
		$this->assertEquals(array("name" => "emma", "language" => "emacros"), $result[1]);
		$this->assertEquals("   Sup World", $result[2]);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testUse5() {
		$program = new SimpleProgram('(use "hello")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testUse6() {
		$program = new SimpleProgram('(use -123)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testImport1() {
		$program = new SimpleProgram('(import)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testImport2() {
		$program = new SimpleProgram('(import -123)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testImport3() {
		$program = new SimpleProgram('(import null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testImport4() {
		$program = new SimpleProgram('(import eMacros\\Package\\MathPackage 150)');
		$result = $program->execute(self::$benv);
	}
	
	public function testImport5() {
		$program = new SimpleProgram('(import eMacros\\Package\\MathPackage)(abs -4)');
		$result = $program->execute(self::$benv);
		$this->assertEquals(4, $result);
	}
	
	public function testImport6() {
		$program = new SimpleProgram('(import eMacros\\Package\\MathPackage)(Math::abs -4)');
		$result = $program->execute(self::$benv);
		$this->assertEquals(4, $result);
	}
	
	public function testImport7() {
		$program = new SimpleProgram('(import eMacros\\Package\\MathPackage matematica)(abs -10)');
		$result = $program->execute(self::$benv);
		$this->assertEquals(10, $result);
	}
	
	public function testImport8() {
		$program = new SimpleProgram('(import eMacros\\Package\\MathPackage matematica)(matematica::abs -10)');
		$result = $program->execute(self::$benv);
		$this->assertEquals(10, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testImport9() {
		$program = new SimpleProgram('(import eMacros\\Package\\MathPackage $$$)($$$::abs -10)');
		$result = $program->execute(self::$benv);
	}
}
?>