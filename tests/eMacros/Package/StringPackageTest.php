<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
use eMacros\Package\StringPackage;
use eMacros\Program\ListProgram;
/**
 * 
 * @author emaphp
 * @group string
 */
class StringPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new StringPackage();
		
		$this->assertEquals(STR_PAD_LEFT, $package['PAD_LEFT']);
		$this->assertEquals(STR_PAD_RIGHT, $package['PAD_RIGHT']);
		$this->assertEquals(STR_PAD_BOTH, $package['PAD_BOTH']);
	}
	
	public function testContatenate0() {
		$program = new SimpleProgram('(.)');
		$result = $program->execute(self::$env);
		$this->assertEquals('', $result);
	}
	
	public function testContatenate1() {
		$program = new SimpleProgram('(. "Hello" " " "World")');
		$result = $program->execute(self::$env);
		$this->assertEquals('Hello World', $result);
	}
	
	public function testAddCSlashes() {
		$program = new SimpleProgram('(addcslashes "foo[ ]" "A..z")');
		$result = $program->execute(self::$env);
		$this->assertEquals('\f\o\o\[ \]', $result);
	}
	
	public function testStripCSlashes() {
		$program = new SimpleProgram('(stripcslashes (%0))');
		$result = $program->execute(self::$env, '\d\n\e');
		$this->assertEquals("d\ne", $result);
	}
	
	public function testBin2Hex() {
		$program = new SimpleProgram('(bin2hex "Hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals('48656c6c6f', $result);
	}
	
	public function testHex2Bin() {
		$program = new SimpleProgram('(hex2bin "6578616d706c65206865782064617461")');
		$result = $program->execute(self::$env);
		$this->assertEquals('example hex data', $result);
	}
	
	public function testChr() {
		$program = new SimpleProgram('(chr 65)');
		$result = $program->execute(self::$env);
		$this->assertEquals('A', $result);
	}
	
	public function testCountChars() {
		$program = new SimpleProgram('(count-chars "aabbcdee" 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(97 => 2, 98 => 2, 99 => 1, 100 => 1, 101 => 2), $result);
	}
	
	public function testLCFirst() {
		$program = new SimpleProgram('(lcfirst "Hello World")');
		$result = $program->execute(self::$env);
		$this->assertEquals("hello World", $result);
	}
	
	public function testLTrim() {
		$program = new SimpleProgram('(ltrim "   Hello World   ")');
		$result = $program->execute(self::$env);
		$this->assertEquals("Hello World   ", $result);
	}
	
	public function testRTrim() {
		$program = new SimpleProgram('(rtrim "   Hello World   ")');
		$result = $program->execute(self::$env);
		$this->assertEquals("   Hello World", $result);
	}
	
	public function testOrd() {
		$program = new SimpleProgram('(ord "\n")');
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testNumberFormat1() {
		$number = 1234.56;
		$program = new SimpleProgram('(number-format (%0))');
		$result = $program->execute(self::$env, $number);
		$this->assertEquals("1,235", $result);
	}
	
	public function testNumberFormat2() {
		$number = 1234.56;
		$program = new SimpleProgram('(number-format (%0) 2 "," " ")');
		$result = $program->execute(self::$env, $number);
		$this->assertEquals("1 234,56", $result);
	}
	
	public function testNumberFormat3() {
		$number = 1234.56;
		$program = new SimpleProgram('(number-format (%0) 2 "." "")');
		$result = $program->execute(self::$env, $number);
		$this->assertEquals("1234.56", $result);
	}
	
	public function testExplode1() {
		$program = new SimpleProgram('(explode "," "1,2,3")');
		$result = $program->execute(self::$env);
		$this->assertEquals(explode(',', '1,2,3'), $result);
	}
	
	public function testExplode2() {
		$program = new SimpleProgram('(String::explode "," "1,2,3")');
		$result = $program->execute(self::$env);
		$this->assertEquals(explode(',', '1,2,3'), $result);
	}
	
	public function testImplode1() {
		$program = new SimpleProgram('(implode "," (%0))');
		$result = $program->execute(self::$env, array(1,2,3));
		$this->assertEquals(implode(',', array(1,2,3)), $result);
	}
	
	public function testImplode2() {
		$program = new SimpleProgram('(String::implode "," (%0))');
		$result = $program->execute(self::$env, array(1,2,3));
		$this->assertEquals(implode(',', array(1,2,3)), $result);
	}
	
	public function testPad1() {
		$program = new SimpleProgram('(pad "Alien" 10 "-=" PAD_LEFT)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_pad('Alien', 10, "-=", STR_PAD_LEFT), $result);
	}
	
	public function testPad2() {
		$program = new SimpleProgram('(String::pad "Alien" 10 "-=" String::PAD_LEFT)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_pad('Alien', 10, "-=", STR_PAD_LEFT), $result);
	}
	
	public function testRepeat1() {
		$program = new SimpleProgram('(repeat "-=" 10)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_repeat("-=", 10), $result);
	}
	
	public function testRepeat2() {
		$program = new SimpleProgram('(String::repeat "-=" 10)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_repeat("-=", 10), $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testReplace0() {
		$program = new SimpleProgram('(replace "%body%" "black" "<body text=\'%body%\'>" 0)');
		$result = $program->execute(self::$env);
	}
	
	public function testReplace1() {
		$program = new SimpleProgram('(replace "%body%" "black" "<body text=\'%body%\'>")');
		$result = $program->execute(self::$env);
		$this->assertEquals("<body text='black'>", $result);
	}
	
	public function testReplace2() {
		$program = new SimpleProgram('(String::replace "%body%" "black" "<body text=\'%body%\'>")');
		$result = $program->execute(self::$env);
		$this->assertEquals("<body text='black'>", $result);
	}
	
	public function testReplace3() {
		$program = new SimpleProgram('(String::replace "%body%" "black" "<body text=\'%body%\'>%body%" _count)(<- _count)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIReplace0() {
		$program = new SimpleProgram('(ireplace "%body%" "black" "<body text=\'%body%\'>" 0)');
		$result = $program->execute(self::$env);
	}
	
	public function testIReplace1() {
		$program = new SimpleProgram('(ireplace "%body%" "black" "<body text=\'%BODY%\'>")');
		$result = $program->execute(self::$env);
		$this->assertEquals("<body text='black'>", $result);
	}
	
	public function testIReplace2() {
		$program = new SimpleProgram('(String::ireplace "%body%" "black" "<body text=\'%body%\'>%BODY%")(<- _count)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	public function testReverse1() {
		$program = new SimpleProgram('(reverse "Hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals("olleH", $result);
	}
	
	public function testReverse2() {
		$program = new SimpleProgram('(String::reverse "Hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals("olleH", $result);
	}
	
	public function testShuffle1() {
		$program = new SimpleProgram('(shuffle "abcde")');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, preg_match('/[a-e]{5}/', $result));
	}
	
	public function testShuffle2() {
		$program = new SimpleProgram('(String::shuffle "abcde")');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, preg_match('/[a-e]{5}/', $result));
	}
	
	public function testSplit1() {
		$program = new SimpleProgram('(split "hello friend" 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_split("hello friend", 3), $result);
	}
	
	public function testSplit2() {
		$program = new SimpleProgram('(String::split "hello friend" 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_split("hello friend", 3), $result);
	}
	
	public function testWordCount1() {
		$program = new SimpleProgram('(word-count "hello my friend")');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_word_count("hello my friend"), $result);
	}
	
	public function testWordCount2() {
		$program = new SimpleProgram('(String::word-count "hello my friend")');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_word_count("hello my friend"), $result);
	}
	
	public function testCmp1() {
		$program = new SimpleProgram('(cmp "abc" "abcd")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strcmp("abc", "abcd"), $result);
	}
	
	public function testCmp2() {
		$program = new SimpleProgram('(String::cmp "abc" "abcd")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strcmp("abc", "abcd"), $result);
	}
	
	public function testLen1() {
		$program = new SimpleProgram('(len "hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strlen("hello"), $result);
	}
	
	public function testLen2() {
		$program = new SimpleProgram('(String::len "hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strlen("hello"), $result);
	}
	
	public function testPos1() {
		$program = new SimpleProgram('(pos "abcdef abcdef" "a" 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(strpos("abcdef abcdef","a",1), $result);
	}
	
	public function testPos2() {
		$program = new SimpleProgram('(String::pos "abcdef abcdef" "a" 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(strpos("abcdef abcdef","a",1), $result);
	}
	
	public function testIPos1() {
		$program = new SimpleProgram('(ipos "xyz" "a")');
		$result = $program->execute(self::$env);
		$this->assertFalse($result);
	}
	
	public function testIPos2() {
		$program = new SimpleProgram('(ipos "ABC" "b")');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testStr1() {
		$program = new SimpleProgram('(str "name@example.com" "@")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strstr("name@example.com", "@"), $result);
	}
	
	public function testStr2() {
		$program = new SimpleProgram('(String::str "name@example.com" "@")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strstr("name@example.com", "@"), $result);
	}
	
	public function testIStr1() {
		$program = new SimpleProgram('(istr "USER@EXAMPLE.com" "e")');
		$result = $program->execute(self::$env);
		$this->assertEquals("ER@EXAMPLE.com", $result);
	}
	
	public function testIStr2() {
		$program = new SimpleProgram('(istr "USER@EXAMPLE.com" "e" true)');
		$result = $program->execute(self::$env);
		$this->assertEquals("US", $result);
	}
	
	public function testToLower1() {
		$program = new SimpleProgram('(to-lower "Mary Had A Little Lamb and She LOVED It So")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strtolower("Mary Had A Little Lamb and She LOVED It So"), $result);
	}
	
	public function testToLower2() {
		$program = new SimpleProgram('(String::to-lower "Mary Had A Little Lamb and She LOVED It So")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strtolower("Mary Had A Little Lamb and She LOVED It So"), $result);
	}
	
	public function testToUpper1() {
		$program = new SimpleProgram('(to-upper "Mary Had A Little Lamb and She LOVED It So")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strtoupper("Mary Had A Little Lamb and She LOVED It So"), $result);
	}
	
	public function testToUpper2() {
		$program = new SimpleProgram('(String::to-upper "Mary Had A Little Lamb and She LOVED It So")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strtoupper("Mary Had A Little Lamb and She LOVED It So"), $result);
	}
	
	public function testSubStr1() {
		$program = new SimpleProgram('(substr "abcdef" -2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(substr("abcdef", -2), $result);
	}
	
	public function testSubStr2() {
		$program = new SimpleProgram('(String::substr "abcdef" -2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(substr("abcdef", -2), $result);
	}
	
	public function testTrim1() {
		$program = new SimpleProgram('(trim "   Hello  ")');
		$result = $program->execute(self::$env);
		$this->assertEquals(trim("   Hello  "), $result);
	}
	
	public function testTrim2() {
		$program = new SimpleProgram('(String::trim "   Hello  ")');
		$result = $program->execute(self::$env);
		$this->assertEquals(trim("   Hello  "), $result);
	}
	
	public function testUcfirst1() {
		$program = new SimpleProgram('(ucfirst "hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals(ucfirst("hello"), $result);
	}
	
	public function testUcfirst2() {
		$program = new SimpleProgram('(String::ucfirst "hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals(ucfirst("hello"), $result);
	}
	
	public function testUcwords1() {
		$program = new SimpleProgram('(ucwords "hello world")');
		$result = $program->execute(self::$env);
		$this->assertEquals(ucwords("hello world"), $result);
	}
	
	public function testUcwords2() {
		$program = new SimpleProgram('(String::ucwords "hello world")');
		$result = $program->execute(self::$env);
		$this->assertEquals(ucwords("hello world"), $result);
	}
	
	public function testPbrk1() {
		$program = new SimpleProgram('(String::pbrk "This is a Simple text." "mi")');
		$result = $program->execute(self::$env);
		$this->assertEquals("is is a Simple text.", $result);
	}
	
	public function testPbrk2() {
		$program = new SimpleProgram('(String::pbrk "This is a Simple text." "S")');
		$result = $program->execute(self::$env);
		$this->assertEquals("Simple text.", $result);
	}
	
	public function testTok() {
		$program = new ListProgram('(:= _first (String::tok "/something" "/"))(:= _second (String::tok "/"))');
		$result = $program->execute(self::$env);
		$this->assertEquals("something", $result[0]);
		$this->assertFalse($result[1]);
	}
	
	public function testSprintf() {
		$program = new SimpleProgram('(sprintf "The %2$s contains %1$04d monkeys" 5 "tree")');
		$result = $program->execute(self::$env);
		$this->assertEquals("The tree contains 0005 monkeys", $result);
	}
	
	public function testGetCSV1() {
		$program = new SimpleProgram('(getcsv "val1,val2,val3")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('val1', 'val2', 'val3'), $result);
	}
	
	public function testGetCSV2() {
		$program = new SimpleProgram('(getcsv "val1.val2.val3" ".")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('val1', 'val2', 'val3'), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testSscanf0() {
		$program = new SimpleProgram('(sscanf)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testSscanf1() {
		$program = new SimpleProgram('(sscanf "some string")');
		$result = $program->execute(self::$env);
	}
	
	public function testSscanf2() {
		$program = new SimpleProgram('(sscanf "SN/2350001" "SN/%d")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('2350001'), $result);
	}
	
	public function testSscanf3() {
		$program = new SimpleProgram('(sscanf "January 01 2000" "%s %d %d")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('January', '01', '2000'), $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSscanf4() {
		$program = new SimpleProgram('(sscanf "January 01 2000" "%s %d %d" 0)');
		$result = $program->execute(self::$env);
	}
	
	public function testSscanf5() {
		$program = new SimpleProgram('(sscanf "24 Lewis Carroll" "%d %s %s" _id _first _last)');
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result);
	}
	
	public function testSscanf6() {
		$program = new ListProgram('(sscanf "24 Lewis Carroll" "%d %s %s" _id _first _last)(<- _id)(<- _first)(<- _last)');
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result[0]);
		$this->assertEquals('24', $result[1]);
		$this->assertEquals('Lewis', $result[2]);
		$this->assertEquals('Carroll', $result[3]);
	}
}
?>
