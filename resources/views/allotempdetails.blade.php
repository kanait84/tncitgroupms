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

<script>
jQuery(document).ready(function( $ ) {
    var today = new Date();
    $('.newdate-picker').datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose:true,
        endDate: "today",
        maxDate: 0,
        minDate: -3
    }).on('changeDate', function (ev) {
        $(this).datepicker('hide');
    });

    $('input.timepicker1').timepicker();
    $('input.timepicker2').timepicker();

    $('.newdate-picker').keyup(function () {
        if (this.value.match(/[^0-9]/g)) {
            this.value = this.value.replace(/[^0-9^-]/g, '');
        }
    });


    $("#ot_file").on('change', function() {
        //Get count of selected files
        var countFiles = $(this)[0].files.length;
        var imgPath = $(this)[0].value;
        var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
        var image_holder = $("#image-holder");
        image_holder.empty();
        if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
            if (typeof(FileReader) != "undefined") {
                //loop for each file selected for uploaded.
                for (var i = 0; i < countFiles; i++)
                {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $("<img />", {
                            "src": e.target.result,
                            "class": "thumb-image",
                            "width": "200",
                        }).appendTo(image_holder);
                    }
                    image_holder.show();
                    reader.readAsDataURL($(this)[0].files[i]);
                }
            } else {
                echo (image_holder);
            }
        } else {
            //alert ("Pls select only images");
        }
    });
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
                        <p><img src="/photo_storage/{{$userDetails->emp_photo}}" class="img-circle"></p>
                        <p>&nbsp;</p>
                    </div>
                </div>
                <div class="col-md-4 profile-text">
                    <h3>{{$userDetails->name}}</h3>
                    <h6>{{$userDetails->position}}</h6>
                    <p>{{$userDetails->email}} || {{$userDetails->mobile}} </p>
                </div>
                <div class="col-md-4 profile-text" style="margin-top: 35px ">
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


    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                <h3 class="control-label col-md-2">Month: </h3>
                <div class="col-md-2 col-xs-6">
                    <h4 class="control-label col-md-2" style="margin-top:20px;">
                        <?php
                        $MonthVal = date('F');
                        $MonthNumber = date('n');
                        $YearNumber = date('Y');
                        $months = array();
                        for ($i = 0; $i < 12; $i++) {
                            $timestamp = mktime(0, 0, 0, date('n') - $i, 1);
                            $months[date('n', $timestamp)] = date('F', $timestamp);
                        } ?>
                        <select name="monthfilter" id="monthfilter" class="btn-primary" style="border-radius: 10px;padding: 5px;">
                            <?php
                            $j = 1;
                            foreach($months as $key =>$value){ ?>
                            <option value="{{$key}}"
                            <?php if($key==$monthval){ echo "selected='selected'"; } ?>>{{$value." ".$YearNumber}}</option>
                            <?php
                            $j++;
                            } ?>
                        </select>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                <h3 class="control-label col-md-2">Total: </h3>
                <div class="col-md-4 col-xs-6">
                    <h3 class="control-label text-left">{{$AllcountHrs."hrs ".$AllcountMins."mins"}}</h3>
                </div>
            </div>
        </div>
    </div>
<div class="row">
<div class="col-lg-12">
    <p>&nbsp;</p>
   <div class="adv-table">
    <table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" {{$tabclass}}>
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
    </table>
   </div>
</div>
</div>


</div>
</div>
</div>
</section>
</section>

    <!--footer start-->
    <footer class="site-footer" style="margin-top: 391px;">
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

<script>
    $("#monthfilter").on("change", function (e) {
        let edit_id = $(this).val();
        window.location.href = window.location.origin + '/allotempdetails/{{$u_id}}?m=' + edit_id;
    });
</script>

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

<script type="text/javascript" language="javascript" src="{{ asset('asset/lib/advanced-datatable/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/advanced-datatable/js/DT_bootstrap.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#hidden-table-info').dataTable();
    });
</script>
</body>
</html>
