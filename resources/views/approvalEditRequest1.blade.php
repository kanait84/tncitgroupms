<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <title>TNC IT GROUP MANAGEMENT SYSTEM</title>
    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('asset/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <!--external css-->
    <link href="{{ asset('asset/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/css/zabuto_calendar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('asset/lib/gritter/css/jquery.gritter.css') }}" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('asset/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('asset/css/style-responsive.css') }}" rel="stylesheet">
    <script src="{{ asset('asset/lib/chart-master/Chart.js') }}"></script>user_details
</head>
<style>
    #zabuto_calendar_{{$seldate}} { background: #fff; }
    div#zabuto_calendar_{{$seldate}}_day { color:#000!important; }
</style>
<body>
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
	<section id="container">
		@include('layout.dashboard')
		@include('layout.sidenav')
		<section id="main-content">
			<section class="wrapper">
				<h3><i class="fa fa-angle-right"></i> Edit Request Approval</h3>
				<!-- BASIC FORM ELELEMNTS -->
                <div class="row">

                    <div class="col-lg-12">
                        <div class="row content-panel">
                            <div class="col-md-2 centered">
                                <div class="profile-pic">
                                    <p>
                                        <img src="photo_storage/{{Auth::user()->emp_photo}}" class="img-circle"></p>
                                    <p>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 profile-text">
                                <h3>{{Auth::user()->name}}</h3>
                                <h6>{{Auth::user()->position}}</h6>
                                <p>{{Auth::user()->email}} || {{Auth::user()->mobile}} </p>
                            </div>
                            <div class="col-md-4 profile-text" style="margin-top: 35px ">
                                <p>
                                    <a class="btn btn-theme" href="{{ url('submitreport') }}"><i class="fa fa-upload"></i> Submit Daily Report</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8 main-chart">

                        <p><b>Report Description</b>:</p> <p>{{$report[0]->description}}</p>

                        @if(isset($report[0]->attachment) && $report[0]->attachment != "")
                            <p>&nbsp;</p>
                            <p>Attachment:</p>
                            <p><a href="/report_attachment/{{$report[0]->date}}-{{$report[0]->u_id}}.{{$report[0]->file_type}}" target="_blank" type="button" class="btn btn-primary btn-xs">Download</a>
                        @else
                            <p>&nbsp;</p><p>No Attachment</p>
                        @endif

                        <div class="col-md-4 profile-text" style="margin-top: 35px ">
                            <p>
                                <a class="btn btn-theme" href="/approvedreq/{{$r_id}}">
                                    <i class="fa fa-thumbs-up"></i> Approve</a></p>
                        </div>

                        <div class="col-md-4 profile-text" style="margin-top: 35px ">
                            <p>
                                <a class="btn btn-theme" href="/disapprovedreq/{{$r_id}}">
                                    <i class="fa fa-thumbs-down"></i>Disapprove</a></p>
                        </div>


                    </div>
                    <!-- /col-lg-9 END SECTION MIDDLE -->
                    <!-- **********************************************************************************************************************************************************
                        RIGHT SIDEBAR CONTENT
                        *********************************************************************************************************************************************************** -->
                    <div class="col-lg-4">
                        <!-- CALENDAR-->
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
                        <!-- / calendar -->
                    </div>
                    <!-- /col-lg-3 -->
                </div>
                <!-- /row -->
		</section>
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
