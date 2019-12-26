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
                <p>  <a class="btn btn-theme" href="{{ url('submitreport') }}"><i class="fa fa-upload"></i>
                        Submit Daily Report</a></p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8">
        <h3><i class="fa fa-angle-right" style="margin-bottom:30px; "></i> Reset Password</h3>
        <div class="adv-table">
            <div class="card">
                <div class="card-body" style="padding:30px;">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">
                                {{ __('E-Mail Address') }}</label>
                            <div class="col-md-6">
                                @if(Auth::user())
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{Auth::user()->email}}" required autocomplete="email" autofocus>
                                @else
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @endif
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div id="calendar" class="mb" style="margin-top: 20px;">
            <div class="panel green-panel no-margin">
                <div class="panel-body">
                    <div id="date-popover" class="popover top" style="cursor: pointer; display: block; margin-left: 33%; width: 175px;">
                        <div class="arrow"></div>
                        <h3 class="popover-title" style="display: none;"></h3>
                        <div id="date-popover-content" class="popover-content"></div>
                    </div>
                    <div id="my-calendar"></div>
                </div>
            </div>
        </div>
        <!-- / calendar -->
    </div>
</div>
</div>
</section>
</section>
<footer class="site-footer">
<div class="text-center">
<p> &copy; Copyrights <strong>TNC IT Group Management System </strong>. All Rights Reserved </p>
<a href="#" class="go-top">
    <i class="fa fa-angle-up"></i>
</a>
</div>
</footer>
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
