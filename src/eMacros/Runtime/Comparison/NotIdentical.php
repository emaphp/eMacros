<?php
namespace eMacros\Runtime\Comparison;

class NotIdentical extends ComparisonPredicate {
    protected $logicalOr = true;

    protected function compare($a, $b) {
        return $a !== $b;
    }
}
