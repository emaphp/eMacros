eMacros
=======

The Extensible Macros Library for PHP

**Author**: Emmanuel Antico<br/>
**Last Modification**: 27/02/2014 [d/m/y]

<br/>

##About
<br/>

*eMacros* is a PHP library based on [lisphp] (https://github.com/lisphp/lisphp "") featuring a customizable LISP dialect interpreter.

<br/>

##Requirements

<br/>

An updated version of PHP 5.4 is required tu run this library.

<br/>

##Installation

<br>

*eMacros* installation is performed via Composer. Add the following file to the project folder and perform the usual installation which is [described here] (http://getcomposer.org/doc/00-intro.md # installation-nix "").

**composer.json**

```json
{
    "require": {
        "emacros/emacros": "dev-master"
    }
}
```
<br/>

##First steps

<br/>

The following example shows the implementation of a simple program that calculates the sum of 2 numbers.

```php

include 'vendor/autoload.php';

use eMacros\Program\SimpleProgram;
use eMacros\Environment\DefaultEnvironment;

//create program instance
$program = new SimpleProgram('(+ 3 7)');

//run program
$result = $program->execute(new DefaultEnvironment);

//show results
echo $result; //prints 10
```
This script begins by creating a new instance of a program which receives the code to be interpreted. For being able to run a program is necessary to define an environment instance. The *execute* method performs the execution of a program using the environment provided as a parameter. The result obtained is then returned.

<br/>

There are several types of programs, each one of these can generate different types of results based on the executed instructions. The class *SimpleProgram* defines the simplest type of program. This class returns the result of the last executed instruction. The following program includes 2 instructions but only one value is returned.

```php
$program = new SimpleProgram('(+ 3 7)(- 6 3)');
```

Since *SimpleProgram* always returns the last generated value, instead of 10 we would have obtained 3, that is, the result of subtracting 3 to 6.

<br/>
To store all the results obtained from each expression we can use the *ListProgram* class. This class works by storing each result in an array. The result of executing a *ListProgram* is an array with the same amount of values that evaluated instructions.

```php
include 'vendor/autoload.php';

use eMacros\Program\ListProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new ListProgram('(+ 3 7)(- 6 (+ 1 2))');
$result = $program->execute(new DefaultEnvironment);

echo $result[0]; //prints 10
echo $result[1]; //prints 3
```

The *TextProgram* class returns the result of concatenating each evaluated expression in a program. The following program performs the concatenation of two expressions to generate a message. This program also introduces the concatenation operator.

```php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new TextProgram('(. "Hel" "lo" " ")(. "Wo" "rld")');
$result = $program->execute(new DefaultEnvironment);

echo $result; //prints "Hello World"
```
<br/>

##The DefaultEnvironment class

<br/>

The *DefaultEnvironment* class defines a default environment where applications can run. An environment defines the list of symbols and operations that the program will be able to interpret. This ranges from simple operations such as arithmetic (+, -, \*, /) to more complex ones (if, or, @name, Array::reverse). Symbols and operations are added to an environment by *importing packages*. Current implementation of the *DefaultEnvironment* class looks like the following:

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

*CorePackage*, *StringPackage*, *ArrayPackage*, etc are classes that define a list of symbols and operations to be used within a program. By importing a package to an environment we enable the use of symbols and operations defined within that package.

<br/>

The *DefaultEnvironment* class comes with a fair amount of functions, which makes it ideal for start experimenting on our own. The rest of the packages can be found in the *eMacros\Package* namespace.

<br/>

##Running programs from files

<br/>

Programs can also be loaded from files. Having the application code in another file turns useful for adding comments, which improves readability. This program is similar to the previous example, except that it also returns the version of PHP running on the system.

```lisp
; hello_world.em
; This is a comment
(. "Hello" " World!" "\n") ; Another comment
(. "This script is running under PHP " PHP_VERSION "\n") 
; END
```

This example uses the *file_get_contents* function to obtain the contents of a source file.

```php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

$program = new TextProgram(file_get_contents('hello_world.em'));
$result = $program->execute(new DefaultEnvironment);

echo $result;
```

<br/>

##The CorePackage class

<br/>

The *CorePackage* class is extremely important when building a program execution environment. Among the elements that are contained on this package are:

* The *null*, *true* and *false* symbols.
* Arithmetic, comparison and logic operators.
* Variables and symbols functions.
* Class/objects functions.
* Argument functions.
* Type handling functions.
* Etc.

<br/>

As noted, the functionality of this package is very critical so it is recommended to have it included whenever we create a customized environment. Below is a brief overview of the capabilities of this package.

<br/>

#####Comparison operators


```lisp
; comparison.em
; Comparison operators always return a boolean value

; equal
(== 1 "1") ; equal to
(!= 1 2) ; not equal to

; identical
(=== 1 1) ; identical to
(!== 1 "1") ; not identical to

; greater than
(> 6 4) ; greater than
(>= 4 4) ; greater than or equal to

; lesser than
(< 3 4) ; lesser than
(<= 3 3) ; lesser than or equal to
```

<br/>

#####Logic operators

```lisp
; logical.em

; AND OR
(and true true) ; true
(or false true) ; true

; several parameters
(and true true false true) ; false

; NOT
(not true) ; false

; IF
; if [CONDITION] [VALUE_TRUE]
; if [CONDITION] [VALUE_TRUE] [VALUE_FALSE]
(if true "is true") ; returns "is true"
(if false "is true" "is false") ; returns "is false"
(if false "is true") ; returns NULL

; COND
; cond searchs for the first non-false value on a list and returns the associated value
(cond (false 1)) ; returns NULL
(cond (false 1) (true 2) (false 3) (true 4)) ; returns 2
```

<br/>

#####Arithmetic operators

```lisp
; arithmetic.em

; add and substract
(+ (- 10 6) 6  1) ; 11

; multiplication and division
(* 4 (/ 10 5)) ; 8

; modulus
(mod 10 3) ; 1
```

<br/>

#####Binary operators

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

#####Type functions

```lisp
; types.em

; get type
(type-of 4) ; "integer"

; check type
(int? 4) ; true

; check types
(string? "" "hola" "mundo") ; true
(int? 5 3 "x") ; false

; empty
(empty "") ; true
(empty 1) ; false
(empty false 0) ; true
```


<br/>

#####Casting

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

#####Constants

* PHP_VERSION (same as *PHP_VERSION*)
* PHP_MAJOR_VERSION (same as *PHP_MAJOR_VERSION*)
* PHP_MINOR_VERSION (same as *PHP_MINOR_VERSION*)
* PHP_RELEASE_VERSION (same as *PHP_RELEASE_VERSION*)
* PHP_EXTRA_VERSION (same as *PHP_EXTRA_VERSION*)
* PHP_VERSION_ID (same as *PHP_VERSION_ID*)
* PHP_OS (same as *PHP_OS*)
* PHP_SAPI (same as *PHP_SAPI*)
* PHP_INT_MAX (same as *PHP_INT_MAX*)
* PHP_INT_SIZE (same as *PHP_INT_SIZE*)

<br/>

##Variables

<br/>
Declaring a variable adds a new symbol to the current environment symbol table. In order to declare a variable we use the assignment operator.


```lisp
; variables.em

(:= _null null) ; _null = null
(:= _false false) ; _false = false
(:= _true true) ; _true = true

; numbers
(:= _two 2) ; declares _two = 2
(:= _five (+ 2 3)) ; declares _five = 2 + 3
(+ _two _five) ; 7

; strings
(:= _name "john")
(:= _message (. "Hello " _name)) ; build _message
(<- _message) ; returns _message value

; unset
(unset _name)
(<- _name) ; NULL
```
Alternatively, we can use the symbol manipulation functions: *sym*, *sym-exists* and *lookup*.

```lisp
; symbols.em
; the sym functions receives a string and an associated values
(sym "_program" "variables.em") ; adds _program to the symbol table with the value "symbols.em"
(. "Running program " _program)

; sym-exists verifies if the given symbol exists on the symbol table
(if (sym-exists "_program") "Symbol \"_program\" already exists")

; lookup obtains a symbol associated value
(. "Ending execution of " (lookup "_program"))
```

<br/>

##Arrays and objects

<br/>
Arrays are created througn the *array* function. It is possible to define key-value pairs using tuples.

```lisp
; arrays.em
; create an int array
(:= _list (array 1 2 3 4 5))
(. "_list has " (count _list) " elements")

; key-value pairs
(:= _data (array ("name" "john") ("surname" "doe") ("job" "developer")))
```
Objects can be created through 2 functions: *new* and *instance*. While *new* expects the class name defined as a symbol, *instance* creates an object instance from a string.

```lisp
; objects.em
; create new stdClass instance
(:= _obj (new stdClass))

; create ArrayObject instance with a constructor parameter
(:= _arr (instance "ArrayObject" (array "one" "two" "three")))

; create DOMDocument instance
(:= _xml (new DOMDocument "1.0" "ISO-8859-1"))
```
In order to work with key/properties, *CorePackage* provides 3 operators.

```lisp
; properties.em
; declare new instance
(:= _os (new stdClass))

; set key/property value (@=)
(@= "name" _os "GNU/Linux") ; _os->name = "GNU/Linux"
(@= "family" _os "Unix-like") ; _os->family = "Unix-like"

; get key/property value (@)
(. "System " (@ "name" _os) " is a " (@ "family" _os) " OS")

; check if key/property exists (@?)
(if (not (@? "company" _os)) " and is libre")
```

Arrays include an special operator to append elements.

```lisp
; keys.em
(:= _arr (array ("program" "keys.em") ("language" "eMacros")))
(. "Program" (@ "program" _arr) " is written in " (@ "language" _arr))

; stores status in array
(@= "status" _arr "Running")

; check key existence
(if (@? "status" _arr) (. "Program status: " (@ "status" _arr)) "Unknown status")

; append elements (@+)
(:= _numbers (array))
(@+ _numbers 1 2 3 4 5)
(. "Numbers: " (implode "," _numbers))
```
The *CorePackage* class also defines an abbreviated way to obtain key/properties through *macros*.

```lisp
; short_keys.em

;; OBJECTS

; create instance
(:= _os (new stdClass))

; assign value (@PROPERTY=)
(@name= _os "GNU/Linux") ; _os->name = "GNU/Linux"
(@family= _os "Unix-like") ; _os->family = "Unix-like"

; get value (@PROPERTY)
(. "System " (@name _os) " is a " (@family _os) " OS")

; check property (@PROPERTY?)
(if (not (@company? _os)) " and is libre")

;; ARRAYS
(:= _arr (array ("program" "keys.em") ("language" "eMacros")))
(. "Program " (@program _arr) " is written in " (@language _arr))

; stores program status
(@status= _arr "Running")

; check key existence
(if (@status? _arr) (. "Program status: " (@status _arr)) "Unknown status")
```
For numeric indexes the '@' should be replaced by '#'.

```lisp
; numeric_keys.em
(:= _arr (array))
(#0= _arr "First element")
(#-2= _arr "Index -2")

(if (not (#1? _arr)) "No element available on index 1")

(. "Array first element " (#0 _arr))
```

<br/>

#####Class/Object functions

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

#####Method invocation
```lisp
; methods.em
(:= _name (new ArrayObject (array "john" "charles" "peter")))
(-> "count" _names) ; 3

; abbreviated
(->count _nombres)

; parameters
; (now) obtains a DateTime instance with the current time
(->format (now) "Y-m-d H:i") ; get current date
```

<br/>

##Arguments

<br/>

A program can receive an arbitrary number of arguments. These must be specified when calling the *execute* method right after the instance environment.

```lisp
; arguments.em
; This program obtains the number of passed arguments

; argument counter (%#)
(. (%#) " parameters have been found\n")

; obtain arguments as array (%_)
(. "Arguments: " (implode "," (%_)))
```
This script performs the execution of the previous program with 3 arguments.

```php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

//create program instance
$program = new TextProgram(file_get_contents('arguments.em'));

//add arguments
$result = $program->execute(new DefaultEnvironment, 1, "hello", 5.5);

//print results
echo $result;
```

The obtained output is the following:

```bash
3 parameters have been found
Parameters: 1,hello,5.5
```
We can access each argument individually with the corresponding functions:

```lisp
; arg_functions.em

; get argument by index (%)
(+ 5 (% 0)) ; 5 + 1

; check argument existence (%?)
(if (%? 1) (. (% 1) " mundo")) ; "hola mundo"

; abbreviated form (%ARGN) (%ARGN?)
(if (%1?) (. (%1) " world")) ; "hello mundo"
```

<br/>

#####The *executeWith* method

<br/>
The *executeWith* method allows us to define the parameters of a program as an array. Using this method we can rewrite the previous example in the following way.

```php
include 'vendor/autoload.php';

use eMacros\Program\TextProgram;
use eMacros\Environment\DefaultEnvironment;

//create program instance
$program = new TextProgram(file_get_contents('arguments.em'));

//run program
$result = $program->executeWith(new DefaultEnvironment, array(1, "hello", 5.5));

//print results
echo $result;
```

<br/>

##Packages

<br/>

*eMacros* has several packages available organized by type within the *eMacros\Package* namespace. The following script demonstrates the use of some functions that are available in the 'String' package.

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
Sometimes two packages define the same symbol, so that the use of a function or value becomes ambiguous. This is the case of *shuffle* and *reverse*, both declared in *StringPackage* and *ArrayPackage*. This problem can be solved using the package name as a symbol prefix.

```lisp
; ambiguos.em

; reverse
(reverse "abcde") ; "edcba"
(Array::reverse (array "one" "two" "three")) ; ["three" "two" "one"]
(String::reverse "xyz") ; "zyx"

; aux array
(:= _arr (array 1 2 3))

; shuffle
(shuffle "abcde") ; shuffle in String package
(Array::shuffle _arr) ; shuffle in Array package
(String::shuffle "xyz") ; shuffle in String package
```
<br/>

##Function invocation

<br/>

The *call-func* and *call-func-array* functions allow invoking a function passed as argument.

```lisp
; call_func.em
; shows some examples of call-func
(call-func "strtoupper" "hello world") ; returns "HELLO WORLD"

(call-func Array::range 2 5) ; returns [2, 3, 4, 5]
```

The *call-func-array* function expects an array containing the list of arguments as a second parameter. This code uses *call-func-array* to sum all arguments ​​passed to the program.

```lisp
; sigma.em
; calculates the sum of all arguments passed
(call-func-array + (%_))
```

<br/>

##Use and Import

<br/>
The *use* and *import* functions allows importing functions directly from PHP or from other packages to the current symbol table.

```lisp
; use_example.em
; usage examples of use function

; import utf8_encode
(use utf8_encode)
(:= _encoded (utf8_encode (%0)))

; using an alias
(use (utf8_decode utf8dec))
(:= _decoded (utf8dec _encoded))

; multiple use
(use mb_detect_encoding mb_internal_encoding (mb_get_info mbinfo))
```

The *import* function expects a symbol with the package class name to import.

```lisp
; import_example.em
; usage examples of import

; import MathPackage class
(import eMacros\Package\MathPackage)
(:= _sin (sin Math::PI_2))

; if no class is found then import tries to recover the package from the eMacros\Package namespace (and adding "Package" as suffix)
(import CType)
(if (digit (%0)) "Argument is a digit" "Argument is not a digit")
```

<br/>

##User packages

<br/>

The preferable way to implement user functions is through packages. By keeping our customized functions within packages we can import them into any environment more efficiently. The following example shows the implementation of a sample package that adds the symbols *MY_CONSTANT* and *message* to the environment's symbol table.

```php
namespace Acme;

use eMacros\Package\Package;

class CustomPackage extends Package {
    public function __construct() {
        //declare and ID for this package
        parent::__construct('Custom');
        
        $this['MY_CONSTANT'] = 42;
        $this['message'] = "this is a custom package";
    }
}
```
While it is possible to import the symbols of this package through the predefined functions, it turns more convenient to use a customized environment. The following example shows the implementation of a runtime environment defined by the user.

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

Having already prepared our new user-defined environment we can make the implementation of programs using the previously declared symbols.

```lisp
; custom.em
; An example using a user-defined environment
(<- MY_CONSTANT); returns 42

; using package name as prefix
(/ Custom::MY_CONSTANT 2) ; returns 21

(String::ucfirst message) ; returns "This is a custom package"
```

<br/>

##Implementing user-defined functions

<br/>

Creating macros and functions is done through 3 available classes and an auxiliary interface:

* PHPFunction (only functions available in PHP)
* Closures
* GenericFunction
* Applicable

<br/>

#####PHPFunction

The *PHPFunction* class acts as a wrapper for PHP functions. This class constructor expects the name of the function to encapsulate.

```php
namespace Acme;

use eMacros\Package\Package;
use eMacros\Runtime\PHPFunction;

class UserPackage extends Package {
    public function __construct() {
        parent::__construct('User');
        
        /**
         * Compress data
         * Usage: (compress "sample data")
         */
        $this['compress'] = new PHPFunction('bzcompress');
    }
}
```
By using *PHPFunction* we omit checking the amount and type of parameters. Still, it is the simplest way to import language features to a package.

```lisp
; phpfunction.em
; compress a string
(compress "some string")
```

<br/>

#####Closures

Functions defined as *Closures* can help to avoid implementing an entire class from scratch.

```php
namespace Acme;

use eMacros\Package\Package;

class UserPackage extends Package {
    public function __construct() {
        parent::__construct('User');
        
        /**
         * Addition and sustraction
         * Usage: (plusmin 6 7 3) ; 10
         */
        $this['plusmin'] = function ($x, $y, $z) {
            return $x + $y - $z;
        });
    }
}
```

<br/>

#####GenericFunction

Classes that extend from *GenericFunction* must implement the *execute* method. This method receives an array with all submitted arguments.

```php
namespace Acme\Runtime;

use eMacros\Runtime\GenericFunction;

class PlusMin extends GenericFunction {
    /**
     * Addition and subtraction
     * Usage: (+- 4 5 1) ; 8
     */
    public function execute(array $args) {
        if (count($args) < 3) {
             throw new \BadFunctionCallException("PlusMin: At least 3 arguments are  required.");
        }
        
        return $args[0] + $args[1] - $args[2];
    }
}
```

This package instantiates the *PlusMin* class and defines the symbol which will be associated with it.

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

#####The Applicable interface

We can also create functions through the *Applicable* interface. This interface is useful if you need to access values declared within the runtime environment (constants, functions, parameters, etc.) or if you need to determine if a given parameter is defined as a symbol or literal. The *apply* method takes 2 arguments: an instance of *Scope* with the current execution environment and an instance of *GenericList* with the given arguments. To retrieve an expression value we need to invoke its *evaluate* method using the *Scope* instance as argument. This example implements a class named *Increment* that increases the value of a symbol by one or by a given value (when specified).

```php
namespace Acme\Runtime;

use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Applicable;
use eMacros\Symbol;

class Increment implements Applicable {
    public function apply(Scope $scope, GenericList $arguments) {
        //check arguments amount
        $nargs = count($arguments);
        
        if ($nargs == 0) {
            throw new \BadFunctionCallException("Increment: No parameters found.");
        }
        
        //check that first parameter is a symbol
        if (!($arguments[0] instanceof Symbol)) {
            throw new \InvalidArgumentException("Increment: A symbol is expected as first argument.");
        }
        
        //get symbol name
        $ref = $arguments[0]->symbol;
        
        //get symbol value
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
Notice that this class ensures that the first parameter is a symbol or otherwise an exception is thrown.

```php
namespace Acme;

use eMacros\Package\Package;
use Acme\Runtime\Increment

class UserPackage extends Package {
    public function __construct() {
        parent::__construct('User');
        
        /**
         * Increments a variable value
         * Usaeg: (inc _x) (inc _y 3)
         */
        $this['inc'] = new Increment();
    }
}
```

The following code imports the *UserPackage* class and shows an usage example of the *inc* function.

```lisp
; inc.em
; Example using the inc function
(import Acme\UserPackage)
(:= _x 1)
(inc _x) ; _x = 2
(inc _x 3) ; _x = 5
```

<br/>

##Macros

<br/>

Macros are functions that instead of being associated with a symbol they're generated from a regular expression. Macros are declared through the *macro* method. This method expects a regular expression string and a *Closure* instance (or anonymous function). This anonymous function receives all matches found for the given regular expression. Its main purpose is to generate a valid environment function with those matches. The following example shows the implementation of a macro to calculate the distance between 2 points. The coordinates of the starting point are declared as part of the operator and then captured by the anonymous function.

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
     * Calculates the distance between 2 point
     * Usage: (dist:X1Y7 3 5)
     */
    public function execute(array $args) {
        if (count($args) < 2) {
            throw new \BadFunctionCallException("Distance: Destination not specified.");
        }
        
        $x = intval($args[0]);
        $y = intval($args[1]);
        
        $distance = pow($x - $this->x, 2) + pow($y - $this->y, 2);
        return sqrt($distance);
    }
}
```
The *dist* macro can be invoked directly without the need of specifying coordinates of origin. In that case, the distance will be calculated from the coordinates (0,0). The following code shows the implementation of the *GeometryPackage* class. This class adds *dist* to the symbol table and defines the customizable macro for calculating distances.

```php
<?php
namespace Acme;

use eMacros\Package\Package;
use Acme\Runtime\Distance;

class GeometryPackage extends Package {
    public function __construct() {
        parent::__construct('Geometry');
        
        //default distance
        $this['dist'] = new Distance(0, 0);

        //macro style
        $this->macro('@dist:X(\d+)Y(\d+)@', function ($matches) {
            return new Distance(intval($matches[1]), intval($matches[2]));
        });
    }
}
```

The next example invokes the *dist" macro using both modes (with and without coordinates).

```lisp
; distance.em
; User-defined macro example
(import Acme\GeometryPackage)

; distance from (0,0)
(dist 4 2)

; distance from (4, 2)
(dist:X4Y2 5 7)
```

<br/>

##Appendix I - Available packages

<br/>
<table width="96%">
    <thead>
        <tr>
            <th>Class name</th>
            <th>Description</th>
            <th>Prefix</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>CorePackage</td>
            <td>Basic symbols and operators</td>
            <td>Core</td>
        </tr>
        <tr>
            <td>ArrayPackage</td>
            <td><a href="http://php.net/manual/en/ref.array.php">Array functions</a></td>
            <td>Array</td>
        </tr>
        <tr>
            <td>BufferPackage</td>
            <td><a href="http://php.net/manual/en/ref.outcontrol.php">Output control functions</a></td>
            <td>Buffer</td>
        </tr>
        <tr>
            <td>CTypePackage</td>
            <td><a href="http://php.net/manual/en/ref.ctype.php">CType functions</a></td>
            <td>CType</td>
        </tr>
        <tr>
            <td>DatePackage</td>
            <td><a href="http://php.net/manual/en/ref.datetime.php">Date/Time functions</a></td>
            <td>Date</td>
        </tr>
        <tr>
            <td>FilePackage</td>
            <td><a href="http://php.net/manual/en/ref.filesystem.php">Filesystem functions</a></td>
            <td>File</td>
        </tr>
        <tr>
            <td>FilterPackage</td>
            <td><a href="http://php.net/manual/en/ref.filter.php">Filter functions</a></td>
            <td>Filter</td>
        </tr>
        <tr>
            <td>HashPackage</td>
            <td>Hashing functions (sha1,md5, etc)</td>
            <td>Hash</td>
        </tr>
        <tr>
            <td>HTMLPackage</td>
            <td>HTML functions (nl2br, strip-tags, etc)</td>
            <td>HTML</td>
        </tr>
        <tr>
            <td>JSONPackage</td>
            <td><a href="http://php.net/manual/en/ref.json.php">JSON functions</a></td>
            <td>JSON</td>
        </tr>
        <tr>
            <td>MathPackage</td>
            <td><a href="http://php.net/manual/en/ref.math.php">Math functions</a></td>
            <td>Math</td>
        </tr>
        <tr>
            <td>RegexPackage</td>
            <td><a href="http://php.net/manual/en/ref.pcre.php">PCRE functions</a></td>
            <td>Regex</td>
        </tr>
        <tr>
            <td>RequestPackage</td>
            <td>Request global vars (GET, POST, etc)</td>
            <td>Request</td>
        </tr>
        <tr>
            <td>StringPackage</td>
            <td><a href="http://php.net/manual/en/ref.strings.php">String functions</a></td>
            <td>String</td>
        </tr>
    </tbody>
</table>

<br/>

##License

<br/>

This code is licensed under the BSD 2-Clause license.