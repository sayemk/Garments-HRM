<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Attendance;
use App\Model\Employee;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = \DataFilter::source(Attendance::with('employees'));

        $filter->add('employees.employee_id','Employee','tags');
        //$filter->add('date','date','date')->format('Y:M:D');
      
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        $grid = \DataGrid::source($filter);

        $grid->add('id','S_No', true)->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart; 
            return ($pageNumber-1)*10 +$serialStart;
        });
        
        $grid->add('{{$employees->employee_id}}','Employee');    
        $grid->add('date','Date',true);
        $grid->add('in_time','In Time',true);
        $grid->add('out_time','Out Time',true);
        $grid->add('duration','Duration',true);
        $grid->add('overtime','Overtime',true);

        $grid->edit('attendance/edit', 'Action','show|modify');
        $grid->link('attendance/edit',"New Attendance", "TR",['class' =>'btn btn-success']);
        //$grid->orderBy('year','ASC');
        
        $grid->paginate(10);


        return  view('attendance.index', compact('grid','filter'));
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
    public function edit()
    {
        $edit = \DataEdit::source(new Attendance());

        $edit->link("attendance","Attendance", "TR",['class' =>'btn btn-primary'])->back();

       $edit->add('employee_id','Employee <i class="fa fa-asterisk text-danger"></i>','select')
                ->options(Employee::lists("employee_id", "id")->all())
                ->rule('required|exists:employees,id');

        $edit->add('date','Date <i class="fa fa-asterisk text-danger"></i>', 'date');

        $edit->add('in_time','In Time <i class="fa fa-asterisk text-danger"></i>', 'datetime')->format('H:i:s')->rule('required');
        $edit->add('out_time','Out Time <i class="fa fa-asterisk text-danger"></i>', 'datetime')->format('H:i:s')->rule('required');
        $edit->add('duration','Duration <i class="fa fa-asterisk text-danger"></i>', 'datetime')->format('H:i:s')->rule('required');
        $edit->add('overtime','Overtime <i class="fa fa-asterisk text-danger"></i>', 'datetime')->format('H:i:s')->rule('required');
        
        $edit->build();

        return $edit->view('attendance.edit', compact('edit')); 
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
