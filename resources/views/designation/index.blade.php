@extends('layouts.master')

@section('title','designation')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'designation','parent_menu'=>'setting'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Designation</h3>
   
      <div class="box-body">
         	{!! $grid !!}
      </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
  </div>          
@endsection
