; use_example.em
; Ejemplos de utilización de use

; importar utf8_decode a la tabla de símbolos
(use utf8_decode)
(:= _decoded (utf8_decode (%0)))

; alias
(use (utf8_encode utf8enc))
(:= _encoded (utf8enc _decoded))

; multiples símbolos
(use mb_detect_encoding mb_internal_encoding (mb_get_info mbinfo))