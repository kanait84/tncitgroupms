<!DOCTYPE html>
<html lang="en">

@include('layout.head')
<link rel="stylesheet" type="text/css" href="asset/lib/bootstrap-fileupload/bootstrap-fileupload.css" />

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
	jQuery(document).ready(function( $ ) {
		var today = new Date();
		$('.newdate-picker').datepicker({
			format: 'mm-dd-yyyy',
			autoclose:true,
			endDate: "today",
			maxDate: today
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
				<h3><i class="fa fa-angle-right"></i> Add Department</h3>
				<!-- BASIC FORM ELELEMNTS -->
				<div class="row mt">
					<div class="col-lg-12">
						<div class="form-panel">

							<form class="form-horizontal style-form" method="post" action="postdepartment" enctype="multipart/form-data" autocomplete="off" style="margin-left: 20px; padding-top: 20px; padding-bottom: 20px;">
								{{ csrf_field() }}

								<div class="form-group">
									<label class="control-label col-md-2">Title</label>
									<div class="col-md-3 col-xs-11">
										<input class="form-control form-control-inline" type="text" value="" name="d_title" id="d_title" required="">
										<span class="help-block"></span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 col-sm-2 control-label">Department Information</label>
									<div class="col-sm-10">
										<textarea class="form-control" name="d_description" id="d_description" placeholder="Department details" rows="5" data-rule="required" data-msg="Please write your daily report"></textarea>
										<span class="help-block"></span>
										<div class="validate"></div>
									</div>
								</div>
								<div class="form-group">
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
