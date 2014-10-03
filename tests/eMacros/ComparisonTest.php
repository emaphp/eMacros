<?php
namespace eMacros;

use eMacros\Program\Program;
/**
 * 
 * @author emaphp
 * @group comparison
 */
class ComparisonTest extends eMacrosTest {
	
	/**
	 * EQUAL
	 */
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testEqual0() {
		$program = new Program('(==)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testEqual1() {
		$program = new Program('(== 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testEqual2() {
		$program = new Program('(== 1 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testEqual3() {
		$program = new Program('(== 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testEqual4() {
		$program = new Program('(== 1 1 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testEqual5() {
		$program = new Program('(== 1 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testEqual6() {
		$program = new Program('(== 1 "1")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	/**
	 * GREATER EQUAL
	 */
	
	/**
	 * @expectedException \BadFunctionCallException	
	 */
	public function testGreaterEqual0() {
		$program = new Program('(>=)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testGreaterEqual1() {
		$program = new Program('(>= 4)');
		$result = $program->execute(self::$env);
	}
	
	public function testGreaterEqual2() {
		$program = new Program('(>= 4 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testGreaterEqual3() {
		$program = new Program('(>= 4 4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testGreaterEqual4() {
		$program = new Program('(>= 4 "4")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testGreaterEqual5() {
		$program = new Program('(>= 4 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testGreaterEqual6() {
		$program = new Program('(>= 4 2 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testGreaterEqual7() {
		$program = new Program('(>= 4 2 7)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * GREATER THAN
	 */
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testGreaterThan0() {
		$program = new Program('(>)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testGreaterThan1() {
		$program = new Program('(> 4)');
		$result = $program->execute(self::$env);
	}
	
	public function testGreaterThan2() {
		$program = new Program('(> 4 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testGreaterThan3() {
		$program = new Program('(> 4 4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testGreaterThan4() {
		$program = new Program('(> 4 "3")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testGreaterThan5() {
		$program = new Program('(> 4 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testGreaterThan6() {
		$program = new Program('(> 4 2 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testGreaterThan7() {
		$program = new Program('(> 4 2 7)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * IDENTICAL
	 */
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testIdentical0() {
		$program = new Program('(===)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testIdentical1() {
		$program = new Program('(=== 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testIdentical2() {
		$program = new Program('(=== 1 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIdentical3() {
		$program = new Program('(=== 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIdentical4() {
		$program = new Program('(=== 1 "1")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIdentical5() {
		$program = new Program('(=== \'1\' "1")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIdentical6() {
		$program = new Program('(=== 1 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testIdentical7() {
		$program = new Program('(=== 1 1 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testIdentical8() {
		$program = new Program('(=== 1 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * LESS EQUAL
	 */
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testLessEqual0() {
		$program = new Program('(<=)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testLessEqual1() {
		$program = new Program('(<= 4)');
		$result = $program->execute(self::$env);
	}
	
	public function testLessEqual2() {
		$program = new Program('(<= 4 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testLessEqual3() {
		$program = new Program('(<= 4 4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testLessEqual4() {
		$program = new Program('(<= 4 "4")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testLessEqual5() {
		$program = new Program('(<= 4 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testLessEqual6() {
		$program = new Program('(<= 4 5 4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testLessEqual7() {
		$program = new Program('(<= 4 7 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * LESS THAN
	 */

	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testLessThan0() {
		$program = new Program('(<)');
		$result = $program->execute(self::$env);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testLessThan1() {
		$program = new Program('(< 4)');
		$result = $program->execute(self::$env);
	}
	
	public function testLessThan2() {
		$program = new Program('(< 4 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testLessThan3() {
		$program = new Program('(< 4 4)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testLessThan4() {
		$program = new Program('(< 4 "6")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testLessThan5() {
		$program = new Program('(< 4 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testLessThan6() {
		$program = new Program('(< 4 6 8)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testLessThan7() {
		$program = new Program('(< 4 7 5)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * NOT EQUAL
	 */
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testNotEqual0() {
		$program = new Program('(!=)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testNotEqual1() {
		$program = new Program('(!= 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testNotEqual2() {
		$program = new Program('(!= 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNotEqual3() {
		$program = new Program('(!= 1 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNotEqual4() {
		$program = new Program('(!= 1 2 3)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNotEqual5() {
		$program = new Program('(!= 1 2 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNotEqual6() {
		$program = new Program('(!= 1 2 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNotEqual7() {
		$program = new Program('(!= 1 "1")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	/**
	 * NOT IDENTICAL
	 */
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testNotIdentical0() {
		$program = new Program('(!==)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	/**
	 * @expectedException \BadFunctionCallException
	 */
	public function testNotIdentical1() {
		$program = new Program('(!== 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(0, $result);
	}
	
	public function testNotIdentical2() {
		$program = new Program('(!== 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNotIdentical3() {
		$program = new Program('(!== 1 1)');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNotIdentical4() {
		$program = new Program('(!== 1 "1")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNotIdentical5() {
		$program = new Program('(!== \'1\' "1")');
		$result = $program->execute(self::$env);
		$this->assertEquals(false, $result);
	}
	
	public function testNotIdentical6() {
		$program = new Program('(!== 1 1 2)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNotIdentical7() {
		$program = new Program('(!== 1 1.0 "1")');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
	
	public function testNotIdentical8() {
		$program = new Program('(!== 1 1.0)');
		$result = $program->execute(self::$env);
		$this->assertEquals(true, $result);
	}
}
?>