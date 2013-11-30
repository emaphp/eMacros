<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
use Foo\Fizz;
use eMacros\Package\ArrayPackage;
/**
 * 
 * @author emaphp
 * @group array
 */
class ArrayPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new ArrayPackage();
		
		$this->assertEquals(COUNT_NORMAL, $package['COUNT_NORMAL']);
		$this->assertEquals(COUNT_RECURSIVE, $package['COUNT_RECURSIVE']);
		
		$this->assertEquals(SORT_REGULAR, $package['SORT_REGULAR']);
		$this->assertEquals(SORT_NUMERIC, $package['SORT_NUMERIC']);
		$this->assertEquals(SORT_STRING, $package['SORT_STRING']);
		$this->assertEquals(SORT_LOCALE_STRING, $package['SORT_LOCALE_STRING']);
		$this->assertEquals(SORT_NATURAL, $package['SORT_NATURAL']);
		$this->assertEquals(SORT_FLAG_CASE, $package['SORT_FLAG_CASE']);
	}
	
	/**
	 * MACROS
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testCar0() {
		$program = new SimpleProgram('(car)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCar1() {
		$program = new SimpleProgram('(car null)');
		$result = $program->execute(self::$env);
	}
	
	public function testCar2() {
		$program = new SimpleProgram('(car (array))');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testCar3() {
		$program = new SimpleProgram('(car (array null))');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testCar4() {
		$program = new SimpleProgram('(car (range 1 10))');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testCar5() {
		$program = new SimpleProgram('(car (%0))');
		$result = $program->execute(self::$env, new \ArrayObject(array()));
		$this->assertEquals(null, $result);
	}
	
	public function testCar6() {
		$program = new SimpleProgram('(car (%0))');
		$result = $program->execute(self::$env, new \ArrayObject(array(2)));
		$this->assertEquals(2, $result);
	}
	
	public function testCar7() {
		$program = new SimpleProgram('(Array::car (%0))');
		$result = $program->execute(self::$env, new \ArrayObject(array(2)));
		$this->assertEquals(2, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testCdr0() {
		$program = new SimpleProgram('(cdr)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCdr1() {
		$program = new SimpleProgram('(cdr null)');
		$result = $program->execute(self::$env);
	}
	
	public function testCdr2() {
		$program = new SimpleProgram('(cdr (array))');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testCdr3() {
		$program = new SimpleProgram('(cdr (array null))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(), $result);
	}
	
	public function testCdr4() {
		$program = new SimpleProgram('(cdr (array 1 2 3))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(2, 3), $result);
	}
	
	public function testCdr5() {
		$program = new SimpleProgram('(cdr (%0))');
		$result = $program->execute(self::$env, new \ArrayObject(array()));
		$this->assertEquals(null, $result);
	}
	
	public function testCdr6() {
		$program = new SimpleProgram('(cdr (%0))');
		$result = $program->execute(self::$env, new \ArrayObject(array(1)));
		$this->assertEquals(array(), $result);
	}
	
	public function testCdr7() {
		$program = new SimpleProgram('(cdr (%0))');
		$result = $program->execute(self::$env, new \ArrayObject(array(1, 2, 3)));
		$this->assertEquals(array(2, 3), $result);
	}
	
	public function testCdr8() {
		$program = new SimpleProgram('(Array::cdr (%0))');
		$result = $program->execute(self::$env, new \ArrayObject(array(1, 2, 3)));
		$this->assertEquals(array(2, 3), $result);
	}
	
	/**
	 * ARRAY FUNCTIONS
	 */
	
	public function testIn0() {
		$program = new SimpleProgram('(in 1 (array 1 2 3))');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIn1() {
		$program = new SimpleProgram('(in 4 (array 1 2 3))');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIn2() {
		$program = new SimpleProgram('(Array::in 4 (array 1 2 3))');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testCount1() {
		$program = new SimpleProgram('(count (array 1 2 3))');
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result);
	}
	
	public function testCount2() {
		$program = new SimpleProgram('(Array::count (array 1 2 3))');
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result);
	}
	
	public function testRange1() {
		$program = new SimpleProgram('(range 1 10)');
		$result = $program->execute(self::$env);
		$this->assertEquals(range(1, 10), $result);
	}
	
	public function testRange2() {
		$program = new SimpleProgram('(Array::range 1 10)');
		$result = $program->execute(self::$env);
		$this->assertEquals(range(1, 10), $result);
	}
	
	public function testChunk1() {
		$program = new SimpleProgram('(chunk (array "a" "b" "c" "d" "e") 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_chunk(array('a', 'b', 'c', 'd', 'e'), 2), $result);
	}
	
	public function testChunk2() {
		$program = new SimpleProgram('(Array::chunk (array "a" "b" "c" "d" "e") 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_chunk(array('a', 'b', 'c', 'd', 'e'), 2), $result);
	}
	
	public function testCombine1() {
		$program = new SimpleProgram('(combine (array "green" "red" "yellow") (array "avocado" "apple" "banana"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_combine(array('green', 'red', 'yellow'), array('avocado', 'apple', 'banana')), $result);
	}
	
	public function testCombine2() {
		$program = new SimpleProgram('(Array::combine (array "green" "red" "yellow") (array "avocado" "apple" "banana"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_combine(array('green', 'red', 'yellow'), array('avocado', 'apple', 'banana')), $result);
	}
	
	public function testCountValues1() {
		$program = new SimpleProgram('(count-values (array 1 "hello" 1 "world" "hello"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_count_values(array(1, "hello", 1, "world", "hello")), $result);
	}
	
	public function testCountValues2() {
		$program = new SimpleProgram('(Array::count-values (array 1 "hello" 1 "world" "hello"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_count_values(array(1, "hello", 1, "world", "hello")), $result);
	}
	
	public function testDiff1() {
		$program = new SimpleProgram('(diff (array "red" "blue" "red") (array "yellow" "red"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_diff(array("red", "blue", "red"), array("yellow", "red")), $result);
	}
	
	public function testDiff2() {
		$program = new SimpleProgram('(Array::diff (array "red" "blue" "red") (Core::array "yellow" "red"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_diff(array("red", "blue", "red"), array("yellow", "red")), $result);
	}
	
	public function testFill1() {
		$program = new SimpleProgram('(fill -2 4 "pear")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_fill(-2, 4, 'pear'), $result);
	}
	
	public function testFill2() {
		$program = new SimpleProgram('(Array::fill -2 4 "pear")');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_fill(-2, 4, 'pear'), $result);
	}
	
	public function testFilter1() {
		$program = new SimpleProgram('(filter (array 1 2 3 4) (%0))');
		$result = $program->execute(self::$env, array('Test\\ArrayTest', 'odd'));
		$this->assertEquals(array(1, 2 => 3), $result);
	}
	
	public function testFilter2() {
		$program = new SimpleProgram('(filter (array 1 2 3 4) (%0))');
		$result = $program->execute(self::$env, function ($var) {
			return(!($var & 1));
		});
		$this->assertEquals(array(1 => 2, 3 => 4), $result);
	}
	
	public function testFilter3() {
		$program = new SimpleProgram('(Array::filter (array 1 2 3 4) (%0))');
		$result = $program->execute(self::$env, array('Test\\ArrayTest', 'odd'));
		$this->assertEquals(array(1, 2 => 3), $result);
	}
	
	public function testFlip1() {
		$arg = array("a" => 1, "b" => 1, "c" => 2);
		$program = new SimpleProgram('(flip (%0))');
		$result = $program->execute(self::$env, $arg);
		$this->assertEquals(array_flip($arg), $result);
	}
	
	public function testFlip2() {
		$arg = array("a" => 1, "b" => 1, "c" => 2);
		$program = new SimpleProgram('(Array::flip (%0))');
		$result = $program->execute(self::$env, $arg);
		$this->assertEquals(array_flip($arg), $result);
	}
	
	public function testIntersect1() {
		$array1 = array("a" => "green", "red", "blue");
		$array2 = array("b" => "green", "yellow", "red");
		$program = new SimpleProgram('(intersect (%0) (%1))');
		$result = $program->execute(self::$env, $array1, $array2);
		$this->assertEquals(array_intersect($array1, $array2), $result);
	}
	
	public function testIntersect2() {
		$array1 = array("a" => "green", "red", "blue");
		$array2 = array("b" => "green", "yellow", "red");
		$program = new SimpleProgram('(Array::intersect (%0) (%1))');
		$result = $program->execute(self::$env, $array1, $array2);
		$this->assertEquals(array_intersect($array1, $array2), $result);
	}
	
	public function testKeys1() {
		$arg = array(0 => 100, "color" => "red");
		$program = new SimpleProgram('(keys (%0))');
		$result = $program->execute(self::$env, $arg);
		$this->assertEquals(array_keys($arg), $result);
	}
	
	public function testKeys2() {
		$arg = array(0 => 100, "color" => "red");
		$program = new SimpleProgram('(Array::keys (%0))');
		$result = $program->execute(self::$env, $arg);
		$this->assertEquals(array_keys($arg), $result);
	}
	
	public function testMerge1() {
		$array1 = array("color" => "red", 2, 4);
		$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
		$program = new SimpleProgram('(merge (%0) (%1))');
		$result = $program->execute(self::$env, $array1, $array2);
		$this->assertEquals(array_merge($array1, $array2), $result);
	}
	
	public function testMerge2() {
		$array1 = array("color" => "red", 2, 4);
		$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
		$program = new SimpleProgram('(Array::merge (%0) (%1))');
		$result = $program->execute(self::$env, $array1, $array2);
		$this->assertEquals(array_merge($array1, $array2), $result);
	}
	
	public function testSearch1() {
		$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
		$program = new SimpleProgram('(search "green" (%0))');
		$result = $program->execute(self::$env, $array);
		$this->assertEquals(array_search("green", $array), $result);
	}
	
	public function testSearch2() {
		$array = array(0 => 'blue', 1 => 'red', 2 => 'green', 3 => 'red');
		$program = new SimpleProgram('(Array::search "green" (%0))');
		$result = $program->execute(self::$env, $array);
		$this->assertEquals(array_search("green", $array), $result);
	}
	
	public function testSlice1() {
		$arg = array("a", "b", "c", "d", "e");
		$program = new SimpleProgram('(slice (%0) 0 3)');
		$result = $program->execute(self::$env, $arg);
		$this->assertEquals(array_slice($arg, 0, 3), $result);
	}
	
	public function testSlice2() {
		$arg = array("a", "b", "c", "d", "e");
		$program = new SimpleProgram('(Array::slice (%0) 0 3)');
		$result = $program->execute(self::$env, $arg);
		$this->assertEquals(array_slice($arg, 0, 3), $result);
	}
	
	public function testPad1() {
		$program = new SimpleProgram('(Array::pad (array 12 10 9) -7 -1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_pad(array(12, 10, 9), -7, -1), $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testPad2() {
		$program = new SimpleProgram('(pad (array 12 10 9) -7 -1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array_pad(array(12, 10, 9), -7, -1), $result);
	}
	
	public function testRand1() {
		$program = new SimpleProgram('(rand (array 1 2 3 4 5) 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, count($result));
	}
	
	public function testRand2() {
		$program = new SimpleProgram('(Array::rand (array 1 2 3 4 5) 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(2, count($result));
	}
	
	public function testProduct1() {
		$input = array(2, 4, 6, 8);
		$program = new SimpleProgram('(product (%0))');
		$result = $program->execute(self::$env, $input);
		$this->assertEquals(array_product($input), $result);
	}
	
	public function testProduct2() {
		$input = array(2, 4, 6, 8);
		$program = new SimpleProgram('(Array::product (%0))');
		$result = $program->execute(self::$env, $input);
		$this->assertEquals(array_product($input), $result);
	}
	
	public function testSum1() {
		$a = array(2, 4, 6, 8);
		$program = new SimpleProgram('(sum (%0))');
		$result = $program->execute(self::$env, $a);
		$this->assertEquals(array_sum($a), $result);
	}
	
	public function testSum2() {
		$a = array(2, 4, 6, 8);
		$program = new SimpleProgram('(Array::sum (%0))');
		$result = $program->execute(self::$env, $a);
		$this->assertEquals(array_sum($a), $result);
	}
	
	public function testUnique1() {
		$input = array("a" => "green", "red", "b" => "green", "blue", "red");
		$program = new SimpleProgram('(unique (%0) SORT_STRING)');
		$result = $program->execute(self::$env, $input);
		$this->assertEquals(array_unique($input, SORT_STRING), $result);
	}
	
	public function testUnique2() {
		$input = array("a" => "green", "red", "b" => "green", "blue", "red");
		$program = new SimpleProgram('(Array::unique (%0) SORT_STRING)');
		$result = $program->execute(self::$env, $input);
		$this->assertEquals(array_unique($input, SORT_STRING), $result);
	}
	
	public function testValues1() {
		$array = array("size" => "XL", "color" => "gold");
		$program = new SimpleProgram('(values (%0))');
		$result = $program->execute(self::$env, $array);
		$this->assertEquals(array_values($array), $result);
	}
	
	public function testValues2() {
		$array = array("size" => "XL", "color" => "gold");
		$program = new SimpleProgram('(Array::values (%0))');
		$result = $program->execute(self::$env, $array);
		$this->assertEquals(array_values($array), $result);
	}
	
	public function testReplace1() {
		$base = array("orange", "banana", "apple", "raspberry");
		$replacements = array(0 => "pineapple", 2 => "cherry");
		
		$program = new SimpleProgram('(Array::replace (%0) (%1))');
		$result = $program->execute(self::$env, $base, $replacements);
		$this->assertEquals(array("pineapple", "banana", "cherry", "raspberry"), $result);
	}
	
	public function testReplace2() {
		$base = array("orange", "banana", "apple", "raspberry");
		$replacements = array(0 => "pineapple", 2 => "cherry");
	
		$program = new SimpleProgram('(Array::replace (%0) (%1))');
		$result = $program->execute(self::$env, $base, $replacements);
		$this->assertEquals(array("pineapple", "banana", "cherry", "raspberry"), $result);
	}
	
	public function testReverse1() {
		$input  = array("php", 4.0, array("green", "red"));
		
		$program = new SimpleProgram('(Array::reverse (%0))');
		$result = $program->execute(self::$env, $input);
		$this->assertEquals(array_reverse($input), $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testReverse2() {
		$input  = array("php", 4.0, array("green", "red"));
	
		$program = new SimpleProgram('(reverse (%0))');
		$result = $program->execute(self::$env, $input);
		$this->assertEquals(array_reverse($input), $result);
	}
	
	/**
	 * REFERENCE FUNCTIONS
	 */
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayPop0() {
		$program = new SimpleProgram('(pop)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testArrayPop1() {
		$program = new SimpleProgram('(pop 3)');
		$result = $program->execute(self::$env);
	}
	
	public function testArrayPop2() {
		$program = new SimpleProgram('(:= _arr (array 1 2 3))(pop _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result);
	}
	
	public function testArrayPop3() {
		$program = new SimpleProgram('(:= _arr (array 1 2 3))(pop _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(1, 2), $result);
	}
	
	public function testArrayPop4() {
		$program = new SimpleProgram('(:= _arr (array))(pop _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(null, $result);
	}
	
	public function testArrayPop5() {
		$program = new SimpleProgram('(:= _arr (array 1 2 3))(Array::pop _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(1, 2), $result);
	}
	
	public function testArrayPop6() {
		$program = new SimpleProgram('(:= _arr (%0))(Array::pop _arr)(<- _arr)');
		$result = $program->execute(self::$env, new Fizz(array(1, 2, 3)));
		$this->assertEquals(new Fizz(array(1, 2)), $result);
	}
	
	public function testArrayPop7() {
		$program = new SimpleProgram('(:= _arr (%0))(Array::pop _arr)');
		$result = $program->execute(self::$env, new Fizz(array(1, 2, 3)));
		$this->assertEquals(3, $result);
	}
	
	public function testArrayPop8() {
		$program = new SimpleProgram('(:= _arr (%0))(Array::pop _arr)(<- _arr)');
		$result = $program->execute(self::$env, new Fizz(array()));
		$this->assertEquals(new Fizz(array()), $result);
	}
	
	public function testArrayPop9() {
		$program = new SimpleProgram('(:= _arr (%0))(Array::pop _arr)');
		$result = $program->execute(self::$env, new Fizz(array()));
		$this->assertEquals(null, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayMap0() {
		$program = new SimpleProgram('(map)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayMap1() {
		$program = new SimpleProgram('(map "strtoupper")');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testArrayMap2() {
		$program = new SimpleProgram('(map null (array))');
		$result = $program->execute(self::$env);
	}
	
	public function testArrayMap3() {
		$program = new SimpleProgram('(map "strtoupper" (array "a" "b" "c"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array("A", "B", "C"), $result);
	}
	
	public function testArrayMap4() {
		$program = new SimpleProgram('(map (%0) (array 1 2 3))');
		$result = $program->execute(self::$env, array('Test\\ArrayTest', 'cube'));
		$this->assertEquals(array(1, 8, 27), $result);
	}
	
	public function testArrayMap5() {
		$program = new SimpleProgram('(map (%0) (array 1 2 3) (array "uno" "dos" "tres"))');
		$result = $program->execute(self::$env, function ($n, $m) {
			return array($n => $m);
		});
		$this->assertEquals(array(array(1 => "uno"), array(2 => "dos"), array(3 => "tres")), $result);
	}
	
	public function testArrayMap6() {
		$program = new SimpleProgram('(Array::map "strtoupper" (array "a" "b" "c"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array("A", "B", "C"), $result);
	}
	
	public function testArrayMap7() {
		$program = new SimpleProgram('(map String::reverse (array "abc" "def" "hij"))');
		$result = $program->execute(self::$env);
		$this->assertEquals(array("cba", "fed", "jih"), $result);
	}
	
	public function testArrayMap8() {
		$program = new SimpleProgram('(map String::reverse (%0))');
		$result = $program->execute(self::$env, new Fizz(array("abc", "def")));
		$this->assertEquals(array("cba", "fed"), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayWalk0() {
		$program = new SimpleProgram('(walk)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayWalk1() {
		$program = new SimpleProgram('(walk null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testArrayWalk2() {
		$program = new SimpleProgram('(walk "strtoupper" null)');
		$result = $program->execute(self::$env);
	}
	
	public function testArrayWalk3() {
		$program = new SimpleProgram('(:= _arr (array "one" "two" "three"))(walk _arr (%0))(<- _arr)');
		$result = $program->execute(self::$env, array('Test\\ArrayTest', 'walk'));
		$this->assertEquals(array("1 - one", "2 - two", "3 - three"), $result);
	}
	
	public function testArrayWalk4() {
		$program = new SimpleProgram('(:= _arr (array "one" "two" "three"))(walk _arr (%0))(<- _arr)');
		$result = $program->execute(self::$env, function (&$item, $key) {
			$item = $item . " - " . ($key + 1);
		});
		$this->assertEquals(array("one - 1", "two - 2", "three - 3"), $result);
	}
	
	public function testArrayWalk5() {
		$program = new SimpleProgram('(:= _arr (array "orange" "apple" "banana"))(walk _arr (%0) "FRUIT: ")(<- _arr)');
		$result = $program->execute(self::$env, function (&$item, $key, $prefix) {
			$item = $prefix . $item;
		});
		$this->assertEquals(array("FRUIT: orange", "FRUIT: apple", "FRUIT: banana"), $result);
	}
	
	public function testArrayWalk6() {
		$program = new SimpleProgram('(:= _arr (%0))(walk _arr (%1))(<- _arr)');
		$result = $program->execute(self::$env, new Fizz(array('one', 'two', 'three')), function (&$item, $key) {
			$item = $item . " - " . ($key + 1);
		});
		$this->assertEquals(new Fizz(array('one - 1', 'two - 2', 'three - 3')), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayPush0() {
		$program = new SimpleProgram('(push)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayPush1() {
		$program = new SimpleProgram('(push null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testArrayPush2() {
		$program = new SimpleProgram('(push null 1)');
		$result = $program->execute(self::$env);
	}
	
	public function testArrayPush3() {
		$program = new SimpleProgram('(:= _arr (array))(push _arr 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testArrayPush4() {
		$program = new SimpleProgram('(:= _arr (array))(push _arr 10)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(10), $result);
	}
	
	public function testArrayPush5() {
		$program = new SimpleProgram('(:= _arr (array 10))(push _arr 20 30)');
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result);
	}
	
	public function testArrayPush6() {
		$program = new SimpleProgram('(:= _arr (array 10))(push _arr 20 30)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(10, 20, 30), $result);
	}
	
	public function testArrayPush7() {
		$program = new SimpleProgram('(:= _arr (%0))(push _arr 20 30)');
		$result = $program->execute(self::$env, new Fizz(array(10)));
		$this->assertEquals(3, $result);
	}
	
	public function testArrayPush9() {
		$program = new SimpleProgram('(:= _arr (%0))(push _arr 20 30)(<- _arr)');
		$result = $program->execute(self::$env, new Fizz(array(10)));
		$this->assertEquals(new Fizz(array(10, 20, 30)), $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayShif0() {
		$program = new SimpleProgram('(shift)');
		$result = $program->execute(self::$env);
	}
	
	public function testArrayShift1() {
		$program = new SimpleProgram('(shift null)');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testArrayShift2() {
		$program = new SimpleProgram('(:= _arr (array))(shift _arr)');
		$result = $program->execute(self::$env);
		$this->assertNull($result);
	}
	
	public function testArrayShift3() {
		$program = new SimpleProgram('(:= _arr (array 10 20 30))(shift _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(10, $result);
	}
	
	public function testArrayShift4() {
		$program = new SimpleProgram('(:= _arr (array 10 20 30))(shift _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(20, 30), $result);
	}
	
	public function testArrayShift5() {
		$program = new SimpleProgram('(:= _arr (%0))(shift _arr)');
		$result = $program->execute(self::$env, new Fizz(array(10, 20, 30)));
		$this->assertEquals(10, $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayUnshift0() {
		$program = new SimpleProgram('(unshift)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayUnshift1() {
		$program = new SimpleProgram('(unshift null)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testArrayUnshift2() {
		$program = new SimpleProgram('(unshift null 1)');
		$result = $program->execute(self::$env);
	}
	
	public function testArrayUnshift3() {
		$program = new SimpleProgram('(:= _arr (array))(unshift _arr 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(1, $result);
	}
	
	public function testArrayUnshift4() {
		$program = new SimpleProgram('(:= _arr (array))(unshift _arr 10)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array(10), $result);
	}
	
	public function testArrayUnshift5() {
		$program = new SimpleProgram('(:= _arr (array 10))(unshift _arr 20 30)');
		$result = $program->execute(self::$env);
		$this->assertEquals(3, $result);
	}
	
	public function testArrayUnshift6() {
		$program = new SimpleProgram('(:= _arr (array "orange" "banana"))(unshift _arr "apple" "raspberry")(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('apple', 'raspberry', 'orange', 'banana'), $result);
	}
	
	public function testArrayUnshift7() {
		$program = new SimpleProgram('(:= _arr (%0))(unshift _arr 20 30)');
		$result = $program->execute(self::$env, new Fizz(array(10)));
		$this->assertEquals(3, $result);
	}
	
	public function testArrayUnshift8() {
		$program = new SimpleProgram('(:= _arr (%0))(unshift _arr 20 30)(<- _arr)');
		$result = $program->execute(self::$env, new Fizz(array(10)));
		$this->assertEquals(new Fizz(array(20, 30, 10)), $result);
	}
	
	public function testArrayReduce1() {
		$program = new SimpleProgram('(:= _arr (array 1 2 3 4 5))(reduce _arr (%0))');
		$result = $program->execute(self::$env, array('Test\\ArrayTest', 'rsum'));
		$this->assertEquals(15, $result);
	}
	
	public function testArrayReduce2() {
		$program = new SimpleProgram('(:= _arr (array 1 2 3 4 5))(Array::reduce _arr (%0))');
		$result = $program->execute(self::$env, function (&$v, $w) {
			$v = ($v == 0) ? $w : $v * $w;
			return $v;
		});
		$this->assertEquals(120, $result);
	}
	
	public function testArrayReduce3() {
		$program = new SimpleProgram('(:= _arr (array))(Array::reduce _arr (%0) "No data")');
		$result = $program->execute(self::$env, function (&$v, $w) {
			$v = ($v == 0) ? $w : $v * $w;
			return $v;
		});
		$this->assertEquals("No data", $result);
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArrayShuffle0() {
		$program = new SimpleProgram('(Array::shuffle)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testArrayShuffle1() {
		$program = new SimpleProgram('(Array::shuffle null)');
		$result = $program->execute(self::$env);
	}
	
	public function testArrayShuffle2() {
		$program = new SimpleProgram('(:= _arr (array))(Array::shuffle _arr)');
		$result = $program->execute(self::$env);
		$this->assertTrue($result);
	}
	
	public function testArrayShuffle3() {
		$program = new SimpleProgram('(:= _arr (array 1 2 3))(Array::shuffle _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertTrue(in_array(1, $result));
		$this->assertTrue(in_array(2, $result));
		$this->assertTrue(in_array(3, $result));
	}
	
	public function testArrayShuffle4() {
		$program = new SimpleProgram('(:= _arr (%0))(Array::shuffle _arr)(<- _arr)');
		$result = $program->execute(self::$env, new Fizz(array(1, 2, 3)));
		$this->assertTrue($result instanceof Fizz);
		$result = $result->getArrayCopy();
		$this->assertTrue(in_array(1, $result));
		$this->assertTrue(in_array(2, $result));
		$this->assertTrue(in_array(3, $result));
	}
	
	/**
	 * @expectedException BadFunctionCallException
	 */
	public function testArraySort0() {
		$program = new SimpleProgram('(Array::sort)');
		$result = $program->execute(self::$env);
	}
	
	public function testArraySort1() {
		$program = new SimpleProgram('(:= _arr (array "lemon" "orange" "banana" "apple"))(Array::sort _arr)');
		$result = $program->execute(self::$env);
		$this->assertTrue($result);
	}
	
	public function testArraySort2() {
		$program = new SimpleProgram('(:= _arr (array "lemon" "orange" "banana" "apple"))(Array::sort _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array("apple", "banana", "lemon", "orange"), $result);
		$this->assertEquals('apple', current($result));
		$this->assertEquals(0, key($result));
	}
	
	public function testArraySort3() {
		$program = new SimpleProgram('(:= _arr (array "Orange1" "orange2" "orange20" "Orange3"))(Array::sort _arr (| Array::SORT_NATURAL Array::SORT_FLAG_CASE))(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array("Orange1", "orange2", "Orange3", "orange20"), $result);
		$this->assertEquals('Orange1', current($result));
		$this->assertEquals(0, key($result));
	}
	
	public function testArrayRSort1() {
		$program = new SimpleProgram('(:= _arr (array "lemon" "orange" "banana" "apple"))(Array::rsort _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('orange', 'lemon', 'banana', 'apple'), $result);
		$this->assertEquals('orange', current($result));
		$this->assertEquals(0, key($result));
	}
	
	public function testArrayASort1() {
		$program = new SimpleProgram('(:= _arr (array ("d" "lemon") ("a" "orange") ("b" "banana") ("c" "apple")))(Array::asort _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('c' => 'apple', 'b' => 'banana', 'd' => 'lemon', 'a' => 'orange'), $result);
		$this->assertEquals('apple', current($result));
		$this->assertEquals('c', key($result));
	}
	
	public function testArrayARSort1() {
		$program = new SimpleProgram('(:= _arr (array ("d" "lemon") ("a" "orange") ("b" "banana") ("c" "apple")))(Array::arsort _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('a' => 'orange', 'd' => 'lemon', 'b' => 'banana', 'c' => 'apple'), $result);
		$this->assertEquals('orange', current($result));
		$this->assertEquals('a', key($result));
	}
	
	public function testArrayKSort1() {
		$program = new SimpleProgram('(:= _arr (array ("d" "lemon") ("a" "orange") ("b" "banana") ("c" "apple")))(Array::ksort _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('a' => 'orange', 'd' => 'lemon', 'b' => 'banana', 'c' => 'apple'), $result);
		$this->assertEquals('orange', current($result));
		$this->assertEquals('a', key($result));
	}
	
	public function testArrayKRSort1() {
		$program = new SimpleProgram('(:= _arr (array ("d" "lemon") ("a" "orange") ("b" "banana") ("c" "apple")))(Array::krsort _arr)(<- _arr)');
		$result = $program->execute(self::$env);
		$this->assertEquals(array('a' => 'orange', 'd' => 'lemon', 'b' => 'banana', 'c' => 'apple'), $result);
		$this->assertEquals('lemon', current($result));
		$this->assertEquals('d', key($result));
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error
	 */
	public function testUSort1() {
		$program = new SimpleProgram('(:= _arr (array 3 2 5 6 1))(Array::usort _arr)');
		$result = $program->execute(self::$env);
	}
	
	public function testUSort2() {
		$program = new SimpleProgram('(:= _arr (array 3 2 5 6 1))(Array::usort _arr (%0))(<- _arr)');
		$result = $program->execute(self::$env, function ($a, $b) {
			if ($a == $b) {
				return 0;
			}
			return ($a < $b) ? -1 : 1;
		});
		
		$this->assertEquals(array(1, 2, 3, 5, 6), $result);
	}
	
	public function testUASort() {
		$program = new SimpleProgram('(:= _arr (array ("a" 4) ("b" 8) ("c" -1) ("d" -9) ("e" 2) ("f" 5) ("g" 3) ("h" -4)))(Array::uasort _arr (%0))(<- _arr)');
		$result = $program->execute(self::$env, function ($a, $b) {
			if ($a == $b) {
				return 0;
			}
			return ($a < $b) ? -1 : 1;
		});
		
		$this->assertEquals(array('a' => 4, 'b' => 8, 'c' => -1, 'd' => -9, 'e' => 2, 'f' => 5, 'g' => 3, 'h' => -4), $result);
		$this->assertEquals(-9, current($result));
		$this->assertEquals('d', key($result));
	}
	
	public function testUKSort() {
		$program = new SimpleProgram('(:= _arr (array ("John" 1) ("the Earth" 2) ("an apple" 3) ("a banana" 4)))(Array::uksort _arr (%0))(<- _arr)');
		$result = $program->execute(self::$env, function ($a, $b) {
			$a = preg_replace('@^(a|an|the) @', '', $a);
			$b = preg_replace('@^(a|an|the) @', '', $b);
			return strcasecmp($a, $b);
		});
		
		$this->assertEquals(3, current($result));
		$this->assertEquals('an apple', key($result));
	}
}
?>