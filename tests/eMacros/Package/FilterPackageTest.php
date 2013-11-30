<?php
namespace eMacros;

use eMacros\Package\FilterPackage;
use eMacros\Program\SimpleProgram;

/**
 * 
 * @author emaphp
 * @group filter
 */
class FilterPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new FilterPackage();
		
		$this->assertEquals(INPUT_GET, $package['INPUT_GET']);
		$this->assertEquals(INPUT_POST, $package['INPUT_POST']);
		$this->assertEquals(INPUT_COOKIE, $package['INPUT_COOKIE']);
		$this->assertEquals(INPUT_SERVER, $package['INPUT_SERVER']);
		$this->assertEquals(INPUT_ENV, $package['INPUT_ENV']);
		$this->assertEquals(INPUT_SESSION, $package['INPUT_SESSION']);
		
		$this->assertEquals(FILTER_VALIDATE_BOOLEAN, $package['VALIDATE_BOOLEAN']);
		$this->assertEquals(FILTER_VALIDATE_EMAIL, $package['VALIDATE_EMAIL']);
		$this->assertEquals(FILTER_VALIDATE_FLOAT, $package['VALIDATE_FLOAT']);
		$this->assertEquals(FILTER_VALIDATE_INT, $package['VALIDATE_INT']);
		$this->assertEquals(FILTER_VALIDATE_IP, $package['VALIDATE_IP']);
		$this->assertEquals(FILTER_VALIDATE_REGEXP, $package['VALIDATE_REGEXP']);
		$this->assertEquals(FILTER_VALIDATE_URL, $package['VALIDATE_URL']);
		
		$this->assertEquals(FILTER_SANITIZE_EMAIL, $package['SANITIZE_EMAIL']);
		$this->assertEquals(FILTER_SANITIZE_ENCODED, $package['SANITIZE_ENCODED']);
		$this->assertEquals(FILTER_SANITIZE_MAGIC_QUOTES, $package['SANITIZE_MAGIC_QUOTES']);
		$this->assertEquals(FILTER_SANITIZE_NUMBER_FLOAT, $package['SANITIZE_NUMBER_FLOAT']);
		$this->assertEquals(FILTER_SANITIZE_NUMBER_INT, $package['SANITIZE_NUMBER_INT']);
		$this->assertEquals(FILTER_SANITIZE_SPECIAL_CHARS, $package['SANITIZE_SPECIAL_CHARS']);
		$this->assertEquals(FILTER_SANITIZE_FULL_SPECIAL_CHARS, $package['SANITIZE_FULL_SPECIAL_CHARS']);
		$this->assertEquals(FILTER_SANITIZE_STRING, $package['SANITIZE_STRING']);
		$this->assertEquals(FILTER_SANITIZE_STRIPPED, $package['SANITIZE_STRIPPED']);
		$this->assertEquals(FILTER_SANITIZE_URL, $package['SANITIZE_URL']);
		$this->assertEquals(FILTER_UNSAFE_RAW, $package['UNSAFE_RAW']);
		
		$this->assertEquals(FILTER_NULL_ON_FAILURE, $package['NULL_ON_FAILURE']);
		$this->assertEquals(FILTER_FLAG_STRIP_LOW, $package['FLAG_STRIP_LOW']);
		$this->assertEquals(FILTER_FLAG_STRIP_HIGH, $package['FLAG_STRIP_HIGH']);
		$this->assertEquals(FILTER_FLAG_ALLOW_FRACTION, $package['FLAG_ALLOW_FRACTION']);
		$this->assertEquals(FILTER_FLAG_ALLOW_THOUSAND, $package['FLAG_ALLOW_THOUSAND']);
		$this->assertEquals(FILTER_FLAG_ALLOW_SCIENTIFIC, $package['FLAG_ALLOW_SCIENTIFIC']);
		$this->assertEquals(FILTER_FLAG_ALLOW_OCTAL, $package['FLAG_ALLOW_OCTAL']);
		$this->assertEquals(FILTER_FLAG_ALLOW_HEX, $package['FLAG_ALLOW_HEX']);
		$this->assertEquals(FILTER_FLAG_NO_ENCODE_QUOTES, $package['FLAG_NO_ENCODE_QUOTES']);
		$this->assertEquals(FILTER_FLAG_ENCODE_LOW, $package['FLAG_ENCODE_LOW']);
		$this->assertEquals(FILTER_FLAG_ENCODE_HIGH, $package['FLAG_ENCODE_HIGH']);
		$this->assertEquals(FILTER_FLAG_ENCODE_AMP, $package['FLAG_ENCODE_AMP']);
		$this->assertEquals(FILTER_FLAG_IPV4, $package['FLAG_IPV4']);
		$this->assertEquals(FILTER_FLAG_IPV6, $package['FLAG_IPV6']);
		$this->assertEquals(FILTER_FLAG_NO_PRIV_RANGE, $package['FLAG_NO_PRIV_RANGE']);
		$this->assertEquals(FILTER_FLAG_NO_RES_RANGE, $package['FLAG_NO_RES_RANGE']);
		$this->assertEquals(FILTER_FLAG_PATH_REQUIRED, $package['FLAG_PATH_REQUIRED']);
		$this->assertEquals(FILTER_FLAG_QUERY_REQUIRED, $package['FLAG_QUERY_REQUIRED']);
	}
	
	public function testHasVar() {
		$program = new SimpleProgram('(Filter::has-var Filter::INPUT_GET "id")');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testVar2() {
		$program = new SimpleProgram('(Filter::var "bob@example.com" Filter::VALIDATE_EMAIL)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals('bob@example.com', $result);
	}
	
	public function testVar3() {
		$program = new SimpleProgram('(Filter::var "http://example.com" Filter::VALIDATE_URL Filter::FLAG_PATH_REQUIRED)');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testVar4() {
		$options = array(
				'options' => array(
						'default' => 3, // value to return if the filter fails
						// other options here
						'min_range' => 0
				),
				'flags' => FILTER_FLAG_ALLOW_OCTAL,
		);
		
		$program = new SimpleProgram('(Filter::var "0755" Filter::VALIDATE_INT (%0))');
		$result = $program->execute(self::$xenv, $options);
		$this->assertEquals(493, $result);
	}
	
	public function testVar5() {
		$program = new SimpleProgram('(Filter::var "oops" Filter::VALIDATE_BOOLEAN Filter::NULL_ON_FAILURE)');
		$result = $program->execute(self::$xenv);
		$this->assertNull($result);		
	}
	
	public function testVar6() {
		$program = new SimpleProgram('(Filter::var "oops" Filter::VALIDATE_BOOLEAN (array ("flags" Filter::NULL_ON_FAILURE)))');
		$result = $program->execute(self::$xenv);
		$this->assertNull($result);
	}
	
	public function testVarArray() {
		$data = array(
				'product_id'    => 'libgd<script>',
				'component'     => '10',
				'versions'      => '2.0.33',
				'testscalar'    => array('2', '23', '10', '12'),
				'testarray'     => '2',
		);
		
		$args = array(
				'product_id'   => FILTER_SANITIZE_ENCODED,
				'component'    => array('filter'    => FILTER_VALIDATE_INT,
						'flags'     => FILTER_FORCE_ARRAY,
						'options'   => array('min_range' => 1, 'max_range' => 10)
				),
				'versions'     => FILTER_SANITIZE_ENCODED,
				'doesnotexist' => FILTER_VALIDATE_INT,
				'testscalar'   => array(
						'filter' => FILTER_VALIDATE_INT,
						'flags'  => FILTER_REQUIRE_SCALAR,
				),
				'testarray'    => array(
						'filter' => FILTER_VALIDATE_INT,
						'flags'  => FILTER_FORCE_ARRAY,
				)
		
		);
		
		$program = new SimpleProgram('(Filter::var-array (%0) (%1))');
		$result = $program->execute(self::$xenv, $data, $args);
		$this->assertEquals(filter_var_array($data, $args), $result);
	}
	
	public function testFilterId() {
		$program = new SimpleProgram('(Filter::id "boolean")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(258, $result);
	}
	
	public function testFilterList() {
		$program = new SimpleProgram('(Filter::list)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(filter_list(), $result);
	}
	
	//TODO: add filter_input test
	//TODO: add filter_input_array test
}
?>