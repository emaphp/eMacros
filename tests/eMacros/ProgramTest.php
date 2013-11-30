<?php
namespace eMacros;

use eMacros\Program\TextProgram;
/**
 * 
 * @author emaphp
 * @group program
 */
class ProgramTest extends eMacrosTest {
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
}
?>