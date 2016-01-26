@extends('layouts.master')

@section('title','Holidays')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'holiday','parent_menu'=>'leave'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">Holidays </h3>
           
      <div class="box-body">
				{!! $filter !!}
        {!! $grid !!}
       </div>
                
                
			<div class="box-footer clearfix">
		                  
      </div>
   </div>  

            
          
          
@endsection
