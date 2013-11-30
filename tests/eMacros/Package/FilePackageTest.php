<?php
namespace eMacros;

use eMacros\Program\SimpleProgram;
use eMacros\Package\FilePackage;
/**
 * 
 * @author emaphp
 * @group file
 */
class FilePackageTest extends eMacrosTest {
	public function testPackage() {
		$package = new FilePackage();
		
		$this->assertEquals(FILE_USE_INCLUDE_PATH, $package['FILE_USE_INCLUDE_PATH']);
		$this->assertEquals(FILE_IGNORE_NEW_LINES, $package['FILE_IGNORE_NEW_LINES']);
		$this->assertEquals(FILE_SKIP_EMPTY_LINES, $package['FILE_SKIP_EMPTY_LINES']);
		$this->assertEquals(INI_SCANNER_NORMAL, $package['INI_SCANNER_NORMAL']);
		$this->assertEquals(INI_SCANNER_RAW, $package['INI_SCANNER_RAW']);
		$this->assertEquals(PATHINFO_DIRNAME, $package['PATHINFO_DIRNAME']);
		$this->assertEquals(PATHINFO_BASENAME, $package['PATHINFO_BASENAME']);
		$this->assertEquals(PATHINFO_EXTENSION, $package['PATHINFO_EXTENSION']);
		$this->assertEquals(PATHINFO_FILENAME, $package['PATHINFO_FILENAME']);
		$this->assertEquals(SCANDIR_SORT_ASCENDING, $package['SCANDIR_SORT_ASCENDING']);
		$this->assertEquals(SCANDIR_SORT_DESCENDING, $package['SCANDIR_SORT_DESCENDING']);
		$this->assertEquals(SCANDIR_SORT_NONE, $package['SCANDIR_SORT_NONE']);
	}
	
	public function testOpen1() {
		$program = new SimpleProgram('(:= _fp (open (%0) "r"))(close _fp)');
		$result = $program->execute(self::$xenv, __DIR__ . '/../source/comments.em');
	}
	
	public function testOpen2() {
		$program = new SimpleProgram('(:= _fp (File::open (%0) "r"))(File::close _fp)');
		$result = $program->execute(self::$xenv, __DIR__ . '/../source/comments.em');
	}
	
	public function testExists1() {
		$program = new SimpleProgram('(exists (%0))');
		$result = $program->execute(self::$xenv, __DIR__ . '/../source/comments.em');
	}
	
	public function testExists2() {
		$program = new SimpleProgram('(File::exists (%0))');
		$result = $program->execute(self::$xenv, __DIR__ . '/../source/comments.em');
	}
	
	public function testGetContents1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(get-contents (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(file_get_contents($filename), $result);
	}
	
	public function testGetContents2() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(File::get-contents (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(file_get_contents($filename), $result);
	}
	
	//TODO: test put-contents
	
	public function testRead1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(:= _fp (open (%0) "r"))
									  (:= _buff (read _fp 10))
									  (close _fp)
									  (<- _buff)');
		$result = $program->execute(self::$xenv, $filename);
		$fp = fopen($filename, "r");
		$this->assertEquals(fread($fp, 10), $result);
		fclose($fp);
	}
	
	public function testRead2() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(:= _fp (File::open (%0) "r"))
									  (:= _buff (File::read _fp 10))
									  (File::close _fp)
									  (<- _buff)');
		$result = $program->execute(self::$xenv, $filename);
		$fp = fopen($filename, "r");
		$this->assertEquals(fread($fp, 10), $result);
		fclose($fp);
	}
	
	//TODO: test write
		
	public function testFile1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(File::file (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(file($filename), $result);
	}
	
	public function testSize1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(size (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(filesize($filename), $result);
	}
	
	public function testSize2() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(File::size (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(filesize($filename), $result);
	}
	
	public function testBasename1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(basename (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(basename($filename), $result);
	}
	
	public function testBasename2() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(File::basename (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(basename($filename), $result);
	}
	
	public function testDirname1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(dirname (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(dirname($filename), $result);
	}
	
	public function testDirname2() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(File::dirname (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(dirname($filename), $result);
	}
	
	public function testPathinfo1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(pathinfo (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(pathinfo($filename), $result);
	}
	
	public function testPathinfo2() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(File::pathinfo (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(pathinfo($filename), $result);
	}
	
	public function testRealpath1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(realpath (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(realpath($filename), $result);
	}
	
	public function testRealpath2() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(File::realpath (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(realpath($filename), $result);
	}
	
	public function testStat1() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(stat (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(stat($filename), $result);
	}
	
	public function testStat2() {
		$filename = __DIR__ . '/../source/comments.em';
		$program = new SimpleProgram('(File::stat (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(stat($filename), $result);
	}
	
	public function testParseIniFile1() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(parse-ini-file (%0) true INI_SCANNER_NORMAL)');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(parse_ini_file($filename, true, INI_SCANNER_NORMAL), $result);
	}
	
	public function testParseIniFile2() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(File::parse-ini-file (%0) true File::INI_SCANNER_NORMAL)');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(parse_ini_file($filename, true, INI_SCANNER_NORMAL), $result);
	}
	
	public function testParseIniString1() {
		$contents = file_get_contents(__DIR__ . '/../files/test.ini');
		$program = new SimpleProgram('(parse-ini-string (%0) true INI_SCANNER_NORMAL)');
		$result = $program->execute(self::$xenv, $contents);
		$this->assertEquals(parse_ini_string($contents, true, INI_SCANNER_NORMAL), $result);
	}
	
	public function testParseIniString2() {
		$contents = file_get_contents(__DIR__ . '/../files/test.ini');
		$program = new SimpleProgram('(File::parse-ini-string (%0) true File::INI_SCANNER_NORMAL)');
		$result = $program->execute(self::$xenv, $contents);
		$this->assertEquals(parse_ini_string($contents, true, INI_SCANNER_NORMAL), $result);
	}
	
	public function testIsDir1() {
		$program = new SimpleProgram('(is-dir (%0))');
		$result = $program->execute(self::$xenv, __DIR__);
		$this->assertTrue($result);
	}
	
	public function testIsDir2() {
		$program = new SimpleProgram('(File::is-dir (%0))');
		$result = $program->execute(self::$xenv, __DIR__);
		$this->assertTrue($result);
	}
	
	public function testIsExecutable1() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(is-executable (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertFalse($result);
	}
	
	public function testIsExecutable2() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(File::is-executable (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertFalse($result);
	}
	
	public function testIsFile1() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(is-file (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertTrue($result);
	}
	
	public function testIsFile2() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(File::is-file (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertTrue($result);
	}
	
	public function testIsLink1() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(is-link (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertFalse($result);
	}
	
	public function testIsLink2() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(File::is-link (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertFalse($result);
	}
	
	public function testIsReadable1() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(is-readable (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertTrue($result);
	}
	
	public function testIsReadable2() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(File::is-readable (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertTrue($result);
	}
	
	public function testIsUploadedFile1() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(is-uploaded-file (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertFalse($result);
	}
	
	public function testIsUploadedFile2() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(File::is-uploaded-file (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertFalse($result);
	}
	
	public function testIsWriteable1() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(is-writeable (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(is_writeable($filename), $result);
	}
	
	public function testIsWriteable2() {
		$filename = __DIR__ . '/../files/test.ini';
		$program = new SimpleProgram('(File::is-writeable (%0))');
		$result = $program->execute(self::$xenv, $filename);
		$this->assertEquals(is_writeable($filename), $result);
	}
	
	public function testScandir1() {
		$program = new SimpleProgram('(File::scandir (%0) File::SCANDIR_SORT_DESCENDING)');
		$result = $program->execute(self::$xenv, __DIR__ . '/../files');
		$this->assertEquals('test.ini', $result[0]);
		$this->assertEquals('resource.db', $result[1]);
		$this->assertEquals('..', $result[2]);
		$this->assertEquals('.', $result[3]);
	}
	
	public function testScandir2() {
		$program = new SimpleProgram('(File::scandir (%0) File::SCANDIR_SORT_ASCENDING)');
		$result = $program->execute(self::$xenv, __DIR__ . '/../files');
		$this->assertEquals('test.ini', $result[3]);
		$this->assertEquals('resource.db', $result[2]);
		$this->assertEquals('..', $result[1]);
		$this->assertEquals('.', $result[0]);
	}
}
?>