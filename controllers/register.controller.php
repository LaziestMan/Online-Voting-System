<?php

/**
  * User Registration Controller
  */

$app->get('/register', function($req, $res){
  $res->render('register', array('appName'=>'LASU Voting System', 'title'=>'Registration', 'app'=>$GLOBALS['app']));
});


$app->post('/register', function($req, $res) {
  echo $req->body['username'];
  echo $req->body['email'];
});

?>