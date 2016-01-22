@extends('layouts.master')

@section('title','Employee')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'employee','parent_menu'=>''])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Employee </h3>
   
      <div class="box-body">
          {!! $filter !!}
         	{!! $grid !!}
      </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
  </div>  

    
            
          
          
@endsection
