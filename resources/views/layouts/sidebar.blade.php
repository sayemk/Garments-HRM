<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
   
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu"> 
     
      <li class=" @if($active == 'admin') active @endif treeview">
        <a href="#">
          <i class="fa fa-gear"></i> <span>Settings </span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="  treeview-menu">
          
          <li><a href="{{ url('organization') }}"><i class="fa fa-circle-o"></i>Organization</a></li>
         
          <li><a href="{{ url('branch') }}"><i class="fa fa-circle-o"></i>Branch</a></li>
          <li><a href="{{ url('department') }}"><i class="fa fa-circle-o"></i>Department</a></li>
          <li><a href="{{ url('section') }}"><i class="fa fa-circle-o"></i>Section</a></li>
          <li><a href="{{ url('line') }}"><i class="fa fa-circle-o"></i>Line</a></li>
          <li><a href="{{ url('designation') }}"><i class="fa fa-circle-o"></i>designation</a></li>
        </ul>
      </li>

      <li class=" @if($active == 'employee') active @endif ">
        <a href="{{ url('employee') }}"><i class="fa fa-user"></i>Employee</a>
      </li> 
         
          
     
    </ul>
  </section>
<!-- /.sidebar -->
</aside>