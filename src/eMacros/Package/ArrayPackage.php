<?php
namespace eMacros\Package;

use eMacros\Runtime\PHPFunction;
use eMacros\Runtime\Collection\Car;
use eMacros\Runtime\Collection\Cdr;
use eMacros\Runtime\Collection\ArrayPop;
use eMacros\Runtime\Collection\ArrayMap;
use eMacros\Runtime\Collection\ArrayWalk;
use eMacros\Runtime\Collection\ArrayPush;
use eMacros\Runtime\Collection\ArrayShift;
use eMacros\Runtime\Collection\ArrayUnshift;
use eMacros\Runtime\Collection\ArrayShuffle;
use eMacros\Runtime\Collection\ArraySort;

class ArrayPackage extends Package {
	public function __construct() {
		parent::__construct('Array');
		
		//array functions
		$this['in'] = new PHPFunction('in_array');
		$this['count'] = new PHPFunction('count');
		$this['range'] = new PHPFunction('range');
		$this['chunk'] = new PHPFunction('array_chunk');
		$this['combine'] = new PHPFunction('array_combine');
		$this['count-values'] = new PHPFunction('array_count_values');
		$this['diff'] = new PHPFunction('array_diff');
		$this['fill'] = new PHPFunction('array_fill');
		$this['filter'] = new PHPFunction('array_filter');
		$this['flip'] = new PHPFunction('array_flip');
		$this['intersect'] = new PHPFunction('array_intersect');
		$this['keys'] = new PHPFunction('array_keys');
		$this['merge'] = new PHPFunction('array_merge');
		$this['search'] = new PHPFunction('array_search');
		$this['slice'] = new PHPFunction('array_slice');
		$this['pad'] = new PHPFunction('array_pad');
		$this['rand'] = new PHPFunction('array_rand');
		$this['product'] = new PHPFunction('array_product');
		$this['sum'] = new PHPFunction('array_sum');
		$this['unique'] = new PHPFunction('array_unique');
		$this['values'] = new PHPFunction('array_values');
		$this['reduce'] = new PHPFunction('array_reduce');
		$this['replace'] = new PHPFunction('array_replace');
		$this['reverse'] = new PHPFunction('array_reverse');
		
		if (function_exists('array_column'))
			$this['column'] = new PHPFunction('array_column');
		
		//macros
		$this['car'] = new Car();
		$this['cdr'] = new Cdr();
		$this['pop'] = new ArrayPop();
		$this['map'] = new ArrayMap();
		$this['walk'] = new ArrayWalk();
		$this['push'] = new ArrayPush();
		$this['shift'] = new ArrayShift();
		$this['unshift'] = new ArrayUnshift();
		$this['shuffle'] = new ArrayShuffle();
		
		//sort
		$this['sort'] = new ArraySort('sort');
		$this['rsort'] = new ArraySort('rsort');
		//preserve association sort
		$this['asort'] = new ArraySort('asort');
		$this['arsort'] = new ArraySort('arsort');
		//key sort
		$this['ksort'] = new ArraySort('ksort');
		$this['krsort'] = new ArraySort('krsort');
		//callable sort
		$this['usort'] = new ArraySort('usort');
		$this['uasort'] = new ArraySort('uasort');
		$this['uksort'] = new ArraySort('uksort');
		
		//count constants
		$this['COUNT_NORMAL'] = COUNT_NORMAL;
		$this['COUNT_RECURSIVE'] = COUNT_RECURSIVE;
		
		//sort constants
		$this['SORT_REGULAR'] = SORT_REGULAR;
		$this['SORT_NUMERIC'] = SORT_NUMERIC;
		$this['SORT_STRING'] = SORT_STRING;
		$this['SORT_LOCALE_STRING'] = SORT_LOCALE_STRING;
		$this['SORT_NATURAL'] = SORT_NATURAL;
		$this['SORT_FLAG_CASE'] = SORT_FLAG_CASE;
	}
}
?>
