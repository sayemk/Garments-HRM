@extends('layouts.master')

@section('title','Leave Type')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'leave_type','parent_menu'=>'leave'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Leave Type </h3>
           
      <div class="box-body">
				{!! $grid !!}
       </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
   </div>  

            
          
          
@endsection
