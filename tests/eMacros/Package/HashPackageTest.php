<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
/**
 * 
 * @author emaphp
 * @group hash
 */
class HashPackageTest extends eMacrosTest {
	public function testMd51() {
		$program = new SimpleProgram('(md5 "abc")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(md5("abc"), $result);
	}
	
	public function testMd52() {
		$program = new SimpleProgram('(Hash::md5 "abc")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(md5("abc"), $result);
	}
	
	public function testMd5File1() {
		$path = __DIR__ . '/../files/resource.db';
		$program = new SimpleProgram('(md5-file (%0))');
		$result = $program->execute(self::$xenv, $path);
		$this->assertEquals(md5_file($path), $result);
	}
	
	public function testMd5File2() {
		$path = __DIR__ . '/../files/resource.db';
		$program = new SimpleProgram('(Hash::md5-file (%0))');
		$result = $program->execute(self::$xenv, $path);
		$this->assertEquals(md5_file($path), $result);
	}
	
	public function testSha1() {
		$program = new SimpleProgram('(sha1 "abc")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(sha1("abc"), $result);
	}
	
	public function testSha2() {
		$program = new SimpleProgram('(Hash::sha1 "abc")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(sha1("abc"), $result);
	}
	
	public function testShaFile1() {
		$path = __DIR__ . '/../files/resource.db';
		$program = new SimpleProgram('(sha1-file (%0))');
		$result = $program->execute(self::$xenv, $path);
		$this->assertEquals(sha1_file($path), $result);
	}
	
	public function testShaFile2() {
		$path = __DIR__ . '/../files/resource.db';
		$program = new SimpleProgram('(Hash::sha1-file (%0))');
		$result = $program->execute(self::$xenv, $path);
		$this->assertEquals(sha1_file($path), $result);
	}
	
	public function testHash1() {
		$program = new SimpleProgram('(hash "ripemd160" "The quick brown fox jumped over the lazy dog.")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(hash('ripemd160', 'The quick brown fox jumped over the lazy dog.'), $result);
	}
	
	public function testHash2() {
		$program = new SimpleProgram('(Hash::hash "ripemd160" "The quick brown fox jumped over the lazy dog.")');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(hash('ripemd160', 'The quick brown fox jumped over the lazy dog.'), $result);
	}
	
	public function testHashFile1() {
		$path = __DIR__ . '/../files/resource.db';
		$program = new SimpleProgram('(file "ripemd160" (%0))');
		$result = $program->execute(self::$xenv, $path);
		$this->assertEquals(hash_file("ripemd160", $path), $result);
	}
	
	public function testHashFile2() {
		$path = __DIR__ . '/../files/resource.db';
		$program = new SimpleProgram('(Hash::file "ripemd160" (%0))');
		$result = $program->execute(self::$xenv, $path);
		$this->assertEquals(hash_file("ripemd160", $path), $result);
	}
	
	public function testHashInit1() {
		$program = new SimpleProgram('(:= _hash (init "md5"))(update _hash "The quick brown fox ")(update _hash "jumped over the lazy dog.")(final _hash)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(md5("The quick brown fox jumped over the lazy dog."), $result);
	}
	
	public function testHashInit2() {
		$program = new SimpleProgram('(:= _hash (Hash::init "md5"))(Hash::update _hash "The quick brown fox ")(Hash::update _hash "jumped over the lazy dog.")(Hash::final _hash)');
		$result = $program->execute(self::$xenv);
		$this->assertEquals(md5("The quick brown fox jumped over the lazy dog."), $result);
	}
}
?>