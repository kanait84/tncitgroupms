<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/lib/bootstrap-fileupload/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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


        $('.newdate-picker').keyup(function () {
            if (this.value.match(/[^0-9]/g)) {
                this.value = this.value.replace(/[^0-9^-]/g, '');
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
                                <p>
                                    <img src="/photo_storage/{{Auth::user()->emp_photo}}" class="img-circle"></p>
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
                            <p>  <a class="btn btn-theme" href="{{ url('submitreport') }}"><i class="fa fa-upload"></i>
                                    Submit Daily Report</a></p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8 main-chart">
                    <h3><i class="fa fa-angle-right"></i> Update Report</h3>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-panel">
                                <form class="form-horizontal style-form" method="post" action="{{url('report/'.$report->r_id.'/'.$n_id)}}" enctype="multipart/form-data" autocomplete="off" style="margin-left: 20px; padding-top: 20px; padding-bottom: 20px;">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label class="control-label col-md-2">Date</label>
                                        <div class="col-md-3 col-xs-11">
                                            <input class="form-control form-control-inline input-medium newdate-picker " size="16" type="text" name="date" id="date" value="{{$report->date}}" disabled="disabled">
                                            <span class="help-block">Select date</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 col-sm-2 control-label">Detailed Report</label>
                                        <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description"
                          placeholder="Daily Report Details" rows="5">{{$report->description}}</textarea>
                                            <span class="help-block">Enter your detailed report.</span>
                                            <div class="validate"></div>
                                        </div>
                                    </div>

                                    {{--<div class="form-group">
                                        <label class="control-label col-md-2">Without input</label>
                                        <div class="controls col-md-9">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                    <span class="btn btn-theme02 btn-file">
                        <input type="file" class="default" value="{{$report->date}}-{{Auth::user()->id}}.{{$report->file_type}}" name="attachment" id="attachment" />
                    </span>
                                            </div>
                                            @if($report->attachment != "")
                                                <p>Attachment: <a href="../report_attachment/{{$report->date}}-{{Auth::user()->id}}.{{$report->file_type}}" target="_blank" type="button" class="btn btn-primary btn-xs">Download</a>
                                            @else
                                                <p>No Attachment</p>
                                                @endif
                                                </p>
                                        </div>
                                    </div>--}}

                                    <div class="form-group">
                                        <label class="control-label col-md-2">Without input</label>
                                        <div class="controls col-md-9">
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
											<span class="btn btn-theme02 btn-file">
												<span class="fileupload-new"><i class="fa fa-paperclip"></i> Select file</span>
												<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
												<input type="file" class="default" name="attachment" id="attachment" value="{{$report->date}}-{{Auth::user()->id}}.{{$report->file_type}}" />
											</span>
                                                <span class="fileupload-preview" style="margin-left:5px;"></span>
                                                <a href="#" class="close fileupload-exists"
                                                   data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
                                                @if($report->attachment != "")
                                                    <span class="right-button showback">
                                                    Existing Attachment: <a href="../report_attachment/{{$report->date}}-{{Auth::user()->id}}.{{$report->file_type}}"
                                                        class="btn btn-primary btn-xs">Download</a></span>
                                                @else
                                                    <span class="right-button showback">No Attachment</span>
                                                @endif

                                            </div>
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-theme">Update</button>
                                </form>
                            </div>
                            <!-- /Message Panel-->
                        </div>
                        <!-- /col-md-8  -->
                    </div>
                </div>
                <div class="col-lg-4">
                </div>
            </div>
        </section>
    </section>
</section>
<!-- js placed at the end of the document so the pages load faster -->
<script src="{{ asset('asset/lib/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('asset/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('asset/lib/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('asset/lib/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('asset/lib/jquery.nicescroll.js') }}" type="text/javascript"></script>
<!--common script for all pages-->
<script src="{{ asset('asset/lib/common-scripts.js') }}"></script>
<!--script for this page-->
<script src="{{ asset('asset/lib/jquery-ui-1.9.2.custom.min.js') }}"></script>
<!--custom switch-->
<script src="{{ asset('asset/lib/bootstrap-switch.js') }}"></script>
<!--custom tagsinput-->
<script src="{{ asset('asset/lib/jquery.tagsinput.js') }}"></script>
<!--custom checkbox & radio-->
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-daterangepicker/date.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-inputmask/bootstrap-inputmask.min.js') }}"></script>
<script src="{{ asset('asset/lib/form-component.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-fileupload/bootstrap-fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/bootstrap-timepicker/js/bootstrap-timepicker.js') }}"></script>
<script src="{{ asset('asset/lib/advanced-form-components.js') }}"></script>

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
</body>
</html>
