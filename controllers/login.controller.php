<?php

/**
  * User Login Controller
  */


# GET '/login' route...
$app->get('/login', function($req, $res){

  if(isset($req->session['logged'])) {
    # If user already logged in, redirect to /dashboard
    $res->redirect('/dashboard');
  } else {
    
  $res->render('login', array('appName'=>'LASU Voting System', 'title'=>'Login', 'app'=>$GLOBALS['app']));    
  }

});



# POST '/login' route...
$app->post('/login', function($req, $res) {

  global $app;
  $err = array();

  # ORM Module...
  $ORM = $app->_ORM;

  # Validator Module...
  $VALIDATE = $app->_ExpressValidator;

  # Get the submitted POST body...
  $matno = $req->body['matno'];
  $password = $req->body['password'];

  # Sanitaize the body...
  $matno = $VALIDATE->sanitaize('string', $matno);
  $password = $VALIDATE->sanitaize('string', $password);

  $matno = $VALIDATE->clean($matno);
  $password = $VALIDATE->clean($password);

  # Validate the form...
  $matnoErr = $passwordErr = FALSE;

  if(empty($matno)) {
    $matnoErr = "Matric number cannot be empty";
    array_push($err, $matnoErr); 
  } else {
    if (!preg_match("/^[0-9]*$/",$matno)) {
        $matnoErr = "Invalid Matric number format";
        array_push($err, $matnoErr);
    }
  }

  if(empty($password)) {

    //lets check if the user password field is empty, if so login the user
    // then tell to change the password

    $check = $ORM->select('password', 'user', array(array('matno'=>array('$equal'=>$matno)), 'and', array('password'=>array('$equal'=>''))));

    if($check!==NULL) {
      // This implies that the user is found
      // Proceed to check if password is empty

      if(empty($check['0']['password'])) {
        // This implies a new user. The user has to login and set password.
      } else {
        // This imples that password has already been set.
        $passwordErr = "Password cannot be empty";
        array_push($err, $passwordErr);
      }
    
    } else {
      // user not found, err
       $passwordErr = "Password cannot be empty";
       array_push($err, $passwordErr);
    }
  }

  if($matnoErr==FALSE && $passwordErr==FALSE) {

    # Form data pass validation...
    # Proceed to check record...
    $row = $ORM->select('uid,username,phone_number,matno,email,user_level', 'user', array(array('matno'=>array('$equal'=>$matno)), 'and', array('password'=>array('$equal'=>$password))));

    $num_rows =  count($row);
    if($row==NULL) {

      # A Record Is Not Found...
      $res->render('login', array('appName'=>'LASU Voting System', 'title'=>'Login', 'app'=>$GLOBALS['app'], 'err'=>array('login'=>'You have provided an invalid login details, please your input')));

    } else {

        # A Record Is Found...
        # SET USER SESSION...
        $res->setSession('logged', TRUE);
        $res->setSession('uid', $row[0]['uid']);
        $res->setSession('user_level', $row[0]['user_level']);
        $res->setSession('matno', $row[0]['matno']);
        $res->setSession('username', $row[0]['username']);
        $res->setSession('email', $row[0]['email']);
        $res->setSession('picture', $row[0]['picture']);

        # SET USER COOKIES...
        $res->setCookie('logged', TRUE, time() + (86400 * 30));

        # Redirect to dashboard...
        $res->redirect('/dashboard');
      } 

  } else {
    $res->render('login', array('appName'=>'LASU Voting System', 'title'=>'Login', 'app'=>$GLOBALS['app'], 'err'=>array('login'=>$err)));
  }
   
  
});


# GET '/account/change/password' route...

$app->get('/account/change/password', function($req, $res){
  $res->render('change_password', array('appName'=>'LASU Voting System', 'title'=>'Login', 'app'=>$GLOBALS['app']));
});





# POST '/account/change/password route...
$app->post('/account/change/password', function($req, $res) {

  global $app;
  $err = array();

  # ORM Module...
  $ORM = $app->_ORM;

  # Validator Module...
  $VALIDATE = $app->_ExpressValidator;

  # Get the submitted POST body...
  $newpass = $req->body['newpass'];
  $repass = $req->body['repass'];

  # Sanitaize the body...
  $newpass = $VALIDATE->sanitaize('string', $newpass);
  $repass = $VALIDATE->sanitaize('string', $repass);

  $newpass = $VALIDATE->clean($newpass);
  $repass = $VALIDATE->clean($repass);

  # Validate the form...
  $newpassErr = $repassErr = FALSE;


  if(empty($newpass)) {
    $newpassErr = "New Password cannot be empty";
    array_push($err, $newpassErr); 
  } else {
    if (!preg_match("/^[a-zA-Z0-9]*$/", $newpass)) {
      $newpassErr = "Only Alphanumeric character allowed.";
      array_push($err, $newpassErr);
    }
  }


  if(empty($repass)) {
       $repassErr = "Re-Password cannot be empty";
       array_push($err, $repassErr);
  } else {

    if (!preg_match("/^[a-zA-Z0-9]*$/", $repass)) {
            $repassErr = "Only Alphanumeric character allowed.";
            array_push($err, $repassErr);
      } else {

          if($repass!=$newpass) {
            $repassErr = "Re-Password do not match";
            array_push($err, $repassErr);
          }
      }
  }
  

  if($newpassErr==FALSE && $repassErr==FALSE) {

    # Form data pass validation...
    # Proceed to check record...
    
    $query = "UPDATE user SET password='".$newpass."' WHERE uid=".$req->session['uid'];

    if($ORM->db->query($query)) {
          // Password was successfully updated 
          $res->redirect('/logout?pass_updated');     
    } else {
      # A Record Is Not Found...
      $res->render('change_password', array('appName'=>'LASU Voting System', 'title'=>'Login', 'app'=>$GLOBALS['app'], 'err'=>array('pass'=>'An error has occured while updating password.')));

    }

    
  } else {
    $res->render('change_password', array('appName'=>'LASU Voting System', 'title'=>'Change Password', 'app'=>$GLOBALS['app'], 'err'=>array('pass'=>$err)));
  }
   
  
});
