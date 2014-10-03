<?php
namespace eMacros\Runtime\Filter;

use eMacros\Runtime\GenericFunction;

class FilterHasVar extends GenericFunction {
	/**
	 * Filter types
	 * @var array
	 */
	public static $filter_types = [INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV, INPUT_SESSION];
	
	/**
	 * Checks whether a given index is defined on a global array
	 * Usage: (has-var POST 'message')
	 * Returns: boolean
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) throw new \BadFunctionCallException("FilterHasVar: No parameters found.");
		if (!isset($arguments[1])) throw new \BadFunctionCallException("FilterHasVar: No filter has been defined.");
		if (!in_array($arguments[0], self::$filter_types))
			throw new \InvalidArgumentException(sprintf("FilterHasVar: Filter type '%s' ", strval($arguments[0])));
		return filter_has_var(self::$filter_types[$arguments[0]], $arguments[1]);
	}
}
?>