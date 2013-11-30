<?php
namespace eMacros\Runtime\String;

use eMacros\Runtime\GenericFunction;

class Concatenation extends GenericFunction {
	/**
	 * Concatenates a list of strings
	 * Usage: (. 'Hello ' 'World')
	 * (non-PHPdoc)
	 * @see \eMacros\Runtime\GenericFunction::execute()
	 */
    protected function execute(array $arguments) {
        if (isset($arguments[0])) {
        	return implode('', $arguments);
        }
        
        return '';
    }
}
