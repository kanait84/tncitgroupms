<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<header class="header black-bg">
  <div class="sidebar-toggle-box">
    <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
  </div>
  <a href="/" class="logo"><b>TNCITGROUP-<span>MS</span></b></a>
    <div class="nav notify-row" id="top_menu">
    <ul class="nav top-menu">
        <li id="header_notification_bar" class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-bell-o"></i>
                @if(auth()->user()->unreadnotifications->count())
                <span class="badge bg-warning">
                    {{auth()->user()->unreadnotifications->count()}}</span>
                @endif
            </a>

            <ul class="dropdown-menu extended notification">
                <div class="notify-arrow notify-arrow-yellow"></div>
                <li>
                    <p class="yellow">You have {{auth()->user()->unreadnotifications->count()}} new notifications</p>
                </li>

                <li><a href="{{route('markRead')}}" style="color: green">Mark all as Read</a> </li>

                @foreach(auth()->user()->unreadNotifications as $notification)
                    @if($notification->type=="App\Notifications\RejectRequest")
                        <li style="background-color: lightgrey">
                            <a href="{{ url("approvalreject/".$notification->id)}}">
                                <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                            </a></li>
                    @elseif($notification->type=="App\Notifications\ReportComment")

                        @if(auth()->user()->type == 'employee')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("empreportcmt/".$notification->id."/".$notification->data['reportdate'])}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                            @elseif(auth()->user()->type == 'management')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("mgreportcmt/".$notification->id."/".$notification->data['u_id']."/".$notification->data['reportdate'])}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif
                    @elseif($notification->type=="App\Notifications\EditRequest")
                        @if(auth()->user()->type == 'management')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("mgrapprovaledit/".$notification->id."/".$notification->data['u_id']."/".$notification->data['r_id']."/".$notification->data['reportdate'])}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif
                    @elseif($notification->type=="App\Notifications\ApproveRequest")
                        @if(auth()->user()->type == 'employee')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("mgrapprovaledit/".$notification->id."/".$notification->data['u_id']."/".$notification->data['r_id']."/".$notification->data['reportdate'])}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @elseif($notification->type=="App\Notifications\OverTimeRequest")
                        @if(auth()->user()->type == 'management')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("mgrotapproval/".$notification->id."/".$notification->data['u_id']."/".$notification->data['reportdate']."/".$notification->data['mgr_id']."/".$notification->data['report_uid'])}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @elseif($notification->type=="App\Notifications\OtAfterMgrApprove")
                        @if(auth()->user()->type == 'topmanagement')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("topmgmtapproval/".$notification->id."/".$notification->data['u_id']."/".$notification->data['otdate'])}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @elseif($notification->type=="App\Notifications\OtAfterTopMgtApprove")
                        @if(auth()->user()->type == 'employee')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("otapproved/".$notification->id)}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @elseif($notification->type=="App\Notifications\OtAfterMgrDisApprove")
                        @if(auth()->user()->type == 'employee')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("otrejected/".$notification->id)}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @elseif($notification->type=="App\Notifications\OtAfterTopMgtDisApprove")
                        @if(auth()->user()->type == 'topmanagement')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("otrejected/".$notification->id)}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @elseif($notification->type=="App\Notifications\OtHRRequest")
                        @if(auth()->user()->type == 'employee')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("otempRequest/".$notification->id."/".$notification->data['u_id']."/".$notification->data['otdate']."/".$notification->data['report_uid'])}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @elseif($notification->type=="App\Notifications\OtHRApprove")
                        @if(auth()->user()->type == 'employee')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("otHRApproved/".$notification->id)}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @elseif($notification->type=="App\Notifications\OtHRReject")
                        @if(auth()->user()->type == 'employee')
                            <li style="background-color: lightgrey">
                                <a href="{{ url("otHRDisapproved/".$notification->id)}}">
                                    <span class="label label-danger"><i class="fa fa-bolt"></i></span>
                                    <span style="white-space: pre-line">{{$notification->data['data']}}</span>
                                </a></li>
                        @endif

                    @endif

                @endforeach
        </ul>
    </li>
    </ul>
    </div>
        <div class="top-menu">
            <ul class="nav pull-right top-menu">
                <li><a class="logout" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
        document.getElementById('logout-form').submit();">Logout</a></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </ul>
        </div>


  </header>
