<!DOCTYPE html>
<html lang="en">

@include('layout.head')
<link href="asset/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="asset/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />
<body>

	<section id="container">

		@include('layout.dashboard')
		@include('layout.sidenav')
		
		<section id="main-content">
			<section class="wrapper site-min-height">
				<div class="row mt">
					<div class="col-lg-12">
						<div class="row content-panel">
							<div class="col-md-4 profile-text mt mb centered">
								<div class="right-divider hidden-sm hidden-xs">
									<h4>10</h4>
									<h6>TOTAL TASK</h6>
									<h4>5</h4>
									<h6>FINISH TASK</h6>
									<h4>5</h4>
									<h6> PENDING TASK</h6>
								</div>
							</div>
							<!-- /col-md-4 -->
							<div class="col-md-4 profile-text">
								<h3>{{Auth::user()->name}}</h3>
								<h6>{{Auth::user()->position}}</h6>
								<p>{{Auth::user()->email}} || {{Auth::user()->mobile}} </p>
								<br>
								<p>  

								</div>
								<!-- /col-md-4 -->
								<div class="col-md-4 centered">
									<div class="profile-pic">
										<p>
											<img src="photo_storage/{{Auth::user()->email}}-{{Auth::user()->name}}.jpg" class="img-circle"></p>
											<p>
											</p>
										</div>
									</div>
								</div>
							</div>

						</div>
						<div class="row" style="margin-top: 20px;">

							<div class="col-lg-4 col-md-4 col-sm-4 mb">
								<div class="weather-3 pn centered">
									<i class="fa fa-bookmark"></i>
									<h1>MANAGEMENT</h1>
									<div class="info">
										<div class="row">
											<h3 class="centered">

												<button type="button" class="btn btn-primary btn-sm">View Report</button>

											</h3>
											<div class="col-sm-6 col-xs-6 pull-left">
												<p class="goleft"><i class="fa fa-tint"></i> </p>
											</div>
											<div class="col-sm-6 col-xs-6 pull-right">
												<p class="goright"><i class="fa fa-flag"></i> </p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 mb">
								<div class="weather-3 pn centered">
									<i class="fa fa-code"></i>
									<h1>I.T DEPARTMENT</h1>
									<div class="info">
										<div class="row">
											<h3 class="centered">
												<a type="button" class="btn btn-primary btn-sm" href="/itdepartment">View Report</a>
											</h3>
											<div class="col-sm-6 col-xs-6 pull-left">
												<p class="goleft"><i class="fa fa-tint"></i> </p>
											</div>
											<div class="col-sm-6 col-xs-6 pull-right">
												<p class="goright"><i class="fa fa-flag"></i> </p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 mb">
								<div class="weather-3 pn centered">
									<i class="fa fa-bullhorn"></i>
									<h1>MARKETING</h1>
									<div class="info">
										<div class="row">
											<h3 class="centered">

												<a type="button" class="btn btn-primary btn-sm" href="/marketing">View Report</a>
											</h3>
											<div class="col-sm-6 col-xs-6 pull-left">
												<p class="goleft"><i class="fa fa-tint"></i> </p>
											</div>
											<div class="col-sm-6 col-xs-6 pull-right">
												<p class="goright"><i class="fa fa-flag"></i> </p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 mb">
								<div class="weather-3 pn centered">
									<i class="fa fa-archive"></i>
									<h1>ADMIN DEPARTMENT</h1>
									<div class="info">
										<div class="row">
											<h3 class="centered">
												<button type="button" class="btn btn-primary btn-sm">View Report</button>
											</h3>
											<div class="col-sm-6 col-xs-6 pull-left">
												<p class="goleft"><i class="fa fa-tint"></i> </p>
											</div>
											<div class="col-sm-6 col-xs-6 pull-right">
												<p class="goright"><i class="fa fa-flag"></i> </p>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-4 col-md-4 col-sm-4 mb">
								<div class="weather-3 pn centered">
									<i class="fa fa-bar-chart-o"></i>
									<h1>ACCOUNTING</h1>
									<div class="info">
										<div class="row">
											<h3 class="centered">
												<button type="button" class="btn btn-primary btn-sm">View Report</button>
											</h3>
											<div class="col-sm-6 col-xs-6 pull-left">
												<p class="goleft"><i class="fa fa-tint"></i> </p>
											</div>
											<div class="col-sm-6 col-xs-6 pull-right">
												<p class="goright"><i class="fa fa-flag"></i> </p>
											</div>
										</div>
									</div>
								</div>
							</div>


						</div>


					</section>

				</section>

				<footer class="site-footer">
					<div class="text-center">
						<p>
							&copy; Copyrights <strong>ABBC </strong>. All Rights Reserved
						</p>

						<a href="profile.html#" class="go-top">
							<i class="fa fa-angle-up"></i>
						</a>
					</div>
				</footer>
				<!--footer end-->
			</section>
			<!-- js placed at the end of the document so the pages load faster -->
			<script src="lib/jquery/jquery.min.js"></script>
			<script src="lib/bootstrap/js/bootstrap.min.js"></script>
			<script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
			<script src="lib/jquery.scrollTo.min.js"></script>
			<script src="lib/jquery.nicescroll.js" type="text/javascript"></script>

			<script type="text/javascript" language="javascript" src="asset/lib/advanced-datatable/js/jquery.js"></script>


			<script type="text/javascript" language="javascript" src="asset/lib/advanced-datatable/js/jquery.dataTables.js"></script>
			<script type="text/javascript" src="asset/lib/advanced-datatable/js/DT_bootstrap.js"></script>
			<!--common script for all pages-->



			<!--common script for all pages-->
			<script src="lib/common-scripts.js"></script>
			<!--script for this page-->
			<!-- MAP SCRIPT - ALL CONFIGURATION IS PLACED HERE - VIEW OUR DOCUMENTATION FOR FURTHER INFORMATION -->
			<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASm3CwaK9qtcZEWYa-iQwHaGi3gcosAJc&sensor=false"></script>
			<script>
				$('.contact-map').click(function() {

      //google map in tab click initialize
      function initialize() {
      	var myLatlng = new google.maps.LatLng(40.6700, -73.9400);
      	var mapOptions = {
      		zoom: 11,
      		scrollwheel: false,
      		center: myLatlng,
      		mapTypeId: google.maps.MapTypeId.ROADMAP
      	}
      	var map = new google.maps.Map(document.getElementById('map'), mapOptions);
      	var marker = new google.maps.Marker({
      		position: myLatlng,
      		map: map,
      		title: 'Dashio Admin Theme!'
      	});
      }
      google.maps.event.addDomListener(window, 'click', initialize);
  });
</script>

<script type="text/javascript">
	/* Formating function for row details */
	function fnFormatDetails(oTable, nTr) {
		var aData = oTable.fnGetData(nTr);
		var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';

		sOut += '<tr><td>Manager Comment:</td><td>Could provide a link here</td></tr>';

		sOut += '</table>';

		return sOut;
	}

	$(document).ready(function() {
      /*
       * Insert a 'details' column to the table
       */
       var nCloneTh = document.createElement('th');
       var nCloneTd = document.createElement('td');
       nCloneTd.innerHTML = '<img src="asset/lib/advanced-datatable/images/details_open.png">';
       nCloneTd.className = "center";

       $('#hidden-table-info thead tr').each(function() {
       	this.insertBefore(nCloneTh, this.childNodes[0]);
       });

       $('#hidden-table-info tbody tr').each(function() {
       	this.insertBefore(nCloneTd.cloneNode(true), this.childNodes[0]);
       });

      /*
       * Initialse DataTables, with no sorting on the 'details' column
       */
       var oTable = $('#hidden-table-info').dataTable({
       	"aoColumnDefs": [{
       		"bSortable": false,
       		"aTargets": [0]
       	}],
       	"aaSorting": [
       	[1, 'asc']
       	]
       });

      /* Add event listener for opening and closing details
       * Note that the indicator for showing which row is open is not controlled by DataTables,
       * rather it is done here
       */
       $('#hidden-table-info tbody td img').live('click', function() {
       	var nTr = $(this).parents('tr')[0];
       	if (oTable.fnIsOpen(nTr)) {
       		/* This row is already open - close it */
       		this.src = "asset/lib/advanced-datatable/media/images/details_open.png";
       		oTable.fnClose(nTr);
       	} else {
       		/* Open this row */
       		this.src = "asset/lib/advanced-datatable/images/details_close.png";
       		oTable.fnOpen(nTr, fnFormatDetails(oTable, nTr), 'details');
       	}
       });
   });
</script>


</body>

</html>