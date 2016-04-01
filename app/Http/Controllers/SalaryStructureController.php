<?php

namespace App\Http\Controllers;

use App\Model\Employee;
use App\Model\SalaryStructure;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Zofe\Rapyd\DataEdit\DataEdit;


class SalaryStructureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = \DataFilter::source(SalaryStructure::with('employee'));

        $filter->add('employee.employee_id','Employee Id','autocomplete')
            ->scope(function($query){
                if (!empty(\Input::get('auto_employee_employee_id'))) {
                    $employee = Employee::where('employee_id',\Input::get('auto_employee_employee_id'))->first();

                    return $query->where('employee_id',$employee->id);
                }
            });
        $filter->add('type','Salary Mode','select')->options([''=>'Select Salary Mode','1'=>'Bank','2'=>'Cash']);
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
        $grid->add('{{ $employee->employee_id}}','EMP Id','employee_id',true);
        $grid->add('{{ $employee->name}}','EMP Name');
        $grid->add('basic','Basic',true);
        $grid->add('house_rent','H/R');
        $grid->add('m_a','M/A');
        $grid->add('t_a','T/A');
        $grid->add('f_a','F/A');
        $grid->add('gross','Gross Salary',true);
        $grid->add('type','Salary Mode',true)->cell(function($value){
            return $value==1 ? 'Bank' : 'Cash';
        });
        $grid->edit('structure/edit', 'Action','modify|delete');
        $grid->link('salary/structure/edit',"New Salary Structure", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('employee_id','ASC');
        return  view('salary.structure.index', compact('grid', 'filter'));
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
        $edit = \DataEdit::source(new SalaryStructure());
        $edit->link("salary/structure","Salary Structure", "TR",['class' =>'btn btn-primary'])->back();
//        $edit->add('branch_id','Branch <span class="text-danger">*</span>','select')
//            ->options([''=>'Select Branch'])
//            ->options(Branch::lists("name", "id")->all())
//            ->attributes(['data-target'=>'department_id','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
//        $edit->add('department_id','Department <span class="text-danger">*</span>','select')
//            ->options([''=>"Select Department"])
//            ->options(Department::lists('name','id')->all())
//            ->attributes(['data-target'=>'section_id','data-source'=>url('/section/json'), 'onchange'=>"populateSelect(this)"]);
//
//        $edit->add('section_id','Section <span class="text-danger">*</span>','select')
//            ->options([''=>"Select Department"])
//            ->options(Section::lists('name','id')->all());
//        $edit->add('name','Line Name <span class="text-danger">*</span>', 'text')->rule('required');

        //$edit->add('description','Description', 'textarea');

        $edit->build();
        return $edit->view('line.edit', compact('edit'));


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
