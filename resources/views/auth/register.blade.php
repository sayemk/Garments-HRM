@extends('layouts.master')

@section('title','User Registration')
@section('sidebar')

@include('layouts.sidebar',['active' =>'user','parent_menu'=>'admin'])

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