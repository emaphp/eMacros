; symbols.em
; la función sym espera una cadena con el nombre del símbolo y su valor
(sym "_program" "symbols.em") ; agrega el símbolo _program con el valor "symbols.em"
(. "Corriendo programa " _program)

; sym-exists verifica si el símbolo está declarado en la tabla de símbolos
(if (sym-exists "_program") "El símbolo \"_program\" ya existe")

; lookup recupera el valor del símbolo
(. "Finalizando ejecución de " (lookup "_program"))