@extends('layouts.master')

@section('title','Attendance Upload')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'attendance','parent_menu'=>'Attendance Setting'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Attendance Upload</h3>
   
      <div class="box-body">
         {!! Form::open(array('url' => 'attendance/store', 'class'=>'form-horizontal','files'=>true)) !!}
            {!! Form::file('image') !!}
            {!! Form::submit('Upload',['class'=>'btn btn-primary']) !!}
         {!! Form::close() !!}
      </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
  </div>          
@endsection
