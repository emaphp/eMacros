; arg_functions.em

; obtener parámetro (%)
(+ 5 (% 0)) ; 5 + 1

; verficar existencia de argumento (%?)
(if (%? 1) (. (% 1) " mundo")) ; "hola mundo"

; forma abreviada (%ARGN) (%ARGN?)
(if (%1?) (. (%1) " mundo")) ; "hola mundo"