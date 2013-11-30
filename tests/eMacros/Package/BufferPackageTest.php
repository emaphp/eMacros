<?php
namespace eMacros;

use eMacros\Package\BufferPackage;
use eMacros\Program\SimpleProgram;

/**
 * 
 * @author emaphp
 * @group buffer
 */
class BufferPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new BufferPackage();
		
		$this->assertEquals(PHP_OUTPUT_HANDLER_START, $package['START']);
		$this->assertEquals(PHP_OUTPUT_HANDLER_WRITE, $package['WRITE']);
		$this->assertEquals(PHP_OUTPUT_HANDLER_FINAL, $package['FINAL']);
		$this->assertEquals(PHP_OUTPUT_HANDLER_CLEAN, $package['CLEAN']);
		$this->assertEquals(PHP_OUTPUT_HANDLER_FLUSH, $package['FLUSH']);
		
		if (version_compare(phpversion(), '5.4', '>=')) {
			//operation constants
			$this->assertEquals(PHP_OUTPUT_HANDLER_STDFLAGS, $package['STD_FLAGS']);
			$this->assertEquals(PHP_OUTPUT_HANDLER_REMOVABLE, $package['REMOVABLE']);
			$this->assertEquals(PHP_OUTPUT_HANDLER_FLUSHABLE, $package['FLUSHABLE']);
			$this->assertEquals(PHP_OUTPUT_HANDLER_CLEANABLE, $package['CLEANABLE']);
		}
	}
	
	public function testStart1() {
		$program = new SimpleProgram('(Buffer::start)(echo "Hello")(:= _contents (Buffer::get-contents))(Buffer::end-clean)(<- _contents)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("Hello", $result);
	}
	
	public function testStart2() {
		$program = new SimpleProgram('(Buffer::start)(echo "Hello")(:= _contents (Buffer::get-clean))(<- _contents)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("Hello", $result);
	}
	
	public function testGetLength() {
		$program = new SimpleProgram('(Buffer::start)(echo "Hello")(:= _length (Buffer::get-length))(:= _contents (Buffer::get-clean))(<- _length)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(5, $result);
	}
	
	public function testGetStatus() {
		$program = new SimpleProgram('(Buffer::start)(echo "Hello")(:= _status (Buffer::get-status))(Buffer::end-clean)(<- _status)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals('default output handler', $result['name']);
		$this->assertEquals(5, $result['buffer_used']);
		$this->assertEquals(1, $result['level']);
	}
	
	public function testGetLevel() {
		$program = new SimpleProgram('(Buffer::start)(Buffer::start)(:= _level (Buffer::get-level))(Buffer::end-clean)(Buffer::end-clean)(<- _level)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(3, $result);
	}
	
	public function testClean() {
		$program = new SimpleProgram('(Buffer::start)(echo "Hello")(Buffer::clean)(echo "World")(:= _contents (Buffer::get-contents))(Buffer::end-clean)(<- _contents)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals("World", $result);
	}
	
	public function testListHandlers() {
		$program = new SimpleProgram('(Buffer::list-handlers)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(ob_list_handlers(), $result);
	}
}
?>