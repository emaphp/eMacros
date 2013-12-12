<?php
namespace Acme\Runtime;

use eMacros\Runtime\GenericFunction;

class Distance extends GenericFunction {
    public $x;
    public $y;

    public function __construct($coordX, $coordY) {
        $this->x = $coordX;
        $this->y = $coordY;
    }

    /**
     * Calcula la distancia entre 2 puntos
     * Uso: (dist:X1Y7 3 5)
     */
    public function execute(array $args) {
        if (count($args) < 2) {
            throw new \BadFunctionCallException("Distance: Destination not specified.");
        }

        $x = intval($args[0]);
        $y = intval($args[1]);

        $distance = pow($x - $this->x, 2) + pow($y - $this->y, 2);
        return sqrt($distance);
    }
}