<?php
namespace eMacros\Runtime\Filter;

use eMacros\Runtime\GenericFunction;

class FilterHasVar extends GenericFunction {
	/**
	 * Filter types
	 * @var array
	 */
	public static $filter_types = array(INPUT_GET, INPUT_POST, INPUT_COOKIE, INPUT_SERVER, INPUT_ENV, INPUT_SESSION);
	
	/**
	 * Usage: (has-var POST 'message')
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
	public function execute(array $arguments) {
		if (empty($arguments)) {
			//no args
			throw new \BadFunctionCallException("FilterHasVar: No parameters found.");
		}
		
		if (!isset($arguments[1])) {
			//no filter defined
			throw new \BadFunctionCallException("FilterHasVar: No filter has been defined.");
		}
		
		if (!in_array($arguments[0], self::$filter_types)) {
			//unknown filter
			throw new \InvalidArgumentException(sprintf("FilterHasVar: Filter type '%s' ", strval($arguments[0])));
		}
		
		return filter_has_var(self::$filter_types[$arguments[0]], $arguments[1]);
	}
}
?>