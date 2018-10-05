<?php include 'tpl/head.php'; ?>
<body id="body-login">


<style>
font-size: 100%;
</style>

<div class="container">
<div class="row login-plate">
  <div class="col-md-4"></div>
  <div class="col-md-4 login-form">
  <?php if(isset($data['err']['pass'])) {?>
     <div class="alert-n">
      <span class="closebtn">&times;</span>
      <strong>Error!</strong>
      <?php if(is_string($data['err']['pass'])) {echo $data['err']['pass']; } else {
          $len = count($data['err']['pass']);
          for($i=0; $i<$len; $i++) {
            echo '<br/>';
            echo "&times; ".$data['err']['pass'][$i];
          }
        } ?>


      </div>
      
   <?php } ?>

<form role="form" method="POST" action="<?php echo $GLOBALS['app']->basePath.'/account/change/password'; ?>" id="sign-in">
    <h3 class="h-tag" style="width:70%;">Change Password</h3>
  <div class="form-group">
    <label for="matno">New Password</label>
    <input type="text" name="newpass" class="form-control pin-box">
  </div>
  <div class="form-group">
    <label for="pwd">Re-type Password</label>
    <input type="text"  name="repass" class="form-control pin-box" id="pwd">
  </div>
  <button type="submit" class="btn btn-default login-btn">CHANGE PASSWORD</button>
</form>

  </div>
  <div class="col-md-4"></div>
</div>
</div>
    <div class="auth-foot">&copy; <?php echo date('Y'); ?> <?php echo $data['appName']; ?>. All rights reserved</div>
<script src="<?php echo $GLOBALS['app']->basePath; ?>/public/js/script.js"></script>
     <script type="text/javascript">
  $(document).ready(function(){

     $(".closebtn").click(function(){
        $(".alert-n").fadeOut(1000);
     });
      
}); 
</script>
</body>
</html>

