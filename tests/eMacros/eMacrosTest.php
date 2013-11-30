<?php
namespace eMacros;

use eMacros\Environment\DefaultEnvironment;
use eMacros\Environment\ExtendedEnvironment;
use eMacros\Environment\Environment;
use eMacros\Package\CorePackage;

abstract class eMacrosTest extends \PHPUnit_Framework_TestCase {
	public static $env;
	public static $xenv;
	public static $benv;
	
	public static function setUpBeforeClass() {
		self::$env = new DefaultEnvironment();
		self::$xenv = new ExtendedEnvironment();
		self::$benv = new Environment();
		self::$benv->import(new CorePackage());
	} 
}
?>