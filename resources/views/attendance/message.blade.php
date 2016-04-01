@extends('layouts.master')

@section('title','attendance')
@section('sidebar')

@include('layouts.sidebar',['active' =>'upload','parent_menu'=>'Attendance Setting'])

@endsection

@section('content')
        <!-- Info boxes -->

<div class="box box-primary">

    <h3 class="box-title padding-left">Attendance Upload Results</h3>

    <div class="box-body">
        @foreach($results as $key=>$result)
            <p>{{ $key }} &nbsp; &nbsp; &nbsp;<span class="{{ spanClass($result) }}">{{ uploadMessage($result) }}</span></p>
        @endforeach
    </div>


    <div class="box-footer clearfix">

    </div>
</div>
@endsection
