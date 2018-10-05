        <br/>
        <div class="c-tag">
          <span class="icon-big icon-vote"><h1>Vote Activities Control</h1></span></div>
          <br/>
          <br/>
          <!-- Accordion -->
          <ul class="nav nav-pills">
            <li class="active"><a data-toggle="pill" href="#home"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/inputs_30.png'?>"/></span> Election </a></li>
            <li><a data-toggle="pill" href="#menu1"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/add.png'?>"/></span> .... </a></li>
            <li><a data-toggle="pill" href="#menu2"><span style="margin-right: 0.5em"><img src="<?php echo $data['app']->basePath.'/public/imgs/delete.png'?>"/></span> &nbsp; ... </a></li>
          </ul>
          <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
              <h5 style="font-weight: bold;">Election Control Board</h5>
              <p style="color:#AC96CD">Actively carry out elcection control activties.</p>
              <br>

<!-- election control board-->

              <div class="row">
                
                  <div class="col-md-8">
                    

<!-- list-election -->


              <div id="election-spinner" class="loader profile-loader" style="left: 18em !important;">
                <div class="loader-inner line-scale" style="margin-left: 5em;">
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                  <div></div>
                </div>
                Fetching Elections Details...
              </div>
<div id="list-election"></div>


<!-- !list-election -->


                  </div>
                  <div class="col-md-4">
                    <div class="section-pane">Create Election</div>
                    <div class="small-well">
                     <form role="form" id="form-election">

<!-- notification -->
                    <div id="e-msg-err"><span class="eclosebtn-msg-err">&times;</span><p></p></div>
                    <div id="e-msg-success"><span class="eclosebtn-msg-success">&times;</span><p></p></div>


                      <div class="form-group">
                        <label for="e-name">Election Name</label>
                        <input type="text" class="form-control" id="e-name" placeholder="Enter election name.">
                      </div>

                      <div class="form-group">
                        <label for="e-name">Public Office</label>
                        <div id="select-office"></div>
                      </div>

                      <div class="form-group">
                        <label for="e-starts">Election Starts</label>
                        <input type="text" class="form-control" id="e-starts" placeholder="Enter start election date and time">
                      </div>
                       <div class="form-group">
                        <label for="e-ends">Election Ends</label>
                        <input type="text" class="form-control" id="e-ends" placeholder="Enter stop election date and time">
                      </div>
                      
                    </form>

                    <button class="btn btn-votify" onclick="createElection()">Create Election</button>

                    </div>
                  </div>
              </div>


<div id="pesudo" style="display: none;"></div>

<!-- !election control board-->






            </div>
            <div id="menu1" class="tab-pane fade">
              <h3>Menu 1</h3>
              <p>Some content in menu 1.</p>
            </div>
            <div id="menu2" class="tab-pane fade">
              <h3>Evict A voter</h3>
              <p>Following are the list of voters. Click on the delete button to evict a voter</p>
              
            </div>
          </div>


<script type="text/javascript">
  
  $.datetimepicker.setLocale('en');
  $('#e-starts').datetimepicker({
    dayOfWeekStart : 1,
    lang:'en',
    disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
    startDate:  '1986/01/05'
});
  $('#e-ends').datetimepicker({
    dayOfWeekStart : 1,
    lang:'en',
    disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
    startDate:  '1986/01/05'
});


</script>



<script type="text/javascript">
  
// HANDLES CREATE ELECTION FORM

function createElection() {
  var e_name = $('#e-name').val();
  var e_office = $('#sel1').val();
  var e_starts = $('#e-starts').val();
  var e_ends = $('#e-ends').val();
  var emsg_err = $('#e-msg-err');
  var emsg_success = $('#e-msg-success');

  
  if(e_name=='') {
    emsg_err.css('display', 'block');
    $('#e-msg-err p').append('&bullet; Election name cannot be empty<br/>');
    
    }

  if(e_starts=='') {
    emsg_err.css('display', 'block');
    $('#e-msg-err p').append('&bullet; Election Start when?<br/>');
    
    }

  if(e_ends=='') {
    emsg_err.css('display', 'block');
    $('#e-msg-err p').append('&bullet; Election Ends when?<br/>');
    
    }


// SEND THE AJAX REQUEST

    if(e_name!=='' & e_starts!=='' && e_ends!=='') {

    // SEND THE AJAX POST
    $.post("<?php echo $data['app']->basePath.'/cpanel/vote/createElection'?>",
    {
    token: "<?php echo $data['session']['token']; ?>",
    e_name: e_name,
    e_office: e_office,
    e_starts: e_starts,
    e_ends: e_ends
    }, function(data, status){
    if(data.trim()=='success') {
      emsg_success.css('display', 'block');
    $('#e-msg-success p').append('<br/>&bullet; Election succesfully created.');
    

    } else {
    
      emsg_err.css('display', 'block');
    $('#e-msg-err p').append('<br/>&bullet;'+data);
    
    }});



    }






    /// HANDLE NOTIFICATION DISMISAL
     $(".eclosebtn-msg-success").click(function(){
    $("#e-msg-success").fadeOut(1000);
    $("#e-msg-success p").html('');
    });
    $(".eclosebtn-msg-err").click(function(){
    $("#e-msg-err").fadeOut(1000);
    $("#e-msg-err p").html('');
    });
}


</script>





    <script type="text/javascript">
      // listElection

      $('#list-election').hide();
      setInterval(listElection, 5000);
      function listElection() {
      $.post("<?php echo $data['app']->basePath.'/cpanel/vote/listElection'?>",
      {
      token: "<?php echo $data['session']['token']; ?>"
      },
      function(data, status){
      var res = JSON.parse(data);
      if(data.trim()!=="null") {
      var tbl = '<div class="table-responsive"><table class="table"><thead><tr><th>#</th><th>Election name</th><th>Public Office</th><th>Election Starts</th><th>Election Ends</th><th>Action</th></tr></thead><tbody>';
      var len = res.length;
      for(i=0;i<len;i++) {

      tbl = tbl+'<tr id="election'+res[i].eid+'"><td>'+(i+1)+'</td><td>'+res[i].e_name+'</td><td>'+res[i].public_office[0].pub_name+'</td><td>'+res[i].e_start_date+'</td><td>'+res[i].e_end_date+'</td><td> <a onclick=\'update_election_modal({eid:'+res[i].eid+', e_name:"'+res[i].e_name+'", e_start_date:"'+res[i].e_start_date+'", e_end_date:"'+res[i].e_end_date+'"})\'><img src="<?php echo $data['app']->basePath.'/public/imgs/edit.png'?>"/></a> <a onclick="evict_election('+res[i].eid+')"><img src="<?php echo $data['app']->basePath.'/public/imgs/not_imported.png'?>"/></a></td></tr>';
      } 
    tbl = tbl+'</tbody></table></div>';
    $('#election-spinner').hide();
    $('#list-election').fadeIn(1000);
    $('#list-election').html(tbl);
    
    } else {
    $('#election-spinner').hide();
    $('#list-election').show();
    $('#list-election').html("&nbsp;&nbsp;Err! There are currently no elections...");
    }
    });
    }
    </script>

    <script type="text/javascript">
      
    function evict_election(eid) {
    // CREATE AJAX REQUEST TO EVICT A PUBLIC OFFICE
    $.post("<?php echo $data['app']->basePath.'/cpanel/vote/evict_election'?>",
    {
    eid: eid,
    token: "<?php echo $data['session']['token']; ?>"
    },
    function(data, status){
    if(status=="success" && data.trim()=='deleted') {
    $('#election'+eid).fadeOut("slow");
    } else {
    alert('err'+data);
    }
    });
    }


    </script>

    <script type="text/javascript">
    

    // INJECTS ELECTION UPDATE MODAL TO DOM WHEN DEMANDED

function update_election_modal(o) {
  var chunk1 = o.e_start_date.split(':');
  chunk1 = chunk1[0]+':'+chunk1[1];
  o.e_start_date = chunk1;
 var chunk2 = o.e_end_date.split(':');
  chunk2 = chunk2[0]+':'+chunk2[1];
  o.e_end_date = chunk2;


    var modal = '<style>#mElectionName, #mElectionStarts, #mElectionEnds{ border:2px solid #e7e7e7; box-shadow: none!important; border-radius: 5px !important;} #mElectionName:focus, #mElectionStarts:focus, #mElectionEnds:focus { border: 2px solid #00aced;}</style><!-- Modal --><div id="updateElectionModal" class="modal fade" role="dialog"><div class="modal-dialog"><!-- Modal content--><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Update '+o.e_name+' Details </h4></div><div class="modal-body" id="modal-form"><!-- update election form -->                    <!-- Add form--><div id="melection-msg-success"><span class="mclosebtn-msg-success">&times;</span><p></p></div><div id="melection-msg-err"><span class="mclosebtn-msg-err">&times;</span><p></p></div>   <form role="form"><br/><div class="form-group"><label for="election">Election name</label><input type="text" class="form-control" id="mElectionName" value="'+o.e_name+'"></div><br/><div class="form-group"><label for="election">Public office</label> <div id="mElectionP ublicOffice"></div> </div><div class="form-group"><label for="mElectionStarts">Election Starts:</label><input type="text" class="form-control" id="mElectionStarts"  value="'+o.e_start_date+'"></div><br/><div class="form-group"><label for="mElectionEnds">Election ends:</label><input type="text" class="form-control" id="mElectionEnds"  value="'+o.e_end_date+'"></div></form><a class="btn btn-info" onclick="update_office('+o.pid+')">Update Office Details</a></div></div></div></div>';
    // inject the prepared modal

    var select = $("#pesudo").html();

    $("#mElectionPublicOffice").html(select);



    $("#modalFacility").html(modal);
    // display update election modal
    $("#updateElectionModal").modal();


  // INITIATE DATE PICKER
  $('#mElectionStarts').datetimepicker({
    dayOfWeekStart : 1,
    lang:'en',
    disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
    startDate:  '1986/01/05'
});

  $('#mElectionEnds').datetimepicker({
    dayOfWeekStart : 1,
    lang:'en',
    disabledDates:['1986/01/08','1986/01/09','1986/01/10'],
    startDate:  '1986/01/05'
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
    $('#pesudo').html(select2);
    }
    });
    </script>

