; ambiguos.em

; reverse
(reverse "abcde") ; "edcba"
(Array::reverse (array "uno" "dos" "tres")) ; ["tres" "dos" "uno"]
(String::reverse "xyz") ; "zyx"

; arreglo auxiliar
(:= _arr (array 1 2 3))

; shuffle
(shuffle "abcde") ; shuffle en paquete String
(Array::shuffle _arr) ; shuffle en paquete Array
(String::shuffle "xyz") ; shuffle en paquete String
