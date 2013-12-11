; objects.em
; declarar instancia de stdClass
(:= _obj (new stdClass))

; crear instancia de ArrayObject con parámetro
(:= _arr (instance "ArrayObject" (array "uno" "dos" "tres")))

; crear instancia de DOMDocument
(:= _xml (new DOMDocument "1.0" "ISO-8859-1"))