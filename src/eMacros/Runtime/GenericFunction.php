<?php
namespace eMacros\Runtime;

use eMacros\Applicable;
use eMacros\GenericList;
use eMacros\Scope;
use eMacros\Expression;

abstract class GenericFunction implements Applicable {
    public $scope, $parameters, $body;
    
    /*public function __construct(Scope $scope, GenericList $parameters, Expression $body) {
    	$this->scope = $scope;
    	$this->parameters = $parameters;
    	$this->body = $body;
    }*/
    
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
    
    protected function execute(array $arguments) {
    	$local = new Scope($this->scope);
    	
    	foreach ($this->parameters as $i => $name) {
    		if (!array_key_exists($i, $arguments)) {
    			throw new \InvalidArgumentException('too few arguments');
    		}
    		
    		$local->let($name, $arguments[$i]);
    	}
    	
    	$local->let('#arguments', new GenericList($arguments));
    	
    	foreach ($this->body as $form) {
    		$retval = $form->evaluate($local);
    	}
    
    	return $retval;
    }
}
