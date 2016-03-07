@extends('layouts.master')

@section('title','Leave Application')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'leaveapplication','parent_menu'=>'leave'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Leave Application </h3>
           
      <div class="box-body">

          {!! $filter !!}
          {!! $grid !!}
       </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
   </div>  

            
          
          
@endsection
