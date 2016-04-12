@extends('layouts.master')

@section('title','Salary Structure')
@section('sidebar')

@include('layouts.sidebar',['active' =>'salary','parent_menu'=>'reports'])

@endsection

@section('content')
        <!-- Info boxes -->

<div class="box box-primary">

    <h3 class="box-title padding-left">Salary Register Report</h3>

    <div class="box-body">

        {!! $filter !!}
    </div>


    <div class="box-footer clearfix">

    </div>
</div>




@endsection
