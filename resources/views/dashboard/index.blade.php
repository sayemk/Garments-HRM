@extends('layouts.master')

@section('title','Department')
@section('sidebar')

@include('layouts.sidebar',['active' =>'dashboard','parent_menu'=>'dashboard'])

@endsection

@section('content')
    <div class="row">
        <div class="col-md-2">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Present</span>
                    <span class="info-box-number">{{ $employeePresents }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
        <div class="col-md-2"><div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Absent</span>
                    <span class="info-box-number">{{ $totalActiveEmployees - $employeePresents }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box --></div>
        <div class="col-md-2">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-green-active"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Active</span>
                    <span class="info-box-number">{{ $totalActiveEmployees }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
        <div class="col-md-2">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Resigned</span>
                    <span class="info-box-number">{{ $totalResignedEmployees }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->

        </div>
        <div class="col-md-2">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-yellow-active"><i class="fa fa-calendar"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Holidays(Y)</span>
                    <span class="info-box-number">{{ $totalHolidays }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->

        </div>
        <div class="col-md-2">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-yellow-active"><i class="fa fa-calendar-plus-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Holidays(m)</span>
                    <span class="info-box-number">{{ $totalHolidayInMonth }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->

        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-sm-4">
            <div class="box box-primary">

                <h3 class="box-title padding-left">Staff by Status </h3>

                <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Permanent</th>
                            <th>{{ $permanentStaffs }}</th>
                        </tr>
                        <tr>
                            <th>New</th>
                            <th>{{ $newStaffs }}</th>
                        </tr>
                        <tr>
                            <th>Resigned</th>
                            <th>{{ $resignedStaffs }}</th>
                        </tr>
                        <tr>
                            <th>Total Active Staff</th>
                            <th> {{ $permanentStaffs+$newStaffs }}</th>
                        </tr>
                    </table>
                </div>


                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="box box-primary">

                <h3 class="box-title padding-left">Worker by Status </h3>

                <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Permanent</th>
                            <th>{{ $permanentWorkers }}</th>
                        </tr>
                        <tr>
                            <th>New</th>
                            <th>{{ $newWorkers }}</th>
                        </tr>
                        <tr>
                            <th>Resigned</th>
                            <th>{{ $resignedWorkers }}</th>
                        </tr>
                        <tr>
                            <th>Total Active Worker</th>
                            <th> {{ $permanentWorkers+$newWorkers }}</th>
                        </tr>
                    </table>
                </div>


                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
        <div class="col-sm-4">

        </div>
    </div>







@endsection
