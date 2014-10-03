<?php
namespace eMacros;

use eMacros\Program\Program;
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
		$program = new Program('(.)');
		$result = $program->execute(self::$env);
		$this->assertEquals('', $result);
	}
	
	public function testContatenate1() {
		$program = new Program('(. "Hello" " " "World")');
		$result = $program->execute(self::$env);
		$this->assertEquals('Hello World', $result);
	}
	
	public function testAddCSlashes() {
		$program = new Program('(addcslashes "foo[ ]" "A..z")');
		$result = $program->execute(self::$env);
		$this->assertEquals('\f\o\o\[ \]', $result);
	}
	
	public function testStripCSlashes() {
		$program = new Program('(stripcslashes (%0))');
		$result = $program->execute(self::$env, '\d\n\e');
		$this->assertEquals("d\ne", $result);
	}
	
	public function testBin2Hex() {
		$program = new Program('(bin2hex "Hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals('48656c6c6f', $result);
	}
	
	public function testHex2Bin() {
		$program = new Program('(hex2bin "6578616d706c65206865782064617461")');
		$result = $program->execute(self::$env);
		$this->assertEquals('example hex data', $result);
	}
	
	public function testChr() {
		$program = new Program('(chr 65)');
		$result = $program->execute(self::$env);
		$this->assertEquals('A', $result);
	}
	
	public function testCountChars() {
		$program = new Program('(count-chars "aabbcdee" 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(97 => 2, 98 => 2, 99 => 1, 100 => 1, 101 => 2), $result);
	}
	
	public function testLCFirst() {
		$program = new Program('(lcfirst "Hello World")');
		$result = $program->execute(self::$env);
		$this->assertEquals("hello World", $result);
	}
	
	public function testLTrim() {
		$program = new Program('(ltrim "   Hello World   ")');
		$result = $program->execute(self::$env);
		$this->assertEquals("Hello World   ", $result);
	}
	
	public function testRTrim() {
		$program = new Program('(rtrim "   Hello World   ")');
		$result = $program->execute(self::$env);
		$this->assertEquals("   Hello World", $result);
	}
	
	public function testOrd() {
		$program = new Program('(ord "\n")');
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testNumberFormat1() {
		$number = 1234.56;
		$program = new Program('(number-format (%0))');
		$result = $program->execute(self::$env, $number);
		$this->assertEquals("1,235", $result);
	}
	
	public function testNumberFormat2() {
		$number = 1234.56;
		$program = new Program('(number-format (%0) 2 "," " ")');
		$result = $program->execute(self::$env, $number);
		$this->assertEquals("1 234,56", $result);
	}
	
	public function testNumberFormat3() {
		$number = 1234.56;
		$program = new Program('(number-format (%0) 2 "." "")');
		$result = $program->execute(self::$env, $number);
		$this->assertEquals("1234.56", $result);
	}
	
	public function testExplode1() {
		$program = new Program('(explode "," "1,2,3")');
		$result = $program->execute(self::$env);
		$this->assertEquals(explode(',', '1,2,3'), $result);
	}
	
	public function testExplode2() {
		$program = new Program('(String::explode "," "1,2,3")');
		$result = $program->execute(self::$env);
		$this->assertEquals(explode(',', '1,2,3'), $result);
	}
	
	public function testImplode1() {
		$program = new Program('(implode "," (%0))');
		$result = $program->execute(self::$env, array(1,2,3));
		$this->assertEquals(implode(',', array(1,2,3)), $result);
	}
	
	public function testImplode2() {
		$program = new Program('(String::implode "," (%0))');
		$result = $program->execute(self::$env, array(1,2,3));
		$this->assertEquals(implode(',', array(1,2,3)), $result);
	}
	
	public function testPad1() {
		$program = new Program('(pad "Alien" 10 "-=" PAD_LEFT)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_pad('Alien', 10, "-=", STR_PAD_LEFT), $result);
	}
	
	public function testPad2() {
		$program = new Program('(String::pad "Alien" 10 "-=" String::PAD_LEFT)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_pad('Alien', 10, "-=", STR_PAD_LEFT), $result);
	}
	
	public function testRepeat1() {
		$program = new Program('(repeat "-=" 10)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_repeat("-=", 10), $result);
	}
	
	public function testRepeat2() {
		$program = new Program('(String::repeat "-=" 10)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_repeat("-=", 10), $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testReplace0() {
		$program = new Program('(replace "%body%" "black" "<body text=\'%body%\'>" 0)');
		$result = $program->execute(self::$env);
	}
	
	public function testReplace1() {
		$program = new Program('(replace "%body%" "black" "<body text=\'%body%\'>")');
		$result = $program->execute(self::$env);
		$this->assertEquals("<body text='black'>", $result);
	}
	
	public function testReplace2() {
		$program = new Program('(String::replace "%body%" "black" "<body text=\'%body%\'>")');
		$result = $program->execute(self::$env);
		$this->assertEquals("<body text='black'>", $result);
	}
	
	public function testReplace3() {
		$program = new Program('(String::replace "%body%" "black" "<body text=\'%body%\'>%body%" _count)(<- _count)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testIReplace0() {
		$program = new Program('(ireplace "%body%" "black" "<body text=\'%body%\'>" 0)');
		$result = $program->execute(self::$env);
	}
	
	public function testIReplace1() {
		$program = new Program('(ireplace "%body%" "black" "<body text=\'%BODY%\'>")');
		$result = $program->execute(self::$env);
		$this->assertEquals("<body text='black'>", $result);
	}
	
	public function testIReplace2() {
		$program = new Program('(String::ireplace "%body%" "black" "<body text=\'%body%\'>%BODY%")(<- _count)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, $result);
	}
	
	public function testReverse1() {
		$program = new Program('(reverse "Hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals("olleH", $result);
	}
	
	public function testReverse2() {
		$program = new Program('(String::reverse "Hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals("olleH", $result);
	}
	
	public function testShuffle1() {
		$program = new Program('(shuffle "abcde")');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, preg_match('/[a-e]{5}/', $result));
	}
	
	public function testShuffle2() {
		$program = new Program('(String::shuffle "abcde")');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, preg_match('/[a-e]{5}/', $result));
	}
	
	public function testSplit1() {
		$program = new Program('(split "hello friend" 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_split("hello friend", 3), $result);
	}
	
	public function testSplit2() {
		$program = new Program('(String::split "hello friend" 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_split("hello friend", 3), $result);
	}
	
	public function testWordCount1() {
		$program = new Program('(word-count "hello my friend")');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_word_count("hello my friend"), $result);
	}
	
	public function testWordCount2() {
		$program = new Program('(String::word-count "hello my friend")');
		$result = $program->execute(self::$env);
		$this->assertEquals(str_word_count("hello my friend"), $result);
	}
	
	public function testCmp1() {
		$program = new Program('(cmp "abc" "abcd")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strcmp("abc", "abcd"), $result);
	}
	
	public function testCmp2() {
		$program = new Program('(String::cmp "abc" "abcd")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strcmp("abc", "abcd"), $result);
	}
	
	public function testLen1() {
		$program = new Program('(len "hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strlen("hello"), $result);
	}
	
	public function testLen2() {
		$program = new Program('(String::len "hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strlen("hello"), $result);
	}
	
	public function testPos1() {
		$program = new Program('(pos "abcdef abcdef" "a" 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(strpos("abcdef abcdef","a",1), $result);
	}
	
	public function testPos2() {
		$program = new Program('(String::pos "abcdef abcdef" "a" 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(strpos("abcdef abcdef","a",1), $result);
	}
	
	public function testIPos1() {
		$program = new Program('(ipos "xyz" "a")');
		$result = $program->execute(self::$env);
		$this->assertFalse($result);
	}
	
	public function testIPos2() {
		$program = new Program('(ipos "ABC" "b")');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testStr1() {
		$program = new Program('(str "name@example.com" "@")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strstr("name@example.com", "@"), $result);
	}
	
	public function testStr2() {
		$program = new Program('(String::str "name@example.com" "@")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strstr("name@example.com", "@"), $result);
	}
	
	public function testIStr1() {
		$program = new Program('(istr "USER@EXAMPLE.com" "e")');
		$result = $program->execute(self::$env);
		$this->assertEquals("ER@EXAMPLE.com", $result);
	}
	
	public function testIStr2() {
		$program = new Program('(istr "USER@EXAMPLE.com" "e" true)');
		$result = $program->execute(self::$env);
		$this->assertEquals("US", $result);
	}
	
	public function testToLower1() {
		$program = new Program('(to-lower "Mary Had A Little Lamb and She LOVED It So")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strtolower("Mary Had A Little Lamb and She LOVED It So"), $result);
	}
	
	public function testToLower2() {
		$program = new Program('(String::to-lower "Mary Had A Little Lamb and She LOVED It So")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strtolower("Mary Had A Little Lamb and She LOVED It So"), $result);
	}
	
	public function testToUpper1() {
		$program = new Program('(to-upper "Mary Had A Little Lamb and She LOVED It So")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strtoupper("Mary Had A Little Lamb and She LOVED It So"), $result);
	}
	
	public function testToUpper2() {
		$program = new Program('(String::to-upper "Mary Had A Little Lamb and She LOVED It So")');
		$result = $program->execute(self::$env);
		$this->assertEquals(strtoupper("Mary Had A Little Lamb and She LOVED It So"), $result);
	}
	
	public function testSubStr1() {
		$program = new Program('(substr "abcdef" -2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(substr("abcdef", -2), $result);
	}
	
	public function testSubStr2() {
		$program = new Program('(String::substr "abcdef" -2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(substr("abcdef", -2), $result);
	}
	
	public function testTrim1() {
		$program = new Program('(trim "   Hello  ")');
		$result = $program->execute(self::$env);
		$this->assertEquals(trim("   Hello  "), $result);
	}
	
	public function testTrim2() {
		$program = new Program('(String::trim "   Hello  ")');
		$result = $program->execute(self::$env);
		$this->assertEquals(trim("   Hello  "), $result);
	}
	
	public function testUcfirst1() {
		$program = new Program('(ucfirst "hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals(ucfirst("hello"), $result);
	}
	
	public function testUcfirst2() {
		$program = new Program('(String::ucfirst "hello")');
		$result = $program->execute(self::$env);
		$this->assertEquals(ucfirst("hello"), $result);
	}
	
	public function testUcwords1() {
		$program = new Program('(ucwords "hello world")');
		$result = $program->execute(self::$env);
		$this->assertEquals(ucwords("hello world"), $result);
	}
	
	public function testUcwords2() {
		$program = new Program('(String::ucwords "hello world")');
		$result = $program->execute(self::$env);
		$this->assertEquals(ucwords("hello world"), $result);
	}
	
	public function testPbrk1() {
		$program = new Program('(String::pbrk "This is a Simple text." "mi")');
		$result = $program->execute(self::$env);
		$this->assertEquals("is is a Simple text.", $result);
	}
	
	public function testPbrk2() {
		$program = new Program('(String::pbrk "This is a Simple text." "S")');
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
		$program = new Program('(sprintf "The %2$s contains %1$04d monkeys" 5 "tree")');
		$result = $program->execute(self::$env);
		$this->assertEquals("The tree contains 0005 monkeys", $result);
	}
	
	public function testGetCSV1() {
		$program = new Program('(getcsv "val1,val2,val3")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('val1', 'val2', 'val3'), $result);
	}
	
	public function testGetCSV2() {
		$program = new Program('(getcsv "val1.val2.val3" ".")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('val1', 'val2', 'val3'), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testSscanf0() {
		$program = new Program('(sscanf)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testSscanf1() {
		$program = new Program('(sscanf "some string")');
		$result = $program->execute(self::$env);
	}
	
	public function testSscanf2() {
		$program = new Program('(sscanf "SN/2350001" "SN/%d")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('2350001'), $result);
	}
	
	public function testSscanf3() {
		$program = new Program('(sscanf "January 01 2000" "%s %d %d")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('January', '01', '2000'), $result);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSscanf4() {
		$program = new Program('(sscanf "January 01 2000" "%s %d %d" 0)');
		$result = $program->execute(self::$env);
	}
	
	public function testSscanf5() {
		$program = new Program('(sscanf "24 Lewis Carroll" "%d %s %s" _id _first _last)');
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
