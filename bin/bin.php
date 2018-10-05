<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

setcookie('username', 'victor', time() + (86400 * 30), "/");

/*
 * 
$app->get('/', function($req, $res){
    echo 'HEADER: '.$req->header['X-Powered-By'].'<br/>';
    echo 'URI: '.$req->uri.'<br/>';
    echo 'GET REQUEST '.$req->query['id'].'<br/>';
    var_dump($req->body);
});

 */

///////////////////////////////////////////////////////



 
/* 
 |_____________________________________
 |                                    |
 |  Routes                            |
 |____________________________________|
 |
 */
 
$app->get('/', function($req, $res){
   echo 'home page';
   header('Content-type:text/plain');   
   $req->update_http_headers();
   echo $req->header['Content-type'];
});


$app->post('/', function($req, $res){
   echo 'POSTED: ';
   echo $req->body['user'];
});

$app->get('/profile/[i:id]/[a:pass]', function($req, $res){
   echo 'profile';  
   echo $req->params['pass'];
});
$app->get('/user/[i:id]', function($req, $res){
   echo 'user'; 
   echo $req->params['id'];
});
$app->get('/about', function($req, $res){
   echo 'about'; 
});


$app->post('/', function($req, $res){
   $res->send('You POSTED: '.$req->body['username'], array(
      'Content-type'=>'text/plain' 
   ));
});