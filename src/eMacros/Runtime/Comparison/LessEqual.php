<?php
namespace eMacros\Runtime\Comparison;

class LessEqual extends ComparisonPredicate {
    protected function compare($a, $b) {
        return $a <= $b;
    }
}
