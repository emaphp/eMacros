<?php
namespace eMacros\Runtime\Comparison;

class GreaterEqual extends ComparisonPredicate {
	protected function compare($a, $b) {
		return $a >= $b;
	}
}
?>