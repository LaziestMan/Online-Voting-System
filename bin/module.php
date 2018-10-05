<?php

/**
 * Module class defination
 */
class Module {

	public 	function __construct() {
		echo ' Hello I am a module <br/>';		
	}

	public function greet() {
		echo 'I greet you <br/>';
	}
}

$invoke = function(){
	// Instance the module
	$module = new Module();

	// Inject to express
	$GLOBALS['app']->_MODULE = $module;
};

// Initiate the module
$invoke();