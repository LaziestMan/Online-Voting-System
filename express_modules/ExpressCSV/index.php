<?php

# Require Express CSV Class Definition...
require 'ExpressCSV.php';


$export = function(){
	
	# Instance the module...
	$module = new ExpressCSV();

	# Inject Module into Express...
	$GLOBALS['app']->_ExpressCSV = $module;
};

# Export module..
$export();