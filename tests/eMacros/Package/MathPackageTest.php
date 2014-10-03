<?php
namespace eMacros;

use eMacros\Program\Program;
use eMacros\Package\MathPackage;

/**
 * 
 * @author emaphp
 * @group math
 */
class MathPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new MathPackage();
		
		$this->assertEquals(M_PI, $package['PI']);
		$this->assertEquals(M_PI_2, $package['PI_2']);
		$this->assertEquals(M_PI_4, $package['PI_4']);
		$this->assertEquals(M_E, $package['E']);
		$this->assertEquals(M_EULER, $package['EULER']);
		$this->assertEquals(PHP_ROUND_HALF_UP, $package['ROUND_HALF_UP']);
		$this->assertEquals(PHP_ROUND_HALF_DOWN, $package['ROUND_HALF_DOWN']);
		$this->assertEquals(PHP_ROUND_HALF_EVEN, $package['ROUND_HALF_EVEN']);
		$this->assertEquals(PHP_ROUND_HALF_ODD, $package['ROUND_HALF_ODD']);
	}
	
	public function testAbs1() {
		$program = new Program('(abs -4)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(4, $result);
	}
	
	public function testAbs2() {
		$program = new Program('(Math::abs -4)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(4, $result);
	}
	
	public function testPow1() {
		$program = new Program('(pow 2 8)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(256, $result);
	}
	
	public function testPow2() {
		$program = new Program('(Math::pow 2 8)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(256, $result);
	}
	
	public function testSqrt1() {
		$program = new Program('(sqrt 9)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(3, $result);
	}
	
	public function testSqrt2() {
		$program = new Program('(Math::sqrt 9)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(3, $result);
	}
	
	public function testExp1() {
		$program = new Program('(exp 5.7)');
		$result = $program->execute(self::$xenv);
		$this->assertLessThan(298.87, $result);
	}
	
	public function testExp2() {
		$program = new Program('(Math::exp 5.7)');
		$result = $program->execute(self::$xenv);
		$this->assertLessThan(298.87, $result);
	}
	
	/**
	 * TODO: log tests
	 */
	
	public function testLog101() {
		$program = new Program('(log10 1000)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(3, $result);
	}
	
	public function testLog102() {
		$program = new Program('(Math::log10 1000)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(3, $result);
	}
	
	public function testRound1() {
		$program = new Program('(round 8.5 0 ROUND_HALF_UP)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(round(8.5, 0, PHP_ROUND_HALF_UP), $result);
	}
	
	public function testRound2() {
		$program = new Program('(Math::round 8.5 0 Math::ROUND_HALF_EVEN)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(round(8.5, 0, PHP_ROUND_HALF_EVEN), $result);
	}
	
	public function testFloor1() {
		$program = new Program('(floor -3.14)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(floor(-3.14), $result);
	}
	
	public function testFloor2() {
		$program = new Program('(Math::floor -3.14)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(floor(-3.14), $result);
	}
	
	public function testCeil1() {
		$program = new Program('(ceil 4.3)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(ceil(4.3), $result);
	}
	
	public function testCeil2() {
		$program = new Program('(Math::ceil 4.3)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(ceil(4.3), $result);
	}
	
	public function testMin1() {
		$program = new Program('(min 2 3 1 6 7)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(min(2, 3, 1, 6, 7), $result);
	}
	
	public function testMin2() {
		$program = new Program('(Math::min 2 3 1 6 7)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(min(2, 3, 1, 6, 7), $result);
	}
	
	public function testMax1() {
		$program = new Program('(max 2 3 1 6 7)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(max(2, 3, 1, 6, 7), $result);
	}
	
	public function testMax2() {
		$program = new Program('(Math::max 2 3 1 6 7)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(max(2, 3, 1, 6, 7), $result);
	}
	
	public function testRand1() {
		$program = new Program('(Math::rand)');
		$result = $program->execute(self::$xenv);
		$this->assertGreaterThanOrEqual(0, $result);
		$this->assertLessThanOrEqual(getrandmax(), $result);
	}
	
	public function testRand2() {
		$program = new Program('(Math::rand 1 10)');
		$result = $program->execute(self::$xenv);
		$this->assertGreaterThanOrEqual(1, $result);
		$this->assertLessThanOrEqual(10, $result);
	}
	
	public function testSrand1() {
		$program = new Program('(srand)');
		$result = $program->execute(self::$xenv);
	}
	
	public function testSrand2() {
		$program = new Program('(Math::srand)');
		$result = $program->execute(self::$xenv);
	}
	
	public function testMTRand1() {
		$program = new Program('(Math::mt-rand)');
		$result = $program->execute(self::$xenv);
		$this->assertGreaterThanOrEqual(0, $result);
		$this->assertLessThanOrEqual(mt_getrandmax(), $result);
	}
	
	public function testMTRand2() {
		$program = new Program('(Math::mt-rand 1 10)');
		$result = $program->execute(self::$xenv);
		$this->assertGreaterThanOrEqual(1, $result);
		$this->assertLessThanOrEqual(10, $result);
	}
	
	public function testMTSrand1() {
		$program = new Program('(mt-srand)');
		$result = $program->execute(self::$xenv);
	}
	
	public function testMTSrand2() {
		$program = new Program('(Math::mt-srand)');
		$result = $program->execute(self::$xenv);
	}
	
	public function testPi1() {
		$program = new Program('(pi)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(pi(), $result);
	}
	
	public function testPi2() {
		$program = new Program('(Math::pi)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(pi(), $result);
	}
	
	public function testFMod1() {
		$program = new Program('(fmod 5.7 1.3)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(fmod(5.7, 1.3), $result);
	}
	
	public function testFMod2() {
		$program = new Program('(Math::fmod 5.7 1.3)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(fmod(5.7, 1.3), $result);
	}
	
	public function testDecBin1() {
		$program = new Program('(decbin 26)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("11010", $result);
	}
	
	public function testDecBin2() {
		$program = new Program('(Math::decbin 26)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("11010", $result);
	}
	
	public function testBinDec1() {
		$program = new Program('(bindec "110011")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(51, $result);
	}
	
	public function testBinDec2() {
		$program = new Program('(Math::bindec "110011")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(51, $result);
	}
	
	public function testDecOct1() {
		$program = new Program('(decoct 264)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("410", $result);
	}
	
	public function testDecOct2() {
		$program = new Program('(Math::decoct 264)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("410", $result);
	}
	
	public function testOctDec1() {
		$program = new Program('(octdec "77")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(63, $result);
	}
	
	public function testOctDec2() {
		$program = new Program('(Math::octdec "77")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(63, $result);
	}
	
	public function testDecHex1() {
		$program = new Program('(dechex 47)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("2f", $result);
	}
	
	public function testDecHex2() {
		$program = new Program('(Math::dechex 47)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("2f", $result);
	}
	
	public function testHexDec1() {
		$program = new Program('(hexdec "ee")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(238, $result);
	}
	
	public function testHexDec2() {
		$program = new Program('(Math::hexdec "ee")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(238, $result);
	}
	
	public function testSin1() {
		$program = new Program('(sin PI)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(0, $result);
	}
	
	public function testSin2() {
		$program = new Program('(Math::sin Math::PI)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(0, $result);
	}
	
	public function testCos1() {
		$program = new Program('(cos PI)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(-1, $result);
	}
	
	public function testCos2() {
		$program = new Program('(Math::cos Math::PI)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(-1, $result);
	}
	
	public function testTan1() {
		$program = new Program('(tan PI_4)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(1, $result);
	}
	
	public function testTan2() {
		$program = new Program('(Math::tan Math::PI_4)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(1, $result);
	}
	
	/**
	 * TYPES
	 */	
	public function testFinite1() {
		$program = new Program('(Math::finite? Math::PI)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testFinite2() {
		$program = new Program('(Math::finite? (Math::log 0))');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testInfinite1() {
		$program = new Program('(Math::infinite? (Math::log 0))');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testInfinite2() {
		$program = new Program('(Math::infinite? 0)');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testNan1() {
		$program = new Program('(Math::nan? 0)');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testNan2() {
		$program = new Program('(Math::nan? (Math::acos 1.01))');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
}
?>