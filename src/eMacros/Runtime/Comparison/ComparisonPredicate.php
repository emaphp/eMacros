<?php
namespace eMacros\Runtime\Comparison;

use eMacros\Runtime\GenericFunction;

abstract class ComparisonPredicate extends GenericFunction {
	protected $logicalOr = false;
	
	protected function execute(array $operands) {
		if (empty($operands)) {
			throw new \BadFunctionCallException(sprintf("%s: No objects to compare.", get_class($this)));
		}
		
		if (!isset($operands[1])) {
			throw new \BadFunctionCallException(sprintf("%s: Cannot compare single object.", get_class($this)));
		}
		
		$fst = array_shift($operands);
		$or = $this->logicalOr;
		
		foreach ($operands as $val) {
			if ($or xor !$this->compare($fst, $val)) {
				return $or;
			}
			
			$fst = $val;
		}
	
		return !$or;
	}
	
	abstract protected function compare($a, $b);
}
?>