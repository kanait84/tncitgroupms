<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/lib/bootstrap-fileupload/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link href="/asset/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="/asset/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="/asset/lib/advanced-datatable/css/DT_bootstrap.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css" />
<style>
    .datepicker table tr td span.active{
        background: #04c!important;
        border-color: #04c!important;
    }
    .datepicker .datepicker-days tr td.active {
        background: #04c!important;
    }
    #week-picker-wrapper .datepicker .datepicker-days tr td.active~td, #week-picker-wrapper .datepicker .datepicker-days tr td.active {
        color: #fff;
        background-color: #04c;
        border-radius: 0;
    }

    #week-picker-wrapper .datepicker .datepicker-days tr:hover td, #week-picker-wrapper .datepicker table tr td.day:hover, #week-picker-wrapper .datepicker table tr td.focused {
        color: #000!important;
        background: #e5e2e3!important;
        border-radius: 0!important;
    }
</style>
<script>
    var weekpicker, start_date, end_date;
    function set_week_picker(date) {
        start_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
        end_date = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
        weekpicker.datepicker('update', start_date);
        weekpicker.val(start_date.getFullYear() + '-' + (start_date.getMonth() + 1) + '-' + start_date.getDate() + ' - ' +
            end_date.getFullYear() + '-' + (end_date.getMonth() + 1) + '-' + end_date.getDate());
    }
    $(document).ready(function() {
        weekpicker = $('.week-picker');
        weekpicker.datepicker({
            autoclose: true,
            forceParse: false,
            dateFormat: 'yy-mm-dd',
            container: '#week-picker-wrapper',
        }).on("changeDate", function(e) {
            set_week_picker(e.date);
        });

        $('.week-prev').on('click', function() {
            var prev = new Date(start_date.getTime());
            prev.setDate(prev.getDate() - 1);
            set_week_picker(prev);
        });
        $('.week-next').on('click', function() {
            var next = new Date(end_date.getTime());
            next.setDate(next.getDate() + 1);
            set_week_picker(next);
        });
        set_week_picker(new Date);

    });
</script>
<body>
<section id="container">
    @include('layout.dashboard')
    @include('layout.sidenav')
<section id="main-content">
<section class="wrapper">
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
<h3><i class="fa fa-angle-right"></i> Filter Reports</h3>
<!-- BASIC FORM ELELEMNTS -->
<div class="row">
<div class="col-lg-12">
<div class="form-panel">
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal style-form" method="post" action="downloadReport">
                {{ csrf_field() }}
            <div class="form-group">
                <div class="col-md-3 col-xs-6">&nbsp;</div>
                <div class="col-md-2 col-xs-6">
                <h5 class="control-label col-md-2">
                    <?php
                    $MonthVal = date('F');
                    $MonthNumber = date('n');
                    $YearNumber = date('Y');
                    $months = array();
                    for ($i = 0; $i < 12; $i++) {
                        $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
                        $months[date('n', $timestamp)] = date('F', $timestamp);
                    } ?>
                    Month:
                   <select name="monthfilter" id="monthfilter" class="btn-primary"
                           style="border-radius: 10px;padding: 5px;">
                    <?php
                    $j = 1;
                    foreach($months as $key =>$value){ ?>
                    <option value="{{$key}}">{{$value." ".$YearNumber}}</option>
                    <?php
                    $j++;
                    } ?>
                </select>
                </h5>
                </div>
                <div class="col-md-2 col-xs-6">
                <h5 class="control-label col-md-2">
                    SubDepartment:
                    <select name="sdidfilter" id="sdidfilter" class="btn-primary" style="border-radius: 10px;padding: 5px;">
                        <?php
                        foreach($subdepartments as $key =>$value){ ?>
                        <option value="{{$value->sd_id}}">{{$value->sd_title}}</option>
                        <?php } ?>
                    </select>
                </h5>
                </div>

                <div class="col-md-2 col-xs-6">
                    <h5 class="control-label col-md-2" style="margin-top: 20px;">
                    <button class="btn btn-theme" name="sbmtreport">Download</button>
                    </h5>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="message-header">
        @if ($message = Session::get('success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('warning'))
            <div class="alert alert-warning alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @if ($message = Session::get('error'))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
    </div>

</div>
</div>
</div>
</section>
</section>

    <!--footer start-->
    <footer class="site-footer" style="margin-top: 342px;">
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

<script src="/asset/lib/jquery/jquery.min.js"></script>
<script src="/asset/lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="/asset/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="/asset/lib/jquery.scrollTo.min.js"></script>
<script src="/asset/lib/jquery.nicescroll.js" type="text/javascript"></script>
<!--common script for all pages-->
<script src="/asset/lib/common-scripts.js"></script>
<!--script for this page-->
<script src="/asset/lib/jquery-ui-1.9.2.custom.min.js"></script>
<!--custom switch-->
<script src="/asset/lib/bootstrap-switch.js"></script>
<!--custom tagsinput-->
<script src="/asset/lib/jquery.tagsinput.js"></script>
<!--custom checkbox & radio-->
<script type="text/javascript" src="/asset/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-daterangepicker/date.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
<script src="/asset/lib/form-component.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="/asset/lib/advanced-form-components.js"></script>
</body>
</html>
