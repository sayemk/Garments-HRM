<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
           <section class="sidebar">
          
          
         
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Admin Panel</li>
                
            
            <li class=" @if($active == 'category') active @endif ">
              <a href="{{ url('category') }}"><i class="fa fa-list"></i>Categories</a>
            </li>  
           
            <li class=" @if($active == 'product') active @endif treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Products </span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="  treeview-menu">
                @if(checkPermission('App\Http\Controllers\ProductController@create'))
                  <li><a href="{{ url('product/create') }}"><i class="fa fa-circle-o"></i> Create New</a></li>
                @endif
                <li><a href="{{ url('product') }}"><i class="fa fa-circle-o"></i>View All</a></li>
              </ul>
            </li>
            <li class=" @if($active == 'faq') active @endif treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>FAQ </span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="  treeview-menu">
                @if(checkPermission('App\Http\Controllers\FaqController@create'))
                  <li><a href="{{ url('faq/create') }}"><i class="fa fa-circle-o"></i> Create New</a></li>
                 @endif  
                <li><a href="{{ url('faq') }}"><i class="fa fa-circle-o"></i>View All</a></li>
              </ul>
            </li>
            <li class=" @if($active == 'task') active @endif treeview">
              <a href="#">
                <i class="fa fa-share"></i> <span>Task </span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="  treeview-menu">
                <li><a href="{{ url('task/edit') }}"><i class="fa fa-circle-o"></i> Create New</a></li>
                
                <li><a href="{{ url('task') }}"><i class="fa fa-circle-o"></i>View All</a></li>
              </ul>
            </li>

            <li class=" @if($active == 'user') active @endif">
              <a href="#" data-toggle="modal" data-target=".bs-example-modal-sm">
                <i class="fa fa-share"></i> <span>Orders </span>
              </a>
            </li>
            @if(checkPermission('App\Http\Controllers\UserController@anyEdit'))
              <li class=" @if($active == 'admin') active @endif treeview">
                <a href="#">
                  <i class="fa fa-share"></i> <span>Admin </span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="  treeview-menu">
                  <li><a href="{{ url('user') }}"><i class="fa fa-circle-o"></i>Users</a></li>
                  
                  <li><a href="{{ url('admin/role') }}"><i class="fa fa-circle-o"></i>Roles</a></li>
                  <li><a href="{{ url('admin/permission') }}"><i class="fa fa-circle-o"></i>Permissions</a></li>
                </ul>
              </li>
            @endif
            
          </ul>
        </section>
      <!-- /.sidebar -->
    </aside>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm modal-primary">
    <div class="modal-content">
    {!! Form::open(array('url' => 'order/get', 'method' => 'GET', 'class' =>'form-inline')) !!}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Get Order Info from Magento</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="order">Order ID</label>
          <input type="text" name="order" class="form-control" id="order" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-outline">Save changes</button>
      </div>
    {!! Form::close() !!}
    </div>
  </div>
</div>