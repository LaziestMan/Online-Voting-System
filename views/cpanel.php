<?php include 'tpl/head.php'; ?>
<?php include 'tpl/header.php'; ?>
<body>
<style>
.cpanel-active {
  background: #6534AC;
}

.cpanel-active a .icon-big {
  background: url('<?php echo $GLOBALS['app']->basePath; ?>/public/css/cpanel_hover.png') no-repeat; 
}
</style>




 <div class="container-fluid admin-board">
  <div class="row">
  <div class="col-sm-2"></div>
<?php include 'cpanel.sidebar.php'; ?>
    <div class="col-sm-8">
    </div>
    <div class="col-sm-2">
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
