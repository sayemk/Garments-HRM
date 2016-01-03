@extends('layouts.master')

@section('title','Permission')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'admin'])

@endsection


@section('page_heading', 'Permission')
@section('extra_heading')
	
@endsection
@section('content')
  <!-- Info boxes -->
         
            <div class="box">
              
              <div class="box-body">
                
                <div class="col-md-12">
					@include('acl::alert')
					@include('acl::confirm')
					<div class="panel panel-default fos-acl">
						<div class="panel-heading position-relative">{!! trans('acl::permission.index.permissions'); !!}
							<a href="{{ action('\Aginev\Acl\Http\Controllers\PermissionController@create') }}" class="btn btn-success btn-sm btn-absolute-right">
								<span class="glyphicon glyphicon-plus"></span> {!! trans('acl::permission.index.add_new_permission'); !!}
							</a>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th class="permission-controller">{!! trans('acl::permission.index.controller_method'); !!}</th>
										<th class="permission-description">{!! trans('acl::permission.index.description'); !!}</th>
										<th class="permission-action">{!! trans('acl::permission.index.action'); !!}</th>
									</tr>
								</thead>
								<tbody>
									@forelse($permissions as $permission)
										<tr>
											<td class="permission-controller">{{ $permission->controller . '@' . $permission->method }}</td>
											<td class="permission-description">{{ $permission->description }}</td>
											<td class="permission-action">
												<a href="{{ action('\Aginev\Acl\Http\Controllers\PermissionController@edit', $permission->id) }}" title="{!! trans('acl::permission.index.edit'); !!}" class="btn btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
												<a href="{{ action('\Aginev\Acl\Http\Controllers\PermissionController@destroy', $permission->id) }}" title="{!! trans('acl::permission.index.delete'); !!}" data-method="DELETE" class="btn btn-xs text-danger" data-confirm="{!! trans('acl::permission.index.delete_confirm'); !!}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="3">{!! trans('acl::permission.index.no_permissions'); !!}</td>
										</tr>
									@endforelse
								</tbody>
							</table>

							<div class="text-center">
								<?php echo $permissions->render(); ?>
							</div>
						</div>
					</div>
				</div>
              </div>
              <div class="box-footer clearfix">
                  
                </div>
            </div>            
          
          
@endsection
@section('script')
	<script src="{{ asset('/vendor/acl/js/script.js') }}"></script>
	<script src="{{ asset('/vendor/acl/js/restful.js') }}"></script>
@endsection