<?php include 'tpl/head.php'; ?>
<?php include 'tpl/header.php'; ?>
<body>

<style>
.user-active {
	background: #6534AC;
}

.user-active a .icon-big {
  background: url('<?php echo $GLOBALS['app']->basePath; ?>/public/css/user-group_hover.png') no-repeat; 
}

</style>



 <div class="container-fluid admin-board">
  <div class="row">
  <div class="col-sm-1"></div>
<?php include 'cpanel.sidebar.php'; ?>
    <div class="col-sm-10 cpanel-content">

<br/>
<div class="c-tag">
<span class="icon-big icon-user-setting"><h1>Manage Users</h1></span></div>
<br/>
<br/>


<!-- Accordion -->
<ul class="nav nav-pills">
  <li class="active"><a data-toggle="pill" href="#home"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/excel.png'?>"/></span> Import Users Form Excel</a></li>
  <li><a data-toggle="pill" href="#menu1"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/add.png'?>"/></span> Add Users Manually</a></li>
  <li><a data-toggle="pill" href="#menu2"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/delete.png'?>"/></span> &nbsp;Evict Users</a></li>
</ul>

<div class="tab-content">
  <div id="home" class="tab-pane fade in active">
    <h3>Import Microsoft Excel CSV</h3>
    <p style="color:#AC96CD">Import users (Voters) form Microsoft Excel CSV document (.csv) file form your local drive.</p>

<!-- File upload -->
<div class="row">
<div class="col-md-1"></div>
<div class="col-md-6">
<form id="myform" method="post">
				<div class="row">

					<div class="col-lg-11">
                    <div class="form-group">
                        <label>Select file (.csv). Max file size 20MB </label>
                        <input class="form-control" type="file" id="myfile" />
                     <div class="form-group">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success myprogress progress-bar-striped" role="progressbar" style="width:0%">0%</div>
                        </div>

                        <div class="msg"></div>
                    </div>



                    </div>
                    </div>
                    <div class="col-lg-1"><br/>
                    <a href="<?php echo $data['app']->basePath.'/cpanel/user'; ?>"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/reload.png'?>"/></span></a>
                    </div>

                    </div>
                   

                    <input type="button" style="border-radius: 2px; padding: 0.7em 1.5em;" id="btn" class="btn btn-success" value="Import Excel CSV Document" />
                </form>
</div>

</div>

<!-- file upload -->








  </div>
  <div id="menu1" class="tab-pane fade">
    <h3>Menu 1</h3>
    <p>Some content in menu 1.</p>
  </div>
  <div id="menu2" class="tab-pane fade">
    <h3>Evict A voter</h3>
    <p>Following are the list of voters. Click on the delete button to evict a voter</p>

    

<!-- Evict Users -->
<?php if($data['users']==NULL) {
	echo "Opps! There are currently no voters. Please import voters.";

	} else { 
?>
<br/>           
  <div style="overflow: auto;height: 400px;">          
  <p>
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Username</th>
        <th>Matric Number</th>
        <th>Email</th>
        <th>User Level</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
<?php
		$user_len = count($data['users']);

		for($i=0;$i<$user_len; $i++) {

		?>

      <tr id="u<?php echo $data['users'][$i]['uid']; ?>">
        <td><?php echo $data['users'][$i]['uid']; ?></td>
        <td><?php echo $data['users'][$i]['username']; ?></td>
        <td><?php echo $data['users'][$i]['matno']; ?></td>
        <td><?php echo $data['users'][$i]['email']; ?></td>
        <td><?php if($data['users'][$i]['user_level']==1){ echo "Admin Voter"; }elseif($data['users'][$i]['user_level']==0){ echo "Voter"; } ?></td>
        <td><a onclick="evict('<?php echo $data['users'][$i]['uid']; ?>')" style="margin-right: 0.5em"><div class="icon icon-delete"></div></a></td>
      </tr>
<?php }?>
   </tbody>
  </table>
  </p>
  
  </div>
<?php } ?>

<!-- !Evict Users -->










  </div>
</div>








    </div>
    <div class="col-sm-1">
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
<script>
            $(function () {
            	$('.progress').hide();
                $('#btn').click(function () {
                    $('.myprogress').css('width', '0');
                    $('.msg').text('');
                    var myfile = $('#myfile').val();
                    if (myfile == '') {
                        alert('Please enter file name and select file');
                        return;
                    }
                    var formData = new FormData();
                    formData.append('myfile', $('#myfile')[0].files[0]);
                    $('#myfile').hide();
                    $('.progress').show();
                    var chromeHack = myfile.split('\\');
                    if(chromeHack.length>0) {
                      chromeHack = chromeHack[chromeHack.length-1];
                    }
                    formData.append('filename', chromeHack);
                    formData.append('token', '<?php echo $data['session']['token']; ?>');
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: '<?php echo $data['app']->basePath.'/cpanel/user/importExcel'?>',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        // this part is progress bar
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    percentComplete = parseInt(percentComplete * 100);
                                    $('.myprogress').text(percentComplete + '%');
                                    $('.myprogress').css('width', percentComplete + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        success: function (data) {
                            $('.msg').html(data);
                            $('#btn').removeAttr('disabled');
                        }
                    });
                });
            });
        </script>
     <script type="text/javascript">
  $(document).ready(function(){

     $(".closebtn").click(function(){
        $(".alert-n").fadeOut(1000);
     });
      
}); 
</script>
<script type="text/javascript">
	
	function evict(uid) {
		// AJAX to delete

     $.post("<?php echo $data['app']->basePath.'/cpanel/user/delete'?>",
    {
        uid: uid,
        token: "<?php echo $data['session']['token']; ?>"
    },
    function(data, status){
        if(status=="success" && data.trim()=='deleted') {
            $('#u'+uid).fadeOut("slow");
        } else {
            alert('err'+data);
        }
    });


		
	}
</script>
</body>
<?php include 'tpl/end.php'; ?>
