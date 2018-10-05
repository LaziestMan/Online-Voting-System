


<?php

class Example {
  public function __construct() {
  echo 'Constructor';
  }

  public function __get($name) {
    switch($name) {
      case 'get':
       return $_GET;
       break;
       case 'body':
       return $_POST;
       break;
    }
  }
}

$app = new Example();
echo $app->get['id'];
var_dump($app->post);