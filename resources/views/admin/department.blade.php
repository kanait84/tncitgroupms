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
				<div class="col-lg-12">
					<h3><i class="fa fa-angle-right" style="margin-bottom:50px; "></i> Department Lists
					<a class="btn btn-theme btn-sm" href="{{url('adddepartment')}}">
						<i class="fa fa-plus"></i>
					</a>
				</h3>

					<div class="adv-table">
						<table cellpadding="0" cellspacing="0" border="0" class="display table" id="hidden-table-info">
							<thead>
								<tr>
									<th>Name</th>
									<th>Department</th>
								</tr>
							</thead>
							<tbody>
								@forelse($departments as $department)
								<tr class="gradeA">
									<td>{{$department->d_title}}</td>

									<td>{{$department->d_description}}</td>

								</tr>
								@empty
								@endforelse
							</tbody>
						</table>
					</div>
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
	<script src="lib/common-scripts.js"></script>
	<!--script for this page-->

<script type="text/javascript">
	/* Formating function for row details */
	function fnFormatDetails(oTable, nTr) {
		var aData = oTable.fnGetData(nTr);
		var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">';


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
