<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<link href="asset/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="asset/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />

<style>
    #zabuto_calendar_{{$seldate}} { background: #fff; }
    div#zabuto_calendar_{{$seldate}}_day { color:#000!important; }
</style>
<body>

  <section id="container">

    @include('layout.dashboard')
    @include('layout.sidenav')

    <section id="main-content">
      <section class="wrapper site-min-height">

        <div class="col-lg-9 ds" style="padding: 30px;">
            <h3>> OverTime Requests</h3>
            <div class="content-panel">
                <div class="adv-table">
                    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                        <thead>
                        <tr>
                            <th>Claim Date</th>
                            <th>Expense Date</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Invoice No.</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($allovertime as $k=>$v)
                            <tr>
                                <td>{{$v->claim_date}}</td>
                                <td>{{$v->expense_date}}</td>
                                <td>{{$v->total_amount." AED"}}</td>
                                <td>{{$v->paymode}}</td>
                                <td>{{$v->invoice_no}}</td>
                                <td>{{$v->category}}</td>
                                <td>{{$v->status}}</td>
                                <td><a href="overtime/{{$v->id}}">View Details</a></td>
                            </tr>
                        @empty
                            <tr class="gradeX">
                                <td>No Records found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- page end-->
            </div>

      </div>

      <div class="col-lg-3 ds" style="padding: 30px;">
        <!--COMPLETED ACTIONS DONUTS CHART-->
        <div id="calendar" class="mb">
          <div class="panel green-panel no-margin">
            <div class="panel-body">
              <div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
                <div class="arrow"></div>
                <h3 class="popover-title" style="disadding: none;"></h3>
                <div id="date-popover-content" class="popover-content"></div>
              </div>
              <div id="my-calendar"></div>
            </div>
          </div>
        </div>

        <div class="donut-main">
          <h4>COMPLETED ACTIONS & PROGRESS</h4>
          <canvas id="newchart" height="130" width="130"></canvas>
          <script>
            var doughnutData = [{
              value: 70,
              color: "#4ECDC4"
            },
            {
              value: 30,
              color: "#fdfdfd"
            }
            ];
            var myDoughnut = new Chart(document.getElementById("newchart").getContext("2d")).Doughnut(doughnutData);
          </script>
        </div>
        <!--NEW EARNING STATS -->
        <div class="panel terques-chart">
          <div class="panel-body">
            <div class="chart">
              <div class="centered">
                <span>TODAY REPORTS</span>
                <strong>{{$todayreportcnt}} | {{$usercount}}</strong>
              </div>
              <br>
            </div>
          </div>
        </div>
          <!-- RECENT ACTIVITIES SECTION -->
          <h4 class="centered mt">RECENT ACTIVITY</h4>
          @forelse($reports as $report)
              <?php
              $currtime = date('Y-m-d H:i:s');
              $to_time = strtotime($currtime);
              $from_time = strtotime($report->created_at);
              $minutes = round(abs($to_time - $from_time) / 60);
              $hours = round(abs($to_time - $from_time) / 3600);
              $hourspel = isset($hours) && ($hours>1) ? 'Hours' : 'Hour';
              $date1 = new DateTime('now');
              $date2 = new DateTime($report->created_at);
              $interval = date_diff($date1, $date2);
              $daycount = $interval->format('%a');
              $counttime = '';
              if($minutes==0){
                  $counttime = "Just Now";
              } elseif($minutes<60 && $daycount==0) {
                  $counttime = $minutes." Minutes Ago";
              } elseif($minutes>60 && $daycount==0) {
                  $counttime = $hours." ".$hourspel." Ago";
              } elseif($daycount>0){
                  $counttime = $daycount." Days Ago";
              } ?>

              <div class="desc">
                  <div class="thumb">
                      <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                  </div>
                  <div class="details">
                      <p>
                          <muted>{{$counttime}}</muted>
                          <br/>
                          <a href="/viewemployee/{{$report->user->id}}">{{$report->user->name}}</a> submitted daily report.<br/>
                      </p>
                  </div>
              </div>
          @empty
              <hr />
              <div align="center"><p>No Activities</p></div>
      @endforelse
      <!-- USERS ONLINE SECTION -->

      </div>
    </section>

  </section>

  <footer class="site-footer">
    <div class="text-center">
      <p>
        &copy; Copyrights <strong>TNC IT Group Management System </strong>. All Rights Reserved
      </p>

      <a href="#" class="go-top">
        <i class="fa fa-angle-up"></i>
      </a>
    </div>
  </footer>
  <!--footer end-->
</section>
<!-- js placed at the end of the document so the pages load faster -->

<script src="{{ asset('asset/lib/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('asset/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('asset/lib/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('asset/lib/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('asset/lib/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('asset/lib/jquery.sparkline.js') }}"></script>
<!--common script for all pages-->
<script src="{{ asset('asset/lib/common-scripts.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/gritter/js/jquery.gritter.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/gritter-conf.js') }}"></script>
<!--script for this page-->
<script src="{{ asset('asset/lib/sparkline-chart.js') }}"></script>
<script src="{{ asset('asset/lib/zabuto_calendar.js') }}"></script>

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

  <script type="application/javascript">
    $(document).ready(function() {
      $("#date-popover").popover({
        html: true,
        trigger: "manual"
      });
      $("#date-popover").hide();
      $("#date-popover").click(function(e) {
        $(this).hide();
      });

      $("#my-calendar").zabuto_calendar({
        action: function() {
          return myDateFunction(this.id, false);
        },
        action_nav: function() {
          return myNavFunction(this.id);
        },
        ajax: {
          url: "show_data.php?action=1",
          modal: true
        },
        legend: [{
          type: "text",
          label: "Special event",
          badge: "00"
        },
        {
          type: "block",
          label: "Regular event",
        }
        ]
      });
    });

    function myNavFunction(id) {
      $("#date-popover").hide();
      var nav = $("#" + id).data("navigation");
      var to = $("#" + id).data("to");
      console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
    }
  </script>


</body>

</html>
