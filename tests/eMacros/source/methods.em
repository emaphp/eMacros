; methods.em
(:= _nombres (new ArrayObject (array "juan" "carlos" "pedro")))
(-> "count" _nombres) ; 3

; forma abreviada
(->count _nombres)

; parámetros
; (now) obtiene un objeto Datetime con la fecha actual (ver DatePackage)
(->format (now) "Y-m-d H:i") ; fecha actual con formato abreviado