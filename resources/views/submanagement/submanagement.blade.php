<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<link href="asset/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="asset/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />
<style>
    #zabuto_calendar_{{$seldate}} { background: #fff; }
    div#zabuto_calendar_{{$seldate}}_day { color:#000!important; }
    .right-button { float: right; vertical-align: top; margin-right: 9px; margin-top: -6px; }
</style>
<?php
$i=0; $alldates = array();
if(isset($allreports)){
    foreach ($allreports as $k=>$v){
        $alldates[$i] = $v->date;
        $i++;
    }
}
$list=array();
$month = date('m');
$prevmonth1 = date('m', strtotime(date('Y-m')." -1 month"));
$prevmonth2 = date('m', strtotime(date('Y-m')." -2 month"));
$currdte = date('d');
$year = date('Y');
for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $month, $d, $year);
    if (date('m', $time)==$month)
        if($currdte>=$d){
            $list[]=date('Y-m-d', $time);
        }
}
for($pred=1; $pred<=31; $pred++)
{
    $time=mktime(12, 0, 0, $prevmonth1, $pred, $year);
    if (date('m', strtotime(date('Y-m')." -1 month"))==$prevmonth1)
        $prevlist1[]=date('Y-m-d', $time);
}
for($pred2=1; $pred2<=31; $pred2++)
{
    $time=mktime(12, 0, 0, $prevmonth2, $pred2, $year);
    if (date('m', strtotime(date('Y-m')." -2 month"))==$prevmonth2)
        $prevlist2[]=date('Y-m-d', $time);
}
$list = array_merge($list, $prevlist1, $prevlist2);
foreach($alldates as $k=>$v){ ?>
<style>
    div#zabuto_calendar_{{$v}}_day { color:#2a9055; }
</style>
<?php
}
$diff_result = array_diff($list, $alldates);
$diff_result = array_values($diff_result);
foreach($diff_result as $k=>$v){
$currdate = date('m-d-Y');
$v = date('Y-m-d', strtotime($v));
if($v < $currdate){ ?>
<style>
    div#zabuto_calendar_{{$val}}_day { color:#ffff; }
</style>
<?php } else {
$val = date('Y-m-d', strtotime($v)); ?>
<style>
    div#zabuto_calendar_{{$val}}_day { color:#ac2925!important; }
</style>
<?php
}
} ?>
<body>
<section id="container">
    @include('layout.dashboard')
    @include('layout.sidenav')
    <section id="main-content">
        <section class="wrapper site-min-height">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row content-panel">
                        <div class="col-md-2 centered">
                            <div class="profile-pic">
                                <p><img src="/photo_storage/{{Auth::user()->emp_photo}}" class="img-circle"></p>
                                <p>&nbsp;</p>
                            </div>
                        </div>
                        <div class="col-md-4 profile-text">
                            <h3>{{Auth::user()->name}}</h3>
                            <h6>{{Auth::user()->position}}</h6>
                            <p>{{Auth::user()->email}} || {{Auth::user()->mobile}} </p>
                        </div>
                        <div class="col-md-4 profile-text" style="margin-top: 35px ">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-9 ds">
                    @foreach($subdepartments as $subd)
                    <a href="{{ url('smviewdepartment')."/".$subd->sd_id}}"><div class="col-md-4 col-sm-4 mb" style="margin-top: 20px;">
                        <div class="darkblue-panel pn">
                            <div class="darkblue-header" style="padding-top: 50px;">
                                <h5>{{$subd->sd_title}}</h5>
                            </div>
                            <canvas id="serverstatus02" height="10" width="120"></canvas>
                            <button class="btn btn-xs btn-block" style="padding: 5px; margin-top: 20px;">View Department</button>
                            <footer style="background-color: blue">
                                <div class="pull-left">
                                </div>
                                <div class="pull-right">
                                    <h5></h5>
                                </div>
                            </footer>
                        </div>

                    </div>
                </a>
                @endforeach
            </div>
                <div class="col-lg-3 ds">
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
                                <strong>68 | 97</strong>
                            </div>
                            <br>
                            <div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[200,135,667,333,526,996,564,123,890,564,455]"></div>
                        </div>
                    </div>
                </div>
                <!--new earning end-->
                <!-- RECENT ACTIVITIES SECTION -->
                <h4 class="centered mt">RECENT ACTIVITY</h4>
                <!-- First Activity -->
                <div class="desc">
                    <div class="thumb">
                        <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                    </div>
                    <div class="details">
                        <p>
                            <muted>Just Now</muted>
                            <br/>
                            <a href="#">Paul Rudd</a> submitted daily report.<br/>
                        </p>
                    </div>
                </div>
                <!-- Second Activity -->
                <div class="desc">
                    <div class="thumb">
                        <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                    </div>
                    <div class="details">
                        <p>
                            <muted>2 Minutes Ago</muted>
                            <br/>
                            <a href="#">James Brown</a> submitted daily report.<br/>
                        </p>
                    </div>
                </div>
                <!-- Third Activity -->
                <div class="desc">
                    <div class="thumb">
                        <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                    </div>
                    <div class="details">
                        <p>
                            <muted>3 Hours Ago</muted>
                            <br/>
                            <a href="#">Diana Kennedy</a> request to edit daily report.<br/>
                        </p>
                    </div>
                </div>
                <!-- Fourth Activity -->
                <div class="desc">
                    <div class="thumb">
                        <span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
                    </div>
                    <div class="details">
                        <p>
                            <muted>7 Hours Ago</muted>
                            <br/>
                            <a href="#">Brando Page</a> submitted daily report.<br/>
                        </p>
                    </div>
                </div>
                <!-- USERS ONLINE SECTION -->
                <!-- CALENDAR-->
                <!-- / calendar -->
            </div>
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
</section>
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
    function myDateFunction(date) {
        myString = date.substring(date.length - 10);
        window.location.href = '/home?d='+myString;
        console.log('Triggered',myString)
    }
</script>
</body>
</html>
