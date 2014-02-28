; short_keys.em

;; OBJETOS

; declarar instancia
(:= _os (new stdClass))

; asignar valores (#PROPIEDAD=)
(#nombre= _os "GNU/Linux") ; _os->nombre = "GNU/Linux"
(#familia= _os "Unix-like") ; _os->familia = "Unix-like"

; obtener valores (#PROPIEDAD)
(. "El sistema " (#nombre _os) " es de la familia " (#familia _os))

; comprobar existencia de propiedad (#PROPIEDAD?)
(if (not (#empresa? _os)) " y es libre")

;; ARREGLOS
(:= _arr (array ("program" "keys.em") ("language" "eMacros")))
(. "El programa " (#program _arr) " está escrito en " (#language _arr))

; guardar estado de programa en arreglo
(#estado= _arr "Ejecutando")

; comprobar existencia de clave
(if (#estado? _arr) (. "Estado de programa: " (#estado _arr)) "Estado desconocido")