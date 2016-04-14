<?php

namespace App\Http\Controllers\Reports;

use App\Model\Attendance;
use App\Model\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = \DataFilter::source(Attendance::class);

        $filter->add('employee_id','Employee','tags');
        $filter->add('month','Month','select')->options([''=>'Select Month'])
            ->options(months());
        $filter->add('year','Year','date')->format('Y');

        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        $month = (!empty(Input::get('month'))) ? Input::get('month') : date('M');
        $monthCarbon = (!empty(Input::get('month'))) ? Input::get('month') : date('m');
        $year = (!empty(Input::get('year'))) ? Input::get('year') : date('Y');

        $startDay = new Carbon('first day of '.$month.' '.$year );
        $endDay = new Carbon('last day of '.$month.' '.$year );
        $noOfDaysInMonth = Carbon::create($year,$monthCarbon)->daysInMonth;
        $employees = Employee::where('status','!=','3')
                    ->with(['attendance'=>function($query) use($startDay,$endDay){
                        return $query->whereBetween('date',[$startDay,$endDay]);
                    }])
                    ->with(['leave'=>function($query) use($startDay,$endDay){
                        return $query->whereBetween('start_day',[$startDay,$endDay]);
                    }])
                    ->where(function($query){
                        if(!empty(Input::get('employee_id')))
                        {
                            return $query->where('employee_id',Input::get('employee_id'));
                        }else{
                            return $query;
                        }
                    })
                    ->paginate(config('hrm.report_row_per_page'));

        return view('report.attendance.index',compact('filter','employees','noOfDaysInMonth'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
