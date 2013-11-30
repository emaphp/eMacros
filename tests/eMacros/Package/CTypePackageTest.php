<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;

/**
 * 
 * @author emaphp
 * @group ctype
 */
class CTypePackageTest extends eMacrosTest {
	public function testAlnum1() {
		$program = new SimpleProgram('(CType::alnum "AbCd1zyZ9")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testAlnum2() {
		$program = new SimpleProgram('(CType::alnum "foo!#$bar")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testAlpha1() {
		$program = new SimpleProgram('(CType::alpha "KjgWZC")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testAlpha2() {
		$program = new SimpleProgram('(CType::alpha "arf12")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testCntrl1() {
		$program = new SimpleProgram('(CType::cntrl (%0))');
		$result = $program->execute(self::$xenv, "\n\t\r");
		$this->assertTrue($result);
	}
	
	public function testCntrl2() {
		$program = new SimpleProgram('(CType::cntrl "arf12")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testDigit1() {
		$program = new SimpleProgram('(CType::digit "1820.20")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testDigit2() {
		$program = new SimpleProgram('(CType::digit "10002")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testDigit3() {
		$program = new SimpleProgram('(CType::digit "wsl!12")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testGraph1() {
		$program = new SimpleProgram('(CType::graph (%0))');
		$result = $program->execute(self::$xenv, "asdf\n\r\t");
		$this->assertFalse($result);
	}
	
	public function testGraph2() {
		$program = new SimpleProgram('(CType::graph "arf12")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testGraph3() {
		$program = new SimpleProgram('(CType::graph "LKA#@%.54")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testLower1() {
		$program = new SimpleProgram('(CType::lower "aac123")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testLower2() {
		$program = new SimpleProgram('(CType::lower "qiutoas")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testLower3() {
		$program = new SimpleProgram('(CType::lower "QASsdks")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testPrint1() {
		$program = new SimpleProgram('(CType::print (%0))');
		$result = $program->execute(self::$xenv, "asdf\n\r\t");
		$this->assertFalse($result);
	}
	
	public function testPrint2() {
		$program = new SimpleProgram('(CType::print "arf12")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testPrint3() {
		$program = new SimpleProgram('(CType::print "LKA#@%.54")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testPunct1() {
		$program = new SimpleProgram('(CType::punct "ABasdk!@!$#")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testPunct2() {
		$program = new SimpleProgram('(CType::punct "!@ # $")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testPunct3() {
		$program = new SimpleProgram('(CType::punct "*&$()")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testSpace1() {
		$program = new SimpleProgram('(CType::space (%0))');
		$result = $program->execute(self::$xenv, "\n\r\t");
		$this->assertTrue($result);
	}
	
	public function testSpace2() {
		$program = new SimpleProgram('(CType::space "\\\narf12")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testUpper1() {
		$program = new SimpleProgram('(CType::upper "AKLWC139")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testUpper2() {
		$program = new SimpleProgram('(CType::upper "LMNSDO")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testUpper3() {
		$program = new SimpleProgram('(CType::punct "akwSKWsm")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testXDigit1() {
		$program = new SimpleProgram('(CType::xdigit "AB10BC99")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testXDigit2() {
		$program = new SimpleProgram('(CType::xdigit "AR1012")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testXDigit3() {
		$program = new SimpleProgram('(CType::xdigit "ab12bc99")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
}
?>