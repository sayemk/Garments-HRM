<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Model\Branch;
use App\Model\Department;
use App\Model\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $filter = \DataFilter::source(Section::with('department.branch'));

        $filter->add('department.branch.name','Branch', 'select')->options([''=>'Select Branch'])->options(Branch::lists("name", "id")->all())
                    ->scope(function($query){
                        if (!empty(\Input::get('department_branch_name'))) {
                            $branch = Branch::where(['id'=>\Input::get('department_branch_name')])->with('departments')->get();
                            $departments = array_pluck($branch[0]->departments->toArray(), 'id');
                            return $query->whereIn('department_id',$departments);
                        } else {
                           return $query; 
                        }
                        

                    })
                    ->attributes(['data-target'=>'department_name','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
        $filter->add('department.name','Department','select')
            ->options([''=>"--Select--"])
            ->options(Department::where('branch_id', \Input::get('department_branch_name'))->lists("name", "id"))
            ->scope(function($query){
                if (!empty(\Input::get('department_name')) && trim(\Input::get('department_name')) !="--Select--") {

                   return $query->where('department_id',\Input::get('department_name'));

                }else{
                    return $query;
                }
            });
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        $grid = \DataGrid::source($filter);

        $grid->add('id','#')->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart; 
            return ($pageNumber-1)*config('hrm.pagination_per_page', 15) +$serialStart;


        });
        $grid->add('name','Section Name',true); 
       
        $grid->add('{{ $department->branch->name }}','Branch','branch_id');
        $grid->add('{{ $department->name }}','Dpartment','department_id');
        $grid->add('description','Description'); 
        $grid->edit('section/edit', 'Edit','show|modify|delete');
        $grid->link('section/edit',"New Section", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('name','ASC');
        
        $grid->paginate(config('hrm.pagination_per_page', 15));


        return  view('section.index', compact('grid','filter'));
    }

   
    public function edit()
    {
        
        $section = Section::find(\Input::get('modify'));
        $section = (!empty($section->branch_id)) ? $section->branch_id : 0;

        $departments =Department::where('branch_id', $section)->lists("name", "id");
        
        $edit = \DataEdit::source(new Section());
        $edit->link("section","Section", "TR",['class' =>'btn btn-primary'])->back();
        $edit->add('branch_id','Branch <i class="fa fa-asterisk text-danger"></i>','select')
                ->options([''=>"--Select--"])
                ->options(Branch::lists("name", "id"))
                ->rule('required|exists:branches,id')
                 ->attributes(['data-target'=>'department_id','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
        $edit->add('department_id','Department <i class="fa fa-asterisk text-danger"></i>','select')
            ->options([''=>"--Select--"])
            ->options($departments)
            ->rule('required|exists:departments,id');

        $edit->add('name','Section Name <i class="fa fa-asterisk text-danger"></i>', 'text')->rule('required');

        $edit->add('description','Description', 'textarea');
       
        $edit->build();
        return $edit->view('section.edit', compact('edit')); 

    }


}
