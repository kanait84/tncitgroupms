  <aside>
    <div id="sidebar" class="nav-collapse ">
      <ul class="sidebar-menu" id="nav-accordion">
        <h5 class="centered">{{Auth::user()->name}}</h5>


        @if(Auth::user()->type === 'topmanagement')

        <li class="mt">
          <a href="/topmanagement">
            <i class="fa fa-dashboard"></i>
            <span>Dashboard</span>
          </a>
        </li>

        <li class="sub-menu">
          <a href="/itdepartment">
            <i class="fa fa-code"></i>
            <span>IT Department</span>
          </a>
        </li>

        <li class="sub-menu">
          <a href="/marketing">
            <i class="fa fa-bullhorn"></i>
            <span>Marketing</span>
          </a>
        </li>

        <li class="sub-menu">
          <a href="#">
            <i class="fa fa-archive"></i>
            <span>Administrative</span>
          </a>
        </li>

        <li class="sub-menu">
          <a href="#">
            <i class="fa fa-bar-chart-o"></i>
            <span>Accounting</span>
          </a>
        </li>

        <li class="sub-menu">
         <a href="/management">
          <i class="fa fa-bookmark"></i>
          <span>Management</span>
        </a>
      </li>

      @elseif(Auth::user()->type === 'employee')

      <li class="mt">
        <a href="/home">
          <i class="fa fa-dashboard"></i>
          <span>Dashboard</span>
        </a>
      </li>


      @elseif(Auth::user()->type === 'management')

      <li class="mt">
        <a href="/management">
          <i class="fa fa-dashboard"></i>
          <span>Dashboard</span>
        </a>
      </li>


     <li class="sub-menu">
         <a href="/home">
          <i class="fa fa-bookmark"></i>
          <span>My Report</span>
        </a>
      </li>

      @endif
    </ul>
  </div>
</aside>
