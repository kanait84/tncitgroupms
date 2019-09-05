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

        <div class="col-lg-8 main-chart">
            <div class="row">
                <div class="col-md-12">
                    <div class="message-p pn">
                        <div class="message-header">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-block">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                            <h5>Report Detail <strong>{{$r_date}}</strong>
                                @if(isset($report[0]->attachment) && $report[0]->attachment != "")
                                     <span style="float: right">
                                       Attachment: <a href="/report_attachment/{{$r_date."-".$u_id.".".$report[0]->file_type}}"
                                       target="_blank" class="btn btn-primary btn-xs text-right">Download</a>
                                    </span>
                                @else
                                    <span style="float: right">No Attachment</span>
                                @endif
                            </h5>
                        </div>

                        <div class="row">
                            <div class="col-md-9">
                                <p class="p-bck" style="white-space: pre-line">
                                    <name>{{$report[0]->description}}</name>
                                </p>
                                <div class="col-md-4 profile-text" style="margin-top: 35px ">
                                    <p>
                                        <a class="btn btn-success btn-xs" href="/approvedreq/{{$r_id.'/'.$n_id}}">
                                            <i class="fa fa-thumbs-up"></i> Approve</a>
                                        <a class="btn btn-danger btn-xs" href="/disapprovedreq/{{$r_id.'/'.$n_id}}">
                                            <i class="fa fa-thumbs-down"></i>Disapprove</a>
                                    </p>
                                </div>
                            </div>
                        </div>

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
  <script src="{{ asset('asset/lib/jquery.sparkline.js') }}"></script>
  <!--common script for all pages-->
  <script src="{{ asset('asset/lib/common-scripts.js') }}"></script>
  <script type="text/javascript" src="{{ asset('asset/lib/gritter/js/jquery.gritter.js') }}"></script>
  <script type="text/javascript" src="{{ asset('asset/lib/gritter-conf.js') }}"></script>
  <footer class="site-footer" style="margin-top: 240px;">
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
