<?php
namespace eMacros;

use eMacros\Program\Program;
use eMacros\Package\PasswordPackage;

/**
 * 
 * @author emaphp
 * @group password
 */
class PasswordPackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new PasswordPackage();
		
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
		
		$this->assertEquals(PASSWORD_DEFAULT, $package->offsetGet('PASSWORD_DEFAULT'));
		$this->assertEquals(PASSWORD_BCRYPT, $package->offsetGet('PASSWORD_BCRYPT'));
	}
	
	public function testCrypt1() {
		if (CRYPT_MD5 != 1) {
			$this->markTestSkipped("MD5 algorithm not found");
		}
		
		$program = new Program('(Password::crypt "abc" "$1$hellow$")');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_string($result));
		$this->assertEquals(32, strlen($result));
	}
	
	public function testHash1() {
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
		
		$program = new Program('(Password::hash "qwerty" Password::PASSWORD_DEFAULT)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_string($result));
		$this->assertEquals(60, strlen($result));
	}
	
	public function testHash2() {
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
	
		$program = new Program('(Password::hash "qwerty" Password::PASSWORD_DEFAULT)');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_string($result));
		$this->assertEquals(60, strlen($result));
	}
	
	public function testHash3() {
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
	
		$program = new Program('(Password::hash "qwerty" Password::PASSWORD_DEFAULT)');
		$result1 = $program->execute(self::$xenv);
		
		$program = new Program('(Password::hash "qwerty" Password::PASSWORD_BCRYPT)');
		$result2 = $program->execute(self::$xenv);
		
		$this->assertNotEquals($result1, $result2);
	}
	
	public function testGetInfo1() {
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
		
		$program = new Program('(Password::get-info (Password::hash "qwerty" Password::PASSWORD_DEFAULT))');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_array($result));
		$this->assertArrayHasKey('algo', $result);
		$this->assertArrayHasKey('algoName', $result);
		$this->assertArrayHasKey('options', $result);
		$this->assertEquals(PASSWORD_DEFAULT, $result['algo']);
	}
	
	public function testGetInfo2() {
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
	
		$program = new Program('(Password::get-info (Password::hash "qwerty" Password::PASSWORD_BCRYPT))');
		$result = $program->execute(self::$xenv);
		$this->assertTrue(is_array($result));
		$this->assertArrayHasKey('algo', $result);
		$this->assertArrayHasKey('algoName', $result);
		$this->assertArrayHasKey('options', $result);
		$this->assertEquals(PASSWORD_BCRYPT, $result['algo']);
	}
	
	public function testNeedsRehash() {
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
		
		//From DOCS: Returns TRUE if the hash should be rehashed to match the given algo and options, or FALSE otherwise.
		$program = new Program('(Password::needs-rehash (Password::hash "qwerty" Password::PASSWORD_BCRYPT) Password::PASSWORD_BCRYPT (array ("cost" 10)))');
		$result = $program->execute(self::$xenv);
		$this->assertFalse($result);
	}
	
	public function testVerify1() {
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
		
		$password = 'qwerty123';
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$program = new Program('(Password::verify (%0) (%1))');
		$result = $program->execute(self::$xenv, $password, $hash);
		$this->assertTrue($result);
	}
	
	public function testVerify2() {
		if (phpversion() <= '5.4') {
			$this->markTestSkipped("PasswordPackage requires PHP 5.5 or older");
		}
	
		$password = 'qwerty123';
		$hash = password_hash($password, PASSWORD_DEFAULT);
		$program = new Program('(Password::verify "fakepass" (%1))');
		$result = $program->execute(self::$xenv, $password, $hash);
		$this->assertFalse($result);
	}
}
?>