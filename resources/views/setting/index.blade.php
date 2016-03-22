@extends('layouts.master')

@section('title','setting')
@section('sidebar')

   @include('layouts.sidebar',['active' =>'setting','parent_menu'=>'Setting'])

@endsection

@section('content')
  <!-- Info boxes -->
         
  <div class="box box-primary">
            
      <h3 class="box-title padding-left">settings</h3>
   
      <div class="box-body">
         	{!! $grid !!}
      </div>

			<div class="box-footer clearfix">

      </div>
  </div> 
           
@endsection
