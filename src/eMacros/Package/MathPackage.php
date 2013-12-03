<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;
use eMacros\Runtime\Type\IsType;

class MathPackage extends Package {
	public function __construct() {
		parent::__construct('Math');
		
		//general functions
		$this['abs'] = new PHPFunction('abs');
		$this['pow'] = new PHPFunction('pow');
		$this['sqrt'] = new PHPFunction('sqrt');
		$this['exp'] = new PHPFunction('exp');
		$this['log'] = new PHPFunction('log');
		$this['log10'] = new PHPFunction('log10');
		$this['round'] = new PHPFunction('round');
		$this['floor'] = new PHPFunction('floor');
		$this['ceil'] = new PHPFunction('ceil');
		$this['min'] = new PHPFunction('min');
		$this['max'] = new PHPFunction('max');
		$this['rand'] = new PHPFunction('rand');
		$this['srand'] = new PHPFunction('srand');
		$this['mt-rand'] = new PHPFunction('mt_rand');
		$this['mt-srand'] = new PHPFunction('mt_srand');
		$this['pi'] = new PHPFunction('pi');
		$this['fmod'] = new PHPFunction('fmod');
		
		//representation functions
		$this['decbin'] = new PHPFunction('decbin');
		$this['bindec'] = new PHPFunction('bindec');
		$this['decoct'] = new PHPFunction('decoct');
		$this['octdec'] = new PHPFunction('octdec');
		$this['dechex'] = new PHPFunction('dechex');
		$this['hexdec'] = new PHPFunction('hexdec');
		
		//trigonometric functions
		$this['sin'] = new PHPFunction('sin');
		$this['cos'] = new PHPFunction('cos');
		$this['tan'] = new PHPFunction('tan');
		$this['asin'] = new PHPFunction('asin');
		$this['acos'] = new PHPFunction('acos');
		$this['atan'] = new PHPFunction('atan');
		
		//constants
		$this['PI']              = M_PI;
		$this['PI_2']            = M_PI_2;
		$this['PI_4']            = M_PI_4;
		$this['E']               = M_E;
		$this['EULER']           = M_EULER;
		$this['ROUND_HALF_UP']   = PHP_ROUND_HALF_UP;
		$this['ROUND_HALF_DOWN'] = PHP_ROUND_HALF_DOWN;
		$this['ROUND_HALF_EVEN'] = PHP_ROUND_HALF_EVEN;
		$this['ROUND_HALF_ODD']  = PHP_ROUND_HALF_ODD;
		
		/**
		 * MACROS
		 */
		$this->macro('/^(finite|infinite|nan)\?$/', function ($matches) {
			return new IsType('is_' . $matches[1]);
		});
	}
}
?>