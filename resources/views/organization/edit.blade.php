@extends('layouts.master')

@section('title','Organization')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'organization'])

@endsection


@section('page_heading', 'Organization')
@section('extra_heading')
	
@endsection
@section('content')
  <!-- Info boxes -->
         
            <div class="box">
              
              <div class="box-body">
                
                <div class="col-md-12">
				
					{!! $edit !!}
					
				</div>
			<div class="box-footer clearfix">
		                  
                </div>
            </div>            
          
          
@endsection
