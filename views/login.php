<?php include 'tpl/head.php'; ?>
<body id="body-login">


<style>
font-size: 100%;
</style>

<div class="container">
<div class="row login-plate">
	<div class="col-md-4"></div>
	<div class="col-md-4 login-form">
  <?php if(isset($data['err']['login'])) {?>
     <div class="alert-n">
      <span class="closebtn">&times;</span>
      <strong>Error!</strong>
      <?php if(is_string($data['err']['login'])) {echo $data['err']['login']; } else {
          $len = count($data['err']['login']);
          for($i=0; $i<$len; $i++) {
            echo '<br/>';
            echo "&times; ".$data['err']['login'][$i];
          }
        } ?>
      </div>
      
   <?php } ?>



<?php if(isset($_GET['loggedOut'])) {?>
     <div class="alert-n" style="background:#6ABD6E !important;">
      <span class="closebtn">&times;</span>
      <strong>Success!</strong>
        Successfully logged out
      </div>
   <?php } ?>


   <?php if(isset($_GET['pass_updated'])) {?>
     <div class="alert-n" style="background:#6ABD6E !important;">
      <span class="closebtn">&times;</span>
      <strong>Success!</strong>
        Password successfully updated, please try logging in with your new password;
      </div>
   <?php } ?>

<form role="form" method="POST" action="<?php echo $GLOBALS['app']->basePath.'/login'; ?>" id="sign-in">
    <h3 class="h-tag">Sign In</h3>
  <div class="form-group">
    <label for="matno">Matric No.</label>
    <input type="text" name="matno" class="form-control mat-box">
  </div>
  <div class="form-group">
    <label for="pwd">Password</label>
    <input type="password"  name="password" class="form-control pin-box" id="pwd">
  </div>
    <br/>
  <span>Remember me</span>
  <div class="checkbox">
    <label class="switch">
  <input type="checkbox">
        <div class="slider round"></div>
</label>
  </div>
  <button type="submit" class="btn btn-default login-btn">SIGN IN</button>
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

