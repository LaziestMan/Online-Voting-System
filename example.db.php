<?php

$app->get('/dbExample', function($req, $res) {
  global $app;
  
  $ORM = $app->_ORM;
  $row = $ORM->select('uid, email', 'user', array(array('username'=>array('$equal'=>'timmy')), 'and', array('password'=>array('$equal'=>'2222'))));
  
  $num_rows =  count($row);
  if($row==NULL) {
    echo 'User not found';
  } else {
    for($i=0;$i<$num_rows;$i++) {
      echo "UID: ".$row[$i]['uid']." EMAIL: ".$row[$i]['email'];
      echo "<br/>";
    }  
  }
  

});

?>