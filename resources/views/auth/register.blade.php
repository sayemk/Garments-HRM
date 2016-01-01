@extends('layouts.master')

@section('title','Register')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'admin'])

@endsection


@section('page_heading', 'Register')
@section('extra_heading')
    
@endsection
@section('content')
  <!-- Info boxes -->
         
            <div class="box">
              
              <div class="box-body">
                
                <div class="col-sm-12">
                  {!! $edit !!}
                </div>
              </div>
              <div class="box-footer clearfix">
                  
                </div>
            </div>            
            
@endsection