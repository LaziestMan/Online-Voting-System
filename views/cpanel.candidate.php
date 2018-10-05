<?php include 'tpl/head.php'; ?>
<?php include 'tpl/header.php'; ?>
<body>
  <style>
  .candidate-active {
  background: #6534AC;
  }
  .candidate-active a .icon-big {
  background: url('<?php echo $GLOBALS['app']->basePath; ?>/public/css/candidate_hover.png') no-repeat;
  }
  </style>
  <div class="container-fluid admin-board">
    <div class="row">
      <div class="col-sm-1"></div>
      <?php include 'cpanel.sidebar.php'; ?>
      <div class="col-sm-7 cpanel-content">
        <br/>
        <div class="c-tag">
          <span class="icon-big icon-candidate"><h1>Candidate Control Service</h1></span></div>
          <br/>
          <br/>
          <!-- Accordion -->
          <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/candidate.png'?>"/></span>Candidates Profile</a></li>
          </ul>
          <div class="profile-pane" style="width: 100% !important;">
            <div id="profile-facility" style="position: relative;">
              <div class="loader profile-loader">
                <div class="loader-inner line-scale" style="margin-left: 5em;">
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
                Fetching Candidates Profile...
              </div>
            </div>
          </div>
          <!-- UPDATE MODAL -->
          <!-- Trigger the modal with a button -->
          <div id="modalFacility"></div>
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
          <div class="section-pane">Candidate Control</div>
          <!-- Accordion -->
          <div class="panel-group" id="accordion">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h5 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                  <span class="glyphicon glyphicon-list"></span> Candidates</a>
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
                  <span class="glyphicon glyphicon-plus"></span> Add candidate </a>
                  </h5>
                </div>
                <div id="collapse2" class="panel-collapse collapse">
                  <div class="panel-body">
                    
                    <!-- Add form-->
                    <div id="office-msg-err"><span class="closebtn-msg-err">&times;</span><p></p></div>
                    <div id="office-msg-success"><span class="closebtn-msg-success">&times;</span><p></p></div>
                    <form class="form-horizontal" role="form">
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="can-name">Candidate Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="can-name" placeholder="Enter Candidate name">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="can-office">Select Public Office</label>
                        <div class="col-sm-10" id="select-office">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="can-manifesto">Candidate Manifesto</label>
                        <div class="col-sm-10">
                          <textarea name="can-manifesto" id="can-manifesto" style="width:100%;height: 100px;padding:10px !important;color: #666; text-align: left!;" placeholder="Candidate Manifesto Goes here..."></textarea>
                        </div>
                      </div>
                    </form>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button onclick="addCandidate()" class="btn btn-success paper">Add Candidate</button>
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
      $.post("<?php echo $data['app']->basePath.'/cpanel/candidate/listPublic'?>",
      {
      token: "<?php echo $data['session']['token']; ?>"
      },
      function(data, status){
      var res = JSON.parse(data);
      global_res = res;
      if(data.trim()!=="null") {
      var tbl = '<div class="table-responsive"><table class="table"><thead><tr><th>#</th><th>Candidate Name</th><th>Contesting Office</th><th>Action</th></tr></thead><tbody>';
      var profile = '<div class="table-responsive"><table class="table profile-tbl"><thead><tr><th>&nbsp;</th><th>&nbsp;</th></tr></thead><tbody>';
      var len = res.length;
      
      for(i=0;i<len;i++) {
      // CONSTRUCTING TABLE
      // HACK
      
      tbl = tbl+'<tr id="candidate-tr'+res[i].cid+'"><td>'+(i+1)+'</td><td>'+res[i].can_name+'</td><td>'+res[i].public_office[0].pub_name+'</td><td> <a onclick=\'update_candidate_modal(global_res, '+i+')\'><img src="<?php echo $data['app']->basePath.'/public/imgs/edit.png'?>"/></a> <a onclick="evict_candidate('+res[i].cid+')"><img src="<?php echo $data['app']->basePath.'/public/imgs/not_imported.png'?>"/></a> <a onclick="update_candidate_pics_modal(global_res, '+i+')"><img src="<?php echo $data['app']->basePath.'/public/imgs/cam_16.png'?>"/></a></td></tr>';
      // CONSTRUCT PROFILE DISPLAY
      profile = profile+'<tr><td style="width:15% !important;padding: 1em;"><img src="<?php echo $data['app']->basePath.'/public/imgs/candidate/'?>'+res[i].can_picture+'" class="img-responsive can-pic"/><br/></td>  <td><h5><img src="<?php echo $data['app']->basePath.'/public/imgs/candidate_16.png'?>" style="margin-right:0.3em;"/>'+res[i].can_name+'</h5> <h5 style="margin-left:2em !important;"><img src="<?php echo $data['app']->basePath.'/public/imgs/office_16.png'?>" style="margin-right:0.3em;"/>'+res[i].public_office[0].pub_name+'</h5><br/><h4>MANIFESTO</h4><p class="well"> '+res[i].can_manifesto+'</p></td></tr>';
      //<({pid:'+res[i].pid+', pub_name:"'+res[i].pub_name+'", pub_desc:"'+res[i].pub_desc+'"})\
      }
    tbl = tbl+'</tbody></table></div>';
  profile = profile+'</tbody></table></div>';
  $('#office-spinner').hide();
  $('#list-office').fadeIn(1000);
  $('#list-office').html(tbl);
  $('#profile-facility').html(profile);
  
  } else {
  $('#list-office').html("&nbsp;&nbsp;Err! There are currently no public Offices...");
  }
  });
  }
  
  </script>
  <script type="text/javascript">
  // ADD candiate function
  function addCandidate() {
  var can_name = $('#can-name').val();
  var can_manifesto = $('#can-manifesto').val();
  var can_select = $('#sel1').val();
  var msg_err = $('#office-msg-err');
  var msg_success = $('#office-msg-success');
  if(can_name=='') {
  msg_err.css('display', 'block');
  $('#office-msg-err p').append('&bullet; Candidate name cannot be empty');
  
  }
  if(can_manifesto=='') {
  msg_err.css('display', 'block');
  $('#office-msg-err p').append('<br/>&bullet; Candidate Manifesto cannot be empty');
  }
  
  if(can_name!=='' & can_manifesto!=='') {
  // SEND THE AJAX POST
  $.post("<?php echo $data['app']->basePath.'/cpanel/candidate/addCandidate'?>",
  {
  token: "<?php echo $data['session']['token']; ?>",
  can_name: can_name,
  can_manifesto: can_manifesto,
  can_select: can_select
  }, function(data, status){
  if(data.trim()=='success') {
  msg_success.css('display', 'block');
  $('#office-msg-success p').append('<br/>&bullet; Candidate succesfully added.');
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
  function evict_candidate(cid) {
  // CREATE AJAX REQUEST TO EVICT A Candidate
  $.post("<?php echo $data['app']->basePath.'/cpanel/candidate/evict_candidate'?>",
  {
  cid: cid,
  token: "<?php echo $data['session']['token']; ?>"
  },
  function(data, status){
  if(status=="success" && data.trim()=='deleted') {
  $('#candidate-tr'+cid).fadeOut("slow");
  } else {
  alert('err'+data);
  }
  });
  }
  function update_candidate_modal(o, cid) {
  var modal = '<style> #mcan-name, #mcan-manifesto, #mcan-select { border:3px solid #e7e7e7; box-shadow: none!important; border-radius: 5px !important;} #mcan-name:focus, #mcan-manifesto:focus, #mcan-select:focus { border: 3px solid #00aced;}</style><!-- Modal --><div id="updateOfficeModal" class="modal fade" role="dialog"><div class="modal-dialog"><!-- Modal content--><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Update '+o[cid].can_name+' Profile</h4></div><div class="modal-body" id="modal-form"><!-- update candidate form -->                    <!-- Add form--><div id="moffice-msg-success"><span class="mclosebtn-msg-success">&times;</span><p></p></div><div id="moffice-msg-err"><span class="mclosebtn-msg-err">&times;</span><p></p></div>   <form role="form"><br/><div class="form-group"><label for="mcan-name">Candidate name</label><input type="text" class="form-control" id="mcan-name" value="'+o[cid].can_name+'"></div><br/><div class="form-group"><label for="mcan-name">Select Public Office</label><div id="mcan-select-inject"></div></div><br/><div class="form-group"><label for="mcan-name"> Candidate Manifesto:</label><br/><textarea id="mcan-manifesto" style="width:100%; height:100px;">'+o[cid].can_manifesto+'</textarea></div><br/></form><a class="btn btn-info" onclick="update_candidate('+o[cid].cid+')">Update Candidate Profile</a></div></div></div></div>';
  // inject the prepared modal
  $("#modalFacility").html(modal);
  // inject the select drop down
  $("#mcan-select-inject").html(select2);
  // display update public office modal
  $("#updateOfficeModal").modal();
  }


  function update_candidate_pics_modal(o, cid) {
  var modal = '<style> #myfile { border:3px solid #e7e7e7; box-shadow: none!important; border-radius: 5px !important;} #myfile:focus { border: 3px solid #00aced;}</style><!-- Modal --><div id="updateOfficeModal" class="modal fade" role="dialog"><div class="modal-dialog"><!-- Modal content--><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Update '+o[cid].can_name+' Profile Picture</h4></div><div class="modal-body" id="modal-form"><!-- update candidate form -->                    <!-- Add form--><div id="moffice-msg-success"><span class="mclosebtn-msg-success">&times;</span><p></p></div><div id="moffice-msg-err"><span class="mclosebtn-msg-err">&times;</span><p></p></div>   <form id="myform" method="post>     <div class="form-group"><label>Select Picture (.png, .jpg, .jpeg). Max file size 2MB </label><input class="form-control" type="file" id="myfile" /><br/><div class="form-group"><div class="progress"><div class="progress-bar progress-bar-success myprogress progress-bar-striped" role="progressbar" style="width:0%">0%</div></div><div class="msg"></div></div> </div></form><a class="btn btn-info" onclick="update_profile_pic('+o[cid].cid+')" style="margin: 1em !important;">Update Profile Picture</a><br></div></div></div></div>';
  // inject the prepared modal
  $("#modalFacility").html(modal);
  // inject the select drop down
  $("#mcan-select-inject").html(select2);
  // display update public office modal
  $("#updateOfficeModal").modal();
  }
  
  function update_candidate(cid) {
  // Do form validation
  var mcan_name = $("#mcan-name").val();
  var mcan_select = $("#sel2").val();
  var mcan_manifesto = $("#mcan-manifesto").val();
  var msg_err = $('#moffice-msg-err');
  var msg_success = $('#moffice-msg-success');
  if(mcan_name=='') {
  msg_err.css('display', 'block');
  $('#moffice-msg-err p').append('&bullet; Candidate Name cannot be empty');
  
  }
  if(mcan_manifesto =='') {
  msg_err.css('display', 'block');
  $('#moffice-msg-err p').append('<br/>&bullet; Candidate manifesto cannot be empty');
  }
  if(mcan_manifesto!=='' & mcan_name!=='') {
  // SEND THE AJAX POST
  $.post("<?php echo $data['app']->basePath.'/cpanel/candidate/updateCandidateOffice'?>",
  {
  token: "<?php echo $data['session']['token']; ?>",
  can_name: mcan_name,
  can_manifesto: mcan_manifesto,
  cid: cid,
  can_select: mcan_select
  }, function(data, status){
  if(data.trim()=='success') {
  msg_success.css('display', 'block');
  $('#moffice-msg-success p').append('<br/>&bullet; Candidate succesfully updated.');
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
  <script type="text/javascript">
  
  /// GET THE LIST OF PUBLC OFFICES
  // SEND THE AJAX POST
  $.post("<?php echo $data['app']->basePath.'/cpanel/vote/listPublic'?>",
  {
  token: "<?php echo $data['session']['token']; ?>",
  }, function(data, status){
  if(data.trim()!=="null") {
  public_list = JSON.parse(data.trim());
  select = '<select class="form-control" id="sel1">';
    select2 = '<select class="form-control" id="sel2">';
      for(k=0;k<public_list.length;k++) {
        select = select+'<option value="'+public_list[k].pid+'">'+public_list[k].pub_name+'</option>';
        select2 = select2+'<option value="'+public_list[k].pid+'">'+public_list[k].pub_name+'</option>';
        }
      select = select+' </select>';
    select2 = select2+' </select>';
    $('#select-office').html(select);
    }
    });
    </script>

<script type="text/javascript">.msg{  color: #666 !important; }</script>
<script>
function update_profile_pic(cid) {
            $(function () {
              $('.progress').hide();
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
                    formData.append('cid', cid);
                    formData.append('token', '<?php echo $data['session']['token']; ?>');
                    $('#btn').attr('disabled', 'disabled');
                     $('.msg').text('Uploading in progress...');
                    $.ajax({
                        url: '<?php echo $data['app']->basePath.'/cpanel/candidate/uploadPicture'?>',
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

          }
        </script>


  </body>
  <?php include 'tpl/end.php'; ?>