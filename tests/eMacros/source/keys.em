; keys.em
(:= _arr (array ("program" "keys.em") ("language" "eMacros")))
(. "El programa " (# "program" _arr) " está escrito en " (# "language" _arr))

; guardar estado de programa en arreglo
(#= "estado" _arr "Ejecutando")

; comprobar existencia de clave
(if (#? "estado" _arr) (. "Estado de programa: " (# "estado" _arr)) "Estado desconocido")