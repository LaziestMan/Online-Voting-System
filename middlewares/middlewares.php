<?php

function auth($req, $res) {
	if(!isset($req->session['logged'])) {
		// User not logged in..
		$res->redirect('/login');
	}
}

function auth_admin($req, $res) {
	if($req->session['user_level']!=1) {
		// User is not an admin..
		$res->setSession('flash', array('msg'=>'Access denied!', 'level'=>'Error'));
		$res->redirect('/dashboard');
	}
}

function validate_pass($req, $res) {
	global $app;
	
	# ORM Module...
	$ORM = $app->_ORM;

	// Check if user password is empty, if so redirect to change password
	$check = $ORM->select('password', 'user', array(array('matno'=>array('$equal'=>$req->session['matno'])), 'and', array('password'=>array('$equal'=>''))));

	if($check!==NULL) {

		// Implies user found
		if(empty($check['0']['password'])) {
			// Password empty, redirect to change password route
			$res->redirect('/account/change/password');
		}
	}
}

$app->use('/dashboard', function($req, $res){

	# Authenticate the user...
	auth($req, $res);

	# Check if password empty
	validate_pass($req, $res);
});

$app->use('/dashboard?', function($req, $res){

	# Authenticate the user...
	auth($req, $res);

	# Check if password empty
	validate_pass($req, $res);
});

$app->use('/account/change/password', function($req, $res){

	# Authenticate the user...
	auth($req, $res);
});

$app->use('/account/change/password?', function($req, $res){

	# Authenticate the user...
	auth($req, $res);
});


$app->use('/logout', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
});

$app->use('/cpanel', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
	auth_admin($req, $res);

});

$app->use('/cpanel?', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
	auth_admin($req, $res);

});


$app->use('/cpanel/user', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
	auth_admin($req, $res);

});


$app->use('/cpanel/user?', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
	auth_admin($req, $res);

});

$app->use('/cpanel/candidate', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
	auth_admin($req, $res);

});

$app->use('/cpanel/candidate?', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
	auth_admin($req, $res);

});

$app->use('/cpanel/vote', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
	auth_admin($req, $res);

});

$app->use('/cpanel/vote?', function($req, $res){
	
	# Authenticate the user...
	auth($req, $res);
	auth_admin($req, $res);

});


?>