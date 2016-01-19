<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Branch;
use App\Model\Designation;
use App\Model\Department;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        //$grid = \DataGrid::source("designations");
        $grid = \DataGrid::source(designation::with('department'));


        $grid->add('id','S_No', true)->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart; 
            return ($pageNumber-1)*10 +$serialStart;

        });

        $grid->add('{{ $department->branch->name }}','Branch','branch_id');
        $grid->add('{{ $department->name }}','Department','department_id');
        

        $grid->add('name',' Name',true); 
       
       
        $grid->add('description','Description'); 
        $grid->edit('designation/edit', 'Edit','show|modify|delete');
        $grid->link('designation/edit',"New Designation", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('id','ASC');
        
        $grid->paginate(10);


        return  view('designation.index', compact('grid'));
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
        $edit = \DataEdit::source(new Designation());
        $edit->link("designation","Designation", "TR",['class' =>'btn btn-primary'])->back();

        $edit->add('branch_id','Branch <i class="fa fa-asterisk text-danger"></i>','select')
             ->options([''=>'Select Branch'])
             ->options(Branch::lists("name", "id")->all())
             ->attributes(['data-target'=>'department_id','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
        $edit->add('department_id','Department <i class="fa fa-asterisk text-danger"></i>','select')
             ->options([''=>"Select Department"])
             ->options(Department::lists('name','id')->all())
             ->attributes(['data-target'=>'section_id','data-source'=>url('/section/json'), 'onchange'=>"populateSelect(this)"]);

        
        $edit->add('name','Name <i class="fa fa-asterisk text-danger"></i>', 'text')->rule('required');

        $edit->add('description','Description', 'redactor');
       
        $edit->build();
        return $edit->view('designation.edit', compact('edit')); 

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

    public function getLists($department_id)
    {
        return Designation::where('department_id',$department_id)->get();
    }
}