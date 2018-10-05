<?php include 'tpl/head.php'; ?>
<?php include 'tpl/header.php'; ?>
<body>
  <style>
  .vote-active {
  background: #6534AC;
  }
  .vote-active a .icon-big {
  background: url('<?php echo $GLOBALS['app']->basePath; ?>/public/css/rating_hover.png') no-repeat;
  }
  </style>
  <div class="container-fluid admin-board">
    <div class="row">
      <div class="col-sm-1"></div>
      <?php include 'cpanel.sidebar.php'; ?>
      <div class="col-sm-7 cpanel-content">

          <!-- UPDATE MODAL -->
          <!-- Trigger the modal with a button -->
          <div id="modalFacility"></div>

                <?php include 'tpl/vote.sub.php'; ?>
        </div>
        <div class="col-sm-4" style="padding-top: 13em;">
          <?php
          if(isset($data['session']['flash']) && $data['session']['flash']!==NULL) {
          switch($data['session']['flash']['level']) {
          case 'Error':
          $bg = '#F66358';
          break;
          case 'Success':
          $bg = '#6ABD6E';
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
          <div class="section-pane">Public Office</div>
          <!-- Accordion -->
          <div class="panel-group" id="accordion">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h5 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                  <span class="glyphicon glyphicon-list"></span> public Offices</a>
                  </h5>
                </div>
                <div id="collapse1" class="panel-collapse collapse in">
                  <div class="panel-body">
                    
                    <div id="office-spinner">  <div class="loader" style="display: table;margin: 2em auto;">
                      <div class="loader-inner ball-clip-rotate-multiple">
                        <div></div>
                        <div></div>
                      </div>
                    </div>
                  </div>
                  <div id="list-office"></div>
                </div>
              </div>
            </div>
            <div class="panel panel-default">
              <div class="panel-heading">
                <h5 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                  <span class="glyphicon glyphicon-plus"></span> Add a public office</a>
                  </h5>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                  <div class="panel-body">
                    
                    <!-- Add form-->
                    <div id="office-msg-err"><span class="closebtn-msg-err">&times;</span><p></p></div>
                    <div id="office-msg-success"><span class="closebtn-msg-success">&times;</span><p></p></div>
                    <form class="form-horizontal" role="form">
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="office">Office Name</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="office" placeholder="Enter Public office name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="pwd">Description</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="office-desc" placeholder="Enter short Description of the public office">
                        </div>
                      </div>
                    </form>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button onclick="addPublicOffice()" class="btn btn-success paper">Add Public Office</button>
                      </div>
                    </div>
                    <!-- Add form-->
                  </div>
                </div>
              </div>
            </div>
            <!-- !Accordion-->
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
      <script type="text/javascript">
      $('#list-office').hide();
      setInterval(listOffice, 5000);
      function listOffice() {
      $.post("<?php echo $data['app']->basePath.'/cpanel/vote/listPublic'?>",
      {
      token: "<?php echo $data['session']['token']; ?>"
      },
      function(data, status){
      var res = JSON.parse(data);
      if(data.trim()!=="null") {
      var tbl = '<div class="table-responsive"><table class="table"><thead><tr><th>#</th><th>Public Office</th><th>Description</th><th>Action</th></tr></thead><tbody>';
      var len = res.length;
      for(i=0;i<len;i++) {
      tbl = tbl+'<tr id="office'+res[i].pid+'"><td>'+(i+1)+'</td><td>'+res[i].pub_name+'</td><td>'+res[i].pub_desc+'</td><td> <a onclick=\'update_office_modal({pid:'+res[i].pid+', pub_name:"'+res[i].pub_name+'", pub_desc:"'+res[i].pub_desc+'"})\'><img src="<?php echo $data['app']->basePath.'/public/imgs/edit.png'?>"/></a> <a onclick="evict_office('+res[i].pid+')"><img src="<?php echo $data['app']->basePath.'/public/imgs/not_imported.png'?>"/></a></td></tr>';
      }
    tbl = tbl+'</tbody></table></div>';
    $('#office-spinner').hide();
    $('#list-office').fadeIn(1000);
    $('#list-office').html(tbl);
    
    } else {
    $('#list-office').html("&nbsp;&nbsp;Err! There are currently no public Offices...");
    }
    });
    }
    
    </script>
    <script type="text/javascript">
    function addPublicOffice() {
    var office = $('#office').val();
    var office_desc = $('#office-desc').val();
    var msg_err = $('#office-msg-err');
    var msg_success = $('#office-msg-success');
    if(office=='') {
    msg_err.css('display', 'block');
    $('#office-msg-err p').append('&bullet; Office Name cannot be empty');
    
    }
    if(office_desc=='') {
    msg_err.css('display', 'block');
    $('#office-msg-err p').append('<br/>&bullet; Office Description cannot be empty');
    }
    
    if(office!=='' & office_desc!=='') {
    // SEND THE AJAX POST
    $.post("<?php echo $data['app']->basePath.'/cpanel/vote/addPublicOffice'?>",
    {
    token: "<?php echo $data['session']['token']; ?>",
    office: office,
    office_desc: office_desc
    }, function(data, status){
    if(data.trim()=='success') {
    msg_success.css('display', 'block');
    $('#office-msg-success p').append('<br/>&bullet; Public office succesfully added.');
    } else {
    
    msg_err.css('display', 'block');
    $('#office-msg-err p').append('<br/>&bullet;'+data);
    }});
    }
    }
    $(".closebtn-msg-success").click(function(){
    $("#office-msg-success").fadeOut(1000);
    $("#office-msg-success p").html('');
    });
    $(".closebtn-msg-err").click(function(){
    $("#office-msg-err").fadeOut(1000);
    $("#office-msg-err p").html('');
    });
    </script>
    <script type="text/javascript">
    function evict_office(pid) {
    // CREATE AJAX REQUEST TO EVICT A PUBLIC OFFICE
    $.post("<?php echo $data['app']->basePath.'/cpanel/vote/evict_office'?>",
    {
    pid: pid,
    token: "<?php echo $data['session']['token']; ?>"
    },
    function(data, status){
    if(status=="success" && data.trim()=='deleted') {
    $('#office'+pid).fadeOut("slow");
    } else {
    alert('err'+data);
    }
    });
    }
    function update_office_modal(o) {
    var modal = '<style>#mOfficeName, #mOfficeDesc{ border:2px solid #e7e7e7; box-shadow: none!important; border-radius: 5px !important;} #mOfficeName:focus, #mOfficeDesc:focus { border: 2px solid #00aced;}</style><!-- Modal --><div id="updateOfficeModal" class="modal fade" role="dialog"><div class="modal-dialog"><!-- Modal content--><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Update '+o.pub_name+' Office</h4></div><div class="modal-body" id="modal-form"><!-- update office form -->                    <!-- Add form--><div id="moffice-msg-success"><span class="mclosebtn-msg-success">&times;</span><p></p></div><div id="moffice-msg-err"><span class="mclosebtn-msg-err">&times;</span><p></p></div>   <form role="form"><br/><div class="form-group"><label for="office">Office name</label><input type="text" class="form-control" id="mOfficeName" value="'+o.pub_name+'"></div><br/><div class="form-group"><label for="mOfficeDesc">Office description:</label><input type="text" class="form-control" id="mOfficeDesc"  value="'+o.pub_desc+'"></div><br/></form><a class="btn btn-info" onclick="update_office('+o.pid+')">Update Office Details</a></div></div></div></div>';
    // inject the prepared modal
    $("#modalFacility").html(modal);
    // display update public office modal
    $("#updateOfficeModal").modal();
    }
    function update_office(pid) {
    // Do form validation
    var mOfficeName = $("#mOfficeName").val();
    var mOfficeDesc = $("#mOfficeDesc").val();
    var msg_err = $('#moffice-msg-err');
    var msg_success = $('#moffice-msg-success');
    if(mOfficeName=='') {
    msg_err.css('display', 'block');
    $('#moffice-msg-err p').append('&bullet; Office Name cannot be empty');
    
    }
    if(mOfficeDesc=='') {
    msg_err.css('display', 'block');
    $('#moffice-msg-err p').append('<br/>&bullet; Office Description cannot be empty');
    }
    if(mOfficeName!=='' & mOfficeDesc!=='') {
    // SEND THE AJAX POST
    $.post("<?php echo $data['app']->basePath.'/cpanel/vote/updatePublicOffice'?>",
    {
    token: "<?php echo $data['session']['token']; ?>",
    office: mOfficeName,
    office_pid: pid,
    office_desc: mOfficeDesc
    }, function(data, status){
    if(data.trim()=='success') {
    msg_success.css('display', 'block');
    $('#moffice-msg-success p').append('<br/>&bullet; Public office succesfully added.');
    } else {
    
    msg_err.css('display', 'block');
    $('#moffice-msg-err p').append('<br/>&bullet;'+data);
    }});
    }
    $(".mclosebtn-msg-success").click(function(){
    $("#moffice-msg-success").fadeOut(1000);
    $("#moffice-msg-success p").html('');
    });
    $(".mclosebtn-msg-err").click(function(){
    $("#moffice-msg-err").fadeOut(1000);
    $("#moffice-msg-err p").html('');
    });
    }
    </script>
  </body>
  <?php include 'tpl/end.php'; ?>