; custom.em
; Muestra el uso de un entorno de ejecución definido por usuario
(<- MY_CONSTANT); retorna 42

; podemos utilizar el nombre de paquete como prefijo
(/ Custom::MY_CONSTANT 2) ; retorna 21

(String::ucfirst message) ; retorna "This is a custom package"