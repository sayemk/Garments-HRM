@extends('layouts.master')

@section('title','Attendance Report')
@section('sidebar')

@include('layouts.sidebar',['active' =>'attendance','parent_menu'=>'reports'])

@endsection

@section('content')
        <!-- Info boxes -->

<div class="box box-primary">

    <h3 class="box-title padding-left">Employee Attendance Record</h3>

    <div class="box-body table-responsive no-padding">

        {!! $filter !!}
        <button id="report_download_btn" class="btn btn-primary pull-right" data-link="/report/salary/download">Download Report</button>
        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Card No</th>
                @for($i=1;$i<=$noOfDaysInMonth;$i++)
                    <th>{{ $i }}</th>

                @endfor
            </tr>
            </thead>
            <tbody>
            <?php
            if(!empty(\Input::get('page')))
            {
                $counter = \Input::get('page')*config('hrm.report_row_per_page')-config('hrm.report_row_per_page');
            }else{
                $counter =0;
            }
            ?>

            </tbody>
        </table>
        {!! $employees->render() !!}

    </div>


    <div class="box-footer clearfix">

    </div>
</div>




@endsection
@section('script')
    <script>

        $(document).on('click', '#report_download_btn', function(event) {

            window.open($(this).attr('data-link')+$(location).attr('search'));


        });

    </script>
@endsection