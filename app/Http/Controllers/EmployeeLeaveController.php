<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\LeaveEmployee;
use App\Model\LeaveType;
use Illuminate\Http\Request;

class EmployeeLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        //return LeaveEmployee::with('leaveType')->get();
        $filter = \DataFilter::source(LeaveEmployee::with('employee','leaveType'));

        $filter->add('employee.employee_id','Employee Id','tags');
        $filter->add('year','Year','date')->format('Y');
        $filter->add('leavetype_id','Leave Type','select')
            ->options([''=>'Leave Type'])
            ->options(LeaveType::lists('name','id'));
                
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
        
        $grid->add('{{ $employee->employee_id }}','Employee ID','employee_id',true);
        $grid->add('{{ $employee->name }}','Employee');    
        $grid->add('{{ $leaveType->name }}','Leave Type','leavetype_id');
        $grid->add('leave_day','Leave Days');
        $grid->add('year','Year');
        $grid->edit('leaveemployee/edit', 'Action','show|modify');
        $grid->link('leaveemployee/edit',"New Allocation", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('year','ASC');
        
        $grid->paginate(10);


        return  view('leave.employee.index', compact('grid', 'filter'));
    }

    public function edit()
    {
       
        $edit = \DataEdit::source(new LeaveEmployee());
        $edit->link("leaveemployee","Employee Leave", "TR",['class' =>'btn btn-primary'])->back();
        
        $edit->add('employee.employee_id','Employee ID <span class="text-danger">*</span>','autocomplete')
                ->search(array('employee_id'))
                ->rule('required|exists:employees,id');
                
        $edit->add('leavetype_id','Leave Type <span class="text-danger">*</span>','select')
             ->options([''=>'Selet Type'])   
             ->options(LeaveType::lists('name','id')->all())
             ->rule('required|exists:leave_types,id');
        $edit->add('leave_day','Leave Days <span class="text-danger">*</span>', 'text')->rule('required|numeric');

        $edit->add('year','Year <span class="text-danger">*</span>', 'date')->format('Y')->rule('required');
        
        $edit->build();

        return $edit->view('leave.employee.edit', compact('edit')); 
    }
}
