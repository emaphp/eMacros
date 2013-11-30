<?php
namespace eMacros\Package;

use eMacros\Runtime\Filter\FilterVar;
use eMacros\Runtime\Filter\FilterHasVar;
use eMacros\Runtime\PHPFunction;

class FilterPackage extends Package {
	public function __construct() {
		parent::__construct('Filter');
		
		//filter functions
		$this['has-var'] = new PHPFunction('filter_has_var');
		$this['var'] = new PHPFunction('filter_var');
		$this['var-array'] = new PHPFunction('filter_var_array');
		$this['id'] = new PHPFunction('filter_id');
		$this['input'] = new PHPFunction('filter_input');
		$this['input-array'] = new PHPFunction('filter_input_array');
		$this['list'] = new PHPFunction('filter_list');
		
		//input type constants
		$this['INPUT_GET']     = INPUT_GET;
		$this['INPUT_POST']    = INPUT_POST;
		$this['INPUT_COOKIE']  = INPUT_COOKIE;
		$this['INPUT_SERVER']  = INPUT_SERVER;
		$this['INPUT_ENV']     = INPUT_ENV;
		$this['INPUT_SESSION'] = INPUT_SESSION;
		
		//validation filters
		$this['VALIDATE_BOOLEAN'] = FILTER_VALIDATE_BOOLEAN;
		$this['VALIDATE_EMAIL']   = FILTER_VALIDATE_EMAIL;
		$this['VALIDATE_FLOAT']   = FILTER_VALIDATE_FLOAT;
		$this['VALIDATE_INT']     = FILTER_VALIDATE_INT;
		$this['VALIDATE_IP']      = FILTER_VALIDATE_IP;
		$this['VALIDATE_REGEXP']  = FILTER_VALIDATE_REGEXP;
		$this['VALIDATE_URL']     = FILTER_VALIDATE_URL;

		//sanitize filters
		$this['SANITIZE_EMAIL']              = FILTER_SANITIZE_EMAIL;
		$this['SANITIZE_ENCODED']            = FILTER_SANITIZE_ENCODED;
		$this['SANITIZE_MAGIC_QUOTES']       = FILTER_SANITIZE_MAGIC_QUOTES;
		$this['SANITIZE_NUMBER_FLOAT']       = FILTER_SANITIZE_NUMBER_FLOAT;
		$this['SANITIZE_NUMBER_INT']         = FILTER_SANITIZE_NUMBER_INT;
		$this['SANITIZE_SPECIAL_CHARS']      = FILTER_SANITIZE_SPECIAL_CHARS;
		$this['SANITIZE_FULL_SPECIAL_CHARS'] = FILTER_SANITIZE_FULL_SPECIAL_CHARS;
		$this['SANITIZE_STRING']             = FILTER_SANITIZE_STRING;
		$this['SANITIZE_STRIPPED']           = FILTER_SANITIZE_STRIPPED;
		$this['SANITIZE_URL']                = FILTER_SANITIZE_URL;
		$this['UNSAFE_RAW']                  = FILTER_UNSAFE_RAW;
		
		//flags
		$this['NULL_ON_FAILURE']       = FILTER_NULL_ON_FAILURE;
		$this['FLAG_STRIP_LOW']        = FILTER_FLAG_STRIP_LOW;
		$this['FLAG_STRIP_HIGH']       = FILTER_FLAG_STRIP_HIGH;
		$this['FLAG_ALLOW_FRACTION']   = FILTER_FLAG_ALLOW_FRACTION;
		$this['FLAG_ALLOW_THOUSAND']   = FILTER_FLAG_ALLOW_THOUSAND;
		$this['FLAG_ALLOW_SCIENTIFIC'] = FILTER_FLAG_ALLOW_SCIENTIFIC;
		$this['FLAG_ALLOW_OCTAL']      = FILTER_FLAG_ALLOW_OCTAL;
		$this['FLAG_ALLOW_HEX']        = FILTER_FLAG_ALLOW_HEX;
		$this['FLAG_NO_ENCODE_QUOTES'] = FILTER_FLAG_NO_ENCODE_QUOTES;
		$this['FLAG_ENCODE_LOW']       = FILTER_FLAG_ENCODE_LOW;
		$this['FLAG_ENCODE_HIGH']      = FILTER_FLAG_ENCODE_HIGH;
		$this['FLAG_ENCODE_AMP']       = FILTER_FLAG_ENCODE_AMP;
		$this['FLAG_IPV4']             = FILTER_FLAG_IPV4;
		$this['FLAG_IPV6']             = FILTER_FLAG_IPV6;
		$this['FLAG_NO_PRIV_RANGE']    = FILTER_FLAG_NO_PRIV_RANGE;
		$this['FLAG_NO_RES_RANGE']     = FILTER_FLAG_NO_RES_RANGE;
		$this['FLAG_PATH_REQUIRED']    = FILTER_FLAG_PATH_REQUIRED;
		$this['FLAG_QUERY_REQUIRED']   = FILTER_FLAG_QUERY_REQUIRED;
	}
}
?>