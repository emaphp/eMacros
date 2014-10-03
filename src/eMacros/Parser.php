<?php
namespace eMacros;

use eMacros\Exception\ParseException;

class Parser {
	/**
	 * Validated symbols
	 * @var array
	 */
	public static $map = [];
	
	/*
	 * SYMBOL REGEX
	 */
	const PARENTHESES = '()';
	const COMMENT_PREFIX = ';';
	const WHITESPACES = " \t\n\r\f\v\0";
	
	/**
	 * Float validation regex
	 * @var string
	 */
	const REAL_PATTERN = '{^[+-]?((\d+|(\d*\.\d+|\d+\.\d*))e[+-]?\d+|\d*\.\d+|\d+\.\d*)}i';
	
	/**
	 * Integer validation regex
	 * @var unknown
	 */
	const INTEGER_PATTERN = '/^([+-]?)(0x([0-9a-f]+)|0([0-7]+)|[1-9]\d*|0)/i';
	
	/**
	 * String validation regex
	 * @var string
	 */
	const STRING_PATTERN = '/^"([^"\\\\]|\\\\.)*"|^\'([^\'\\\\]|\\\\.)*\'/';
	
	/**
	 * Escape string replacement regex
	 * @var string
	 */
    const STRING_ESCAPE_PATTERN = '/\\\\(([0-7]{1,3})|x([0-9A-Fa-f]{1,2})|.)/';
    
    /**
     * Symbol validation regex
     * @var string
     */
    const SYMBOL_PATTERN = '{^[^\s\d(){}\[\]"\';][^\s\'"(){}\[\];]*}';
	
    /**
     * Parses a program
     * @param string $program
     * @throws ParseException
     * @return \eMacros\GenericList
     */
	public static function parse($program) {
		$i = 0;
		$len = strlen($program);
		$forms = [];
		
		while ($i < $len) {
			if (strpos(self::WHITESPACES, $program[$i]) === false) {
				try {
					$form = self::parseExpression(substr($program, $i), $offset);
					if (!is_null($form)) $forms[] = $form;
 				}
 				catch (ParseException $e) {
 					throw new ParseException($program, $e->offset + $i);
 				}
				
				$i += $offset;
			}
			else
				++$i;
		}
		
		return $forms;
	}
	
	/**
	 * Parses an inner expression
	 * @param string $form
	 * @param int $offset
	 * @throws ParseException
	 * @return mixed
	 */
	public static function parseExpression($form, &$offset) {
		static $parentheses = null;
		
		if (is_null($parentheses)) {
			$_parentheses = self::PARENTHESES;
			$parentheses = [];
			
			for ($i = 0, $len = strlen($_parentheses); $i < $len; $i += 2)
				$parentheses[$_parentheses[$i]] = $_parentheses[$i + 1];
			
			unset($_parentheses);
		}
		
		if (isset($form[0], $parentheses[$form[0]])) {
			$end = $parentheses[$form[0]];
			$values = [];
			$i = 1;
			$len = strlen($form);
			
			while ($i < $len && $form[$i] != $end) {
				if (strpos(self::WHITESPACES, $form[$i]) !== false) {
					++$i;
					continue;
				}
				
				try {
					$values[] = self::parseExpression(substr($form, $i), $_offset);
					$i += $_offset;
				}
 				catch (ParseException $e) {
 					throw new ParseException($form, $i + $e->offset);
 				}
			}
			
			if (isset($form[$i]) && $form[$i] == $end) {
				$offset = $i + 1;
				return new GenericList($values);
			}

			throw new ParseException($form, $i);
		}
		elseif (isset($form[0]) && $form[0] == self::COMMENT_PREFIX) {
			$offset = strlen(strtok($form, "\n"));
			return;
		}
		elseif (preg_match(self::REAL_PATTERN, $form, $matches)) {
			$offset = strlen($matches[0]);
			return new Literal((float) $matches[0]);
		}
		elseif (preg_match(self::INTEGER_PATTERN, $form, $matches)) {
			$offset = strlen($matches[0]);
			$sign = $matches[1] == '-' ? -1 : 1;
			$value = !empty($matches[3]) ? hexdec($matches[3]) : (!empty($matches[4]) ? octdec($matches[4]) : $matches[2]);
			return new Literal($sign * $value);
		}
		elseif (preg_match(self::STRING_PATTERN, $form, $matches)) {
			list($parsed) = $matches;
			$offset = strlen($parsed);
			return new Literal(preg_replace_callback(self::STRING_ESCAPE_PATTERN, [__CLASS__, 'unescapeString'], substr($parsed, 1, -1)));
		}
		elseif (preg_match(self::SYMBOL_PATTERN, $form, $matches)) {
			$symbol = $matches[0];
			$offset = strlen($matches[0]);
			
			//store validated symbols in order to reduce checks
			if (array_key_exists($symbol, self::$map))
				return self::$map[$symbol];
			
			return self::$map[$symbol] = new Symbol($symbol);
		}
		
		throw new ParseException($form, 0);
	}
	
	/**
	 * Replaces special characters in a string
	 * @param array $matches
	 * @return string
	 */
	protected static function unescapeString($matches) {
		static $map = ['n' => "\n", 'r' => "\r", 't' => "\t", 'v' => "\v", 'f' => "\f"];
		
		if (!empty($matches[2]))
			return chr(octdec($matches[2]));
		elseif (!empty($matches[3]))
			return chr(hexdec($matches[3]));
		elseif (isset($map[$matches[1]]))
			return $map[$matches[1]];
		
		return $matches[1];
	}
	
	/**
	 * Flushes validated symbols table
	 */
	public static function flush() {
		self::$map = [];
	}
}
?>