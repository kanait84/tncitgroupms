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
            <div class="col-lg-8">
                <h3><i class="fa fa-angle-right" style="margin-bottom:30px;"></i> Add Employee</h3>
                <div class="adv-table">
                    <div class="card">
                        <div class="card-body" style="padding:30px;">
                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
                                    <div class="col-md-6">
                                        <select id="type" type="text" class="form-control @error('type') is-invalid @enderror"
                                                name="type" value="{{ old('type') }}" required autocomplete="type" autofocus>
                                            <option> Select Account Type</option>
                                            <option value="admin">Administrator</option>
                                            <option value="topmanagement">Top Management</option>
                                            <option value="management">Management</option>
                                            <option value="submanagement">Sub Management</option>
                                            <option value="employee">Employee</option>
                                        </select>


                                        @error('type')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="department" class="col-md-4 col-form-label text-md-right">{{ __('Department') }}</label>

                                    <div class="col-md-6">
                                        <select id="d_id" type="text" class="form-control @error('department') is-invalid @enderror" name="d_id" value="{{ old('d_id') }}" required autocomplete="d_id" autofocus>
                                            <option disabled=""> Select Department</option>

                                            @forelse($departments as $department)
                                                <option value="{{$department->d_id}}">{{$department->d_title}}</option>
                                            @empty
                                            @endforelse

                                        </select>


                                        @error('department')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="subdepartment" class="col-md-4 col-form-label text-md-right">{{ __('Sub Department') }}</label>

                                    <div class="col-md-6">
                                        <select id="sd_id" type="text" class="form-control @error('subdepartment') is-invalid @enderror" name="sd_id" value="{{ old('sd_id') }}" required autocomplete="sd_id" autofocus>
                                            <option > Select Sub Department</option>


                                            @forelse($subdepartments as $subdepartment)
                                                <option value="{{$subdepartment->sd_id}}">{{$subdepartment->sd_title}}</option>
                                            @empty
                                            @endforelse

                                        </select>


                                        @error('sub_department')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="form-group row">
                                    <label for="position" class="col-md-4 col-form-label text-md-right">{{ __('Position') }}</label>

                                    <div class="col-md-6">
                                        <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" required autocomplete="position">

                                        @error('position')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="mobile" class="col-md-4 col-form-label text-md-right">{{ __('Mobile No.') }}</label>

                                    <div class="col-md-6">
                                        <input id="mobile" type="number" class="form-control @error('position') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile">

                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="emp_photo" class="col-md-4 col-form-label text-md-right">{{ __('Photo') }}</label>

                                    <div class="col-md-6">
                                        <input id="emp_photo" type="file" class="form-control @error('emp_photo') is-invalid @enderror" name="emp_photo" autocomplete="emp_photo">

                                        @error('emp_photo')
                                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Register') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </section>

    <footer class="site-footer">
        <div class="text-center">
            <p>
                &copy; Copyrights <strong>TNC IT Group Management System </strong>. All Rights Reserved
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
