eMacros
=======

The Extensible Macros Library for PHP

[![Build Status](https://travis-ci.org/emaphp/eMacros.svg?branch=master)](https://travis-ci.org/emaphp/eMacros)

**Autor**: Emmanuel Antico<br/>
**Ultima modificación**: 03/10/2014

<br/>

##Descripción
<br/>

*eMacros* es una librería escrita en PHP y basada en [lisphp](https://github.com/lisphp/lisphp "") que incorpora un intérprete de dialecto LISP customizable.

<br/>

##Características
<br/>

A diferencia de *lisphp*, *eMacros* está orientada a aplicaciones embebidas dentro de PHP, por lo que no cuenta con un comando de consola. *eMacros* fue desarrollado con la idea de poder generar texto dinamicamente en los casos donde la funciones de formato de texto no fueran lo suficientemente complejas, pero puede resultar de utilidad en otros escenarios.

<br/>

##Requerimientos
<br/>
Es necesario contar con una versión actualizada de PHP 5.4.

<br/>

##Instalación
<br>


La instalación de *eMacros* se realiza a través de **Composer**. Agregar el siguiente archivo a la carpeta del proyecto y realizar la instalación habitual [descrita aquí](http://getcomposer.org/doc/00-intro.md#installation-nix "").

**composer.json**

```json
{
    "require": {
        "emacros/emacros": "1.1.*"
    }
}
```
<br/>

##Introducción
<br/>
El siguiente ejemplo muestra la implementación de un programa en *eMacros* sencillo que calcula la suma de 2 números.

```php
include 'vendor/autoload.php';

use eMacros\Program\Program;
use eMacros\Environment\DefaultEnvironment;

//instanciar programa
$program = new Program('(+ 3 7)');

//ejecutar programa
$result = $program->execute(new DefaultEnvironment);

//mostrar resultados
echo $result; //imprime el número 10 por pantalla
```
Este script comienza creando una nueva instancia de programa a la cual se le pasa el código a ser interpretado. Para realizar la ejecución de un programa es necesario definir el entorno donde se ejecutará. El método *execute* realiza la ejecución de un programa en el entorno pasado como parámetro. El valor generado es luego devuelto.

<br/>
Existen varios tipos de programas, cada uno de estos programas puede generar distintos tipos de resultados de acuerdo a las instrucciones ejecutadas. La clase *Program* define el tipo más sencillo de programa. Esta clase devuelve el resultado de la última instrucción ejecutada. En caso de que hubieramos instanciado el programa de la siguiente manera el resultado hubiera sido diferente.

```php
$program = new Program('(+ 3 7)(- 6 3)');
```

Dado que *Program* obtiene siempre el último valor generado, en lugar de 10 la ejecución hubiera mostrado un 3, es decir, el resultado de restar 3 a 6.

<br/>
En caso de que se quiera almacenar todos los resultados obtenidos de cada expresión podemos utilizar la clase *ListProgram*. Esta clase va almacenando cada resultado generado en un arreglo. El resultado obtenido de ejecutar un *ListProgram* es un arreglo con tantos valores como expresiones (no anidadas) se hayan evaluado.

```php
include 'vendor/autoload.php';

use eMacros\Program\ListProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new ListProgram('(+ 3 7)(- 6 (+ 1 2))');
$result = $program->execute(new DefaultEnvironment);

echo $result[0]; //imprime 10
echo $result[1]; //imprime 3
```

Ademas de estas 2 clases también contamos con *TextProgram*. La clase *TextProgram* obtiene el resultado de concatenar cada uno de los valores generados por expresiones no anidadas dentro de un programa. El siguiente programa realiza la concatenación de 2 expresiones para generar un mensaje. Este programa también introduce el operador de concatenación.

```php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new TextProgram('(. "Hel" "lo" " ")(. "Wo" "rld")');
$result = $program->execute(new DefaultEnvironment);

echo $result; //imprime la cadena "Hello World"
```
<br/>

##La clase DefaultEnvironment

<br/>

La clase *DefaultEnvironment* define un entorno por defecto donde las aplicaciones *eMacros* pueden ejecutarse. Un entorno define el listado de operaciones que van a poder interpretarse. Esto va desde las operaciones simples como las aritméticas (+, -, \*, /) hasta las más complejas (if, or, @nombre, Array::reverse). La forma de definir estos símbolos es a través del **importado de paquetes**. Si nos fijamos en la implementación de esta clase veremos lo siguiente:

```php
namespace eMacros\Environment;

use eMacros\Package\CorePackage;
use eMacros\Package\StringPackage;
use eMacros\Package\ArrayPackage;
use eMacros\Package\RegexPackage;
use eMacros\Package\DatePackage;

class DefaultEnvironment extends Environment {
	public function __construct() {
		$this->import(new StringPackage);
		$this->import(new ArrayPackage);
		$this->import(new RegexPackage);
		$this->import(new DatePackage);
		$this->import(new CorePackage);
	}
}
```

Las clases *CorePackage*, *StringPackage*, *ArrayPackage*, etc son clases que definen un listado de símbolos y operaciones a ser usados dentro de un programa. Al importar un paquete dentro de un entorno hacemos posible la utilización de los símbolos y operaciones definidos dentro del paquete en un programa.

<br/>
La clase *DefaultEnvironment* incorpora los paquetes para funciones de cadenas, arreglos, fechas y expresiones regulares, por lo que resulta ideal para empezar a experimentar por nuestra cuenta. El resto de los paquetes pueden encontrarse dentro del namespace *eMacros\Package*.

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
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new TextProgram(file_get_contents('hello_world.em'));
$result = $program->execute(new DefaultEnvironment);

echo $result;
```

<br/>

##La clase CorePackage

<br/>

La clase *CorePackage* resulta esencial para la generación de ambientes de ejecución de programas. Entre los elementos que se agregan con este paquete se encuentran:

* Los símbolos *null*, *true* y *false*.
* Operadores de comparación, aritméticos y lógicos.
* Funciones de manejo de variables y símbolos.
* Funciones de clases y objetos.
* Funciones para manejo de argumentos.
* Funciones para manejos de tipos.
* Etc.

<br/>
Como se observa, la funcionalidad de este paquete es muy básica por lo que se recomienda contar con el mismo en el caso de definir un entorno customizado. A continuación se hará una breve reseña de las capacidades de este paquete.

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

#####Constantes

* PHP_VERSION (igual a *PHP_VERSION*)
* PHP_MAJOR_VERSION (igual a *PHP_MAJOR_VERSION*)
* PHP_MINOR_VERSION (igual a *PHP_MINOR_VERSION*)
* PHP_RELEASE_VERSION (igual a *PHP_RELEASE_VERSION*)
* PHP_EXTRA_VERSION (igual a *PHP_EXTRA_VERSION*)
* PHP_VERSION_ID (igual a *PHP_VERSION_ID*)
* PHP_OS (igual a *PHP_OS*)
* PHP_SAPI (igual a *PHP_SAPI*)
* PHP_INT_MAX (igual a *PHP_INT_MAX*)
* PHP_INT_SIZE (igual a *PHP_INT_SIZE*)

<br/>

##Variables

<br/>
La declaración de una variable agrega un símbolo a la tabla del símbolos del entono de ejecución. Para agregar una variable con un valor de inicialización utilizamos el operador **:=**.


```lisp
; variables.em

(:= _nulo null) ; _nulo = null
(:= _falso false) ; _falso = false
(:= _verdadero true)

; numeros
(:= _dos 2) ; declarar _dos = 2
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
(sym "_program" "symbols.em") ; agrega el símbolo _program con el valor "symbols.em"
(. "Corriendo programa " _program)

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
Para la creación de objetos contamos con 2 funciones: *new* e *instance*. La diferencia entre estas 2 es que *new* espera el nombre de la clase definido como símbolo mientras que *instance* espera una cadena.

```lisp
; objects.em
; declarar instancia de stdClass
(:= _obj (new stdClass))

; crear instancia de ArrayObject con parámetro
(:= _arr (instance "ArrayObject" (array "uno" "dos" "tres")))

; crear instancia de DOMDocument
(:= _xml (new DOMDocument "1.0" "ISO-8859-1"))
```
Para trabajar con propiedades contamos con los operadores de asignación, comprobación y obtención.

```lisp
; properties.em
; declarar instancia
(:= _os (new stdClass))

; asignar valores (#=)
(#= "nombre" _os "GNU/Linux") ; _os->nombre = "GNU/Linux"
(#= "familia" _os "Unix-like") ; _os->familia = "Unix-like"

; obtener valores (#)
(. "El sistema " (# "nombre" _os) " es de la familia " (# "familia" _os))

; comprobar existencia de propiedad (#?)
(if (not (#? "empresa" _os)) " y es libre")
```
Las mismas funciones puede utilizarse para índices en arreglos.
```lisp
; keys.em
(:= _arr (array ("program" "keys.em") ("language" "eMacros")))
(. "El programa " (# "program" _arr) " está escrito en " (# "language" _arr))

; guardar estado de programa en arreglo
(#= "estado" _arr "Ejecutando")

; comprobar existencia de clave
(if (#? "estado" _arr) (. "Estado de programa: " (# "estado" _arr)) "Estado desconocido")
```
La clase *CorePackage* define un método abreviado para el acceso a claves en arreglos y objetos.

```lisp
; short_keys.em

;; OBJETOS

; declarar instancia
(:= _os (new stdClass))

; asignar valores (#PROPIEDAD=)
(#nombre= _os "GNU/Linux") ; _os->nombre = "GNU/Linux"
(#familia= _os "Unix-like") ; _os->familia = "Unix-like"

; obtener valores (#PROPIEDAD)
(. "El sistema " (#nombre _os) " es de la familia " (#familia _os))

; comprobar existencia de propiedad (#PROPIEDAD?)
(if (not (#empresa? _os)) " y es libre")

;; ARREGLOS
(:= _arr (array ("program" "keys.em") ("language" "eMacros")))
(. "El programa " (#program _arr) " está escrito en " (#language _arr))

; guardar estado de programa en arreglo
(#estado= _arr "Ejecutando")

; comprobar existencia de clave
(if (#estado? _arr) (. "Estado de programa: " (#estado _arr)) "Estado desconocido")
```
Este operador también funciona para índices numéricos.

```lisp
; numeric_keys.em
(:= _arr (array))
(#0= _arr "Primer elemento")
(#-2= _arr "Indice -2")

(if (not (#1? _arr)) "No se encontró ningún elemento en la posición 1")

(. "El primer elemento es " (#0 _arr))
```

<br/>

#####Funciones de clase y objetos

```lisp
; class_functions.em
(:= _song (new stdClass))
(#name= _song "Meditango")
(#artist= _song "Astor Piazzolla")
(#genre= _song "Tango")

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
(property-exists "eMacros\\Symbol" "package") ; true

; method-exists
(method-exists "ArrayObject" "count") ; true

; is-subclass-of
(is-subclass-of "eMacros\\Environment\\DefaultEnvironment" "eMacros\\Scope") ; true

; get-parent-class
(get-parent-class "eMacros\\Environment\\DefaultEnvironment") ; "eMacros\Environment\Environment"

; get-class-vars
(get-class-vars "eMacros\\Literal") ; ["value" => NULL]

; get-class-methods
(get-class-methods "eMacros\\Expression") ; ["evaluate"]

; class-alias
(class-alias "eMacros\\Symbol" "symbol")
(:= _song (new symbol "song"))
```
<br/>

#####Invocación de métodos
```lisp
; methods.em
(:= _nombres (new ArrayObject (array "juan" "carlos" "pedro")))
(-> "count" _nombres) ; 3

; forma abreviada
(->count _nombres)

; parámetros
; (now) obtiene un objeto Datetime con la fecha actual (ver DatePackage)
(->format (now) "Y-m-d H:i") ; fecha actual con formato abreviado
```

<br/>

##Pasaje de parámetros

<br/>
Un programa puede recibir un número arbitrario de parámetros. Estos deben ir especificados luego de la instancia de entorno al realizar la ejecución del mismo.

```lisp
; arguments.em
; Este programa realiza el conteo de parametros recibidos

; conteo de parámetros (%#)
(. "Se encontraron un total de " (%#) "parámetros\n")

; obtener parámetros como arreglo (%_)
(. "Parámetros: " (implode "," (%_)))
```
Este script realiza la ejecución del programa especificado con 3 argumentos.

```php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

//instanciar programa
$program = new TextProgram(file_get_contents('arguments.em'));

//ejecutar programa
$result = $program->execute(new DefaultEnvironment, 1, "hola", 5.5);

//mostrar resultados
echo $result;
```

La salida producida es la siguiente:
```bash
Se encontraron un total de 3 parámetros
Parámetros: 1,hola,5.5
```
Podemos acceder a cada parámetro individualmente con las funciones correspondientes:

```lisp
; arg_functions.em

; obtener parámetro (%)
(+ 5 (% 0)) ; 5 + 1

; verficar existencia de argumento (%?)
(if (%? 1) (. (% 1) " mundo")) ; "hola mundo"

; forma abreviada (%ARGN) (%ARGN?)
(if (%1?) (. (%1) " mundo")) ; "hola mundo"
``` 
<br/>

#####El método *executeWith*

<br/>
El método *executeWith* nos permite definir los parámetros de un programa como un arreglo. Utilizando este método podemos reescribir el ejemplo anterior de la siguiente manera.

```php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

//instanciar programa
$program = new TextProgram(file_get_contents('arguments.em'));

//ejecutar programa
$result = $program->executeWith(new DefaultEnvironment, array(1, "hola", 5.5));

//mostrar resultados
echo $result;
```

<br/>

##Paquetes

<br/>

*eMacros* cuenta con varios paquetes a disposición organizados por tipo dentro del namespace *eMacros\Package*. El siguiente script muestra el uso de funciones declaradas dentro del paquete 'String'.

```lisp
; string_functions.em
; len (strlen)
(len "hello") ; 5

; explode
(explode "." "198.123.12.45") ; ["198", "123", "12", "45"]

; reverse (strrev)
(reverse "Hello") ; "olleH"

; str (strstr)
(str "email@example.com" "@") ; "@example.com"
```
En ocasiones 2 paquetes definen el mismo símbolo haciendo que la utilización de una función o valor resulte ambiguo. Este es el caso de *shuffle* y *reverse*, ambos declarados en *StringPackage* y *ArrayPackage*. Este problema puede solventarse utilizando el nombre del paquete como prefijo del símbolo.

```lisp
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
```
<br/>

##Invocación de funciones

<br/>

Las funciones *call* y *apply* permiten invocar una función pasada como parámetro.

```lisp
; call_func.em
; muestra ejemplos de invocación utilizando call
(call-func "strtoupper" "hello world") ; retorna "HELLO WORLD"

(call Array::range 2 5) ; retorna [2, 3, 4, 5]
```

La función *apply* espera un arreglo conteniendo el listado de argumentos como segundo parámetro. Este ejemplo realiza la suma de todos los valores pasados al programa.

```lisp
; sigma.em
; calcula la suma de todos los valores pasados como parámetro
(apply + (%_))
```

<br/>

##Use e Import

<br/>
Las funciones *use* e *import* permiten importar funciones directamente desde PHP o desde otros paquetes a la tabla de símbolos del entorno de ejecución.
```lisp
; use_example.em
; Ejemplos de utilización de use

; importar utf8_encode a la tabla de símbolos
(use utf8_encode)
(:= _encoded (utf8_encode (%0)))

; alias
(use (utf8_decode utf8dec))
(:= _decoded (utf8dec _encoded))

; multiples símbolos
(use mb_detect_encoding mb_internal_encoding (mb_get_info mbinfo))
```
La función *import* espera como parámetro un símbolo con el nombre de clase a importar.

```lisp
; import_example.em
; Ejemplos de uso de import

; import MathPackage class
(import eMacros\Package\MathPackage)
(:= _sin (sin Math::PI_2))

; si la clase no existe import intenta recuperarla del paquete eMacros\Package (agregando Package al final)
(import CType)
(if (digit (%0)) "El parámetro es un dígito" "El parámetro no es un dígito")
```

<br/>

##Paquetes de usuario

<br/>

La forma recomendable de implementar funciones de usuario es a través de paquetes. Al mantener nuestras funciones dentro de paquetes customizados podemos importarlas a cualquier entorno de manera más eficiente. El siguiente ejemplo muestra la implementación de un paquete de ejemplo que agrega los símbolos *MY_CONSTANT* y *message* a su tabla de símbolos.

```php
namespace Acme;

use eMacros\Package\Package;

class CustomPackage extends Package {
    public function __construct() {
        //debemos especificar un ID de paquete
        parent::__construct('Custom');
        
        $this['MY_CONSTANT'] = 42;
        $this['message'] = "this is a custom package";
    }
}
```
Si bien es posible utilizar *import* para importar los símbolos de este paquete al entorno de ejecución, a la larga es preferible utilizar un entorno customizado. El siguiente código de ejemplo muestra la implementación de un entorno de ejecución definido por usuario.

```php
namespace Acme;

use eMacros\Environment\Environment;
use eMacros\Package\CorePackage;
use eMacros\Package\StringPackage;

class CustomEnvironment extends Environment {
    public function __construct() {
        $this->import(new CustomPackage);        
        $this->import(new StringPackage);
        $this->import(new CorePackage);
    }
}
```

Teniendo ya el entorno preparado podemos realizar la ejecución de programas utilizando los símbolos declarados previamente.

```lisp
; custom.em
; Muestra el uso de un entorno de ejecución definido por usuario
(<- MY_CONSTANT); retorna 42

; podemos utilizar el nombre de paquete como prefijo
(/ Custom::MY_CONSTANT 2) ; retorna 21

(String::ucfirst message) ; retorna "This is a custom package"
```

Utilizar un entorno definido por usuario no dista mucho de los ejemplos vistos previamente.

```php
include 'vendor/autoload.php';

use Acme\CustomEnvironment;
use eMacros\Program\SimpleProgram;

$program = new SimpleProgram(file_get_contents('custom.em'));
$program->execute(new CustomEnvironment);
```
<br/>

##Implementación de funciones

<br/>

La creación de macros y funciones se realiza a través de 3 tipos de clases y una interfaz auxiliar:

* PHPFunction (solo funciones disponibles en PHP)
* Closures
* GenericFunction
* Applicable

<br/>

#####PHPFunction

La clase *PHPFunction* actua como un wrapper de funciones PHP. El único parámetro requerido para su creación es el nombre de la función a encapsular.

```php
namespace Acme;

use eMacros\Package\Package;
use eMacros\Runtime\PHPFunction;

class UserPackage extends Package {
    public function __construct() {
        parent::__construct('User');
        
        /**
         * Compresión de datos
         * Uso: (compress "sample data")
         */
        $this['compress'] = new PHPFunction('bzcompress');
    }
}
```
Al utilizar *PHPFunction* omitimos realizar el chequeo de cantidad y tipo de parámetros. Aún así, resulta la manera más simple de importar funciones del lenguaje a un paquete.

```lisp
; phpfunction.em
; comprimir un string
(compress "some string")
```

<br/>

#####Closures

Las funciones definidas como *Closures* tienen la ventaja de ahorrarnos la implementación de una clase.

```php
namespace Acme;

use eMacros\Package\Package;

class UserPackage extends Package {
    public function __construct() {
        parent::__construct('User');
        
        /**
         * Suma y resta
         * Uso: (plusmin 6 7 3) ; 10
         */
        $this['plusmin'] = function ($x, $y, $z) {
            return $x + $y - $z;
        });
    }
}
```

<br/>

#####GenericFunction

Las clases que extienden de *GenericFunction* deben implementar el método *execute*. Este método recibe un arreglo con todos los argumentos recibidos.

```php
namespace Acme\Runtime;

use eMacros\Runtime\GenericFunction;

class PlusMin extends GenericFunction {
    /**
     * Suma y resta de valores
     * Uso: (+- 4 5 1) ; 8
     */
    public function execute(array $args) {
        if (count($args) < 3) {
             throw new \BadFunctionCallException("PlusMin: At least 3 arguments are  required.");
        }
        
        return $args[0] + $args[1] - $args[2];
    }
}
```
El paquete se debe encargar de instanciar la clase y definir el símbolo asociado.
```php
namespace Acme;

use eMacros\Package\Package;
use Acme\Runtime\PlusMin;

class UserPackage extends Package {
    public function __construct() {
        parent::__construct('User');
        
        /**
         * Suma y resta
         * Uso: (+- 6 7 3) ; 10
         */
        $this['+-'] = new PlusMin;
    }
}
```

<br/>

#####La interfaz Applicable

El método restante para la declaración de funciones consiste en la implementación de la interfaz *Applicable*. Esta interfaz resulta útil en caso de necesitar acceder a valores declarados dentro del entorno de ejecución (contantes, funciones, parámetros, etc) o si es necesario determinar si un parámetro se definió como un símbolo o valor literal. El método *apply* recibe 2 argumentos: una instancia de *Scope* con el entorno de ejecución actual y una instancia de *GenericList* con los argumentos suministrados. Para recuperar el valor de cada expresión presente en el listado de argumentos es necesario invocar al método *evaluate* pasando como parámetro la instancia de *Scope*. Este ejemplo implementa una clase *Increment* que incrementa el valor de un símbolo en 1 o en un valor auxiliar definido en la invocación.
```php
namespace Acme\Runtime;

use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Applicable;
use eMacros\Symbol;

class Increment implements Applicable {
    public function apply(Scope $scope, GenericList $arguments) {
        //comprobar cantidad de parámetros
        $nargs = count($arguments);
        
        if ($nargs == 0) {
            throw new \BadFunctionCallException("Increment: No parameters found.");
        }
        
        //comprobar que primer parámetro es símbolo
        if (!($arguments[0] instanceof Symbol)) {
            throw new \InvalidArgumentException("Increment: A symbol is expected as first argument.");
        }
        
        //obtener nombre de símbolo
        $ref = $arguments[0]->symbol;
        
        //obtener valor de símbolo
        $value = $arguments[0]->evaluate($scope);
        
        if ($nargs > 1) {
            $value += intval($arguments[1]->evaluate($scope));
        }
        else {
            $value++;
        }
        
        $scope->symbols[$ref] = $value;
        return true;
    }
}
```
Es válido notar que esta clase debe asegurarse de que el primer parámetro sea un símbolo o de otro modo una excepción es lanzada.

```php
namespace Acme;

use eMacros\Package\Package;
use Acme\Runtime\Increment

class UserPackage extends Package {
    public function __construct() {
        parent::__construct('User');
        
        /**
         * Incrementar valor de variable
         * Uso: (inc _x) (inc _y 3)
         */
        $this['inc'] = new Increment();
    }
}
```
El siguiente código importa la clase *UserPackage* y muestra un ejemplo de utilización de la función *inc*.

```lisp
; inc.em
; Ejemplo de uso de función "inc"
(import Acme\UserPackage)
(:= _x 1)
(inc _x) ; _x = 2
(inc _x 3) ; _x = 5
```

<br/>

##Macros

<br/>

Las macros son funciones que en vez de estar asociadas a un símbolo se definen a través de una expresión regular. Los paquetes implementan macros a través del método *macro*. Este método espera una cadena de texto con la expresión a comparar y una función anónima. Esta función recibe las coincidencias obtenidas al comparar la expresión regular contra el símbolo entrante. Por lo general, la funciones devueltas por una macro deben implementar un constructor que es invocado dentro de la función anónima con las coincidencias encontradas. El siguiente ejemplo muestra la implementación de una macro para calcular la distancia entre 2 puntos. Las coordenadas del punto inicial son declaradas como parte del operador y luego capturadas por la función anónima.

```php
namespace Acme\Runtime;

use eMacros\Runtime\GenericFunction;

class Distance extends GenericFunction {
    public $x;
    public $y;

    public function __construct($coordX, $coordY) {
        $this->x = $coordX;
        $this->y = $coordY;
    }
    
    /**
     * Calcula la distancia entre 2 puntos
     * Uso: (dist:X1Y7 3 5)
     */
    public function execute(array $args) {
        if (count($args) < 2) {
            throw new \BadFunctionCallException("Distance: Destino no especificado.");
        }
        
        $x = intval($args[0]);
        $y = intval($args[1]);
        
        $distance = pow($x - $this->x, 2) + pow($y - $this->y, 2);
        return sqrt($distance);
    }
}
```

La macro *dist* puede ser invocada directamente sin la necesidad de especificar coordenadas de origen. En ese caso, la distancia será calculada a partír de las coordenadas (0,0). El siguiente código muestra la implementación de la clase *GeometryPackage*. Esta clase agrega *dist* a la tabla de símbolos y define la macro para el calculo de distancias customizable.

```php
namespace Acme;

use eMacros\Package\Package;
use Acme\Runtime\Distance;

class GeometryPackage extends Package {
    public function __construct() {
        parent::__construct('Geometry');
        
        //distancia por defecto
        $this['dist'] = new Distance(0, 0);

        //macro
        $this->macro('@dist:X(\d+)Y(\d+)@', function ($matches) {
            return new Distance(intval($matches[1]), intval($matches[2]));
        });
    }
}
```
El siguiente programa muestra el funcionamiento de la función *dist* en ambos modos.

```lisp
; distance.em
; Ejemplo de macro definida por usuario
(import Acme\GeometryPackage)

; distance from (0,0)
(dist 4 2)

; distance from (4, 2)
(dist:X4Y2 5 7)
```
<br/>

##Apéndice I - Paquetes disponibles

<br/>
<table width="96%">
    <thead>
        <tr>
            <th>Clase</th>
            <th>Descripción</th>
            <th>Prefijo</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>CorePackage</td>
            <td>Símbolos y operadores básicos</td>
            <td>Core</td>
        </tr>
        <tr>
            <td>ArrayPackage</td>
            <td><a href="http://php.net/manual/es/ref.array.php">Funciones de arreglos</a></td>
            <td>Array</td>
        </tr>
        <tr>
            <td>BufferPackage</td>
            <td><a href="http://php.net/manual/es/ref.outcontrol.php">Funciones de control de output</a></td>
            <td>Buffer</td>
        </tr>
        <tr>
            <td>CTypePackage</td>
            <td><a href="http://php.net/manual/es/ref.ctype.php">Funciones CType</a></td>
            <td>CType</td>
        </tr>
        <tr>
            <td>DatePackage</td>
            <td><a href="http://php.net/manual/es/ref.datetime.php">Funciones de fecha y hora</a></td>
            <td>Date</td>
        </tr>
        <tr>
            <td>FilePackage</td>
            <td><a href="http://php.net/manual/es/ref.filesystem.php">Funciones de sistema de archivos</a></td>
            <td>File</td>
        </tr>
        <tr>
            <td>FilterPackage</td>
            <td><a href="http://php.net/manual/es/ref.filter.php">Funciones de filtro</a></td>
            <td>Filter</td>
        </tr>
        <tr>
            <td>HashPackage</td>
            <td>Funciones de hashing (sha1,md5, etc)</td>
            <td>Hash</td>
        </tr>
        <tr>
            <td>HTMLPackage</td>
            <td>Funciones HTML (nl2br, strip-tags, etc)</td>
            <td>HTML</td>
        </tr>
        <tr>
            <td>JSONPackage</td>
            <td><a href="http://php.net/manual/es/ref.json.php">Funciones JSON</a></td>
            <td>JSON</td>
        </tr>
        <tr>
            <td>MathPackage</td>
            <td><a href="http://php.net/manual/es/ref.math.php">Funciones matemáticas</a></td>
            <td>Math</td>
        </tr>
        <tr>
            <td>RegexPackage</td>
            <td><a href="http://php.net/manual/es/ref.pcre.php">Funciones de expresiones regulares</a></td>
            <td>Regex</td>
        </tr>
        <tr>
            <td>RequestPackage</td>
            <td>Variables globales de request (GET, POST, etc)</td>
            <td>Request</td>
        </tr>
        <tr>
            <td>StringPackage</td>
            <td><a href="http://php.net/manual/es/ref.strings.php">Funciones de cadenas de texto</a></td>
            <td>String</td>
        </tr>
    </tbody>
</table>

<br/>

##Licencia

<br/>

El código correspondiente a esta librería es liberado utilizando la licencia BSD 2-Clause License.