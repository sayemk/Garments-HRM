<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Employee;
use App\Model\Leave;
use App\Model\LeaveEmployee;
use App\Model\LeaveType;
use Illuminate\Http\Request;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\Facades\DataGrid;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = DataFilter::source(Leave::with('employee'));
        $filter->add('employee.employee_id','Employee ID','text');
        $filter->add('year','Year','date')->format('Y')->scope( function ($query, $value) {
            if(!empty(\Input::get('year'))){
                return $query->where('year', \Input::get('year'));
            } else {
                return $query;
            }
        });

        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        $grid = \DataGrid::source($filter);

        $grid->add('id','S_No')->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart;
            return ($pageNumber-1)*10 +$serialStart;


        });

        $grid->add('employee.employee_id','Employee ID','employee_id', true);
        $grid->add('employee.name','Name');
        $grid->add('total_days','Number Of Days',true);
        $grid->add('start_day','Start Date',true);
        $grid->add('end_day','End Date',true);
        $grid->add('year','Year',true);

        $grid->edit('leaveapplication/edit', 'Action','show|modify');
        $grid->link('leaveapplication/create',"New Leave Application", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('year','DESC');

        $grid->paginate(10);


        return view('leave.application.index',compact('grid','filter'));
//        $leaves = Leave::with(['employee'=>function($query){
//                if (!empty(\Input::get('employee'))) {
//
//                    return $query->where('employee_id', \Input::get('employee'));
//                }
//                return $query;
//            }])
//            ->where(function($query){
//                if (!empty(\Input::get('year'))) {
//                    return $query->where('year', \Input::get('year'));
//                }
//                return $query;
//            })
//            ->paginate(10);
//
//        //return $leaves;
//
//        return view('leave.application.index',compact('leaves'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leaveType = LeaveType::lists('name','id');
        return view('leave.application.create', compact('leaveType'));
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
        return;
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

    public function summary($employee_id){
        $employee = Employee::where('employee_id',$employee_id)->with(['leaveEmployees'=>function($query){
            $query->where(['year'=>date('Y')])->with('leaveType');
        }])->get();

        foreach($employee[0]->leaveEmployees as $alocatedLeave){
            $spentLeave = Leave::where([ 'year' => date('Y'),'employee_id'=>$employee[0]->id])->with(['leaveDetails'=>function($query) use($alocatedLeave){
                return $query->where('leave_type_id',$alocatedLeave->leaveType->id);
            }])->get();
            $summary[$alocatedLeave->leaveType->id] = $spentLeave[0]->leaveDetails->sum('days');
        }

        return response()->json(['employe'=>$employee, 'summary'=>$summary]);


    }
}
