<?php

namespace App\Http\Controllers;

use App\Model\Employee;
use App\Model\SalaryStructure;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
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
                return $query;
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
        $grid->add('ot_rate','OT Rate');
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
    public function edit(Request $request)
    {
        if(!empty(Input::get('update')))
        {
//            return redirect('/salary/structure/'.Input::get('update').'/edit')->withInput(Input::all());

            $structure = SalaryStructure::find(Input::get('update'));
            $structure->delete();

            $structure = new SalaryStructure();

            $structure->employee_id = $request->employee_employee_id;
            $structure->basic = $request->basic;
            $structure->house_rent = $request->house_rent;
            $structure->m_a = $request->m_a;
            $structure->t_a = $request->t_a;
            $structure->f_a = $request->f_a;
            $structure->gross = $request->gross;
            $structure->ot_rate = $request->ot_rate;

            $structure->save();

            return redirect('/salary/structure');
        }
        $edit = \DataEdit::source(new SalaryStructure());
        $edit->link("salary/structure","Salary Structure", "TR",['class' =>'btn btn-primary'])->back();
        $edit->add('employee.employee_id','Employee ID <span class="text-danger">*</span>','autocomplete')
            ->search(array('employee_id'))
            ->rule('required|exists:employees,id');

        $edit->add('basic','Basic <span class="text-danger salry">*</span>','text')
            ->rule('required');
        $edit->add('house_rent','House Rent <span class="text-danger">*</span>','text')
            ->rule('required');
        $edit->add('m_a','M/A <span class="text-danger">*</span>','text')
            ->rule('required');
        $edit->add('t_a','T/A <span class="text-danger">*</span>','text')
            ->rule('required');
        $edit->add('f_a','F/A <span class="text-danger">*</span>','text')
            ->rule('required');
        $edit->add('gross','Gross Salry <span class="text-danger">*</span>','text')
            ->rule('required');
        $edit->add('ot_rate','Over Time Rate <span class="text-danger">*</span>','text')
            ->rule('required');

        $edit->add('type','Salary Type <span class="text-danger">*</span>','select')
            ->options([''=>"Select Type",'1'=>'Bank','2'=>'Cash'])
            ->rule('required');

        $edit->build();
        return $edit->view('salary.structure.edit', compact('edit'));


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
        return Input::all();
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
