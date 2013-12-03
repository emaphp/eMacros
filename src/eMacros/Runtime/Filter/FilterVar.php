<?php
namespace eMacros\Runtime\Filter;

use eMacros\Runtime\GenericFunction;

class FilterVar extends GenericFunction {
	/**
	 * Filters a value according to a specified filter
	 * Usage: (var 'yes' 'boolean')
	 * Returns: mixed
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) {
			//no args
			throw new \BadFunctionCallException("FilterVar: No parameters found.");
		}
		
		if (!isset($arguments[1])) {
			//no filter defined
			throw new \BadFunctionCallException("FilterVar: No filter has been defined.");
		}
		
		if (!in_array($arguments[1], filter_list())) {
			//unrecognized filter
			throw new \InvalidArgumentException(sprintf("FilterVar: '%s' is not a valid filter.", strval($arguments[1])));
		}
		
		return filter_var($arguments[0], filter_id($arguments[1]));
	}
}
?>