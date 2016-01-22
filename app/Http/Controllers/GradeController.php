<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Grade;
use App\Model\Branch;
use App\Model\Department;
use App\Model\Designation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$grid = \DataGrid::source(Grade::with('designation'));

        $filter = \DataFilter::source(grade::with('designation.department.branch'));

        $filter->add('designation.department.branch.name','Branch', 'select')->options([''=>'Select Branch'])->options(Branch::lists("name", "id")->all())
                    ->scope(function($query){
                        if (!empty(\Input::get('department_branch_name'))) {
                            $branch = Branch::where(['id'=>\Input::get('designation_department_branch_name')])->with('departments')->get();
                            $departments = array_pluck($branch[0]->departments->toArray(), 'id');
                            return $query->whereIn('department_id',$departments);
                        } else {
                           return $query; 
                        }
                        

                    })
                    ->attributes(['data-target'=>'designation_department_name','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
        $filter->add('designation.department.name','Department','select')
            ->options([''=>"--Select--"])
            ->options(Department::where('branch_id', \Input::get('designation.department_branch_name'))->lists("name", "id"))
            ->scope(function($query){
                if (!empty(\Input::get('designation_department_name')) && trim(\Input::get('designation_department_name')) !="--Select--") {

                   return $query->where('_department_id',\Input::get('department_name'));

                }else{
                    return $query;
                }
            });

            
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


        $grid->add('id','S_No', true)->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart; 
            return ($pageNumber-1)*10 +$serialStart;

        });

        $grid->add('{{ $designation->department->branch->name }}','Branch','branch_id');
        $grid->add('{{ $designation->department->name }}','Department','department_id');
        $grid->add('{{ $designation->name }}','Designation','designation_id');
        $grid->add('name','Grade Name',true); 
        //$grid->add('address','Adress'); 
        $grid->edit('grade/edit', 'Edit','show|modify|delete');
        $grid->link('grade/edit',"New Grade", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('name','ASC');
        
        $grid->paginate(10);


        return  view('grade.index', compact('grid','filter'));
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
        $edit = \DataEdit::source(new Grade());
        $edit->link("grade","grade", "TR",['class' =>'btn btn-primary'])->back();

        $edit->add('branch_id','Branch <i class="fa fa-asterisk text-danger"></i>','select')
             ->options([''=>'Select Branch'])
             ->options(Branch::lists("name", "id")->all())
             ->attributes(['data-target'=>'department_id','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
        $edit->add('department_id','Department <i class="fa fa-asterisk text-danger"></i>','select')
             ->options([''=>"Select Department"])
             ->options(Department::lists('name','id')->all())
             ->attributes(['data-target'=>'designation_id','data-source'=>url('/designation/json'), 'onchange'=>"populateSelect(this)"]);


             $edit->add('designation_id','Designation <i class="fa fa-asterisk text-danger"></i>','select')
             ->options([''=>"Select Designation"]);

        $edit->add('name','Grade <i class="fa fa-asterisk text-danger"></i>', 'text')->rule('required');
        $edit->build();
        return $edit->view('grade.edit', compact('edit')); 
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

    public function getLists($designation_id)
    {
        return Grade::where('designation_id',$designation_id)->get();
    }
}
