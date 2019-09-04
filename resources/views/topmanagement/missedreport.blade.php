<!DOCTYPE html>
<html lang="en">

@include('layout.head')
<link href="asset/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="asset/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />

<!-- Custom styles for this template -->
<link href="asset/css/style.css" rel="stylesheet">
<link href="asset/css/style-responsive.css" rel="stylesheet">
<style>
    #zabuto_calendar_{{$seldate}} { background: #fff; }
    div#zabuto_calendar_{{$seldate}}_day { color:#000!important; }
</style>
<body>
  <section id="container">
    @include('layout.dashboard')
    @include('layout.sidenav')
    <section id="main-content">
      <section class="wrapper">
        <div class="col-lg-9 ds">
            <?php
                $getweek = isset($_GET['dweek']) && ($_GET['dweek']!='') ? 'Last 7 Days' : '';
                $getmonth = isset($_GET['lmonth']) && ($_GET['lmonth']!='') ? 'Last 30 Days' : '';
                $getlday = isset($_GET['d']) && ($_GET['d']!='') ? 'Last Day' : '';
            ?>
            <h3> Missed Reports - {{$getlday.$getweek.$getmonth}}</h3>
                <!-- page start-->
                <div class="content-panel">
                    <div class="adv-table">
                        <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered"
                               @if(count($listusers)>0) id="hidden-table-info" @endif>
                            <thead>
                            <tr>
                                <th width="20%">Name</th>
                                <th width="15%">Email</th>
                                <th width="20%">Department</th>
                                <th width="20%">SubDepartment</th>
                                @if($getweek!='' || $getmonth!='')
                                    <th width="10%">Days</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($listusers as $user)
                            <tr class="gradeA">
                                <td>{{isset($user->name) ? $user->name : ''}}</td>
                                <td>{{isset($user->email) ? $user->email : ''}}</td>
                                <td>{{isset($user->department->d_title) ? $user->department->d_title : ''}}</td>
                                <td>{{isset($user->subdepartment->sd_title) ? $user->subdepartment->sd_title : ''}}</td>
                                @if($getweek!='')
                                    <td align="center"><a href="listmissreports/{{$user->id."/".$lweek}}">
                                            @if($user->missdates>0)
                                            {{$user->missdates}}
                                                @else
                                            {{0}}
                                            @endif
                                        </a></td>
                                @endif
                            </tr>
                            @empty
                                <tr class="gradeX">
                                    @if($getweek!='')
                                        <td colspan="5">No Records found</td>
                                        @else
                                        <td colspan="4">No Records found</td>
                                    @endif
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                <!-- page end-->
            </div>
            <!-- /row -->

      </div>
      <div class="col-lg-3 ds">
        <!--COMPLETED ACTIONS DONUTS CHART-->
        <div id="calendar" class="mb" style="margin-top: 20px;">
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
        <!--new earning end-->
        <!-- RECENT ACTIVITIES SECTION -->
        <h4 class="centered mt">RECENT ACTIVITY</h4>
          @forelse($recentreports as $report)
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
        <!-- CALENDAR-->
        <!-- / calendar -->
      </div>
    </section>

  </section>

  <footer class="site-footer">
    <div class="text-center">
      <p>
        &copy; Copyrights <strong>TNC IT Group Management System </strong>. All Rights Reserved
      </p>

      <a href="profile.html#" class="go-top">
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

<script type="text/javascript" language="javascript" src="{{ asset('asset/lib/advanced-datatable/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/advanced-datatable/js/DT_bootstrap.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
       $('#hidden-table-info').dataTable();
  });
</script>
  <!--script for this page-->
  <script src="{{ asset('asset/lib/zabuto_calendar.js') }}"></script>
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
                  return myDateFunction(this.id, true);
              },
              action_nav: function() {
                  return myNavFunction(this.id);
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
      function myDateFunction(date) {
          myString = date.substring(date.length - 10);
          window.location.href = '/home?d='+myString;
          console.log('Triggered',myString)
      }
</script>

</body>
</html>
