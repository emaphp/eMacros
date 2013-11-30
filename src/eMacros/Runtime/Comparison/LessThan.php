<?php
namespace eMacros\Runtime\Comparison;

class LessThan extends ComparisonPredicate {
    protected function compare($a, $b) {
        return $a < $b;
    }
}
