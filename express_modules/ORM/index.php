<?php

# Require Express Validator Class Definition...
require 'ORM.php';


$export = function(){
	
	# Instance the module...
	$module = new ORM();

	# Inject Module into Express...
	$GLOBALS['app']->_ORM = $module;
};

# Export module..
$export();