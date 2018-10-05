<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" style="text-transform: uppercase; margin-top: 1px;" href="<?php echo $data['app']->basePath; ?>"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/logo.png'?>"/></span><?php echo $data['appName']; ?></a>
    </div>
    
    <ul class="nav navbar-nav navbar-right">  
    <li><a><div class="icon icon-user"></div></a></li>
    <li><span class="wel">Hello, <?php echo $data['session']['username']; ?></span></li>

    <?php if(isset($data['session']['user_level']) && $data['session']['user_level']==1){
        ?>
        <li><a href="<?php echo $data['app']->basePath.'/cpanel'?>"><div class="icon icon-admin"></div> </a></li>
        <?php
      }?>
      <li><a href="<?php echo $data['app']->basePath.'/logout'?>"><div class="icon icon-login"></div> </a></li>

    </ul>
  </div>
</nav>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>