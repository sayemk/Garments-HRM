@extends('layouts.master')

@section('title','Section')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'section','parent_menu'=>'setting'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Section </h3>
   
      <div class="box-body">
          {!! $filter !!}
         	{!! $grid !!}
      </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
  </div>  

    
            
          
          
@endsection
