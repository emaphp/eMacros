; arguments.em
; Este programa realiza el conteo de parametros recibidos

; conteo de parámetros (%#)
(. "Se encontraron un total de " (%#) " parámetros\n")

; obtener parámetros como arreglo (%_)
(. "Parámetros: " (implode "," (%_)))