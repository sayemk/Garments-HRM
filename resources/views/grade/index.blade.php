@extends('layouts.master')

@section('title','Grade')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'Grade','parent_menu'=>'setting'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Grade </h3>
   
      <div class="box-body">
         
         	{!! $grid !!}
      </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
  </div>  

    
            
          
          
@endsection