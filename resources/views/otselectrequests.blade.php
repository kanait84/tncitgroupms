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

        $('#otweek').on('change', function () {
            var id = $(this).val(); // get selected value
            if (id) {
                window.location = "otselectrequests?datedur="+id;
            }
            return false;
        });

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = window.location.search.substring(1),
                sURLVariables = sPageURL.split('&'),
                sParameterName,
                i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
                }
            }
        };

        $('.week-picker').val(getUrlParameter('datedur'));

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
<h3><i class="fa fa-angle-right"></i> OverTime Requests</h3>
<!-- BASIC FORM ELELEMNTS -->
<div class="row">
<div class="col-lg-12">
<div class="form-panel">
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
    <div class="col-lg-12">
       <div class="text-left">
           <div class="form-group col-md-8 col-md-offset-2" id="week-picker-wrapper">
               <label for="week" class="control-label">Select Week</label>
               <div class="input-group">
		<span class="input-group-btn">
			<button type="button" class="btn btn-rm week-prev">&laquo;</button>
		</span>
                   <input type="text" name="otweek" id="otweek" class="form-control week-picker"
                          placeholder="Select a Week">
                   <span class="input-group-btn">
			<button type="button" class="btn btn-rm week-next">&raquo;</button>
		</span>
               </div>
           </div>
       </div>
    </div>

<div class="row">
<div class="col-lg-12">
    <p>&nbsp;</p>
   <div class="adv-table">
       @if($dateduration)
       <h4 style="padding: 30px;">Duration: &nbsp;<b>{{$dateduration}}</b></h4>
       @endif
    <table class="display table table-bordered" {{$tabclass}}>
    <thead>
    <tr>
        <th width="10%">Date</th>
        <th width="9%">Start Time</th>
        <th width="9%">End Time</th>
        <th width="9%">Total Hours</th>
        <th width="25%">Description</th>
        <th width="12%">Status</th>
        <th width="18%">Approved By</th>
    </tr>
    </thead>
        <tbody>
        @forelse($resArr as $k=>$v)
        <tr>
            <td>{{$v['date']}}</td>
            <td>{{$v['start_time']}}</td>
            <td>{{$v['end_time']}}</td>
            <td>{{floor($v['totalhours'])."hrs ".$v['totalmins']."mins"}}</td>
            <td>{{$v['reason']}}</td>
            <td>
                @if($v['status'] == 'Rejected')
                    <span class="label label-danger">REJECTED</span>
                @elseif($v['status'] == 'Approved')
                    <span class="label label-success">APPROVED</span>
                @elseif ($v['status'] == 'Progress')
                    <span class="label label-primary">Pending for Executive</span>
                @else
                    <span class="label label-primary">Pending for Manager</span>
                @endif
            </td>
            <td>{{$v['report_name']}}</td>
        </tr>
        @empty
        <tr class="gradeX">
            <td colspan="7">No Records found</td>
        </tr>
        @endforelse
        </tbody>
    </table>
   </div>
</div>
</div>
@if(count($resArr)>0)
<div class="row">
    <div class="col-lg-5 text-center">
        <p>  <a class="btn btn-theme" href="printotrequests/{{$formDate.'/'.$toDate}}"><i class="fa fa-print"></i>
                Print</a></p>
    </div>
</div>
@endif
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
<script type="text/javascript" src="/asset/lib/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>

<script type="text/javascript" language="javascript" src="{{ asset('asset/lib/advanced-datatable/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/advanced-datatable/js/DT_bootstrap.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#hidden-table-info').dataTable();
    });
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script>
</body>
</html>
