<?php
namespace eMacros;

use eMacros\Package\CorePackage;
use eMacros\Package\ArrayPackage;
use eMacros\Package\DatePackage;
use eMacros\Package\FilterPackage;
use eMacros\Package\HashPackage;
use eMacros\Package\StringPackage;
use eMacros\Package\RequestPackage;
use eMacros\Program\SimpleProgram;
use eMacros\Package\FilePackage;
use eMacros\Package\MathPackage;
use eMacros\Package\PasswordPackage;
use eMacros\Package\CTypePackage;
use eMacros\Package\HTMLPackage;
use eMacros\Package\JSONPackage;
use eMacros\Package\RegexPackage;

/**
 * 
 * @author emaphp
 * @group regex
 */
class RegexTest extends eMacrosTest {
	public $symbolRegex;
	
	public function setUp() {
		$this->symbolRegex = Symbol::PATTERN;
	}
	
	public function testCoreSymbols() {
		$package = new CorePackage();
		$symbols = array_keys($package->symbols);
				
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testStringSymbols() {
		$package = new StringPackage;
		$symbols = array_keys($package->symbols);
	
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testArraySymbols() {
		$package = new ArrayPackage();
		$symbols = array_keys($package->symbols);
	
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testDateSymbols() {
		$package = new DatePackage;
		$symbols = array_keys($package->symbols);
	
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testFilterSymbols() {
		$package = new FilterPackage();
		$symbols = array_keys($package->symbols);
	
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testHashSymbols() {
		$package = new HashPackage;
		$symbols = array_keys($package->symbols);
	
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testRequestSymbols() {
		$package = new RequestPackage;
		$symbols = array_keys($package->symbols);
	
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testPackageSymbols() {
		$package = new PasswordPackage();
		
		$symbols = array_keys($package->symbols);
		
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testFilePackage() {
		$package = new FilePackage;
		
		$symbols = array_keys($package->symbols);
		
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testMathPackage() {
		$package = new MathPackage();
		
		$symbols = array_keys($package->symbols);
		
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testCTypePackage() {
		$package = new CTypePackage();
		$symbols = array_keys($package->symbols);
		
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testHTMLPackage() {
		$package = new HTMLPackage();
		$symbols = array_keys($package->symbols);
		
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testJSONPackage() {
		$package = new JSONPackage();
		$symbols = array_keys($package->symbols);
		
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testPasswordPackage() {
		$package = new PasswordPackage();
		$symbols = array_keys($package->symbols);
		
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testRegexPackage() {
		$package = new RegexPackage();
		$symbols = array_keys($package->symbols);
		
		foreach ($symbols as $symbol) {
			$result = preg_match($this->symbolRegex, $symbol);
			$this->assertEquals(1, $result);
		}
	}
	
	public function testSymbol0() {
		$result = preg_match($this->symbolRegex, '');
		$this->assertEquals(0, $result);
	}
	
	public function testSymbol1() {
		$result = preg_match($this->symbolRegex, 'var', $matches);
		$this->assertEquals(1, $result);
		$this->assertEquals('var', $matches[0]);
	}
	
	public function testSymbol2() {
		$result = preg_match($this->symbolRegex, 'var  ', $matches);
		$this->assertEquals(0, $result);
	}
	
	public function testSymbol3() {
		$result = preg_match($this->symbolRegex, '   var');
		$this->assertEquals(0, $result);
	}
	
	public function testSymbol4() {
		$result = preg_match($this->symbolRegex, 'v;ar', $matches);
		$this->assertEquals(0, $result);
	}
	
	public function testSymbol5() {
		$result = preg_match($this->symbolRegex, ';var');
		$this->assertEquals(0, $result);
	}
	
	public function testSymbol6() {
		$result = preg_match($this->symbolRegex, '10');
		$this->assertEquals(0, $result);
	}
	
	public function testSymbol7() {
		$result = preg_match($this->symbolRegex, '-10', $matches);
		$this->assertEquals(1, $result);
		//it doesnt matter because its captured by the integer regex first
		$this->assertEquals('-10', $matches[0]);
	}
	
	public function testSymbol8() {
		$result = preg_match($this->symbolRegex, 'core::v;ar', $matches);
		$this->assertEquals(0, $result);
	}
	
	public function testSymbol9() {
		$result = preg_match($this->symbolRegex, 'xxx"', $matches);
		$this->assertEquals(0, $result);
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testSymbolEval0() {
		$program = new SimpleProgram('(core::test)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testSymbolEval1() {
		$program = new SimpleProgram('(core::;test)');
		$result = $program->execute(self::$env);
	}
		
	public function testCommentRegex() {
		$program = new SimpleProgram(file_get_contents(__DIR__ . '/source/comments.em'));
		$result = $program->execute(self::$env);
	}
	
	public function testNs0() {
		$program = new SimpleProgram('(string::shuffle)');
		$form = $program->expressions[0];
		$this->assertEquals('string', $form[0]->package);
		$this->assertEquals('shuffle', $form[0]->symbol);
	}
	
	public function testNs1() {
		$program = new SimpleProgram('(shuffle);no namespace');
		$form = $program->expressions[0];
		$this->assertEquals(null, $form[0]->package);
		$this->assertEquals('shuffle', $form[0]->symbol);
	}
	
	/**
	 * @expectedException UnexpectedValueException
	 */
	public function testNs2() {
		$program = new SimpleProgram('(string::)');
	}
}
?>