@extends('layouts.master')

@section('title','Salary Structure')
@section('sidebar')
@include('layouts.sidebar',['active' =>'structure','parent_menu'=>'salary'])
@endsection
@section('content')
        <!-- Info boxes -->
<div class="box box-primary">

    <h3 class="box-title padding-left">Salary Structures </h3>
    <div class="box-body">

        {!! $filter !!}
        {!! $grid !!}
    </div>


    <div class="box-footer clearfix">

    </div>
</div>
@endsection


