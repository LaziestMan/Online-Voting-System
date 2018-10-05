<?php

/*
 *   _____                                ____  _   _ ____
 *  | ____|_  ___ __  _ __ ___  ___ ___  |  _ \| | | |  _ \
 *  |  _| \ \/ / '_ \| '__/ _ \/ __/ __| | |_) | |_| | |_) |
 *  | |___ >  <| |_) | | |  __/\__ \__ \ |  __/|  _  |  __/
 *  |_____/_/\_\ .__/|_|  \___||___/___/ |_|   |_| |_|_|   v 1.0.0
 *             |_|
 *
*/

# Require Express PHP Framework...
include 'Express.php';

# Create an Expess PHP app...
$app = new Express();


# Configure Express PHP app...

/**
 * Set Express router's base path
 */
 $app->set('basePath', '/express');
 
 /**
  * Set Express view engine
  */
 $app->set('view engine', 'default');

 /**
  * Set Express views path
  */
$app->set('views', 'views/');

/**
  * Set Express static files path
  */
$app->set('static', 'public/');

/**
  * Import ORM Module
  */
$app->import('ORM');

/**
  * Import ExpressValidator Module for FORM Validation
  */
$app->import('ExpressValidator');

/**
  * Connect to vote db using the ORM module
  */
$app->_ORM->connect('localhost', 'root', '', 'vote');


/**
  * Initiate the SESSION middleware
  */
$app->use(session_start());

# Define app routes... 


# Include Middleware
include 'middlewares/middlewares.php';

$app->get('/', function($req, $res){
  $res->redirect('/login');
});

# Include Register controller
include 'controllers/register.controller.php';


# Include Login controller
include 'controllers/login.controller.php';

# Include Cpanel controller
include 'controllers/cpanel.controller.php';


$app->post('/cpanel/user/upload', function($req, $res) {
  global $app;
 



});



$app->get('/dashboard', function($req, $res) {
  $res->render('dashboard', array('appName'=>'Votify', 'title'=>'Dashboard', 'app'=>$GLOBALS['app'], 'session'=>$req->session));
  if(isset($req->session['flash'])) {
    $res->setSession('flash', NULL);  
  }
  
});


$app->get('/logout', function($req, $res) {
   
  # Unset user auth data..
  unset($req->session['logged']);
  unset($req->session['uid']);
  unset($req->session['lmatno']);
  unset($req->session['username']);
  unset($req->session['email']);
  unset($req->session['picture']);
  unset($req->cookies['logged']);

  session_destroy();

  # Redirect to login...

  if(isset($_GET['pass_updated'])) {
         $res->redirect('/login?pass_updated');

  } else {
         $res->redirect('/login?loggedOut');   
  }
 
});


$app->get('/x', function($req, $res) {
  global $app;
  $ORM = $app->_ORM;
  $insert = $ORM->insert('user', array('username', 'password', 'email', 'picture'), array('ahkohd', 1234, 'ahkohd@gmail.com', 'default'));
  if($insert) {
    echo 'successfully inserted';
  } else {
    echo 'Unable to insert';
  }
});


