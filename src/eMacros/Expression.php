<?php
namespace eMacros;

interface Expression {
	public function evaluate(Scope $scope);
}
?>