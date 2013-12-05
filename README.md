eMacros
=======

The Extensible Macros Library for PHP

**Author**: Emmanuel Antico<br/>
**Last Modification**: 05/12/2013

<br/>
*Documentation still in progress...*

<br/>

##Descripción
<br/>

eMacros es una librería escrita en PHP y basada en [lisphp](https://github.com/lisphp/lisphp "") que incorpora un intérprete de dialecto LISP customizable.

<br/>

##Caraterísticas
<br/>

A diferencia de lisphp, eMacros está orientada a aplicaciones embebidas dentro de PHP, por lo que no cuenta con un comando de consola. eMacros fue desarrollado con la idea de poder generar texto dinamicamente en los casos donde la funciones de formato de texto no fueran lo suficientemente complejas, pero puede resultar de utilidad en otros escenarios.

<br/>

##Requerimientos
<br/>
Es neceario contar con una versión actualizada de PHP 5.4.

<br/>

##Instalación
<br>


La instalación de eMacros se realiza a través de Composer. Agregar el siguiente archivo a la carpeta del proyecto y realizar la instalación habitual [descrita aquí](http://getcomposer.org/doc/00-intro.md#installation-nix "").

**composer.json**

```json
{
    "require": {
        "emacros/emacros": "dev-master"
    }
}
```
<br/>

##Primeros pasos

<br/>
El siguiente ejemplo muestra la implementación de un programa en eMacros sencillo que calcula la suma de 2 números.

```php
<?php
include 'vendor/autoload.php';

use eMacros\Program\SimpleProgram;
use eMacros\Environment\DefaultEnvironment;

//instanciar programa
$program = new SimpleProgram('(+ 3 7)');

//ejecutar programa
$result = $program->execute(new DefaultEnvironment);

//mostrar resultados
echo $result; //imprime el número 10 por pantalla
?>
```
Este script comienza creando una nueva instancia de programa a la cual se le pasa el código a ser interpretado y "compilado". Para realizar la ejecución de un programa es necesario definir el entorno donde se ejecutará. El método *execute* realiza la ejecución de un programa en el entorno pasado como parámetro. El resultado obtenido es luego devuelto.

<br/>
En caso de que el código fuentes del programa sea inválido una excepción de tipo *eMacros\Exception\ParseException* será lanzada al interpretarlo. Existen varios tipos de programas, cada uno de estos programas puede generar distintos tipos de resultados de acuerdo a las instrucciones ejecutadas. La clase *SimpleProgram* define el tipo más sencillo de programa. Esta clase devuelve el resultado de la última instrucción ejecutada. En caso de que hubieramos instanciado el programa de la siguiente manera, el resultado hubiera sido diferente.

```php
$program = new SimpleProgram('(+ 3 7)(- 6 3)');
```

Dado que *SimpleProgram* obtiene siempre el último resultado generado, en lugar de 10 la ejecución hubiera mostrado un 3, es decir, el resultado de restar 3 a 6.

<br/>
En caso de que se quiera almacenar todos los resultados obtenidos de cada expresión podemos utilizar la clase *ListProgram*. Esta clase va almacenando cada resultado generado en un arreglo. El resultado obtenido de ejecutar un *ListProgram* es un arreglo con tantos valores como expresiones (no anidadas) se hayan evaluado.

```php
<?php
include 'vendor/autoload.php';

use eMacros\Program\ListProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new ListProgram('(+ 3 7)(- 6 (+ 1 2))');
$result = $program->execute(new DefaultEnvironment);

echo $result[0]; //imprime 10
echo $result[1]; //imprime 3
?>
```

Ademas de estas 2 clases también contamos con *TextProgram*. La clase *TextProgram* obtiene el resultado de concatenar el resultado de evaluar cada expresión dentro de un programa. El siguiente programa realiza la concatenación de 2 expresiones para generar un mensaje. Este programa también introduce el operador de concatenación.

```php
<?php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new TextProgram('(. "Hel" "lo" " ")(. "Wo" "rld")');
$result = $program->execute(new DefaultEnvironment);

echo $result; //imprime la cadena "Hello World"
?>
```
<br/>

##La clase DefaultEnvironment

<br/>

La clase *eMacros\Environment\DefaultEnvironment* define un entorno por defecto donde las aplicaciones eMacros pueden ejecutarse. Un entorno define el listado de operaciones que van a poder interpretarse. Esto va desde las operaciones simples como las aritméticas (+, -, \*, /) como las más complejas (if, or, @nombre, Array::reverse). La forma de definir estos símbolos es a través del **importado de paquetes**. Si nos fijamos en la implementación de esta clase veremos lo siguiente:

```php
<?php
namespace eMacros\Environment;

use eMacros\Package\CorePackage;
use eMacros\Package\StringPackage;
use eMacros\Package\ArrayPackage;
use eMacros\Package\RegexPackage;
use eMacros\Package\DatePackage;

class DefaultEnvironment extends Environment {
	public function __construct() {
		$this->import(new CorePackage);
		$this->import(new StringPackage);
		$this->import(new ArrayPackage);
		$this->import(new RegexPackage);
		$this->import(new DatePackage);
	}
}
?>
```

Las clases *CorePackage*, *StringPackage*, *ArrayPackage*, etc son clases que definen un listado de símbolos y operaciones a ser usados dentro de un programa. Al importar un paquete dentro de un entorno hacemos posible la utilización de los símbolos y operaciones definidos dentro del paquete en un programa.

<br/>
La clase DefaultEnvironment incorpora los paquetes para funciones de cadenas, arreglos, fechas y expresiones regulares, por lo que resulta ideal para empezar a experimentar por nuestra cuenta. El resto de los paquetes pueden encontrarse dentro del namespace *eMacros\Package*.

<br/>

##Corriendo programas desde archivos

<br/>

Los programas también pueden cargarse desde archivos en caso de que resulte más comodo. Tener el código de la aplicación en otro archivo resulta provechoso a la hora de agregar comentarios, lo que mejora la legibilidad del mismo. Este programa de ejemplo es similar al anterior, excepto que también retorna la versión de PHP corriendo en sistema.

```lisp
; hello_world.em
; Esto es un comentario
(. "Hola" " Mundo!" "\n") ; otro comentario
(. "Este script corre bajo PHP " PHP_VERSION "\n") 
; FIN
```

La única modificación a agregar es utilizar la función *file_get_contents* para obtener el código fuente.

```php
<?php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new TextProgram(file_get_contents('hello_world.em'));
$result = $program->execute(new DefaultEnvironment);

echo $result;
?>
```

<br/>

##La clase CorePackage

<br/>

La clase *eMacros\Package\CorePackage* resulta esencial para la generación de ambientes de ejecución de programas. Entre los elementos que se agregan con este paquete se encuentran:

* Los símbolos *null*, *true* y *false*.
* Operadores de comparación, aritméticos y lógicos.
* Funciones de manejo de variables y símbolos.
* Funciones de clases y objetos.
* Funciones para manejo de argumentos.
* Funciones para manejos de tipos.
* Etc.

<br/>
Como se observa, la funcionalidad de este paquete es muy básica por lo que se recomienda contar con la misma en el caso de definir un entorno customizado. A continuación se hará una breve reseña de las capacidades de este paquete.

<br/>

#####Operadores de comparación


```lisp
; comparison.em
; Los operadores de comparación devuelven siempre un valor booleano

; igual
(== 1 "1") ; igual a
(!= 1 2) ; distinto a

; identico
(=== 1 1) ; identico a
(!== 1 "1") ; no identico a

; mayor
(> 6 4) ; mayor que
(>= 4 4) ; mayor igual que

; menor
(< 3 4) ; menor que
(<= 3 3) ; menor igual que
```

<br/>

#####Operadores lógicos

```lisp
; logical.em

; AND y OR
(and true true) ; AND lógico
(or false true) ; OR lógico

; pueden evaluarse varios parámetros
(and true true false true)

; NOT
(not true)

; IF
; if [CONDITION] [VALUE_TRUE]
; if [CONDITION] [VALUE_TRUE] [VALUE_FALSE]
(if true "Es verdadero") ; devuelve "Es verdadero"
(if false "Es verdadero" "Es falso") ; devuelve "Es falso"
(if false "Es verdadero") ; devuelve NULL

; COND
; cond busca el primer elemento no falso de un listado y devuelve el valor asociado
(cond (false 1)) ; devuelve NULL
(cond (false 1) (true 2) (false 3) (true 4)) ; devuelve 2
```

<br/>

#####Operadores aritméticos

```lisp
; arithmetic.em

; suma y resta
(+ (- 10 6) 6  1) ; 11

; multiplicación y división
(* 4 (/ 10 5)) ; 8

; modulo
(mod 10 3) ; 1
```

<br/>

#####Operadores binarios

```lisp
; binary.em

; OR
; 1010 | 0110
(| 10 6) ; 14

; AND
; 0101 & 1110
(& 5 14) ; 4
```

<br/>

#####Funciones de tipo

```lisp
; types.em

; obtener tipo
(type-of 4) ; "integer"

; comprobar tipo
(int? 4) ; true

; múltiples parametros
(string? "" "hola" "mundo") ; true
(int? 5 3 "x") ; false

; vacio
(empty "") ; true
(empty 1) ; false
(empty false 0) ; true
```


<br/>

#####Conversión

```lisp
; casting.em

; as-TYPE
(as-int "123") ; 123
(as-float "345.25") ; 345.25

; strval
(strval true) ; "1"

; intval
(intval 34.55) ; 34

; floatval
(floatval "13.45") ; 13.45

; boolval (solo PHP 5.5)
(boolval 0) ; false
```

<br/>

##Variables

<br/>
La declaración de una variable agrega un símbolo a la tabla del símbolos del entono de ejecución. Para agregar una variable con un valor de inicialización utilizamos el operador de asignación.


```lisp
; variables.em

(:= _nulo null) ; _nulo = null
(:= _falso false) ; _falso = false
(:= _verdadero true)

; numeros
(:= _dos 1) ; declarar _dos = 1
(:= _cinco (+ 2 3)) ; declarar _cinco = 2 + 3
(+ _dos _cinco) ; 7

; cadenas
(:= _nombre "pepe")
(:= _mensaje (. "Hola " _nombre)) ; construir mensaje
(<- _mensaje) ; retornar valor de _mensaje

; unset
(unset _nombre)
(<- _nombre) ; NULL
```
Alternativamente podemos utilizar las funciones de maipulación de simbolos: *sym*, *sym-exists* y *lookup*.

```lisp
; symbols.em
; la función sym espera una cadena con el nombre del símbolo y su valor
(sym "_program" "variables.em") ; agrega el símbolo _program con el valor "variables.em"
(. 'Corriendo programa ' _program)

; sym-exists verifica si el símbolo está declarado en la tabla de símbolos
(if (sym-exists "_program") "El símbolo \"_program\" ya existe")

; lookup recupera el valor del símbolo
(. "Finalizando ejecución de " (lookup "_program"))
```

<br/>

##Arreglos y objetos

<br/>
Los arreglos se crean a través de la función *array*. Es posible definir sus valores mediante pares clave-valor.

```lisp
; arrays.em
; crear arreglo de enteros
(:= _lista (array 1 2 3 4 5))
(. "_lista posee " (count _lista) " elementos")

; setear claves
(:= _data (array ("nombre" "juan") ("apellido" "perez") ("ocupacion" "desarrollador")))
```
Para la creación de objectos contamos con 2 funciones: *new* y *instance*. La diferencia entre estas 2 es que *new* esperea el nombre de la clase definido como símbolo mientras que *instance* espera una cadena.

```lisp
; objects.em
; declarar instancia de stdClass
(:= _obj (new stdClass))

; crear instancia de ArrayObject con parámetro
(:= _arr (instance "ArrayObject" (array "uno" "dos" "tres")))

; crear instancia de DOMDocument
(:= _xml (new DOMDocument "1.0" "ISO-8859-1"))
```
Para trabajar con las claves y propiedades de arreglos/objetos contamos con 3 operadores de asignación, comprobación y obtención.

```lisp
; properties.em
; declarar instancia
(:= _os (new stdClass))

; asignar valores (@=)
(@= "nombre" _os "GNU/Linux") ; _os->nombre = "GNU/Linux"
(@= "familia" _os "Unix-like") ; _os->familia = "Unix-like"

; obtener valores (@)
(. "El sistema " (@ "nombre" _os) " es de la familia " (@ "familia" _os))

; comprobar existencia de propiedad (@?)
(if (not (@? "empresa" _os)) " y es libre")
```

Los arreglos cuentan con un operador adicional para agregación de elementos.
```lisp
; keys.em
(:= _arr (array ("program" "keys.em") ("language" "eMacros")))
(. "El programa " (@ "program" _arr) " está escrito en " (@ "language" _arr))

; guardar estado de programa en arreglo
(@= "estado" _arr "Ejecutando")

; comprobar existencia de clave
(if (@? "estado" _arr) (. "Estado de programa: " (@ "estado" _arr)) "Estado desconocido")

; agregar elementos (@+)
(:= _numeros (array))
(@+ 1 2 3 4 5 _numeros) ; la referencia va siempre al final
(. "Numeros: " (implode "," _numeros))
```
La clase *CorePackage* define un método abreviado para el acceso a claves en arreglos y objetos.

```lisp
; short_keys.em

;; OBJETOS

; declarar instancia
(:= _os (new stdClass))

; asignar valores (@PROPIEDAD=)
(@nombre= _os "GNU/Linux") ; _os->nombre = "GNU/Linux"
(@familia= _os "Unix-like") ; _os->familia = "Unix-like"

; obtener valores (@PROPIEDAD)
(. "El sistema " (@nombre _os) " es de la familia " (@familia _os))

; comprobar existencia de propiedad (@PROPIEDAD?)
(if (not (@empresa? _os)) " y es libre")

;; ARREGLOS
(:= _arr (array ("program" "keys.em") ("language" "eMacros")))
(. "El programa " (@program _arr) " está escrito en " (@language _arr))

; guardar estado de programa en arreglo
(@estado= _arr "Ejecutando")

; comprobar existencia de clave
(if (@estado? _arr) (. "Estado de programa: " (@estado _arr)) "Estado desconocido")
```
Para el caso particular de índices numéricos debe reemplazarse '@' por '#'.

```lisp
; numeric_keys.em
(:= _arr (array))
(#0= "Primer elemento")
(#-2= "Indice -2")

(if (not (#1? _arr)) "No se encontró ningún elemento en la posición 1")

(. "El primer elemento es " (#0 _arr))
```

<br/>

#####Funciones de clase y objetos

```lisp
; class_functions.em
(:= _song (new stdClass))
(@name= _song "Meditango")
(@artist= _song "Astor Piazzolla")
(@genre= _song "Tango")

; get-object-vars
(get-object-vars _song) ; ["name" => "Meditango", "artist" => "Astor Piazzolla", "genre" => "Tango"]

; get-class
(get-class _song) ; "stdClass"

; instance-of
(instance-of _obj stdClass) ; true
(instance-of _obj ArrayObject) ; false

; is-a
(is-a _obj "stdClass") ; true
(is-a _obj "ArrayObject") ; false

; property-exists
(property-exists "eMacros\Symbol" "package") ; true

; method-exists
(method-exists "ArrayObject" "count") ; true

; is-subclass-of
(is-subclass-of "eMacros\Environment\DefaultEnvironment" "eMacros\Scope") ; true

; get-parent-class
(get-parent-class "eMacros\Environment\DefaultEnvironment") ; "eMacros\Environment\Environment"

; get-class-vars
(get-class-vars "eMacros\Literal") ; ["value" => NULL]

; get-class-methods
(get-class-methods "eMacros\Expression") ; ["evaluate"]

; class-alias
(class-alias "stdClass" "song")
(:= _song (new song))
```
<br/>

#####Invocación de métodos
```lisp
; methods.em
(:= _nombres (new ArrayObject (array "juan" "carlos" "pedro"))
(-> "count" _nombres) ; 3

; forma abreviada
(->count _nombres)

; parámetros
; (now) obtiene un objeto Datetime con la fecha actual (ver DatePackage)
(->format (now) "Y-m-d H:i") ; fecha actual con formato
; abreviado
```

<br/>

##Pasaje de parámetros

<br/>

##Licencia

<br/>

El código correspondiente a esta librería es liberado utilizando la licencia BSD 2-Clause License.