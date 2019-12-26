<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/lib/bootstrap-fileupload/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    jQuery(document).ready(function( $ ) {
        Date.prototype.yyyymmdd = function () {
            var dd = this.getDate().toString();
            var mm = (this.getMonth() + 1).toString();
            var yyyy = this.getFullYear().toString();
            return (yyyy + "-" + (mm[1] ? mm : "0" + mm[0]) + (dd[1] ? dd : "0" + dd[0]));
        };
        $(".newdate-picker").datepicker({
            dateFormat: "yy-mm-dd", endDate: "today",
            onSelect: function (_date, _datepicker) {
                var myDate = new Date(_date).yyyymmdd();
                myDate.setDate(myDate.getDate());
            }
        });

        $("#empotfilter").hide();
        $("#deptotfilter").hide();
        $("#emptyfilter1").show();
        $("#emptyfilter2").show();

        <?php if(isset($errempmsg) && $errempmsg == 1){ ?>
            $("#empotfilter").show();
        <?php } ?>

        <?php if(isset($errdeptmsg) && $errdeptmsg == 1){ ?>
            $("#deptotfilter").show();
        <?php } ?>

        $("#empbtn").click(function(){
            $("#empotfilter").toggle();
            $("#deptotfilter").hide();
        });
        $("#deptbtn").click(function(){
            $("#deptotfilter").toggle();
            $("#empotfilter").hide();
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
    <div class="row mt-2">
        <div class="col-md-2">
            <button class="form-control form-control-inline btn-theme" id="empbtn" style="display: block;margin-left:10px;">Employee</button>
        </div>
        <div class="col-md-2">
            <button class="form-control form-control-inline btn-theme" id="deptbtn" style="display: block;margin: auto">Department</button>
        </div>

    </div>

<div class="row">
<div class="col-lg-12">
<div class="form-panel">
    <div class="row" id="emptyfilter1" >
        <div class="col-lg-12"><p style="height: 100px;">&nbsp;</p></div>
    </div>
    <div id="empotfilter" style="display: none">
        <div class="row mt-3">
        <div class="col-lg-12">
            <form class="form-horizontal style-form" method="post" action="downloadReportEmp">
                {{ csrf_field() }}
            <div class="form-group">
                <div class="row">
                <div class="col-md-3 col-md-offset-1">
                    <div class="pull-right" style="display: grid;">
                        <label class="control-label">Select Employee</label>
                        <select name="empidfilter" id="empidfilter" class="btn-primary form-control form-control-inline">
                            <option value="allemps">All Employees</option>
                            <?php
                            foreach($allusers as $key =>$value){ ?>
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="control-label">From Date</label>
                        <input class="form-control form-control-inline input-medium newdate-picker" type="text"
                               name="fromdate" autocomplete="off" required>
                </div>

                <div class="col-md-2">
                    <label class="control-label">To Date</label>
                    <input class="form-control form-control-inline input-medium newdate-picker" type="text"
                           name="todate" autocomplete="off" required>
                </div>

                <div class="col-md-2">
                    <label class="control-label">&nbsp;</label>
                    <button class="form-control form-control-inline btn-theme" name="sbmtreport">Download</button>
                </div>
                </div>
            </div>
            </form>
        </div>
    </div>
        <div class="col-lg-12">
            <div class="col-md-8 col-md-offset-2">
                <?php if(isset($errempmsg) && $errempmsg==1){ ?>
                    <button class="btn btn-danger w-100" style="width: 100%;pointer-events: none">No Records Found!</button>
                <?php } ?>
            </div>
        </div>
    </div>

    <div id="deptotfilter" style="display: none">
        <div class="row mt-3">
            <div class="col-lg-12">
                <form class="form-horizontal style-form" method="post" action="downloadDeptReport">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-md-2 col-md-offset-1">
                            <div class="pull-right" style="display: grid;">
                            <label class="control-label">Department</label>
                            <select name="didfilter" id="didfilter" class="btn-primary form-control form-control-inline">
                                <option value="alldepts">All Departments</option>
                                <?php
                                foreach($departments as $key =>$value){ ?>
                                <option value="{{$value->d_id}}">{{$value->d_title}}</option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="pull-right" style="display: grid;">
                            <label class="control-label">SubDepartment</label>
                            <select name="sdidfilter" id="sdidfilter" class="btn-primary form-control form-control-inline">
                                <option value="allsubdepts">All SubDepartments</option>
                                <?php
                                foreach($subdepartments as $key =>$value){ ?>
                                <option value="{{$value->sd_id}}">{{$value->sd_title}}</option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label class="control-label">From Date</label>
                            <input class="form-control form-control-inline input-medium newdate-picker "
                                   type="text" name="fromdate" autocomplete="off" required>
                        </div>

                        <div class="col-md-2">
                            <label class="control-label">To Date</label>
                            <input class="form-control form-control-inline input-medium newdate-picker"
                                   type="text" name="todate" autocomplete="off" required>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label">&nbsp;</label>
                                <button class="btn btn-theme form-control form-control-inline" name="sbmtreport">Download</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="col-md-8 col-md-offset-2">
                <?php if(isset($errdeptmsg) && $errdeptmsg==1){ ?>
                <button class="btn btn-danger w-100" style="width: 100%;pointer-events: none">No Records Found!</button>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="row" id="emptyfilter2" >
        <div class="col-lg-12"><p style="height: 100px;">&nbsp;</p></div>
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

<script type="text/javascript">
    $("select[name='didfilter']").change(function(){
        var d_id = $(this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "<?php echo route('select-ajax') ?>",
            method: 'POST',
            data: {d_id:d_id, _token:token},
            success: function(data) {
                $("select[name='sdidfilter'").html('');
                $("select[name='sdidfilter'").html(data.options);
            }
        });
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
<script type="text/javascript" src="/asset/lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/asset/lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
<script src="/asset/lib/advanced-form-components.js"></script>
</body>
</html>
