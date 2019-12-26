<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/lib/bootstrap-fileupload/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
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
    $('input.timepicker2').timepicker('setTime', '17:00');
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
<h3><i class="fa fa-angle-right"></i> OverTime Request</h3>
<!-- BASIC FORM ELELEMNTS -->
<div class="row">
    <div class="col-lg-12">
        <div class="form-panel">
            <form class="form-horizontal style-form" method="post" action="postOtUserRequest"
                  enctype="multipart/form-data" autocomplete="off" style="margin-left: 20px; padding-top: 20px; padding-bottom: 20px;">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="control-label col-md-2">Date</label>
                            <div class="col-md-3 col-xs-6">
                                <input class="form-control form-control-inline input-medium newdate-picker"
                                       size="16" type="text" name="date" id="date" value="{{$cdate}}" required="" >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="control-label col-md-2">Start Time</label>
                            <div class="col-md-3 col-xs-6">
                                <input class="form-control form-control-inline input-medium timepicker1"
                                       size="16" type="text" name="start_time" id="start_time" value="18:00" required="" >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="control-label col-md-2">End Time</label>
                            <div class="col-md-3 col-xs-6">
                                <input class="form-control form-control-inline input-medium timepicker2"
                                       size="16" type="text" name="end_time" id="end_time" required="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="control-label col-md-2">Reporting Person</label>
                            <div class="col-md-3 col-xs-6">
                                <select name="report_uid" id="report_uid" class="form-control">
                                    @foreach($allusers as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="control-label col-md-2">Reason</label>
                            <div class="col-md-6 col-xs-8">
                                <textarea class="form-control" name="reason" id="reason" placeholder="Reason"
                                          rows="5" data-rule="required" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="form-group">
                            <label class="control-label col-md-2">Upload File</label>
                            <div class="col-md-6 col-xs-8">
                                <input id="ot_file" type="file" name="ot_file" class="form-control">
                                <span id="image-holder"></span>
                                <script>
                                    var loadFile = function(event) {
                                        var output = document.getElementById('ot_file');
                                        output.src = URL.createObjectURL(event.target.files[0]);
                                    };
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="hidden" name="mgr_id" id="mgr_id" value="{{$mgrDetails->id}}">
                    <button type="submit" class="btn btn-theme">Submit</button>
                </form>
                @if ($message = Session::get('error'))
                    <div class="alert alert-danger alert-block">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                @endif

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
            </div>
        </div>
    </div>
</section>
</section>

    <!--footer start-->
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
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
</body>
</html>
