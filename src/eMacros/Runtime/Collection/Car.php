<?php
namespace eMacros\Runtime\Collection;

use eMacros\Runtime\GenericFunction;

class Car extends GenericFunction {
	/**
	 * Returns the head element on a list
	 * Usage: (Array:car (array 1 2 3))
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    public function execute(array $arguments) {
    	if (empty($arguments)) throw new \BadFunctionCallException("Car: No parameters found.");
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
        elseif (is_array($list))
        	$value = !empty($list) ? array_shift($list) : null;
        elseif ($list instanceof \ArrayAccess)
        	$value = isset($list[0]) ? $list[0] : null;
        else
        	throw new \InvalidArgumentException('Car: Parameter is not a list.');
        return $value;
    }
}
