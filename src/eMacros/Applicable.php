<?php
namespace eMacros;

interface Applicable {
    public function apply(Scope $scope, GenericList $arguments);
}
