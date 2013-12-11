<?php
namespace eMacros;

use eMacros\Program\TextProgram;
use eMacros\Program\ListProgram;
use eMacros\Program\SimpleProgram;

/**
 * 
 * @author emaphp
 * @group examples
 */
class ExamplesTest extends eMacrosTest {
	public function testHelloWorld() {
		$program = new TextProgram(file_get_contents(__DIR__ . '/source/hello_world.em'));
		$result = $program->execute(self::$env);
		$this->assertEquals("Hola Mundo!\nEste script corre bajo PHP " . PHP_VERSION . "\n", $result);
	}
	
	public function testVariables() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/variables.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(11, $result);
		$this->assertNull($result[0]);
		$this->assertFalse($result[1]);
		$this->assertTrue($result[2]);
		$this->assertEquals(2, $result[3]);
		$this->assertEquals(5, $result[4]);
		$this->assertEquals(7, $result[5]);
		$this->assertEquals("pepe", $result[6]);
		$this->assertEquals("Hola pepe", $result[7]);
		$this->assertEquals("Hola pepe", $result[8]);
		$this->assertNull($result[9]);
		$this->assertNull($result[10]);
	}
	
	public function testSymbols() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/symbols.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(4, $result);
		$this->assertNull($result[0]);
		$this->assertEquals("Corriendo programa variables.em", $result[1]);
		$this->assertEquals("El símbolo \"_program\" ya existe", $result[2]);
		$this->assertEquals("Finalizando ejecución de variables.em", $result[3]);
	}
	
	public function testArrays() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/arrays.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(3, $result);
		$this->assertEquals(array(1, 2, 3, 4, 5), $result[0]);
		$this->assertEquals("_lista posee 5 elementos", $result[1]);
		$this->assertEquals(array('nombre' => 'juan', 'apellido' => 'perez', 'ocupacion' => 'desarrollador'), $result[2]);
	}
	
	public function testObjects() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/objects.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(3, $result);
		$this->assertInstanceOf('stdClass', $result[0]);
		$this->assertInstanceOf('ArrayObject', $result[1]);
		$this->assertEquals('uno', $result[1][0]);
		$this->assertEquals('dos', $result[1][1]);
		$this->assertEquals('tres', $result[1][2]);
		$this->assertInstanceOf('DOMDocument', $result[2]);
	}
	
	public function testProperties() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/properties.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(5, $result);
		$this->assertInstanceOf('stdClass', $result[0]);
		$this->assertEquals("El sistema GNU/Linux es de la familia Unix-like", $result[3]);
		$this->assertEquals(' y es libre', $result[4]);
	}
	
	public function testKeys() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/keys.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(7, $result);
		$this->assertEquals(array("program" => "keys.em", "language" => "eMacros"), $result[0]);
		$this->assertEquals("El programa keys.em está escrito en eMacros", $result[1]);
		$this->assertEquals("Estado de programa: Ejecutando", $result[3]);
		$this->assertInternalType('array', $result[4]);
		$this->assertEquals(5, $result[5]);
		$this->assertEquals("Numeros: 1,2,3,4,5", $result[6]);
	}
	
	public function testShortKeys() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/short_keys.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(9, $result);
		$this->assertInstanceOf('stdClass', $result[0]);
		$this->assertEquals("El sistema GNU/Linux es de la familia Unix-like", $result[3]);
		$this->assertEquals(' y es libre', $result[4]);
		$this->assertEquals(array("program" => "keys.em", "language" => "eMacros"), $result[5]);
		$this->assertEquals("El programa keys.em está escrito en eMacros", $result[6]);
		$this->assertEquals("Estado de programa: Ejecutando", $result[8]);
	}
	
	public function testNumericKeys() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/numeric_keys.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(5, $result);
		$this->assertInternalType('array', $result[0]);
		$this->assertEquals("No se encontró ningún elemento en la posición 1", $result[3]);
		$this->assertEquals("El primer elemento es Primer elemento", $result[4]);
	}
	
	public function testClassFunctions() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/class_functions.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(18, $result);
		
		$this->assertEquals(array("name" => "Meditango", "artist" => "Astor Piazzolla", "genre" => "Tango"), $result[4]);
		$this->assertEquals("stdClass", $result[5]); // (get-class _song)
		$this->assertTrue($result[6]); // (instance-of _obj stdClass)
		$this->assertFalse($result[7]);
		$this->assertTrue($result[8]); // (is-a _obj "stdClass")
		$this->assertFalse($result[9]); // (is-a _obj "ArrayObject")
		$this->assertTrue($result[10]); // (property-exists "eMacros\\Symbol" "package")
		$this->assertTrue($result[11]); // (method-exists "ArrayObject" "count")
		$this->assertTrue($result[12]); // (is-subclass-of "eMacros\\Environment\\DefaultEnvironment" "eMacros\\Scope")
		$this->assertEquals("eMacros\\Environment\\Environment", $result[13]); // (get-parent-class "eMacros\\Environment\\DefaultEnvironment")
		$this->assertEquals(array('value' => null), $result[14]);
		$this->assertEquals(array('evaluate'), $result[15]);
		$this->assertInstanceOf('eMacros\\Symbol', $result[17]);
	}
	
	public function testMethods() {
		$tz = ini_get('date.timezone');
		
		if (empty($tz)) {
			$this->markTestSkipped("No default timezone found! Set 'date.timezone' in your php.ini.");
		}
		
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/methods.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(4, $result);
		
		$this->assertInstanceOf('ArrayObject', $result[0]);
		$this->assertEquals(3, $result[1]);
		$this->assertEquals(3, $result[2]);
		$this->assertRegExp('/([\d]{4})-([\d]{2})-([\d]{2}) ([\d]{2}):([\d]{2})/', $result[3]);
	}
	
	public function testArguments() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/arguments.em'));
		$result = $program->execute(self::$env, 1, "hola", 5.5);
		$this->assertInternalType('array', $result);
		$this->assertCount(2, $result);
		
		$this->assertEquals("Se encontraron un total de 3 parámetros\n", $result[0]);
		$this->assertEquals("Parámetros: 1,hola,5.5", $result[1]);
	}
	
	public function testArgumentFunctions() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/arg_functions.em'));
		$result = $program->execute(self::$env, 1, "hola", 5.5);
		$this->assertInternalType('array', $result);
		$this->assertCount(3, $result);
		
		$this->assertEquals(6, $result[0]);
		$this->assertEquals("hola mundo", $result[1]);
		$this->assertEquals("hola mundo", $result[2]);
	}
	
	public function testStringFunctions() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/string_functions.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(4, $result);
		
		$this->assertEquals(5, $result[0]);
		$this->assertEquals(array('198', '123', '12', '45'), $result[1]);
		$this->assertEquals("olleH", $result[2]);
		$this->assertEquals("@example.com", $result[3]);
	}
	
	public function testAmbigous() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/ambigous.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(7, $result);
		
		$this->assertEquals("edcba", $result[0]);
		$this->assertEquals(array("tres", "dos", "uno"), $result[1]);
		$this->assertEquals("zyx", $result[2]);
		$this->assertEquals(array(1, 2, 3), $result[3]);
	}
	
	public function testCallFunc() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/call_func.em'));
		$result = $program->execute(self::$env);
		$this->assertInternalType('array', $result);
		$this->assertCount(2, $result);
		
		$this->assertEquals("HELLO WORLD", $result[0]);
		$this->assertEquals(array(2,3,4,5), $result[1]);
	}
	
	public function testSigma() {
		$program = new SimpleProgram(file_get_contents(__DIR__ . '/source/sigma.em'));
		$result = $program->execute(self::$env, 1, 2, 3, 4, 5);
		$this->assertEquals(15, $result);
	}
	
	public function testUseExample() {
		$program = new ListProgram(file_get_contents(__DIR__ . '/source/import_example.em'));
		$result = $program->execute(self::$env, "14");
		$this->assertInternalType('array', $result);
		$this->assertCount(4, $result);
		
		$this->assertEquals(1, $result[1]);
		$this->assertEquals("El parámetro es un dígito", $result[3]);
	}
}
?>