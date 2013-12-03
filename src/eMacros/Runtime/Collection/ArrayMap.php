<?php
namespace eMacros\Runtime\Collection;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;

class ArrayMap implements Applicable {
	/**
	 * Applies a callback to a given array
	 * Usage: (Array::map "strtoupper" (array "a" "b" "c"))
	 * Returns: array
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		$nargs = count($arguments);
		
		if ($nargs == 0) {
			throw new \BadFunctionCallException("ArrayMap: No callback specified.");
		}
		elseif ($nargs == 1) {
			throw new \BadFunctionCallException("ArrayMap: No target specified.");
		}
		
		$op = $arguments[0]->evaluate($scope);
		
		if (is_callable($op)) {
			$args = array();
			$it = $arguments->getIterator();
			$it->rewind();
			
			for ($it->next(); $it->valid(); $it->next()) {
				 $el = $it->current()->evaluate($scope);

				 if ($el instanceof \IteratorAggregate) {
				 	$eit = $el->getIterator();
				 	$eit->rewind();
				 	
				 	$el = array();
				 	
				 	for (;$eit->valid(); $eit->next()) {
				 		$el[] = $eit->current();
				 	}
				 }
				 
				 $args[] = $el;
			}
			
			array_unshift($args, $op);
			
			return call_user_func_array('array_map', $args);
		}
		
		throw new \InvalidArgumentException("ArrayMap: Expected callable as first argument.");
	}
}

?>