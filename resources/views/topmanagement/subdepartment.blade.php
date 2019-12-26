<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<link href="asset/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="asset/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />
<style>
    #zabuto_calendar_{{$seldate}} { background: #fff; }
    div#zabuto_calendar_{{$seldate}}_day { color:#000!important; }
</style>

<?php
$i=0; $alldates = array();
if(isset($allreports)){
    foreach ($allreports as $k=>$v){
        $alldates[$i] = $v->date;
        $i++;
    }
}
$list=array();
$month = date('m');
$prevmonth1 = date('m', strtotime(date('Y-m')." -1 month"));
$prevmonth2 = date('m', strtotime(date('Y-m')." -2 month"));
$currdte = date('d');
$year = date('Y');
for($d=1; $d<=31; $d++)
{
    $time=mktime(12, 0, 0, $month, $d, $year);
    if (date('m', $time)==$month)
        if($currdte>=$d){
            $list[]=date('Y-m-d', $time);
        }
}
for($pred=1; $pred<=31; $pred++)
{
    $time=mktime(12, 0, 0, $prevmonth1, $pred, $year);
    if (date('m', strtotime(date('Y-m')." -1 month"))==$prevmonth1)
        $prevlist1[]=date('Y-m-d', $time);
}
for($pred2=1; $pred2<=31; $pred2++)
{
    $time=mktime(12, 0, 0, $prevmonth2, $pred2, $year);
    if (date('m', strtotime(date('Y-m')." -2 month"))==$prevmonth2)
        $prevlist2[]=date('Y-m-d', $time);
}
$list = array_merge($list, $prevlist1, $prevlist2);
foreach($alldates as $k=>$v){ ?>
<style>
    div#zabuto_calendar_{{$v}}_day { color:#2a9055; }
</style>
<?php
}
$diff_result = array_diff($list, $alldates);
$diff_result = array_values($diff_result);
foreach($diff_result as $k=>$v){
$currdate = date('m-d-Y');
$v = date('Y-m-d', strtotime($v));
if($v < $currdate){ ?>
<style>
    div#zabuto_calendar_{{$val}}_day { color:#ffff; }
</style>
<?php } else {
$val = date('Y-m-d', strtotime($v)); ?>
<style>
    div#zabuto_calendar_{{$val}}_day { color:#ac2925!important; }
</style>
<?php
}
} ?>
<body>
	<section id="container">
		@include('layout.dashboard')
		@include('layout.sidenav')
		<section id="main-content">
			<section class="wrapper site-min-height">
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
                <div class="row">
                    @foreach($staffs as $staff)
                    <div class="col-lg-9 ds">
                        <div class="content-panel pn">
                            <div id="profile-02">
                                <div class="user">
                                    <?php
                                    if(isset($staff->sub_department) && $staff->sub_department=='marketing_seo'){
                                        $sub_department = 'SEO';
                                    } elseif($staff->sub_department=='it_app'){
                                        $sub_department = 'APP';
                                    } elseif($staff->sub_department=='marketing_content'){
                                        $sub_department = 'Content';
                                    } elseif($staff->sub_department=='marketing_support'){
                                        $sub_department = 'Support';
                                    } elseif($staff->sub_department=='it_blockchain'){
                                        $sub_department = 'Blockchain';
                                    } elseif($staff->sub_department=='management_operation'){
                                        $sub_department = 'Operation';
                                    }
                                    ?>

                                    <h4>{{$sub_department}} Team</h4>
                                </div>
                            </div>

                            <div class="pr2-social centered">
                                <a href="{{ url('management/subdept')."/".$staff->sub_department}}" class="btn btn-sm btn-clear-g" style="margin-top: 10px; color: #3d3d3d;">View Team</a>
                            </div>

                        </div>

                    </div>
                    @endforeach
                </div>
                </section>
        </section>
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
			<!-- js placed at the end of the document so the pages load faster -->
			<script src="lib/jquery/jquery.min.js"></script>
			<script src="lib/bootstrap/js/bootstrap.min.js"></script>
			<script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
			<script src="lib/jquery.scrollTo.min.js"></script>
			<script src="lib/jquery.nicescroll.js" type="text/javascript"></script>

			<script type="text/javascript" language="javascript" src="/asset/lib/advanced-datatable/js/jquery.js"></script>


			<script type="text/javascript" language="javascript" src="/asset/lib/advanced-datatable/js/jquery.dataTables.js"></script>
			<script type="text/javascript" src="/asset/lib/advanced-datatable/js/DT_bootstrap.js"></script>
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
       nCloneTd.innerHTML = '<img src="/asset/lib/advanced-datatable/images/details_open.png">';
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
