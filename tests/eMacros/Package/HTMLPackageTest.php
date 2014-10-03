<?php
namespace eMacros;

use eMacros\Package\HTMLPackage;
use eMacros\Program\Program;

/**
 * 
 * @author emaphp
 * @group html
 */
class HTMLPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new HTMLPackage();
		
		$this->assertEquals(ENT_COMPAT, $package['ENT_COMPAT']);
		$this->assertEquals(ENT_QUOTES, $package['ENT_QUOTES']);
		$this->assertEquals(ENT_NOQUOTES, $package['ENT_NOQUOTES']);
		$this->assertEquals(ENT_IGNORE, $package['ENT_IGNORE']);
		$this->assertEquals(ENT_SUBSTITUTE, $package['ENT_SUBSTITUTE']);
		$this->assertEquals(ENT_DISALLOWED, $package['ENT_DISALLOWED']);
		$this->assertEquals(ENT_HTML401, $package['ENT_HTML401']);
		$this->assertEquals(ENT_XML1, $package['ENT_XML1']);
		$this->assertEquals(ENT_XHTML, $package['ENT_XHTML']);
		$this->assertEquals(ENT_HTML5, $package['ENT_HTML5']);
	}
	
	public function testNl2Br() {
		$str = "foo isn't\n bar";
		$program = new Program('(HTML::nl2br (%0))');
		$result = $program->execute(self::$xenv, $str);
		$this->assertEquals(nl2br($str), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testParseString0() {
		$program = new Program('(HTML::parse-string)');
		$result = $program->execute(self::$xenv);
	}
	
	public function testParseString1() {
		$program = new Program('(HTML::parse-string "first=value&arr[]=foo+bar&arr[]=baz")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(array('first' => 'value', 'arr' => array('foo bar', 'baz')), $result);
	}
	
	public function testHTMLSpecialChars() {
		$program = new Program('(HTML::special-chars "<a href=\'test\'>Test</a>" HTML::ENT_QUOTES)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("&lt;a href=&#039;test&#039;&gt;Test&lt;/a&gt;", $result);
	}
	
	public function testHTMLSpecialCharsDecode() {
		$program = new Program('(HTML::special-chars-decode "<p>this -&gt; &quot;</p>" HTML::ENT_NOQUOTES)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals('<p>this -> &quot;</p>', $result);
	}
	
	public function testHTMLEntities1() {
		$program = new Program('(HTML::entities "A \'quote\' is <b>bold</b>")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("A 'quote' is &lt;b&gt;bold&lt;/b&gt;", $result);
	}
	
	public function testHTMLEntities2() {
		$program = new Program('(HTML::entities "A \'quote\' is <b>bold</b>" HTML::ENT_QUOTES)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("A &#039;quote&#039; is &lt;b&gt;bold&lt;/b&gt;", $result);
	}
	
	public function testHTMLEntityDecode() {
		$program = new Program('(HTML::entity-decode "the &lt;b&gt;dog&lt;/b&gt; now")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("the <b>dog</b> now", $result);
	}
	
	public function testStripTags1() {
		$program = new Program('(HTML::strip-tags "<p>Test paragraph.</p><!-- Comment --> <a href=\"#fragment\">Other text</a>")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("Test paragraph. Other text", $result);
	}
	
	public function testStripTags2() {
		$program = new Program('(HTML::strip-tags "<p>Test paragraph.</p><!-- Comment --> <a href=\"#fragment\">Other text</a>" "<p><a>")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals('<p>Test paragraph.</p> <a href="#fragment">Other text</a>', $result);
	}
}
?>