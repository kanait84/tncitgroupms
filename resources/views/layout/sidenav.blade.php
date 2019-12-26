<aside>
    <div id="sidebar" class="nav-collapse ">
        <ul class="sidebar-menu" id="nav-accordion">
            <h5 class="centered">{{Auth::user()->name}}</h5>
            <?php
            $missrepactive = '';
            if(isset($filterdate) && $filterdate!=''){ $missrepactive= 'active'; }
            if(request()->is('listmissreports')){ $missrepactive= 'active'; }
            ?>

            @if(Auth::user()->type === 'topmanagement')
                <li class="mt">
                    <a href="{{ url('topmanagement') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Departments</span>
                    </a>
                </li>

                <li class="sub-menu dcjq-parent-li">
                    <a href="javascript:;"  class="dcjq-parent {{$missrepactive}}">
                        <i class="fa fa-list"></i>
                        <span>Missed Report</span>
                        <span class="dcjq-icon"></span></a>
                    <ul class="sub" style="display: block;">
                        <?php
                        $d = isset($yesterday) ? $yesterday : date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")-1,date("Y")));
                        $lweek = isset($lweek) ? $lweek : date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")-7,date("Y")));
                        ?>
                        <li <?php if(isset($_GET['d']) && $_GET['d']!=''){ echo 'class="active"'; } ?>><a href="{{ url('missedreport')."?d=".$d }}">Last Day</a></li>
                        <li <?php if(isset($_GET['dweek']) && $_GET['dweek']!=''){ echo 'class="active"'; } ?>><a href="{{ url('missedreport')."?dweek=".$lweek }}">Last 7 Days</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('alltopmtotrequests') }}">
                        <i class="fa fa-list"></i>
                        <span>OverTime</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('printfilterreport') }}">
                        <i class="fa fa-list"></i>
                        <span>Print Report</span>
                    </a>
                </li>

            @elseif(Auth::user()->type === 'employee')

                <li class="mt">
                    <a href="{{ url('home') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('otrequests') }}">
                        <i class="fa fa-list"></i>
                        <span>OverTime</span>
                    </a>
                </li>

            @elseif(Auth::user()->type === 'management')

                <li class="mt">
                    <a href="{{ url('management') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('home') }}">
                        <i class="fa fa-list"></i>
                        <span>My Report</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('otmgmtrequests') }}">
                        <i class="fa fa-list"></i>
                        <span>OverTime</span>
                    </a>
                </li>

                <li class="sub-menu dcjq-parent-li">
                    <a href="javascript:;"  class="dcjq-parent {{$missrepactive}}">
                        <i class="fa fa-list"></i>
                        <span>Missed Report</span>
                        <span class="dcjq-icon"></span></a>
                    <ul class="sub" style="display: block;">
                        <?php
                        $d = isset($yesterday) ? $yesterday : date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")-1,date("Y")));
                        $lweek = isset($lweek) ? $lweek : date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")-7,date("Y")));
                        ?>
                        <li <?php if(isset($_GET['d']) && $_GET['d']!=''){ echo 'class="active"'; } ?>><a href="{{ url('missedreport')."?d=".$d }}">Last Day</a></li>
                        <li <?php if(isset($_GET['dweek']) && $_GET['dweek']!=''){ echo 'class="active"'; } ?>><a href="{{ url('missedreport')."?dweek=".$lweek }}">Last 7 Days</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('downloadcsv') }}">
                        <i class="fa fa-download"></i>
                        <span>Export CSV</span>
                    </a>
                </li>


            @elseif(Auth::user()->type === 'submanagement')

                <li class="mt">
                    <a href="{{ url('submanagement') }}">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('home') }}">
                        <i class="fa fa-list"></i>
                        <span>My Report</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('otsubmgmtrequests') }}">
                        <i class="fa fa-list"></i>
                        <span>OverTime</span>
                    </a>
                </li>

                <li class="sub-menu dcjq-parent-li">
                    <a href="javascript:;"  class="dcjq-parent {{$missrepactive}}">
                        <i class="fa fa-list"></i>
                        <span>Missed Report</span>
                        <span class="dcjq-icon"></span></a>
                    <ul class="sub" style="display: block;">
                        <?php
                        $d = isset($yesterday) ? $yesterday : date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")-1,date("Y")));
                        $lweek = isset($lweek) ? $lweek : date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")-7,date("Y")));
                        ?>
                        <li <?php if(isset($_GET['d']) && $_GET['d']!=''){ echo 'class="active"'; } ?>><a href="{{ url('missedreport')."?d=".$d }}">Last Day</a></li>
                        <li <?php if(isset($_GET['dweek']) && $_GET['dweek']!=''){ echo 'class="active"'; } ?>><a href="{{ url('missedreport')."?dweek=".$lweek }}">Last 7 Days</a></li>
                    </ul>
                </li>

            @elseif(Auth::user()->type === 'admin')

                <li class="mt">
                    <a href="{{ url('admin') }}">
                        <i class="fa fa-users"></i>
                        <span>Employee</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('/register') }}">
                        <i class="fa fa-plus-square-o"></i>
                        <span>Add Employee</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('/department') }}">
                        <i class="fa fa-building-o"></i>
                        <span>Departments</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('/subdepartment') }}">
                        <i class="fa fa-building-o"></i>
                        <span>Sub-Departments</span>
                    </a>
                </li>


                <li class="sub-menu">
                    <a href="{{ url('allreports') }}">
                        <i class="fa fa-gears"></i>
                        <span>All Reports</span>
                    </a>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('/submitnewreport') }}">
                        <i class="fa fa-plus-square-o"></i>
                        <span>Add Report</span>
                    </a>
                </li>

                <li class="sub-menu dcjq-parent-li">
                    <a href="javascript:;"  class="dcjq-parent {{$missrepactive}}">
                        <i class="fa fa-list"></i>
                        <span>Missed Report</span>
                        <span class="dcjq-icon"></span></a>
                    <ul class="sub" style="display: block;">
                        <?php
                        $d = isset($yesterday) ? $yesterday : date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")-1,date("Y")));
                        $lweek = isset($lweek) ? $lweek : date("Y-m-d", mktime(0, 0, 0, date("m") , date("d")-7,date("Y")));
                        ?>
                        <li <?php if(isset($_GET['d']) && $_GET['d']!=''){ echo 'class="active"'; } ?>><a href="{{ url('missedreport')."?d=".$d }}">Last Day</a></li>
                        <li <?php if(isset($_GET['dweek']) && $_GET['dweek']!=''){ echo 'class="active"'; } ?>><a href="{{ url('missedreport')."?dweek=".$lweek }}">Last 7 Days</a></li>
                    </ul>
                </li>

                <li class="sub-menu">
                    <a href="{{ url('alltopmtotrequests') }}">
                        <i class="fa fa-list"></i>
                        <span>OverTime</span>
                    </a>
                </li>

            @endif

            <li class="sub-menu">
                <a href="{{ url('password/reset') }}">
                    <i class="fa fa-gears"></i>
                    <span>Change Password</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="{{ url('profile/update') }}">
                    <i class="fa fa-user"></i>
                    <span>Update Profile</span>
                </a>
            </li>

        </ul>
    </div>
</aside>
