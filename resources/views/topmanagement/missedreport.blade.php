<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<link rel="stylesheet" type="text/css" href="{{ asset('asset/lib/bootstrap-fileupload/bootstrap-fileupload.css') }}" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<link href="asset/lib/advanced-datatable/css/demo_page.css" rel="stylesheet" />
<link href="asset/lib/advanced-datatable/css/demo_table.css" rel="stylesheet" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />
<link rel="stylesheet" href="asset/lib/advanced-datatable/css/DT_bootstrap.css" />
<style>
    #zabuto_calendar_{{$seldate}} { background: #fff; }
    div#zabuto_calendar_{{$seldate}}_day { color:#000!important; }
</style>
<body>
  <section id="container">
    @include('layout.dashboard')
    @include('layout.sidenav')
<section id="main-content">
<section class="wrapper">
    <?php
    $getweek = isset($_GET['dweek']) && ($_GET['dweek']!='') ? 'Last 7 Days' : '';
    $getmonth = isset($_GET['lmonth']) && ($_GET['lmonth']!='') ? 'Last 30 Days' : '';
    $getlday = isset($_GET['d']) && ($_GET['d']!='') ? 'Last Day' : ''; ?>
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
        <h3> <i class="fa fa-angle-right"></i> Missed Reports - {{$getlday.$getweek.$getmonth}}</h3>
  <div class="row">
    <div class="col-lg-12">
        <p>&nbsp;</p>
    <div class="adv-table">
        <table class="display table table-bordered" @if(count($listusers)>0) id="hidden-table-info" @endif>
            <thead>
            <tr>
                <th width="20%">Name</th>
                <th width="15%">Email</th>
                <th width="20%">Department</th>
                <th width="20%">SubDepartment</th>
                @if($getweek!='' || $getmonth!='')
                    <th width="10%">Days</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @forelse($listusers as $user)
                @if($user->missdates>0 && isset($_GET['dweek']))
                        <tr>
                            <td>{{isset($user->name) ? $user->name : ''}}</td>
                            <td>{{isset($user->email) ? $user->email : ''}}</td>
                            <td>{{isset($user->department->d_title) ? $user->department->d_title : ''}}</td>
                            <td>{{isset($user->subdepartment->sd_title) ? $user->subdepartment->sd_title : ''}}</td>
                            @if($getweek!='')
                                <td align="center"><a href="listmissreports/{{$user->id."/".$lweek}}">
                                        @if($user->missdates>0)
                                        {{$user->missdates}}
                                            @else
                                        {{0}}
                                        @endif
                                    </a></td>
                            @endif
                        </tr>
                    @elseif(isset($_GET['d']))
                    <tr>
                        <td>{{isset($user->name) ? $user->name : ''}}</td>
                        <td>{{isset($user->email) ? $user->email : ''}}</td>
                        <td>{{isset($user->department->d_title) ? $user->department->d_title : ''}}</td>
                        <td>{{isset($user->subdepartment->sd_title) ? $user->subdepartment->sd_title : ''}}</td>
                    </tr>
                @endif
            @empty
                <tr class="gradeX">
                    @if($getweek!='')
                        <td colspan="5">No Records found</td>
                        @else
                        <td colspan="4">No Records found</td>
                    @endif
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    </div>
  </div>
</section>
</section>
  <footer class="site-footer" style="margin-top: 325px;">
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
<script src="{{ asset('asset/lib/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('asset/lib/bootstrap/js/bootstrap.min.js') }}"></script>
<script class="include" type="text/javascript" src="{{ asset('asset/lib/jquery.dcjqaccordion.2.7.js') }}"></script>
<script src="{{ asset('asset/lib/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('asset/lib/jquery.nicescroll.js') }}" type="text/javascript"></script>
<script src="{{ asset('asset/lib/jquery.sparkline.js') }}"></script>
<!--common script for all pages-->
<script src="{{ asset('asset/lib/common-scripts.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/gritter/js/jquery.gritter.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/gritter-conf.js') }}"></script>
<!--script for this page-->
<script src="{{ asset('asset/lib/sparkline-chart.js') }}"></script>
<script src="{{ asset('asset/lib/zabuto_calendar.js') }}"></script>

<script type="text/javascript" language="javascript" src="{{ asset('asset/lib/advanced-datatable/js/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('asset/lib/advanced-datatable/js/DT_bootstrap.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
       $('#hidden-table-info').dataTable();
  });
</script>
  <!--script for this page-->
  <script src="{{ asset('asset/lib/zabuto_calendar.js') }}"></script>
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
                  return myDateFunction(this.id, true);
              },
              action_nav: function() {
                  return myNavFunction(this.id);
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
      function myDateFunction(date) {
          myString = date.substring(date.length - 10);
          window.location.href = '/home?d='+myString;
          console.log('Triggered',myString)
      }
</script>

</body>
</html>
