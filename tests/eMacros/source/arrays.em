; arrays.em
; crear arreglo de enteros
(:= _lista (array 1 2 3 4 5))
(. "_lista posee " (count _lista) " elementos")

; setear claves
(:= _data (array ("nombre" "juan") ("apellido" "perez") ("ocupacion" "desarrollador")))