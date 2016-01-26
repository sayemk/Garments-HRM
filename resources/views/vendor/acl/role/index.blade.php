@extends('layouts.master')

@section('title','Role')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'admin','parent_menu'=>''])

@endsection


@section('page_heading', 'Role')
@section('extra_heading')
	
@endsection
@section('content')
  <!-- Info boxes -->
         
            <div class="box">
              
              <div class="box-body">
                
                <div class="col-md-12">

					@include('acl::alert')

					<div class="panel panel-default fos-acl">
						<div class="panel-heading position-relative">{!! trans('acl::role.index.roles'); !!}
							<a href="{{ action('\Aginev\Acl\Http\Controllers\RoleController@create') }}" class="btn btn-success btn-sm btn-absolute-right">
								<span class="glyphicon glyphicon-plus"></span> {!! trans('acl::role.index.add_new_role'); !!}
							</a>
						</div>
						<div class="panel-body">
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th class="role-title">{!! trans('acl::role.index.role'); !!}</th>
										<th class="role-description">{!! trans('acl::role.index.description'); !!}</th>
										<th class="role-action">{!! trans('acl::role.index.action'); !!}</th>
									</tr>
								</thead>
								<tbody>
									@forelse($roles as $role)
										<tr>
											<td class="role-title">{{ $role->role_title }}</td>
											<td class="role-description">{{ $role->role_description }}</td>
											<td class="role-action">
												<a href="{{ action('\Aginev\Acl\Http\Controllers\RoleController@edit', $role->id) }}" title="{!! trans('acl::role.index.edit'); !!}" class="btn btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
												@if ($role->id != 2)
												<a href="{{ action('\Aginev\Acl\Http\Controllers\RoleController@destroy', $role->id) }}" title="{!! trans('acl::role.index.delete'); !!}" data-method="DELETE" class="btn btn-xs text-danger" data-confirm="{!! trans('acl::role.index.delete_confirm'); !!}"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>
												@endif
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="3" class="no-results">{!! trans('acl::role.index.no_roles'); !!}</td>
										</tr>
									@endforelse
								</tbody>
							</table>

							<div class="text-center">
								<?php echo $roles->render(); ?>
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