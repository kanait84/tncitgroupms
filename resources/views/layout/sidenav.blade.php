  <aside>
    <div id="sidebar" class="nav-collapse ">
      <ul class="sidebar-menu" id="nav-accordion">
        <h5 class="centered">{{Auth::user()->name}}</h5>


        @if(Auth::user()->type === 'topmanagement')

        <li class="mt">
          <a href="{{ url('topmanagement') }}">
            <i class="fa fa-dashboard"></i>
            <span>Departments</span>
          </a>
        </li>

        @elseif(Auth::user()->type === 'employee')

        <li class="mt">
          <a href="{{ url('home') }}">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
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
          <i class="fa fa-bookmark"></i>
          <span>My Report</span>
        </a>
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


@endif
<li class="sub-menu">
 <a href="{{ url('password/reset') }}">
  <i class="fa fa-gears"></i>
  <span>Change Password</span>
</a>
</li>
</ul>
</div>
</aside>
