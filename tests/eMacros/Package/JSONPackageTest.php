<?php
namespace eMacros;

use eMacros\Package\JSONPackage;
use eMacros\Program\SimpleProgram;

/**
 * 
 * @author emaphp
 * @group json
 */
class JSONPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new JSONPackage();
		
		$this->assertEquals(JSON_HEX_TAG, $package['HEX_TAG']);
		$this->assertEquals(JSON_HEX_AMP, $package['HEX_AMP']);
		$this->assertEquals(JSON_HEX_APOS, $package['HEX_APOS']);
		$this->assertEquals(JSON_HEX_QUOT, $package['HEX_QUOT']);
		$this->assertEquals(JSON_FORCE_OBJECT, $package['FORCE_OBJECT']);
		$this->assertEquals(JSON_NUMERIC_CHECK, $package['NUMERIC_CHECK']);
		$this->assertEquals(JSON_BIGINT_AS_STRING, $package['BIGINT_AS_STRING']);
		$this->assertEquals(JSON_PRETTY_PRINT, $package['PRETTY_PRINT']);
		$this->assertEquals(JSON_UNESCAPED_SLASHES, $package['UNESCAPED_SLASHES']);
		$this->assertEquals(JSON_UNESCAPED_UNICODE, $package['UNESCAPED_UNICODE']);
	}
	
	public function testDecode1() {
		$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
		$program = new SimpleProgram('(JSON::decode (%0))');
		$result = $program->execute(self::$xenv, $json);
		$this->assertEquals((object) array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5), $result);
	}
	
	public function testDecode2() {
		$json = '{"a":1,"b":2,"c":3,"d":4,"e":5}';
		$program = new SimpleProgram('(JSON::decode (%0) true)');
		$result = $program->execute(self::$xenv, $json);
		$this->assertEquals(array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5), $result);
	}
	
	public function testDecode3() {
		$this->markTestIncomplete("Could not reproduce behaviour posted in docs. Check: http://www.php.net/manual/es/function.json-decode.php");
		
		$json = '{"number": 12345678901234567890}';
		$program = new SimpleProgram('(JSON::decode (%0))');
		$result = $program->execute(self::$xenv, $json);
		$this->assertEquals(1.2345678901235E+19, $result->number);
	}
	
	public function testDecode4() {
		$this->markTestSkipped("BIGINT_AS_STRING not implemented...");
		
		$json = '{"number": 12345678901234567890}';
		$program = new SimpleProgram('(JSON::decode (%0) false 512 JSON::BIGINT_AS_STRING)');
		$result = $program->execute(self::$xenv, $json);
		$this->assertEquals("12345678901234567890", $result->number);
	}
	
	public function testEncode1() {
		$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
		$program = new SimpleProgram('(JSON::encode (%0))');
		$result = $program->execute(self::$xenv, $arr);
		$this->assertEquals('{"a":1,"b":2,"c":3,"d":4,"e":5}', $result);
	}
	
	public function testEncode2() {
		$a = array('<foo>', "'bar'", '"baz"', '&blong&', "é");
		$program = new SimpleProgram('(JSON::encode (%0))');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('["<foo>","\'bar\'","\"baz\"","&blong&","\u00e9"]', $result);
	}
	
	public function testEncode3() {
		$a = array('<foo>', "'bar'", '"baz"', '&blong&', "é");
		$program = new SimpleProgram('(JSON::encode (%0) JSON::HEX_TAG)');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('["\u003Cfoo\u003E","\'bar\'","\"baz\"","&blong&","\u00e9"]', $result);
	}
	
	public function testEncode4() {
		$a = array('<foo>', "'bar'", '"baz"', '&blong&', "é");
		$program = new SimpleProgram('(JSON::encode (%0) JSON::HEX_APOS)');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('["<foo>","\u0027bar\u0027","\"baz\"","&blong&","\u00e9"]', $result);
	}
	
	public function testEncode5() {
		$a = array('<foo>', "'bar'", '"baz"', '&blong&', "é");
		$program = new SimpleProgram('(JSON::encode (%0) JSON::HEX_QUOT)');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('["<foo>","\'bar\'","\u0022baz\u0022","&blong&","\u00e9"]', $result);
	}
	
	public function testEncode6() {
		$a = array('<foo>', "'bar'", '"baz"', '&blong&', "é");
		$program = new SimpleProgram('(JSON::encode (%0) JSON::HEX_AMP)');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('["<foo>","\'bar\'","\"baz\"","\u0026blong\u0026","\u00e9"]', $result);
	}
	
	public function testEncode7() {
		$a = array('<foo>', "'bar'", '"baz"', '&blong&', "é");
		$program = new SimpleProgram('(JSON::encode (%0) JSON::UNESCAPED_UNICODE)');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('["<foo>","\'bar\'","\"baz\"","&blong&","é"]', $result);
	}
	
	public function testEncode8() {
		$a = array('<foo>', "'bar'", '"baz"', '&blong&', "é");
		$program = new SimpleProgram('(JSON::encode (%0) (| JSON::HEX_TAG JSON::HEX_APOS JSON::HEX_QUOT JSON::HEX_AMP JSON::UNESCAPED_UNICODE))');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('["\u003Cfoo\u003E","\u0027bar\u0027","\u0022baz\u0022","\u0026blong\u0026","é"]', $result);
	}
	
	public function testEncode9() {
		$a = array();
		$program = new SimpleProgram('(JSON::encode (%0))');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('[]', $result);
	}
	
	public function testEncode10() {
		$a = array();
		$program = new SimpleProgram('(JSON::encode (%0) JSON::FORCE_OBJECT)');
		$result = $program->execute(self::$xenv, $a);
		$this->assertEquals('{}', $result);
	}
}
?>