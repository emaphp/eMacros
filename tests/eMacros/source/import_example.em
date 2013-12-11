; import_example.em
; Ejemplos de uso de import

; import MathPackage class
(import eMacros\Package\MathPackage)
(:= _sin (sin Math::PI_2))

; si la clase no existe import intenta recuperarla del paquete eMacros\Package (agregando Package al final)
(import CType)
(if (digit (%0)) "El parámetro es un dígito" "El parámetro no es un dígito")