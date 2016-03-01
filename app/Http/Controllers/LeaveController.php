<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Employee;
use App\Model\Leave;
use App\Model\LeaveDetail;
use App\Model\LeaveEmployee;
use App\Model\LeaveType;
use Illuminate\Http\Request;
use Zofe\Rapyd\DataFilter\DataFilter;
use Zofe\Rapyd\Facades\DataGrid;
use Carbon\Carbon;

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

        $this->validate($request, [
            'employee_id' => 'required|exists:employees,employee_id',
            'start_date' => 'required|date_format:d/m/Y',
            'end_date' => 'required|date_format:d/m/Y',
            'total_day' =>'required|numeric',
            'leave_type'=>'required|array',
            'sub_start_date'=>'required|array',
            'sub_end_date'=>'required|array',
            'sub_total_days'=>'required|array',
            'payable'=>'required|array',
        ]);

       Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString('Y-m-d');

        $leaveapplication = new Leave();

        $employee = Employee::where('employee_id', $request->employee_id)->select(['id','name','employee_id'])->get();

        $leaveapplication->employee_id = $employee[0]->id;
        $leaveapplication->start_day =  Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString('Y-m-d');
        $leaveapplication->end_day = Carbon::createFromFormat('d/m/Y', $request->end_date)->toDateString('Y-m-d');

        $start_day = Carbon::createFromFormat('d/m/Y', $request->start_date);
        $end_day = Carbon::createFromFormat('d/m/Y', $request->end_date);
        $total_days = $end_day->diffInDays($start_day);


        $leaveapplication->total_days = $total_days+1; //As diffInDays return 0 for same days

        $leaveapplication->year = Carbon::createFromFormat('d/m/Y', $request->start_date)->toDateString('Y');

        $leaveapplication->save();

        foreach($request->leave_type as $index => $type){
            $leaveDetails = new LeaveDetail();
            $leaveDetails->leave_id = $leaveapplication->id;
            $leaveDetails->leave_type_id = $type;
            $leaveDetails->days = $request->sub_total_days[$index];
            $leaveDetails->start_day = Carbon::createFromFormat('d/m/Y', $request->sub_start_date[$index])->toDateString('Y-m-d');
            $leaveDetails->end_day = Carbon::createFromFormat('d/m/Y', $request->sub_end_date[$index])->toDateString('Y-m-d');
            $leaveDetails->payable = $request->payable[$index];
            $leaveDetails->save();
        }

        return redirect('/leaveapplication');

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
            
            $spentLeaves = Leave::where([ 'year' => date('Y'),'employee_id'=>$employee[0]->id])->with(['leaveDetails'=>function($query) use($alocatedLeave){
                return $query->where('leave_type_id',$alocatedLeave->leaveType->id);
            }])->get();
            $total = 0;
            foreach($spentLeaves as $spentLeave){
                $total = $total + $spentLeave->leaveDetails->sum('days');
            }
            
            $summary[$alocatedLeave->leaveType->id] =['leaveType'=>$alocatedLeave->leaveType->name,'alocated'=>$alocatedLeave->leave_day,'spent'=>$total];
        }
        
        return response()->json(['status'=>1,'employee'=>$employee[0]->name, 'summary'=>$summary]);

    }
}
