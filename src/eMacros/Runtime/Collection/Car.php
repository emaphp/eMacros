<?php
namespace eMacros\Runtime\Collection;

use eMacros\Runtime\GenericFunction;

class Car extends GenericFunction {
	/**
	 * Returns a list first element
	 * Usage: (Array:car (array 1 2 3))
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    protected function execute(array $arguments) {
    	if (empty($arguments)) {
    		throw new \BadFunctionCallException("Car: No parameters found.");
    	}
    	
        list($list) = $arguments;
        
        if ($list instanceof \Iterator) {
            $list->rewind();
            $value = $list->valid() ? $list->current() : null;
        }
        elseif ($list instanceof \IteratorAggregate) {
            $iter = $list->getIterator();
            $iter->rewind();
            $value = $iter->valid() ? $iter->current() : null;
        }
        elseif (is_array($list)) {
            $value = !empty($list) ? array_shift($list) : null;
        }
        elseif ($list instanceof \ArrayAccess) {
        	//cannot ensure which is the first element, return index 0
        	$value = isset($list[0]) ? $list[0] : null;
        }
        else {
            throw new \InvalidArgumentException('Car: Parameter is not a list.');
        }
        
        return $value;
    }
}
