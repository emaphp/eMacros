<?php
namespace eMacros;

use eMacros\Program\Program;

/**
 * 
 * @author emaphp
 * @group ctype
 */
class CTypePackageTest extends eMacrosTest {
	public function testAlnum1() {
		$program = new Program('(CType::alnum "AbCd1zyZ9")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testAlnum2() {
		$program = new Program('(CType::alnum "foo!#$bar")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testAlpha1() {
		$program = new Program('(CType::alpha "KjgWZC")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testAlpha2() {
		$program = new Program('(CType::alpha "arf12")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testCntrl1() {
		$program = new Program('(CType::cntrl (%0))');
		$result = $program->execute(self::$xenv, "\n\t\r");
		$this->assertTrue($result);
	}
	
	public function testCntrl2() {
		$program = new Program('(CType::cntrl "arf12")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testDigit1() {
		$program = new Program('(CType::digit "1820.20")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testDigit2() {
		$program = new Program('(CType::digit "10002")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testDigit3() {
		$program = new Program('(CType::digit "wsl!12")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testGraph1() {
		$program = new Program('(CType::graph (%0))');
		$result = $program->execute(self::$xenv, "asdf\n\r\t");
		$this->assertFalse($result);
	}
	
	public function testGraph2() {
		$program = new Program('(CType::graph "arf12")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testGraph3() {
		$program = new Program('(CType::graph "LKA#@%.54")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testLower1() {
		$program = new Program('(CType::lower "aac123")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testLower2() {
		$program = new Program('(CType::lower "qiutoas")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testLower3() {
		$program = new Program('(CType::lower "QASsdks")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testPrint1() {
		$program = new Program('(CType::print (%0))');
		$result = $program->execute(self::$xenv, "asdf\n\r\t");
		$this->assertFalse($result);
	}
	
	public function testPrint2() {
		$program = new Program('(CType::print "arf12")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testPrint3() {
		$program = new Program('(CType::print "LKA#@%.54")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testPunct1() {
		$program = new Program('(CType::punct "ABasdk!@!$#")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testPunct2() {
		$program = new Program('(CType::punct "!@ # $")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testPunct3() {
		$program = new Program('(CType::punct "*&$()")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testSpace1() {
		$program = new Program('(CType::space (%0))');
		$result = $program->execute(self::$xenv, "\n\r\t");
		$this->assertTrue($result);
	}
	
	public function testSpace2() {
		$program = new Program('(CType::space "\\\narf12")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testUpper1() {
		$program = new Program('(CType::upper "AKLWC139")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testUpper2() {
		$program = new Program('(CType::upper "LMNSDO")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testUpper3() {
		$program = new Program('(CType::punct "akwSKWsm")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testXDigit1() {
		$program = new Program('(CType::xdigit "AB10BC99")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testXDigit2() {
		$program = new Program('(CType::xdigit "AR1012")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testXDigit3() {
		$program = new Program('(CType::xdigit "ab12bc99")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
}
?>