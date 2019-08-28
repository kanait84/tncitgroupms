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
      <section class="wrapper site-min-height">
        <div class="col-lg-9 ds">

            <h3> Missed Report Dates - {{$misseduser}} (Last {{$datediff}} Days)</h3>
                <!-- page start-->
                <div class="content-panel">
                    <div class="adv-table">
                        <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="hidden-table-info">
                            <thead>
                            <tr>
                                <th width="50%">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($filterdates as $k=>$v)
                            <tr class="gradeA">
                                <td>
                                    {{$v}}
                                </td>
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
          @foreach($recentreports as $report)
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
      @endforeach
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
</body>
</html>
