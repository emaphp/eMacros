<?php
namespace eMacros;

use eMacros\Package\CorePackage;
/**
 * 
 * @author emaphp
 * @group core
 */
class CorePackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new CorePackage();
		
		$this->assertEquals(PHP_VERSION, $package['PHP_VERSION']);
		$this->assertEquals(PHP_MAJOR_VERSION, $package['PHP_MAJOR_VERSION']);
		$this->assertEquals(PHP_MINOR_VERSION, $package['PHP_MINOR_VERSION']);
		$this->assertEquals(PHP_RELEASE_VERSION, $package['PHP_RELEASE_VERSION']);
		$this->assertEquals(PHP_EXTRA_VERSION, $package['PHP_EXTRA_VERSION']);
		$this->assertEquals(PHP_VERSION_ID, $package['PHP_VERSION_ID']);
		$this->assertEquals(PHP_OS, $package['PHP_OS']);
		$this->assertEquals(PHP_SAPI, $package['PHP_SAPI']);
		$this->assertEquals(PHP_INT_MAX, $package['PHP_INT_MAX']);
		$this->assertEquals(PHP_INT_SIZE, $package['PHP_INT_SIZE']);
	}
}
?>