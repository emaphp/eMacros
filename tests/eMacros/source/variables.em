; variables.em

(:= _nulo null) ; _nulo = null
(:= _falso false) ; _falso = false
(:= _verdadero true)

; numeros
(:= _dos 2) ; declarar _dos = 2
(:= _cinco (+ 2 3)) ; declarar _cinco = 2 + 3
(+ _dos _cinco) ; 7

; cadenas
(:= _nombre "pepe")
(:= _mensaje (. "Hola " _nombre)) ; construir mensaje
(<- _mensaje) ; retornar valor de _mensaje

; unset
(unset _nombre)
(<- _nombre) ; NULL