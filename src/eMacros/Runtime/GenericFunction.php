<?php
namespace eMacros\Runtime;

use eMacros\Applicable;
use eMacros\GenericList;
use eMacros\Scope;
use eMacros\Expression;

abstract class GenericFunction implements Applicable {    
    final public function apply(Scope $scope, GenericList $arguments) {
    	$args = array();
    	
    	foreach ($arguments as $arg) {
    		$args[] = $arg->evaluate($scope);
    	}
    
    	return $this->execute($args);
    }
    
    public function __invoke() {
    	$args = func_get_args();
    	return $this->execute($args);
    }
    
    abstract function execute(array $arguments);
}
