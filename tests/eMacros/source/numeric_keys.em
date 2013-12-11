; numeric_keys.em
(:= _arr (array))
(#0= _arr "Primer elemento")
(#-2= _arr "Indice -2")

(if (not (#1? _arr)) "No se encontró ningún elemento en la posición 1")

(. "El primer elemento es " (#0 _arr))