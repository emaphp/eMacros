<?php
namespace eMacros\Runtime\Comparison;

class Identical extends ComparisonPredicate {
	protected function compare($a, $b) {
		return $a === $b;
	}
}
?>