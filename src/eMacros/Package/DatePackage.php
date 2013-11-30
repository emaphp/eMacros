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
		$this['dt'] = function($date = null) {
			if (!empty($date)) {
				$rc = new \ReflectionClass('\\DateTime');
				return $rc->newInstance($date);
			}
			
			return new \DateTime;
		};
		
		$this['now'] = function() {				
			return new \DateTime;
		};
		
		//DateInterval instance builder
		$this['interval'] = function($interval = null) {
			if (empty($interval)) {
				throw new \BadFunctionCallException("interval: No interval specified.");
			}
			
			return new \DateInterval($interval);
		};
		
		//DateTimeZone
		$this['tz'] = function($tz = null) {
			if (empty($tz)) {
				throw new \BadFunctionCallException("tz: No timezone specified.");
			}
			
			return new \DateTimeZone($tz);
		};
	}
}
?>