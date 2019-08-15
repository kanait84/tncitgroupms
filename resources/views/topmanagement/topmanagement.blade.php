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
				
				<div class="col-lg-9 ds" style="">


					@foreach($departments as $department)
					<a href="{{ url('viewdepartment')."/".$department->d_id}}"><div class="col-md-4 col-sm-4 mb" style="margin-top: 20px;">
						<div class="darkblue-panel pn">
							<div class="darkblue-header" style="padding-top: 50px;">
								

								<h5>{{$department->d_title}}</h5>
								
							</div>
							<canvas id="serverstatus02" height="10" width="120"></canvas>
					<!-- 		<h1>10</h1>
						<p>No. of Employee</p> -->


						<button class="btn btn-xs btn-block" style="padding: 5px; margin-top: 20px;">View Department</button>
						
						<footer style="background-color: blue">
							<div class="pull-left">
								<!-- <h5><i class="fa fa-hdd-o"></i> </h5> -->
							</div>
							<div class="pull-right">
								<h5></h5>
							</div>
						</footer>
					</div>
					<!--  /darkblue panel -->
				</div></a>

				@endforeach




			</div>
			<div class="col-lg-3 ds">
				<!--COMPLETED ACTIONS DONUTS CHART-->
				<div id="calendar" class="mb">
					<div class="panel green-panel no-margin">
						<div class="panel-body">
							<div id="date-popover" class="popover top" style="cursor: pointer; disadding: block; margin-left: 33%; margin-top: -50px; width: 175px;">
								<div class="arrow"></div>
								<h3 class="popover-title" style="disadding: none;"></h3>
								<div id="date-popover-content" class="popover-content"></div>
							</div>
							<div id="my-calendar"></div>
						</div>
					</div>
				</div>


				<div class="donut-main">
					<h4>COMPLETED ACTIONS & PROGRESS</h4>
					<canvas id="newchart" height="130" width="130"></canvas>
					<script>
						var doughnutData = [{
							value: 70,
							color: "#4ECDC4"
						},
						{
							value: 30,
							color: "#fdfdfd"
						}
						];
						var myDoughnut = new Chart(document.getElementById("newchart").getContext("2d")).Doughnut(doughnutData);
					</script>
				</div>
				<!--NEW EARNING STATS -->
				<div class="panel terques-chart">
					<div class="panel-body">
						<div class="chart">
							<div class="centered">
								<span>TODAY REPORTS</span>
								<strong>68 | 97</strong>
							</div>
							<br>
							<div class="sparkline" data-type="line" data-resize="true" data-height="75" data-width="90%" data-line-width="1" data-line-color="#fff" data-spot-color="#fff" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="4" data-data="[200,135,667,333,526,996,564,123,890,564,455]"></div>
						</div>
					</div>
				</div>
				<!--new earning end-->
				<!-- RECENT ACTIVITIES SECTION -->
				<h4 class="centered mt">RECENT ACTIVITY</h4>
				<!-- First Activity -->
				<div class="desc">
					<div class="thumb">
						<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
					</div>
					<div class="details">
						<p>
							<muted>Just Now</muted>
							<br/>
							<a href="#">Paul Rudd</a> submitted daily report.<br/>
						</p>
					</div>
				</div>
				<!-- Second Activity -->
				<div class="desc">
					<div class="thumb">
						<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
					</div>
					<div class="details">
						<p>
							<muted>2 Minutes Ago</muted>
							<br/>
							<a href="#">James Brown</a> submitted daily report.<br/>
						</p>
					</div>
				</div>
				<!-- Third Activity -->
				<div class="desc">
					<div class="thumb">
						<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
					</div>
					<div class="details">
						<p>
							<muted>3 Hours Ago</muted>
							<br/>
							<a href="#">Diana Kennedy</a> request to edit daily report.<br/>
						</p>
					</div>
				</div>
				<!-- Fourth Activity -->
				<div class="desc">
					<div class="thumb">
						<span class="badge bg-theme"><i class="fa fa-clock-o"></i></span>
					</div>
					<div class="details">
						<p>
							<muted>7 Hours Ago</muted>
							<br/>
							<a href="#">Brando Page</a> submitted daily report.<br/>
						</p>
					</div>
				</div>
				<!-- USERS ONLINE SECTION -->
				<!-- CALENDAR-->
				<!-- / calendar -->
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
<script src="asset/lib/jquery/jquery.min.js"></script>
<script src="asset/lib/bootstrap/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="asset/lib/jquery.dcjqaccordion.2.7.js"></script>
<script src="asset/lib/jquery.scrollTo.min.js"></script>
<script src="asset/lib/jquery.nicescroll.js" type="text/javascript"></script>
<script src="asset/lib/zabuto_calendar.js"></script>

<script type="text/javascript" language="javascript" src="asset/asset/lib/advanced-datatable/js/jquery.js"></script>


<script type="text/javascript" language="javascript" src="asset/lib/advanced-datatable/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="asset/lib/advanced-datatable/js/DT_bootstrap.js"></script>
<!--common script for all pages-->


<!--common script for all pages-->
<script src="asset/lib/common-scripts.js"></script>

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
				return myDateFunction(this.id, false);
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
</script>


</body>

</html>
