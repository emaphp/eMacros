<?php
namespace Acme\Runtime;

use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Applicable;
use eMacros\Symbol;

class Increment implements Applicable {
	public function apply(Scope $scope, GenericList $arguments) {
		//comprobar cantidad de parámetros
		$nargs = count($arguments);

		if ($nargs == 0) {
			throw new \BadFunctionCallException("Increment: No parameters found.");
		}

		//comprobar que primer parámetro es símbolo
		if (!($arguments[0] instanceof Symbol)) {
			throw new \InvalidArgumentException("Increment: A symbol is expected as first argument.");
		}

		//obtener nombre de símbolo
		$ref = $arguments[0]->symbol;

		//obtener valor de símbolo
		$value = $arguments[0]->evaluate($scope);

		if ($nargs > 1) {
			$value += intval($arguments[1]->evaluate($scope));
		}
		else {
			$value++;
		}

		$scope->symbols[$ref] = $value;
		return true;
	}
}