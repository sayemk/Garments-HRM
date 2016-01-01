@extends('layouts.master')

@section('title','Users')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'admin'])

@endsection


@section('page_heading', 'Users')
@section('extra_heading')
	
@endsection
@section('content')
  <!-- Info boxes -->
         
            <div class="box">
              
              <div class="box-body">
                
                {!! $filter !!}
                {!! $grid !!}

              </div>
              <div class="box-footer clearfix">
                  
                </div>
            </div>            
        
@endsection