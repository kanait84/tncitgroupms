<!DOCTYPE html>
<html lang="en">

<script type="text/JavaScript">
//courtesy of BoogieJack.com
function killCopy(e){
  return false
}
function reEnable(){
  return true
}
document.onselectstart=new Function ("return false")
if (window.sidebar){
  document.onmousedown=killCopy
  document.onclick=reEnable
}
</script>


@include('layout.head')
<link href="asset/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="asset/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />
<body>

  <section id="container">

    @include('layout.dashboard')
    @include('layout.sidenav')


    <section id="main-content">
      <section class="wrapper site-min-height">
        <div class="row mt">
          <div class="col-lg-12">
            <div class="row content-panel">
              <div class="col-md-4 profile-text mt mb centered">
                <div class="right-divider hidden-sm hidden-xs">
                  <h4>10</h4>
                  <h6>TOTAL TASK</h6>
                  <h4>5</h4>
                  <h6>FINISH TASK</h6>
                  <h4>5</h4>
                  <h6> PENDING TASK</h6>
                </div>
              </div>
              <!-- /col-md-4 -->
              <div class="col-md-4 profile-text">
                <h3>{{$report->user->name}}</h3>
                <h6>{{$report->user->position}}}}</h6>
                <p>{{$report->user->email}}}} || {{$report->user->mobile}} </p>
                <br>
                <p>
                  <a class="btn btn-theme" href="{{ url('viewemployee')."/".$report->user->id}}"><i class="fa fa-upload"></i> View All Report</a></p>
                </div>
                <!-- /col-md-4 -->
                <div class="col-md-4 centered">
                  <div class="profile-pic">
                    <p>
                      <img src="../photo_storage/{{$report->user->email}}-{{$report->user->name}}.jpg" class="img-circle"></p>
                      <p>
                      </p>
                    </div>
                  </div>
                </div>
              </div>

            </div>
            <h3><i class="fa fa-angle-right"></i> Reprot Details <span class="badge bg-success">{{$report->date}}</span></h3>


            <div class="col-lg-6 col-md-6 col-sm-12">
              <!--  ALERTS EXAMPLES -->
              <div class="showback">
                <h4><i class="fa fa-angle-right"></i> Daily Activity</h4>
                <div class="alert alert-default" style="background-color: #efefef">
                  <p style="white-space: pre-line">
                    {{$report->description}}
                  </p>
                </div>
                @if($report->description != "")

                <p>Attachment: <a href="../report_attachment/{{$report->date}}-{{$report->user->id}}.{{$report->file_type}}" target="_blank" type="button" class="btn btn-primary btn-xs">Download</a>

                  @else
                  <p>No Attachment</p>
                  @endif
                </p>

              </div>


            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">

              <div class="showback">
                <h4><i class="fa fa-angle-right"></i> Report Details</h4>
                <p>Date: <span class="badge bg-success">{{$report->date}}</span></p>
            </div>
            <!-- /showback -->
            <!--  LABELS -->
            <div class="showback">
              <h4><i class="fa fa-angle-right"></i> Manager's Comment</h4>

              <form id="commentform">
                @csrf

                <input type="hidden" name="u_id" value="{{$report->user->id}}">
                <input type="hidden" name="r_id" value="{{$report->r_id}}">
              <div class="alert alert-success" style="background-color: #efefef">
                <p>


                  <div class="form-group">

                    <div class="col-sm-12">
                      <textarea class="form-control" name="comment" id="comment" placeholder="Daily Report Details" rows="5" required></textarea>
               <br>
                      <button type="submit" name="submit" class="btn btn-xs btn-theme">Post Comment</button>
                      <div class="validate"></div>
                    </div>
                  </div>

                    <p>&nbsp;</p>
                </p>
              </div>
              </form>
              <!-- where the response will be displayed -->
              <div id='response'></div>
                <div id='all_posts'>
              <?php
              $user_details = array_reverse($user_details);
               foreach($user_details as $k=>$v) {
                $cid = $v['commentid'];
                $rid = $v['rid'];

                  echo "<div align='left' style='border:1px solid; font-weight:bold;'>
                        <p style='color:#48BCB4;'>".ucfirst($v['type'])."</p>
                        <p><h5 style='color:#48cfad;'>".$v['name']."</h5>
                        <a href='/deletecomment/$cid/$rid' style='color:red;'>Delete</a> </p>
                        <p style='color:#2e6da4;'>".$v['created']."</p>
                        <p>".$v['comment']."</p></div> <p>&nbsp;</p>";
              } ?>
              </div>
              <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js "></script>
              <script>
                $(document).ready(function(){
                  $('#commentform').submit(function(){

                    // show that something is loading
                    //$('#response').html("<b>Loading response...</b>");

                    /*
                     * 'post_receiver.php' - where you will pass the form data
                     * $(this).serialize() - to easily read form data
                     * function(data){... - data contains the response from post_receiver.php
                     */
                    $.ajax({
                      type: 'POST',
                      url: '/post_comments',
                      data: $(this).serialize()
                    })
                            .done(function(data){

                              // show the response
                              $('#all_posts').html(data);

                            })
                            .fail(function() {

                              // just in case posting your form failed
                              alert( "Posting failed." );

                            });

                    // to prevent refreshing the whole page page
                    return false;
                  });


                });
              </script>

            </div>
            <!-- /showback -->
          </div>


        </section>

      </section>

      <footer class="site-footer">
        <div class="text-center">
          <p>
            &copy; Copyrights <strong>ABBC </strong>. All Rights Reserved
          </p>

          <a href="profile.html#" class="go-top">
            <i class="fa fa-angle-up"></i>
          </a>
        </div>
      </footer>
      <!--footer end-->
    </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
    <script src="lib/jquery.scrollTo.min.js"></script>
    <script src="lib/jquery.nicescroll.js" type="text/javascript"></script>

    <script type="text/javascript" language="javascript" src="asset/lib/advanced-datatable/js/jquery.js"></script>


    <script type="text/javascript" language="javascript" src="asset/lib/advanced-datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="asset/lib/advanced-datatable/js/DT_bootstrap.js"></script>
    <!--common script for all pages-->



    <!--common script for all pages-->
    <script src="lib/common-scripts.js"></script>
    <!--script for this page-->
    <!-- MAP SCRIPT - ALL CONFIGURATION IS PLACED HERE - VIEW OUR DOCUMENTATION FOR FURTHER INFORMATION -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
    <script>
      $('.contact-map').click(function() {

      //google map in tab click initialize
      function initialize() {
        var myLatlng = new google.maps.LatLng(40.6700, -73.9400);
        var mapOptions = {
          zoom: 11,
          scrollwheel: false,
          center: myLatlng,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var marker = new google.maps.Marker({
          position: myLatlng,
          map: map,
          title: 'Dashio Admin Theme!'
        });
      }
      google.maps.event.addDomListener(window, 'click', initialize);
    });
  </script>

  <script type="text/javascript">
    /* Formating function for row details */
    function fnFormatDetails(oTable, nTr) {
      var aData = oTable.fnGetData(nTr);
      var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';

      sOut += '<tr><td>Manager Comment:</td><td>{{ $report->comment === "" ? "No comment" : $report->comment}}</td></tr>';

      sOut += '</table>';

      return sOut;
    }

    $(document).ready(function() {
      /*
       * Insert a 'details' column to the table
       */
       var nCloneTh = document.createElement('th');
       var nCloneTd = document.createElement('td');
       nCloneTd.innerHTML = '<img src="asset/lib/advanced-datatable/images/details_open.png">';
       nCloneTd.className = "center";

       $('#hidden-table-info thead tr').each(function() {
        this.insertBefore(nCloneTh, this.childNodes[0]);
      });

       $('#hidden-table-info tbody tr').each(function() {
        this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
      });

      /*
       * Initialse DataTables, with no sorting on the 'details' column
       */
       var oTable = $('#hidden-table-info').dataTable({
        "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0]
        }],
        "aaSorting": [
        [1, 'asc']
        ]
      });

      /* Add event listener for opening and closing details
       * Note that the indicator for showing which row is open is not controlled by DataTables,
       * rather it is done here
       */
       $('#hidden-table-info tbody td img').live('click', function() {
        var nTr = $(this).parents('tr')[0];
        if (oTable.fnIsOpen(nTr)) {
          /* This row is already open - close it */
          this.src = "asset/lib/advanced-datatable/media/images/details_open.png";
          oTable.fnClose(nTr);
        } else {
          /* Open this row */
          this.src = "asset/lib/advanced-datatable/images/details_close.png";
          oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
        }
      });
     });
   </script>


 </body>

 </html>
