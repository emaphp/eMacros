<?php
namespace eMacros\Runtime\Comparison;

class Equal extends ComparisonPredicate {
	protected function compare($a, $b) {
		return $a == $b;
	}
}
?>