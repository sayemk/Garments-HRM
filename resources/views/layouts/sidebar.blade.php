<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
   
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu"> 
     
      <li class=" @if($parent_menu == 'setting') active @endif treeview">
        <a href="#">
          <i class="fa fa-gear"></i> <span>Settings </span>
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
         
          
     
    </ul>
  </section>
<!-- /.sidebar -->
</aside>