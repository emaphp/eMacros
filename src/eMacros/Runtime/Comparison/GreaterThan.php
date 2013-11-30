<?php
namespace eMacros\Runtime\Comparison;

class GreaterThan extends ComparisonPredicate {
    protected function compare($a, $b) {
        return $a > $b;
    }
}
