<?php include 'tpl/head.php'; ?>
<?php include 'tpl/header.php'; ?>
<body>


 <div class="container">
 	  <div class="jumbotron">
    <h1>Welcome <?php echo $data['session']['username']; ?></h1>
  </div>
  <div class="row">
    <div class="col-sm-4">
      <h3>Column 1</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
    <div class="col-sm-4">
      <h3>Column 2</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
    <div class="col-sm-4">
    <?php 
if(isset($data['session']['flash']) && $data['session']['flash']!==NULL) {

	switch($data['session']['flash']['level']) {
		case 'Error':
			$bg = '#F66358';
		break;
		case 'Success':
			$bg = '#6ABD6E"';
		break;
		case 'Warning':
			$bg = '#FFAA2B';
		break;
		case 'Info':
			$bg = '#47A8F5';
		break;
	}

	?>
<div class="alert-n" style="background:<?php echo $bg; ?> !important;">
      <span class="closebtn">&times;</span>
      <strong><?php echo $data['session']['flash']['level']; ?></strong>
      <?php echo $data['session']['flash']['msg']; ?>
</div>
	<?php
	unset($bg);
	
}
?>

    </div>
  </div>
</div>








<script src="<?php echo $GLOBALS['app']->basePath; ?>/public/js/script.js"></script>
     <script type="text/javascript">
  $(document).ready(function(){

     $(".closebtn").click(function(){
        $(".alert-n").fadeOut(1000);
     });
      
}); 
</script>

</body>
<?php include 'tpl/end.php'; ?>
