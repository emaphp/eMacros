; properties.em
; declarar instancia
(:= _os (new stdClass))

; asignar valores (#=)
(#= "nombre" _os "GNU/Linux") ; _os->nombre = "GNU/Linux"
(#= "familia" _os "Unix-like") ; _os->familia = "Unix-like"

; obtener valores (#)
(. "El sistema " (# "nombre" _os) " es de la familia " (# "familia" _os))

; comprobar existencia de propiedad (#?)
(if (not (#? "empresa" _os)) " y es libre")