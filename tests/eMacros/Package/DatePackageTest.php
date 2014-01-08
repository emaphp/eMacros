<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
/**
 * 
 * @author emaphp
 * @group date
 */
class DatePackageTest extends eMacrosTest {
	public function testTime1() {
		$program = new SimpleProgram('(time)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_int($result));
	}
	
	public function testTime2() {
		$program = new SimpleProgram('(Date::time)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_int($result));
	}
	
	public function testMicrotime1() {
		$program = new SimpleProgram('(microtime)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(1, preg_match('/^0\.(\d+) (\d+)/', $result));
	}
	
	public function testMicrotime2() {
		$program = new SimpleProgram('(Date::microtime)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(1, preg_match('/^0\.(\d+) (\d+)/', $result));
	}
	
	public function testCheckDate0() {
		$program = new SimpleProgram('(check-date 12 31 2009)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result);
	}
	
	public function testCheckDate1() {
		$program = new SimpleProgram('(check-date 2 29 2001)');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testCheckDate2() {
		$program = new SimpleProgram('(Date::check-date 2 29 2001)');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testGetDate1() {
		$program = new SimpleProgram('(get-date)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_array($result));
	}
	
	public function testGetDate2() {
		$program = new SimpleProgram('(Date::get-date)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_array($result));
	}
	
	public function testDate1() {
		$program = new SimpleProgram('(date "Y-m-d" (mktime 0 0 0 7 1 2000))');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(date("Y-m-d", mktime(0, 0, 0, 7, 1, 2000)), $result);
	}
	
	public function testDate2() {		
		$program = new SimpleProgram('(Date::date "Y-m-d" (Date::mktime 0 0 0 7 1 2000))');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(date("Y-m-d", mktime(0, 0, 0, 7, 1, 2000)), $result);
	}
	
	public function testDateCreate1() {
		$program = new SimpleProgram('(date-create "j-M-Y" "15-Feb-2009")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateTime);
		$this->assertEquals(\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'), $result);
	}
	
	public function testDateCreate2() {		
		$program = new SimpleProgram('(Date::date-create "j-M-Y" "15-Feb-2009")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateTime);
		$this->assertEquals(\DateTime::createFromFormat('j-M-Y', '15-Feb-2009'), $result);
	}
	
	public function testDateParse1() {
		$program = new SimpleProgram('(date-parse "2006-12-11 10:00:00.5")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_array($result));
		$this->assertEquals(2006, $result['year']);
		$this->assertEquals(12, $result['month']);
		$this->assertEquals(11, $result['day']);
	}
	
	public function testDateParse2() {
		$program = new SimpleProgram('(Date::date-parse "2006-12-11 10:00:00.5")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_array($result));
		$this->assertEquals(2006, $result['year']);
		$this->assertEquals(12, $result['month']);
		$this->assertEquals(11, $result['day']);
	}
	
	public function testIntervalCreate1() {
		$program = new SimpleProgram('(interval-create "1 month")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(\DateInterval::createFromDateString('1 month'), $result);
	}
	
	public function testIntervalCreate2() {
		$program = new SimpleProgram('(Date::interval-create "1 month")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(\DateInterval::createFromDateString('1 month'), $result);
	}
	
	public function testToTime1() {
		$program = new SimpleProgram('(to-time "10 September 2000")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(strtotime("10 September 2000"), $result);
	}
	
	public function testToTime2() {		
		$program = new SimpleProgram('(Date::to-time "10 September 2000")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(strtotime("10 September 2000"), $result);
	}
	
	public function testFormatTime1() {
		$format = "%d/%m/%Y";
		$program = new SimpleProgram('(parse-time (format-time (%0)) (%0))');
		$result = $program->execute(self::$xenv, $format);
		$this->assertEquals(strptime(strftime($format), $format), $result);
	}
	
	public function testFormatTime2() {
		$format = "%d/%m/%Y";
		$program = new SimpleProgram('(Date::parse-time (format-time (%0)) (%0))');
		$result = $program->execute(self::$xenv, $format);
		$this->assertEquals(strptime(strftime($format), $format), $result);
	}
	
	/**
	 * @expectedException PHPUnit_Framework_Error_Warning
	 */
	public function testDt0() {
		$program = new SimpleProgram('(dt)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateTime);
	}
	
	public function testDt1() {
		$program = new SimpleProgram('(dt "2000-01-01")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateTime);
		$this->assertEquals(new \DateTime('2000-01-01'), $result);
	}
	
	public function testDt2() {
		$program = new SimpleProgram('(Date::dt "2000-01-01")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateTime);
		$this->assertEquals(new \DateTime('2000-01-01'), $result);
	}
	
	public function testNow1() {
		$program = new SimpleProgram('(->format (now) "Y-m-d")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(1, preg_match('/([\d]{4})-([\d]{2})-([\d]{2})/', $result));
	}
	
	public function testNow2() {
		$program = new SimpleProgram('(->format (Date::now) "Y-m-d")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(1, preg_match('/([\d]{4})-([\d]{2})-([\d]{2})/', $result));
	}
	
	public function testInterval1() {
		$program = new SimpleProgram('(interval "P2Y4DT6H8M")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateInterval);
		$this->assertEquals(new \DateInterval('P2Y4DT6H8M'), $result);
	}
	
	public function testInterval2() {
		$program = new SimpleProgram('(Date::interval "P2Y4DT6H8M")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateInterval);
		$this->assertEquals(new \DateInterval('P2Y4DT6H8M'), $result);
	}
	
	public function testTz1() {
		$program = new SimpleProgram('(tz "America/Argentina/Buenos_Aires")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateTimeZone);
		$this->assertEquals(new \DateTimeZone("America/Argentina/Buenos_Aires"), $result);
	}
	
	public function testTz2() {
		$program = new SimpleProgram('(Date::tz "America/Argentina/Buenos_Aires")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue($result instanceof \DateTimeZone);
		$this->assertEquals(new \DateTimeZone("America/Argentina/Buenos_Aires"), $result);
	}
}
?>