<?php
namespace eMacros;

use eMacros\Program\TextProgram;
use eMacros\Program\SimpleProgram;
/**
 * 
 * @author emaphp
 * @group program
 */
class ProgramTest extends eMacrosTest {
	public function testSimpleProgram1() {
		$program = new SimpleProgram('(+ 3 (* 4 7))');
		$result = $program->execute(self::$env);
		$this->assertEquals(31, $result);
	}
	
	public function testSimpleProgram2() {
		$program = new SimpleProgram('(+ (%0) (* (%1) (%2)))');
		$result = $program->execute(self::$env, 3, 4, 7);
		$this->assertEquals(31, $result);
	}
	
	public function testSimpleProgram3() {
		$program = new SimpleProgram('(+ (%0) (* (%1) (%2)))');
		$result = $program->executeWith(self::$env, array(3, 4, 7));
		$this->assertEquals(31, $result);
	}
	
	public function testTextProgram1() {
		$program = new TextProgram('(to-upper "hello")(. " " "World")');
		$result = $program->execute(self::$env);
		$this->assertEquals("HELLO World", $result);
	}
	
	public function testTextProgram2() {
		$code = "'Hello ' (if (%0?) (%0) 'stranger') '! '
				(if (and (%1?) (!= (%1) 0)) (. 'You\'ve been here ' (%1) ' times already.') 'It seems that this it\'s your first time here.')";
		$program = new TextProgram($code);
		$result = $program->execute(self::$env);
		$this->assertEquals("Hello stranger! It seems that this it's your first time here.", $result);
	}
	
	public function testTextProgram3() {
		$code = "'Hello ' (if (%0?) (%0) 'stranger') '! '
				(if (and (%1?) (!= (%1) 0)) (. 'You\'ve been here ' (%1) ' times already.') 'It seems that this it\'s your first time here.')";
		$program = new TextProgram($code);
		$result = $program->execute(self::$env, "emma");
		$this->assertEquals("Hello emma! It seems that this it's your first time here.", $result);
	}
	
	public function testTextProgram4() {
		$code = "'Hello ' (if (%0?) (%0) 'stranger') '! '
				(if (and (%1?) (!= (%1) 0)) (. 'You\'ve been here ' (%1) ' times already.') 'It seems that this it\'s your first time here.')";
		$program = new TextProgram($code);
		$result = $program->execute(self::$env, "emma", 6);
		$this->assertEquals("Hello emma! You've been here 6 times already.", $result);
	}
	
	public function testTextProgram5() {
		$code = "'Hello ' (if (%0?) (%0) 'stranger') '! '
				(if (and (%1?) (!= (%1) 0)) (. 'You\'ve been here ' (%1) ' times already.') 'It seems that this it\'s your first time here.')";
		$program = new TextProgram($code);
		$result = $program->executeWith(self::$env, array("emma", 6));
		$this->assertEquals("Hello emma! You've been here 6 times already.", $result);
	}
}
?>