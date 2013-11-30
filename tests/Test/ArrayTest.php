<?php
namespace Test;

class ArrayTest {
	public static function cube($n) {
		return($n * $n * $n);
	}
	
	public static function odd($var) {
		return($var & 1);
	}
	
	public static function walk(&$item, $key) {
		$item = ($key + 1) . " - " . $item;
	}
	
	public static function rsum($v, $w) {
	    $v += $w;
	    return $v;
	}
}
?>