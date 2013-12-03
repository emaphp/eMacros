<?php
namespace eMacros\Runtime\Collection;

use eMacros\Runtime\GenericFunction;

class Cdr extends GenericFunction {
	/**
	 * Returns a list without its first element
	 * Usage: (Array::cdr (array 1 2 3))
	 * Returns: array
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) {
			throw new \BadFunctionCallException("Cdr: No parameters found.");
		}
		
		list($list) = $arguments;
		
		if (is_array($list)) {
			if (empty($list)) {
				return null;
			}
			
			return array_slice($list, 1);
		}
		
		if ($list instanceof \Iterator || $list instanceof \IteratorAggregate) {
			$it = $list instanceof \Iterator ? $list : $list->getIterator();
			$it->rewind();
			
			//empty list?
			if (!$it->valid()) {
				return null;
			}
			
			$result = array();
			
			for ($it->next(); $it->valid(); $it->next()) {
				$result[] = $it->current();
			}
		
			return $result;
		}
		
		throw new \InvalidArgumentException('Cdr: Parameter is not a list.');
	}
}
?>