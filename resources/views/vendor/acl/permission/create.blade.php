
@extends('layouts.master')

@section('title','Role')
@section('sidebar')

@include('layouts.sidebar',['active' =>'permission','parent_menu'=>'admin'])

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

					<div class="panel panel-default fos-acl">
						<div class="panel-heading position-relative">{!! trans('acl::permission.create.create_new_permission'); !!}
							<a href="{{ action('\Aginev\Acl\Http\Controllers\PermissionController@index') }}" class="btn btn-danger btn-sm btn-absolute-right"><span class="glyphicon glyphicon-arrow-left"></span> {!! trans('acl::permission.create.back'); !!}</a>
						</div>
						<div class="panel-body">

							{!! Form::open(['action' => '\Aginev\Acl\Http\Controllers\PermissionController@store', 'method' => 'POST', 'id' => 'role-form']) !!}

							<div class="form-group">
								<label for="controller">{!! trans('acl::permission.create.controller'); !!}</label>
								{!! Form::text('controller', old('controller'), ['class' => 'form-control required', 'id' => 'controller', 'placeholder' => trans('acl::permission.create.controller_placeholder')]) !!}
								{!! $errors->first('controller') !!}
							</div>

							<div class="form-group">
								<label for="method">{!! trans('acl::permission.create.method'); !!}</label>
								{!! Form::text('method', old('method'), ['class' => 'form-control required', 'id' => 'method', 'placeholder' => trans('acl::permission.create.method_placeholder')]) !!}
								{!! $errors->first('method') !!}
							</div>

							<div class="form-group">
								<label for="description">{!! trans('acl::permission.create.description'); !!}</label>
								{!! Form::text('description', old('description'), ['class' => 'form-control', 'id' => 'description', 'placeholder' => trans('acl::permission.create.description_placeholder')]) !!}
								{!! $errors->first('description') !!}
							</div>
							
							<button type="submit" class="btn btn-success">{!! trans('acl::permission.create.create'); !!}</button>

							{!! Form::close() !!}

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