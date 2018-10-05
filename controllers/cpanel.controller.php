<?php

function generateAJAXToken($res) {
	# Method to generate a token for ajax call verification...
	$token = md5(rand(9900, 1111));
	$res->setSession('token', $token);
}

function auth_ajax($req, $res, $action) {

	// error_reporting(0);

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])=='xmlhttprequest') {
		# Request identified as an ajax request...

		if(isset($req->body['token']) && $req->body['token']==$req->session['token']) {
			# Authentication passed, do the AJAX call..

			$action();

		} else {
			echo 'Nice try!';
		}
		
	} else {
		'Opps! not an AJAX call';
	}
}

$app->get('/cpanel', function($req, $res) {
  global $app;
  $res->render('cpanel', array('appName'=>'Votify', 'title'=>'Cpanel', 'app'=>$GLOBALS['app'], 'session'=>$req->session));
  if(isset($req->session['flash'])) {
    $res->setSession('flash', NULL);  
  }

});

$app->get('/cpanel/user', function($req, $res) {
  global $app;

  # AJAX token Generation...
  generateAJAXToken($res);

  # ORM Module...
  $ORM = $app->_ORM;

  $users = $ORM->select('*', 'user', '');

  $res->render('cpanel.user', array('appName'=>'Votify', 'title'=>'Cpanel :: User', 'app'=>$GLOBALS['app'], 'session'=>$req->session, 'users'=>$users));
  if(isset($req->session['flash'])) {
    $res->setSession('flash', NULL);  
  }

});


$app->get('/cpanel/candidate', function($req, $res) {
  global $app;

  # AJAX token Generation...
  generateAJAXToken($res);

  # ORM Module...
  $ORM = $app->_ORM;

  $res->render('cpanel.candidate', array('appName'=>'Votify', 'title'=>'Cpanel :: Candidate', 'app'=>$GLOBALS['app'], 'session'=>$req->session));
  if(isset($req->session['flash'])) {
    $res->setSession('flash', NULL);  
  }

});


$app->get('/cpanel/vote', function($req, $res) {
  global $app;

  # AJAX token Generation...
  generateAJAXToken($res);

  # ORM Module...
  $ORM = $app->_ORM;

  $res->render('cpanel.vote', array('appName'=>'Votify', 'title'=>'Cpanel :: Vote', 'app'=>$GLOBALS['app'], 'session'=>$req->session));
  if(isset($req->session['flash'])) {
    $res->setSession('flash', NULL);  
  }

});













# AJAX ROUTES...

$app->post('/cpanel/user/importExcel', function($req, $res) {
  global $app;

		auth_ajax($req, $res, function(){
			global $app;
		# Our AJAX goes here...

		# ORM Module...
  		$ORM = $app->_ORM;



    $path = $_SERVER['DOCUMENT_ROOT'].$app->basePath."/uploads/";

     //set your folder path
    //set the valid file extensions 
    $valid_formats = array("csv"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 20988880) { // check if the file size is more than 20 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

                # actual uploade file name...
                $fileName =  $path.$file_name.'.'.$ext;
                if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                    echo "File uploaded successfully!!";

                  


                    $response = '<br/><br/><br/><div class="table-
                    $responsive"><table class="table"><thead><tr><th>#</th><th
                    $>User</th><th>status</th><th>Details</th></tr></thead><tb
                    $ody>';

                    	$app->import('ExpressCSV');

                    	$result = $app->_ExpressCSV->importCSV($fileName, 4);
                    	$result_count = count($result);

                    	for($i=0; $i<$result_count;$i++) {
                    		# Insert the result row by  row...

                    		$response = $response.'<tr><td>'.($i+1).'</td><td>'.$result[$i][0].'</td>';
                    		$select = $ORM->select('username', 'user', array(array('matno'=>array('$equal'=>$result[$i][1]))));

                    		if($select==NULL) {
                    			# User does not exists in database add user..
                    			if($ORM->insert('user', array('username', 'matno', 'email', 'phone_number'), array($result[$i][0], $result[$i][1], $result[$i][2], $result[$i][3]))) {

                    					$response = $response.'<td> <img src="'.$app->basePath.'/public/imgs/imported.png"/></td>';
                    					$response = $response.'<td> Imported!</td></tr>';

			                    	} else {

			                    		$response = $response.'<td> <img src="'.$app->basePath.'/public/imgs/not_imported.png"/> </td>';
			                    		$response = $response.'<td> An Error Ocurred While Importing. </td></tr>';
			                    	}
                    		} else {
                    			$response = $response.'<td> <img src="'.$app->basePath.'/public/imgs/not_imported.png"/></td>';

                    			$response = $response.'<td> Already Exists In Database</td></tr>';
                    		}


                    	}
    

                    	$response = $response.'</tbody></table></div>';

                    	echo $response;

                    	unlink($fileName);

                } else {
                    echo "failed";
                }
            } else {
                echo "File size max 20 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;


		});


});



$app->post('/cpanel/vote/evict_office', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

      # Clean form data
      $pid = $app->_ExpressValidator->clean($_POST['pid']);

        $query = "DELETE FROM public_office WHERE pid='".$pid."'";
        if($ORM->db->query($query)) {
          echo 'deleted';
        } else {
          echo 'err-delete';
        }
    });


});

$app->post('/cpanel/vote/evict_election', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

      # Clean form data
      $eid = $app->_ExpressValidator->clean($_POST['eid']);

        $query = "DELETE FROM election_tbl WHERE eid='".$eid."'";
        if($ORM->db->query($query)) {
          echo 'deleted';
        } else {
          echo 'err-delete';
        }
    });


});


$app->post('/cpanel/candidate/evict_candidate', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

      # Clean form data
      $cid = $app->_ExpressValidator->clean($_POST['cid']);

        $query = "DELETE FROM candidate_tbl WHERE cid='".$cid."'";
        if($ORM->db->query($query)) {
          echo 'deleted';
        } else {
          echo 'err-delete';
        }
});


});

$app->post('/cpanel/user/delete', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

      # Clean form data
      $uid = $app->_ExpressValidator->clean($_POST['uid']);

        $query = "DELETE FROM user WHERE uid='".$uid."'";
        if($ORM->db->query($query)) {
          echo 'deleted';
        } else {
          echo 'err-delete';
        }
    });


});



$app->post('/cpanel/vote/listPublic', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

      $data = $ORM->select('*', 'public_office', '');

      if($data==null) {
        echo 'null';
      } else {
        echo json_encode($data);
      }

        
    });


});



$app->post('/cpanel/candidate/listPublic', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

      $data = $ORM->select('*', 'candidate_tbl', '');
      

      if($data==null) {
        echo 'null';
      } else {

          $len = count($data);

          for($i=0;$i<$len;$i++) {
            $data1 = $ORM->select('*', 'public_office', array(array('pid'=>array('$equal'=>$data[$i]['pid_fk']))));
            $data[$i]['public_office'] = $data1;
          }

        echo json_encode($data);
      }
 
        
    });


});

$app->post('/cpanel/vote/listElection', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

      $data = $ORM->select('*', 'election_tbl', '');
      

      if($data==null) {
        echo 'null';
      } else {

          $len = count($data);

        // convert timestamp to real date

          for($x=0;$x<$len;$x++) {
            $stamp_starts = date("Y/m/d h:i:a", $data[$x]['e_start']);
            $stamp_ends = date("Y/m/d h:i:a", $data[$x]['e_end']);
            $data[$x]['e_start_date'] = $stamp_starts;
            $data[$x]['e_end_date'] = $stamp_ends;

          }


          for($i=0;$i<$len;$i++) {
            $data1 = $ORM->select('*', 'public_office', array(array('pid'=>array('$equal'=>$data[$i]['pid_fk']))));
            $data[$i]['public_office'] = $data1;
          }

        echo json_encode($data);
      }
 
        
    });


});


$app->post('/cpanel/vote/addPublicOffice', function($req, $res) {
  global $app;

		auth_ajax($req, $res, function(){
			global $app;
		# Our AJAX goes here...

			 # ORM Module...
			 $ORM = $app->_ORM;

       # Validator Module...
       $VALIDATE = $app->_ExpressValidator;

		  // GET FORM DATA
       $office = $_POST['office'];
       $office_desc = $_POST['office_desc'];

       $office = $VALIDATE->sanitaize('string', $office);
       $office_desc = $VALIDATE->sanitaize('string', $office_desc);

       $office = $VALIDATE->clean($office);
       $office_desc = $VALIDATE->clean($office_desc);

         # Validate the form...
        $officeErr = $office_descErr = FALSE;



         if(empty($office)) {
          $officeErr = "Public name cannot be empty";
          echo $officeErr;
        } else {
          if (!preg_match("/^[a-zA-Z0-9 ().]*$/", $office)) {
            $officeErr = "Only Alphanumeric character, whitespaces, fullstop and () allowed.";
           echo $officeErr;
          }
        }


        if(empty($office_desc)) {
            $office_descErr = "Public Office description cannot be empty";
            echo $office_descErr;
        }

        if($officeErr==FALSE && $office_descErr==FALSE) {

          
          date_default_timezone_set("Africa/Lagos");

          if($ORM->insert('public_office', array('pub_name', 'pub_desc', 'pub_date'), array($office, $office_desc, date('D d, M Y')))) {
            echo 'success';
          } else {
            echo 'error';
          }


        }


				
		});


});



$app->post('/cpanel/candidate/updateCandidateOffice', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

       # Validator Module...
       $VALIDATE = $app->_ExpressValidator;

      // GET FORM DATA
       $cid = $_POST['cid'];
       $can_name = $_POST['can_name'];
       $can_select = $_POST['can_select'];
       $can_manifesto = $_POST['can_manifesto'];

       $cid= $VALIDATE->sanitaize('string', $cid);
       $can_name = $VALIDATE->sanitaize('string', $can_name);
       $can_select = $VALIDATE->sanitaize('string', $can_select);
       $can_mainfesto = $VALIDATE->sanitaize('string', $can_manifesto);

       $cid = $VALIDATE->clean($cid);
       $can_name = $VALIDATE->clean($can_name);
       $can_select = $VALIDATE->clean($can_select);
       $can_mainfesto = $VALIDATE->clean($can_mainfesto);

         # Validate the form...
        $cidErr = $can_nameErr = $can_selectErr = $can_manifestoErr = FALSE;



         if(empty($can_name)) {
          $can_nameErr = "Candidate name cannot be empty";
          echo $can_nameErr;
        } else {
          if (!preg_match("/^[a-zA-Z0-9 ().]*$/", $can_name)) {
            $can_nameErr = "Only Alphanumeric character, whitespaces, fullstop and () allowed.";
           echo $can_nameErr;
          }
        }

         if(empty($cid)) {
          $cidErr = "Candidate ID required";
          echo $cidErr;
        } else {
          if (!preg_match("/^[0-9]*$/", $cid)) {
            $cidErr = "Only numneric allowed.";
           echo $cidErr;
          }
        }

         if(empty($can_select)) {
          $can_selectErr = "Public ID required";
          echo $can_selectErr;
        } else {
          if (!preg_match("/^[0-9]*$/", $can_select)) {
            $can_selectErr = "Only numneric allowed.";
           echo $can_selectErr;
          }
        }


        if(empty($can_manifesto)) {
            $can_manifestoErr = "Candidate Manifesto cannot be empty";
            echo $can_manifestoErr;
        }

        if($cidErr==FALSE && $can_nameErr==FALSE&& $can_selectErr==FALSE && $can_manifestoErr==FALSE) {


          if($ORM->db->query("UPDATE candidate_tbl SET can_name = '".$can_name."', pid_fk = ".$can_select.", can_manifesto='".$can_manifesto."' WHERE cid=".$cid)) {
            echo 'success';
          } else {

            echo 'Opp! An error occured while trying to update the candidate.';
          }


        }


        
    });


});




$app->post('/cpanel/vote/updatePublicOffice', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

       # Validator Module...
       $VALIDATE = $app->_ExpressValidator;

      // GET FORM DATA
       $office_pid = $_POST['office_pid'];
       $office = $_POST['office'];
       $office_desc = $_POST['office_desc'];

       $office_pid= $VALIDATE->sanitaize('string', $office_pid);
       $office = $VALIDATE->sanitaize('string', $office);
       $office_desc = $VALIDATE->sanitaize('string', $office_desc);

       $office_pid = $VALIDATE->clean($office_pid);
       $office = $VALIDATE->clean($office);
       $office_desc = $VALIDATE->clean($office_desc);

         # Validate the form...
        $office_pidErr = $officeErr = $office_descErr = FALSE;



         if(empty($office)) {
          $officeErr = "Public name cannot be empty";
          echo $officeErr;
        } else {
          if (!preg_match("/^[a-zA-Z0-9 ().]*$/", $office)) {
            $officeErr = "Only Alphanumeric character, whitespaces, fullstop and () allowed.";
           echo $officeErr;
          }
        }

         if(empty($office_pid)) {
          $office_pidErr = "Public ID required";
          echo $office_pidErr;
        } else {
          if (!preg_match("/^[0-9]*$/", $office_pid)) {
            $office_pidErr = "Only numneric allowed.";
           echo $office_pidErr;
          }
        }


        if(empty($office_desc)) {
            $office_descErr = "Public Office description cannot be empty";
            echo $office_descErr;
        }

        if($officeErr==FALSE && $office_descErr==FALSE&& $office_pidErr==FALSE) {


          if($ORM->db->query("UPDATE public_office SET pub_name = '".$office."', pub_desc='".$office_desc."' WHERE pid=".$office_pid)) {
            echo 'success';
          } else {

            echo 'Opp! An error occured while trying to update the public office';
          }


        }


        
    });


});





$app->post('/cpanel/candidate/addCandidate', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

       # Validator Module...
       $VALIDATE = $app->_ExpressValidator;

      // GET FORM DATA
       $can_name = $_POST['can_name'];
       $can_select = $_POST['can_select'];
       $can_manifesto = $_POST['can_manifesto'];

       $can_name = $VALIDATE->sanitaize('string', $can_name);
       $can_select = $VALIDATE->sanitaize('string', $can_select);
       $can_manifesto = $VALIDATE->sanitaize('string', $can_manifesto);

       $can_name = $VALIDATE->clean($can_name);
       $can_select = $VALIDATE->clean($can_select);
       $can_manifesto = $VALIDATE->clean($can_manifesto);

         # Validate the form...
        $can_nameErr = $can_manifestoErr = $can_selectErr = FALSE;



         if(empty($can_name)) {
          $can_nameErr = "Candidate name cannot be empty";
          echo $can_nameErr;
        } else {
          if (!preg_match("/^[a-zA-Z0-9 ().]*$/", $can_name)) {
            $can_nameErr = "Only Alphanumeric character, whitespaces, fullstop and () allowed.";
           echo $can_nameErr;
          }
        }

        if(empty($can_select)) {
          $can_selectErr = "Public Office ID cannot be empty";
          echo $can_selectErr;
        } else {
          if (!preg_match("/^[0-9]*$/", $can_select)) {
            $can_selectErr = "Only numneric characters are allowed.";
           echo $can_selectErr;
          }
        }


        if(empty($can_manifesto)) {
            $can_manifestoErr = "Candidate Manifesto cannot be empty";
            echo $can_manifestoErr;
        }

        if($can_nameErr==FALSE && $can_manifestoErr==FALSE && $can_selectErr == FALSE) {

          if($ORM->insert('candidate_tbl', array('can_name', 'can_manifesto', 'pid_fk', 'can_picture'), array($can_name, $can_manifesto, $can_select, 'default.png'))) {
            echo 'success';
          } else {
            echo 'error';
          }


        }


        
    });


});


# AJAX ROUTES...

$app->post('/cpanel/candidate/uploadPicture', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

    # ORM Module...
    $ORM = $app->_ORM;

    # Validator Module...
    $VALIDATE = $app->_ExpressValidator;


    $path = $_SERVER['DOCUMENT_ROOT'].$app->basePath."/public/imgs/candidate/";

     //set your folder path
    //set the valid file extensions 
    $valid_formats = array("jpg", "jpeg", "png", "JPG", "JPEG", "PNG"); //add the formats you want to upload

    $name = $_FILES['myfile']['name']; //get the name of the file
    
    $size = $_FILES['myfile']['size']; //get the size of the file

    if (strlen($name)) { //check if the file is selected or cancelled after pressing the browse button.
        list($txt, $ext) = explode(".", $name); //extract the name and extension of the file
        if (in_array($ext, $valid_formats)) { //if the file is valid go on.
            if ($size < 2098888) { // check if the file size is more than 2 mb
                $file_name = $_POST['filename']; //get the file name
                $tmp = $_FILES['myfile']['tmp_name'];

                # actual uploade file name...
                $fileName =  $path.$file_name.'.'.$ext;
                if (move_uploaded_file($tmp, $path . $file_name.'.'.$ext)) { //check if it the file move successfully.
                      
                      $cid = $_POST['cid'];
                      $cid = $VALIDATE->sanitaize('string', $cid);
                      $cid = $VALIDATE->clean($cid);

                      if(empty($cid)) {
                        $cidErr = "Candidate ID required";
                        echo $cidErr;
                      } else {
                        if (!preg_match("/^[0-9]*$/", $cid)) {
                          $cidErr = "Only numneric allowed.";
                         echo $cidErr;
                        }
                      }

                    if($ORM->db->query("UPDATE candidate_tbl SET can_picture='".$file_name.'.'.$ext."' WHERE cid=".$cid)) {


                       echo "Profile Picture uploaded successfully!!";
 
                    } else {
                      echo "Unable to update profile picture!!!";
                    }

                } else {
                    echo "failed";
                }
            } else {
                echo "File size max 2 MB";
            }
        } else {
            echo "Invalid file format..";
        }
    } else {
        echo "Please select a file..!";
    }
    exit;


    });


});




$app->post('/cpanel/vote/createElection', function($req, $res) {
  global $app;

    auth_ajax($req, $res, function(){
      global $app;
    # Our AJAX goes here...

       # ORM Module...
       $ORM = $app->_ORM;

       # Validator Module...
       $VALIDATE = $app->_ExpressValidator;

      // GET FORM DATA
       $e_name = $_POST['e_name'];
       $e_office = $_POST['e_office'];
       $e_starts = $_POST['e_starts'];
       $e_ends = $_POST['e_ends'];

       $e_name = $VALIDATE->sanitaize('string', $e_name);
       $e_office = $VALIDATE->sanitaize('string', $e_office);
       $e_starts = $VALIDATE->sanitaize('string', $e_starts);
       $e_ends = $VALIDATE->sanitaize('string', $e_ends);

       $e_name = $VALIDATE->clean($e_name);
       $e_office = $VALIDATE->clean($e_office);
       $e_starts = $VALIDATE->clean($e_starts);
       $e_ends = $VALIDATE->clean($e_ends);

         # Validate the form...
        $e_nameErr = $e_startsErr = $e_endsErr = $e_officeErr = FALSE;



         if(empty($e_name)) {
          $e_nameErr = "Election name cannot be empty";
          echo $e_nameErr;
        } else {
          if (!preg_match("/^[a-zA-Z0-9 ().]*$/", $e_name)) {
            $e_nameErr = "Only Alphanumeric character, whitespaces, fullstop and () allowed.";
           echo $e_nameErr;
          }
        }


         if(empty($e_office)) {
          $e_officeErr = "Public office ID cannot be empty";
          echo $e_officeErr;
        } else {
          if (!preg_match("/^[0-9]*$/", $e_office)) {
            $e_officeErr = "Only Numeric characters allowed.";
           echo $e_officeErr;
          }
        }

         if(empty($e_starts)) {
                  $e_startsErr = "Election starts when?";
                  echo $e_startsErr;
        }


        if(empty($e_ends)) {
            $e_endsErr = "Election ends when?";
            echo $e_endsErr;
        }


        if($e_nameErr==FALSE && $e_officeErr==FALSE && $e_startsErr==FALSE && $e_endsErr==FALSE) {

          // Set server date and time zone
          date_default_timezone_set("Africa/Lagos");

          // Convert the HUMAN READABLE DATE TIME to TIMESTAMP

          $e_starts = new DateTime($e_starts);
          $e_starts = $e_starts->getTimestamp();
          $e_ends = new DateTime($e_ends);
          $e_ends = $e_ends->getTimestamp();

          if($ORM->insert('election_tbl', array('e_name', 'e_start', 'e_end', 'pid_fk', 'date_added'), array($e_name, $e_starts, $e_ends, $e_office, date('D d, M Y')))) {
            echo 'success';
          } else {
            echo 'error';
          }

        }


        
    });


});


?>


