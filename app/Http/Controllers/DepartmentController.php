<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\Branch;
use App\Model\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
    	$filter = \DataFilter::source(Department::with('branch'));

        $filter->add('branch.name','Branch', 'select')->options([''=>'Select Branch'])->options(Branch::lists("name", "id")->all());
       
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
        $grid->add('name','Department Name',true); 
       
        $grid->add('{{ $branch->name }}','Branch','branch_id');
        $grid->add('description','Description'); 
        $grid->edit('department/edit', 'Edit','show|modify|delete')->style('width:10%');
        $grid->link('department/edit',"New Department", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('branch_id','ASC');
        
        $grid->paginate(10);


        return  view('department.index', compact('grid','filter'));
    }

    public function edit()
    {
    	$edit = \DataEdit::source(new Department());
        $edit->link("department","Department", "TR",['class' =>'btn btn-primary'])->back();
        $edit->add('branch_id','Branch <i class="fa fa-asterisk text-danger"></i>','select')
                ->options(Branch::lists("name", "id")->all())
                ->rule('required|exists:branches,id');
                
        $edit->add('name','Department Name <i class="fa fa-asterisk text-danger"></i>', 'text')->rule('required');

        $edit->add('description','Description', 'textarea');
       
        $edit->build();
        return $edit->view('department.edit', compact('edit')); 


    }

    public function getLists($branch_id)	
    {
    	return Department::where(['branch_id'=>$branch_id])->get();
    }

}
