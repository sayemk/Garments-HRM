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
        <button id="report_download_btn" class="btn btn-primary pull-right" data-link="/report/attendance/download">Download Report</button>
        <br>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Card No</th>
                @for($i=1;$i<=$noOfDaysInMonth;$i++)
                    <td>{{ $i }}</td>

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
            @foreach($employees as $employee)
                <tr>
                    <td>{{ ++$counter }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->employee_id }}</td>
                    <?php
                    $leaves = \App\Model\LeaveDetail::whereBetween('start_day',[$startDay,$endDay])
                                                    ->with(['leave'=>function($query)use($employee){
                                                        return $query->where('employee_id',$employee->id);
                                                    }])
                                                    ->get();
                    //dd($leaves);

                    if(!empty($leaves))
                    {
                        //dd($leaves);
                        $leaveDates=[];
                        foreach ($leaves as $leave)
                        {
                            if ($leave->start_day == $leave->end_day)
                                $leaveDates[] = date('Y-m-d',strtotime(str_replace('/','-',$leave->start_day)));
                            else {
                                $dates = createDateRangeArray( date('Y-m-d',strtotime(str_replace('/','-',$leave->start_day))), date('Y-m-d',strtotime(str_replace('/','-',$leave->end_day))));
                                $leaveDates = array_merge($leaveDates,$dates);
                            }
                        }
                        //dd($leaveDates);
                    }

                    ?>
                    @foreach($allDates as $date)
                        <td>
                            @if(\App\Model\Attendance::where(['employee_id'=>$employee->id, 'date'=>$date])->count())
                                P
                            @elseif(\App\Model\Holiday::where('date',$date)->count())
                                <span class="text-green">H</span>
                            @elseif(in_array($date,$leaveDates))
                                <span class="text-yellow">L</span>
                            @else

                                <span class="text-red">A</span>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach

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