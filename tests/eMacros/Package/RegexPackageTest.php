<?php
namespace eMacros;

use eMacros\Package\RegexPackage;
use eMacros\Program\Program;
use eMacros\Program\ListProgram;

/**
 * 
 * @author emaphp
 * @group regex
 */
class RegexPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new RegexPackage();
		
		$this->assertEquals(PREG_OFFSET_CAPTURE, $package['OFFSET_CAPTURE']);
		$this->assertEquals(PREG_GREP_INVERT, $package['GREP_INVERT']);
		$this->assertEquals(PREG_PATTERN_ORDER, $package['PATTERN_ORDER']);
		$this->assertEquals(PREG_SET_ORDER, $package['SET_ORDER']);
		$this->assertEquals(PREG_SPLIT_NO_EMPTY, $package['SPLIT_NO_EMPTY']);
		$this->assertEquals(PREG_SPLIT_DELIM_CAPTURE, $package['SPLIT_DELIM_CAPTURE']);
		$this->assertEquals(PREG_SPLIT_OFFSET_CAPTURE, $package['SPLIT_OFFSET_CAPTURE']);
	}
	
	public function testGrep1() {
		$input = array('abc', '45.23', '0x3F', '4.5', '%&(*)');
		$program = new Program('(Regex::grep "/^(\\\d+)?\\\.\\\d+$/" (%0))');
		$result = $program->execute(self::$env, $input);
		$this->assertEquals(array(1 => '45.23', 3 => '4.5'), $result);
	}
	
	public function testGrep2() {
		$input = array('abc', '45.23', '0x3F', '4.5', '%&(*)');
		$program = new Program('(Regex::grep "/^(\\\d+)?\\\.\\\d+$/" (%0) Regex::GREP_INVERT)');
		$result = $program->execute(self::$env, $input);
		$this->assertEquals(array(0 => 'abc', 2 => '0x3F', 4 => '%&(*)'), $result);
	}
	
	public function testQuote1() {
		$keywords = '$40 for a g3/400';
		$program = new Program('(Regex::quote (%0))');
		$result = $program->execute(self::$env, $keywords);
		$this->assertEquals("\\$40 for a g3/400", $result);
	}
	
	public function testQuote2() {
		$keywords = '$40 for a g3/400';
		$program = new Program('(Regex::quote (%0) "/")');
		$result = $program->execute(self::$env, $keywords);
		$this->assertEquals("\\$40 for a g3\\/400", $result);
	}
	
	public function testSplit1() {
		$pattern = "/[\s,]+/";
		$subject = "hypertext language, programming";
		$program = new Program('(Regex::split (%0) (%1))');
		$result = $program->execute(self::$env, $pattern, $subject);
		$this->assertEquals(array('hypertext', 'language', 'programming'), $result);
	}
	
	public function testSplit2() {
		$pattern = "//";
		$subject = "string";
		$program = new Program('(Regex::split (%0) (%1) -1 Regex::SPLIT_NO_EMPTY)');
		$result = $program->execute(self::$env, $pattern, $subject);
		$this->assertEquals(array('s', 't', 'r', 'i', 'n', 'g'), $result);
	}
	
	public function testSplit3() {
		$pattern = "/ /";
		$subject = "hypertext language programming";
		$program = new Program('(Regex::split (%0) (%1) -1 Regex::SPLIT_OFFSET_CAPTURE)');
		$result = $program->execute(self::$env, $pattern, $subject);
		$this->assertEquals(array(array('hypertext', 0), array('language', 10), array('programming', 19)), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testMatch0() {
		$program = new Program('(Regex::match)');
		$result = $program->execute(self::$env);
	}
	
	public function testMatch2() {
		$program = new Program('(Regex::match "/([\\\d]{4})-([\\\d]{2})-([\\\d]{2})/" "2013-11-12")');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testMatch3() {
		$program = new Program('(Regex::match "/([\\\d]{4})-([\\\d]{2})-([\\\d]{2})/" "2013-11-12" _matches)(<- _matches)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('2013-11-12', '2013', '11', '12'), $result);
	}
	
	public function testMatch4() {
		$program = new Program('(Regex::match "/([\\\d]{4})-([\\\d]{2})-([\\\d]{2})/" "2013-11-12" _matches Regex::OFFSET_CAPTURE)(<- _matches)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(array('2013-11-12', 0), array('2013', 0), array('11', 5), array('12', 8)), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testAllMatches0() {
		$program = new Program('(Regex::match-all)');
		$result = $program->execute(self::$env);
	}
	
	public function testAllMatches1() {
		$pattern = "|<[^>]+>(.*)</[^>]+>|U";
		$subject = "<b>example: </b><div align=left>this is a test</div>";
		$program = new Program('(Regex::match-all (%0) (%1))');
		$result = $program->execute(self::$env, $pattern, $subject);
		$this->assertEquals(2, $result);
	}
	
	public function testAllMatches2() {
		$pattern = "|<[^>]+>(.*)</[^>]+>|U";
		$subject = "<b>example: </b><div align=left>this is a test</div>";
		$program = new Program('(Regex::match-all (%0) (%1) _matches)(<- _matches)');
		$result = $program->execute(self::$env, $pattern, $subject);
		$this->assertEquals(array(array('<b>example: </b>', '<div align=left>this is a test</div>'),
				array('example: ', 'this is a test')), $result);
	}
	
	public function testAllMatches3() {
		$pattern = "|<[^>]+>(.*)</[^>]+>|U";
		$subject = "<b>example: </b><div align=left>this is a test</div>";
		$program = new Program('(Regex::match-all (%0) (%1) _matches Regex::PATTERN_ORDER)(<- _matches)');
		$result = $program->execute(self::$env, $pattern, $subject);
		$this->assertEquals(array(array('<b>example: </b>', '<div align=left>this is a test</div>'),
				array('example: ', 'this is a test')), $result);
	}
	
	public function testAllMatches4() {
		$pattern = "|<[^>]+>(.*)</[^>]+>|U";
		$subject = "<b>example: </b><div align=left>this is a test</div>";
		$program = new Program('(Regex::match-all (%0) (%1) _matches Regex::SET_ORDER)(<- _matches)');
		$result = $program->execute(self::$env, $pattern, $subject);
		$this->assertEquals(array(array('<b>example: </b>', 'example: '),
				array('<div align=left>this is a test</div>', 'this is a test')), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testReplace0() {
		$program = new Program('(Regex::replace)');
		$result = $program->execute(self::$env);
	}
	
	public function testReplace1() {
		$string = 'April 15, 2003';
		$pattern = '/(\w+) (\d+), (\d+)/i';
		$replacement = '${1}1,$3';
		$program = new Program('(Regex::replace (%0) (%1) (%2))');
		$result = $program->execute(self::$env, $pattern, $replacement, $string);
		$this->assertEquals('April1,2003', $result);
	}
	
	public function testReplace2() {
		$patterns = array ('/(19|20)(\d{2})-(\d{1,2})-(\d{1,2})/',						
						   '/^\s*{(\w+)}\s*=/');
		$replacements = array ('\3/\4/\1\2', '$\1 =');
		$string = '{startDate} = 1999-5-27';
		$program = new Program('(Regex::replace (%0) (%1) (%2))');
		$result = $program->execute(self::$env, $patterns, $replacements, $string);
		$this->assertEquals('$startDate = 5/27/1999', $result);
	}
	
	public function testReplace3() {
		$patterns = array('/\d/', '/\s/');
		$replacement = '*';
		$string = 'gnu 4 to';
		$program = new ListProgram('(Regex::replace (%0) (%1) (%2) -1 _count)(<- _count)');
		$result = $program->execute(self::$env, $patterns, $replacement, $string);
		$this->assertEquals('gnu***to', $result[0]);
		$this->assertEquals(3, $result[1]);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testReplaceCallback0() {
		$program = new Program('(Regex::replace-callback)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testReplaceCallback1() {
		$pattern = "|(\d{2}/\d{2}/)(\d{4})|";
		$subject = "April fools day is 04/01/2002";
		$program = new Program('(Regex::replace-callback (%0) null (%1))');
		$result = $program->execute(self::$env, $pattern, $subject);
	}
	
	public function testReplaceCallback2() {
		$pattern = "|(\d{2}/\d{2}/)(\d{4})|";
		$callback = function ($matches) {
			return $matches[1].($matches[2]+1);
		};
		$subject = "April fools day is 04/01/2002\nLast christmas was 12/24/2001\n";
		$program = new Program('(Regex::replace-callback (%0) (%1) (%2))');
		$result = $program->execute(self::$env, $pattern, $callback, $subject);
		$this->assertEquals("April fools day is 04/01/2003\nLast christmas was 12/24/2002\n", $result);
	}
}
?>