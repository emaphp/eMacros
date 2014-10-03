<?php
namespace eMacros\Runtime\Environment;

use eMacros\Applicable;
use eMacros\Scope;
use eMacros\GenericList;
use eMacros\Symbol;
use eMacros\Environment\Environment;
use eMacros\Package\Package;

class EnvironmentImport implements Applicable {
	/**
	 * Imports a package into current environment
	 * Usage: (import eMacros\Package\MathPackage) (import eMacros\Package\PasswordPackage Pwd) 
	 * Returns: NULL
	 * (non-PHPdoc)
	 * @see \eMacros\Applicable::apply()
	 */
	public function apply(Scope $scope, GenericList $arguments) {
		if (!($scope instanceof Environment)) throw new \RuntimeException("EnvironmentImport: Cannot import package from outside of main context.");
		$nargs = count($arguments);
		if ($nargs == 0) throw new \BadFunctionCallException('EnvironmentImport: No package specified.');
		if (!($arguments[0] instanceof Symbol))
			throw new \InvalidArgumentException(sprintf("EnvironmentImport: Expected symbol as first argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[0]), '\\')), 1)));
		$package = $arguments[0]->symbol;
		
		if (!class_exists($package, true)) {
			//try finding a compatible package in eMacros\\Package namespace
			$xpackage = sprintf("eMacros\\Package\\%sPackage", $package);
			if (class_exists($xpackage, true)) $package = $xpackage;
			else throw new \InvalidArgumentException("EnvironmentImport: Package '$package' not found.");
		}
		
		$rc = new \ReflectionClass($package);
		
		if ($rc->isSubclassOf('eMacros\Package\Package')) {
			if ($nargs > 1) {
				if (!($arguments[1] instanceof Symbol))
					throw new \InvalidArgumentException(sprintf("EnvironmentImport: Expected symbol as second argument but %s was found instead.", substr(strtolower(strstr(get_class($arguments[1]), '\\')), 1)));
				$alias = $arguments[1]->symbol;
				//validate alias
				if (!preg_match(Symbol::PACKAGE_PREFIX, $alias . '::')) throw new \InvalidArgumentException("EnvironmentImport: Alias '$alias' is not a valid package alias.");
				return $scope->import($rc->newInstance(), $alias);
			}
			
			return $scope->import($rc->newInstance());
		}
		
		throw new \InvalidArgumentException("EnvironmentImport: '$package' is not a valid package class.");
	}
}
?>