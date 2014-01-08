<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;

class DatePackage extends Package {
	public function __construct() {
		parent::__construct('Date');
		
		//date/time functions
		$this['time'] = new PHPFunction('time');
		$this['microtime'] = new PHPFunction('microtime');
		$this['check-date'] = new PHPFunction('checkdate');
		$this['get-date'] = new PHPFunction('getdate');
		$this['date'] = new PHPFunction('date');
		$this['mktime'] = new PHPFunction('mktime');
		$this['date-create'] = new PHPFunction(array('DateTime', 'createFromFormat'));
		$this['date-parse'] = new PHPFunction('date_parse');
		$this['interval-create'] = new PHPFunction(array('DateInterval', 'createFromDateString'));
		
		//string + date functions
		$this['to-time'] = new PHPFunction('strtotime');
		$this['parse-time'] = new PHPFunction('strptime');
		$this['format-time'] = new PHPFunction('strftime');
		
		//DateTime instance builder
		$this['dt'] = function($date, \DateTimeZone $tz = null) {
			if (is_null($tz)) {
				return new \DateTime($date);
			}
						
			return new \DateTime($date, $tz);
		};
		
		//DateTime instance builder (now)
		$this['now'] = function(\DateTimeZone $tz = null) {
			if (is_null($tz)) {
				return new \DateTime('now');
			}
						
			return new \DateTime('now', $tz);
		};
		
		//DateInterval instance builder
		$this['interval'] = function($interval) {
			if (!is_string($interval) || empty($interval)) {
				throw new \BadFunctionCallException("interval: No valid interval specified.");
			}
			
			return new \DateInterval($interval);
		};
		
		//DateTimeZone instance builder
		$this['tz'] = function($tz) {
			if (!is_string($tz) || empty($tz)) {
				throw new \BadFunctionCallException("tz: No valid timezone specified.");
			}
			
			return new \DateTimeZone($tz);
		};
	}
}
?>