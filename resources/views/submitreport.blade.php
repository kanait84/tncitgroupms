<!DOCTYPE html>
<html lang="en">

@include('layout.head')
<link rel="stylesheet" type="text/css" href="asset/lib/bootstrap-fileupload/bootstrap-fileupload.css" />

<body>

	<section id="container">

		@include('layout.dashboard')
		@include('layout.sidenav')

		<section id="main-content">
			<section class="wrapper">
				<h3><i class="fa fa-angle-right"></i> Submit Report</h3>
				<!-- BASIC FORM ELELEMNTS -->
				<div class="row mt">
					<div class="col-lg-12">
						<div class="form-panel">

							<form class="form-horizontal style-form" method="post" action="postReport" enctype="multipart/form-data" autocomplete="off" style="margin-left: 20px; padding-top: 20px; padding-bottom: 20px;">
								{{ csrf_field() }}


								<div class="form-group">
									<label class="control-label col-md-2">Date</label>
									<div class="col-md-3 col-xs-11">
										<input class="form-control form-control-inline input-medium default-date-picker " size="16" type="text" value="" name="date" id="date" required="">
										<span class="help-block">Select date</span>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-md-2">Task Date</label>
									<div class="col-md-3 col-xs-11">
										<input class="form-control form-control-inline input-medium default-date-picker " size="16" type="text" value="" name="task_date" id="task_date" required="">
										<span class="help-block">Select the date where your task started.</span>
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label">Detailed Report</label>
									<div class="col-sm-10">
										<textarea class="form-control" name="description" id="description" placeholder="Daily Report Details" rows="5" data-rule="required" data-msg="Please write your daily report"></textarea>
										<span class="help-block">Enter your detailed report.</span>
										<div class="validate"></div>
									</div>
								</div>


								<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label">Overtime</label>
									<div class="col-sm-1 text-center">
										<div class="switch switch-square" data-on-label="<i class=' fa fa-check'></i>" data-off-label="<i class='fa fa-times'></i>">
											<input type="checkbox"  name="overtime" id="overtime" />
										</div>
									</div>

							
								</div>

								<div class="form-group">
									<label class="control-label col-md-2">Without input</label>
									<div class="controls col-md-9">
										<div class="fileupload fileupload-new" data-provides="fileupload">
											<span class="btn btn-theme02 btn-file">
												<span class="fileupload-new"><i class="fa fa-paperclip"></i> Select file</span>
												<span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
												<input type="file" class="default" name="attachment" id="attachment" />
											</span>
											<span class="fileupload-preview" style="margin-left:5px;"></span>
											<a href="advanced_form_components.html#" class="close fileupload-exists" data-dismiss="fileupload" style="float: none; margin-left:5px;"></a>
										</div>
									</div>
								</div>

								<button type="submit" class="btn btn-theme">Submit</button>
							</form>
						</div>
					</div>

				</div>


			</section>

		</section>



	</section>



	<script src="asset/lib/jquery/jquery.min.js"></script>
	<script src="asset/lib/bootstrap/js/bootstrap.min.js"></script>
	<script class="include" type="text/javascript" src="asset/lib/jquery.dcjqaccordion.2.7.js"></script>
	<script src="asset/lib/jquery.scrollTo.min.js"></script>
	<script src="asset/lib/jquery.nicescroll.js" type="text/javascript"></script>
	<!--common script for all pages-->
	<script src="asset/lib/common-scripts.js"></script>
	<!--script for this page-->
	<script src="asset/lib/jquery-ui-1.9.2.custom.min.js"></script>
	<!--custom switch-->
	<script src="asset/lib/bootstrap-switch.js"></script>
	<!--custom tagsinput-->
	<script src="asset/lib/jquery.tagsinput.js"></script>
	<!--custom checkbox & radio-->
	<script type="text/javascript" src="asset/lib/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="asset/lib/bootstrap-daterangepicker/date.js"></script>
	<script type="text/javascript" src="asset/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="asset/lib/bootstrap-inputmask/bootstrap-inputmask.min.js"></script>
	<script src="asset/lib/form-component.js"></script>



	<script type="text/javascript" src="asset/lib/bootstrap-fileupload/bootstrap-fileupload.js"></script>
	<script type="text/javascript" src="asset/lib/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script type="text/javascript" src="asset/lib/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="asset/lib/bootstrap-daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="asset/lib/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script src="asset/lib/advanced-form-components.js"></script>




</body>

</html>
