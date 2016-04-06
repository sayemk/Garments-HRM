<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
   
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu"> 

      <li class=" @if($parent_menu == 'setting') active @endif treeview">
        <a href="#">
          <i class="fa fa-gear"></i> <span>Company Basic Settings </span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="  treeview-menu">
          
          <li class="@if($active == 'organization') active @endif">
            <a href="{{ url('organization') }}"><i class="fa fa-circle-o"></i>Organization</a>
          </li>
         
          <li class="@if($active == 'branch') active @endif">
            <a href="{{ url('branch') }}"><i class="fa fa-circle-o"></i>Branch</a>
          </li>
          <li class="@if($active == 'department') active @endif">
            <a href="{{ url('department') }}"><i class="fa fa-circle-o"></i>Department</a>
          </li>
          <li class="@if($active == 'section') active @endif">
            <a href="{{ url('section') }}"><i class="fa fa-circle-o"></i>Section</a>
          </li>
          <li class="@if($active == 'line') active @endif">
            <a href="{{ url('line') }}"><i class="fa fa-circle-o"></i>Line</a>
          </li>
          <li class="@if($active == 'designation') active @endif">
            <a href="{{ url('designation') }}"><i class="fa fa-circle-o"></i>Designation</a>
          </li>
          <li class="@if($active == 'grade') active @endif">
            <a href="{{ url('grade') }}"><i class="fa fa-circle-o"></i>Grade</a>
          </li>
        </ul>
      </li>

      <li class=" @if($active == 'employee') active @endif ">
        <a href="{{ url('employee') }}"><i class="fa fa-user"></i>Employee</a>
      </li>

      <li class=" @if($parent_menu == 'leave') active @endif treeview">
        <a href="#">
          <i class="fa fa-sticky-note"></i> <span>Leaves </span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          
          <li class="@if($active == 'leavetype') active @endif">
            <a href="{{ url('leavetype') }}"><i class="fa fa-circle-o"></i>Leaves Type</a>
          </li>
         
          <li class="@if($active == 'branch') active @endif">
            <a href="{{ url('holiday') }}"><i class="fa fa-circle-o"></i>Holidays</a>
          </li>
          <li class="@if($active == 'leaveemployee') active @endif">
            <a href="{{ url('leaveemployee') }}"><i class="fa fa-circle-o"></i>Employee Leave</a>
          </li>
          <li class="@if($active == 'leaveapplication') active @endif">
            <a href="{{ url('leaveapplication') }}"><i class="fa fa-circle-o"></i>Leave Application</a>
          </li>
        </ul>
      </li>


      <li class=" @if($parent_menu == 'salary') active @endif treeview">
        <a href="#">
          <i class="fa fa-money"></i> <span>Salary </span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="  treeview-menu">

          <li class="@if($active == 'structure') active @endif">
            <a href="{{ url('salary/structure') }}"><i class="fa fa-circle-o"></i>Salary Structures</a>
          </li>
          <li class="@if($active == 'structure') active @endif">
            <a href="{{ url('salary/create') }}"><i class="fa fa-circle-o"></i>Salary Generation</a>
          </li>

        </ul>
      </li>

      <li class=" @if($parent_menu == 'Attendance Setting') active @endif treeview">
        <a href="#">
         <i class="fa fa-user"></i> <span>Attendance </span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="  treeview-menu">
        
          <li class="@if($active == 'attendance') active @endif">
            <a href="{{ url('attendance') }}"><i class="fa fa-circle-o"></i>Manual Attendance</a>
          </li>
          <li class="@if($active == 'upload') active @endif">
            <a href="{{ url('attendance/upload') }}"><i class="fa fa-circle-o"></i>Upload Attendance</a>

          </li>

        </ul>
      </li>

      <li class=" @if($parent_menu == 'Setting') active @endif treeview">

        <a href="#">
          <i class="fa fa-gear"></i> <span>All System Setting</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>

        <ul class="  treeview-menu">
           <li class="@if($active == 'setting') active @endif">
            <a href="{{ url('setting') }}"><i class="fa fa-circle-o"></i>Setting</a>
          </li>
        </ul>

      </li>
   

    </ul>
  </section>
<!-- /.sidebar -->
</aside>