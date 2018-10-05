<?php include 'tpl/head.php'; ?>
<?php include 'tpl/header.php'; ?>
<body>

<div class="container">


<br/>
<br/>
<br/>
<br/>
<br/>
<form method="POST" action="<?php echo $data['app']->get('basePath').'/register'; ?>">
<input type="text" name="username" placeholder="Enter your Username"/><br>
<input type="email" name="email" placeholder="Enter your Email"/><br/>
<input type="submit" value="Submit"/>
</form>  
  
</div>

</body>
<?php include 'tpl/end.php'; ?>

