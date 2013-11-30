<?php
namespace eMacros\Runtime\Comparison;

class NotEqual extends ComparisonPredicate {
    protected $logicalOr = true;

    protected function compare($a, $b) {
        return $a != $b;
    }
}
