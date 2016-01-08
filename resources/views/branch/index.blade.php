@extends('layouts.master')

@section('title','Branch')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'branch','parent_menu'=>'setting'])

@endsection

@section('content')
  <!-- Info boxes -->
         
        	<div class="box box-primary">
            
              <h3 class="box-title padding-left">Branch </h3>
           
              <div class="box-body">
				{!! $grid !!}
              </div>
                
                
			<div class="box-footer clearfix">
		                  
                </div>
            </div>  

        </div>
            
          
          
@endsection
