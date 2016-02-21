@extends('layouts.master')

@section('title','Leave Allocation')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'leaveemployee','parent_menu'=>'leave'])

@endsection

@section('content')
  <!-- Info boxes -->
         <ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        <a href="index-2.html">Home</a>
        <i class="icon-angle-right"></i>
    </li>
    <li><a href="#">Dashboard</a></li>
</ul>
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Leave Allocation</h3>
           
      <div class="box-body">
				{!! $filter !!}
        {!! $grid !!}
       </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
   </div>  

            
          
          
@endsection
