eMacros
=======

The Extensible Macros Library for PHP

**Author**: Emmanuel Antico<br/>
**Last Modification**: 04/12/2013

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

##La clase CorePackage

<br/>

##Pasaje de parámetros

<br/>

##Licencia

<br/>

El código correspondiente a esta librería es liberado utilizando la licencia BSD 2-Clause License.