<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Branch;
use App\Model\Department;
use App\Model\Section;
use App\Model\Line;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = \DataFilter::source(Line::with('section.department.branch'));  

        $filter->add('section.department.branch','Branch', 'select')->options([''=>'Select Branch'])->options(Branch::lists("name", "id")->all())
                    ->scope(function($query){
                        if (!empty(\Input::get('section_department_branch'))) {
                            $branches = Branch::where(['id'=>\Input::get('section_department_branch')])->with('departments.sections')->get();
                            $sections = [];
                            foreach ($branches as $branch) {
                                foreach ($branch->departments as $department) {
                                        $sections = array_merge($sections, array_pluck($department->sections->toArray(), 'id'));
                                }
                            }
                            return $query->whereIn('section_id',$sections);
                        } else {
                           return $query; 
                        }

                    })
                    ->attributes(['data-target'=>'section_department','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
            $filter->add('section.department','Department','select')

            ->options([''=>"Select Department"])
            ->options(Department::where('branch_id', \Input::get('section_department_branch'))->lists("name", "id"))
            ->scope(function($query){
                if (!empty(\Input::get('section_department')) && trim(\Input::get('section_department')) !="--Select--") {

                    $sections = [];

                    $departments = Department::where(['id'=>\Input::get('section_department')])->with('sections')->get();
                        foreach ($departments as $department) {
                                $sections = array_merge($sections, array_pluck($department->sections->toArray(), 'id'));
                            
                        }
                    return $query->whereIn('section_id',$sections);

                }else{
                    return $query;
                }
            }) ->attributes(['data-target'=>'section','data-source'=>url('/section/json'), 'onchange'=>"populateSelect(this)"]);
       
            $filter->add('section','Section','select')

            ->options([''=>"Select Section"])
            ->options(Section::where('department_id', \Input::get('section_department'))->lists("name", "id"))
            ->scope(function($query){
                if (!empty(\Input::get('section')) && trim(\Input::get('section')) !="--Select--") {

                    return $query->where('section_id',\Input::get('section'));

                }else{
                    return $query;
                }
        });

        //$filter->add('designations.name','Designations','tags')->options([''=>'Select Desination'])->options(Designation::lists("name", "id"));

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
        $grid->add('{{ $section->department->branch->name }}','Branch','branch_id');
        $grid->add('{{ $section->department->name }}','Department','department_id');
        $grid->add('{{ $section->name }}','Section','section_id');
        $grid->add('name','Line Name',true); 
        $grid->add('description','Description'); 
        $grid->edit('line/edit', 'Edit','show|modify|delete');
        $grid->link('line/edit',"New Line", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('name','ASC');
        
        $grid->paginate(10);

        return  view('line.index', compact('grid','filter'));
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
        

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {

       $edit = \DataEdit::source(new line());
        $edit->link("line","Lines", "TR",['class' =>'btn btn-primary'])->back();
       $edit->add('branch_id','Branch <i class="fa fa-asterisk text-danger"></i>','select')
             ->options([''=>'Select Branch'])
             ->options(Branch::lists("name", "id")->all())
             ->attributes(['data-target'=>'department_id','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
        $edit->add('department_id','Department <i class="fa fa-asterisk text-danger"></i>','select')
             ->options([''=>"Select Department"])
             ->options(Department::lists('name','id')->all())
             ->attributes(['data-target'=>'section_id','data-source'=>url('/section/json'), 'onchange'=>"populateSelect(this)"]);

        $edit->add('section_id','Section <i class="fa fa-asterisk text-danger"></i>','select')
             ->options([''=>"Select Department"])
             ->options(Section::lists('name','id')->all());
        $edit->add('name','Line Name <i class="fa fa-asterisk text-danger"></i>', 'text')->rule('required');

        $edit->add('description','Description', 'textarea');
       
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

    public function getLists($branch_id)    
    {
        return Line::where(['section_id'=>$branch_id])->get();
    }
}
