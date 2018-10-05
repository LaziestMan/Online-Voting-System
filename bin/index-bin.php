<?php

class App {

  public $modules = array();
  public function __construct() {
    echo "I am Express constructor <br/>";
  }

  public function __set($name, $value) {

    # Check if the property meets our module format:
    #     _MODULE_NAME

    if((strpos($name, '_')!==FALSE) && (strpos($name, '_')===0)) {
      # It is a module
      # Register the module...
      $this->modules[$name] = $value;
    } else {
      throw new Exception ('Cannot set '.$name.'. Not a defined class property', 1);
    }
  }

  public function __get($name) {
   #Check if the user is trying to get a module
    if((strpos($name, '_')!==FALSE) && (strpos($name, '_')===0)) {
        # true
        # return the appropriate module object
        if(array_key_exists($name, $this->modules)){

          // module exists return module object
          return $this->modules[$name];  
        } else {

          // module does exists return NULL
          return NULL;
        }
      } else {
        throw new Exception($name.' not a defined class property', 1);
      }
  }
}


$app = new App();

include 'module.php';
echo $app->_MODULE->greet();
//echo $app->test;


<?php

class App {

  public $modules = array();
  public function __construct() {
    echo "I am Express constructor <br/>";
  }

  public function __set($name, $value) {

    # Check if the property meets our module format:
    #     _MODULE_NAME

    if((strpos($name, '_')!==FALSE) && (strpos($name, '_')===0)) {
      # It is a module
      # Register the module...
      $this->modules[$name] = $value;
    } else {
      throw new Exception ('Cannot set '.$name.'. Not a defined class property', 1);
    }
  }

  public function __get($name) {
   #Check if the user is trying to get a module
    if((strpos($name, '_')!==FALSE) && (strpos($name, '_')===0)) {
        # true
        # return the appropriate module object
        if(array_key_exists($name, $this->modules)){

          // module exists return module object
          return $this->modules[$name];  
        } else {

          // module does exists return NULL
          return NULL;
        }
      } else {
        throw new Exception($name.' not a defined class property', 1);
      }
  }
}


$app = new App();

include 'module.php';
echo $app->_MODULE->greet();
//echo $app->test;


