<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Branch;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Employee;
use App\Model\Grade;
use App\Model\Line;
use App\Model\Section;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
    	// return Employee::with('line.section.department.branch','designations')->get();
        
        $filter = \DataFilter::source(Employee::with('line.section.department.branch','designations'));
        
        $filter->add('employee_id','Employee ID','text');
        $filter->add('line.section.department.branch','Branch', 'select')->options([''=>'Select Branch'])->options(Branch::lists("name", "id")->all())
                    ->scope(function($query){
                        if (!empty(\Input::get('line_section_department_branch'))) {
                            $branches = Branch::where(['id'=>\Input::get('line_section_department_branch')])->with('departments.sections.lines')->get();
                            $lines = [];
                            foreach ($branches as $branch) {
                            	foreach ($branch->departments as $department) {
                            		foreach ($department->sections as $section) {
                            			$lines = array_merge($lines, array_pluck($section->lines->toArray(), 'id'));
                            		}
                            	}
                            }
                            return $query->whereIn('line_id',$lines);
                        } else {
                           return $query; 
                        }

                    })
                    ->attributes(['data-target'=>'line_section_department','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
        $filter->add('line.section.department','Department','select')

            ->options([''=>"Select Department"])
            ->options(Department::where('branch_id', \Input::get('line_section_department_branch'))->lists("name", "id"))
            ->scope(function($query){
                if (!empty(\Input::get('line_section_department')) && trim(\Input::get('line_section_department')) !="--Select--") {

                	$lines = [];

                    $departments = Department::where(['id'=>\Input::get('line_section_department')])->with('sections.lines')->get();
                    	foreach ($departments as $department) {
                    		foreach ($department->sections as $section) {
                    			$lines = array_merge($lines, array_pluck($section->lines->toArray(), 'id'));
                    		}
                    	}
                	return $query->whereIn('line_id',$lines);

                }else{
                    return $query;
                }
            })
            ->attributes(['data-target'=>'line_section','data-source'=>url('/section/json'), 'onchange'=>"populateSelect(this)"]);
       
        $filter->add('line.section','Section','select')

            ->options([''=>"Select Section"])
            ->options(Section::where('department_id', \Input::get('line_section_department'))->lists("name", "id"))
            ->scope(function($query){
                if (!empty(\Input::get('line_section')) && trim(\Input::get('line_section')) !="--Select--") {

                	$lines= [];

                    $sections = Section::where(['id'=>\Input::get('line_section')])->with('lines')->get();
                   
            		foreach ($sections as $section) {
            			$lines = array_merge($lines, array_pluck($section->lines->toArray(), 'id'));
            		}
            		
                    return $query->whereIn('line_id',$lines);

                }else{
                    return $query;
                }
            })
            ->attributes(['data-target'=>'department_section_name','data-source'=>url('/section/json'), 'onchange'=>"populateSelect(this)"]);
        
        	$filter->add('line','Section','select')

            ->options([''=>"Select Line"])
            ->options(Line::where('section_id', \Input::get('line_section'))->lists("name", "id"))
            ->scope(function($query){
                if (!empty(\Input::get('line')) && trim(\Input::get('line')) !="--Select--") {
            		
                    return $query->where('line_id',\Input::get('line'));

                }else{
                    return $query;
                }
        });


        $filter->add('designations.name','Designations','tags');

        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        //Grid View

        $grid = \DataGrid::source($filter);

        $grid->add('id','#')->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart; 
            return ($pageNumber-1)*config('hrm.pagination_per_page', 15) +$serialStart;


        });
        
        $grid->add('employee_id','Employee ID',true);
        $grid->add('image','Image')->cell(function($value,$row){
        	if(preg_match('/^http/', $value)){
                return '<img alt="employee Photo" class="attachment-img img-responsive" style="width:120px; height:90px" src="'.url("uploads/images/employees/dummyPortrait.png").'">' ;
            }else {
                return '<img alt="employee Photo" class="attachment-img img-responsive" style="width:120px; height:90px" src="'.url("uploads/images/employees").'/'.$value.'">' ;
            }
        });
        $grid->add('name','Employee Name',true); 
        $grid->add('{{  implode(", ", $designations->lists("name")->all()) }}','Designation',true);
       
        $grid->add('{{ $line->section->department->branch->name }}','Branch','branch_id');
        $grid->add('{{ $line->section->department->name }}','Department','department_id');
        $grid->add('{{ $line->section->name }}','Section','section_id');
        $grid->add('{{ $line->name }}','Line','line_id');
        $grid->add('gender','Gender',true)->cell(function($value,$row){
        	return ($value==1)?'Male':'Female';
        });
        $grid->add('status','Status',true)->cell(function($value,$row){
        	return employeeStatus($value);
        });
        $grid->edit('employee/edit', 'Edit','modify');
        $grid->link('employee/edit',"New Employee", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('id','ASC');
        
        $grid->paginate(config('hrm.pagination_per_page', 15));


        return  view('employee.index', compact('grid','filter'));
    }


    public function edit()
    {
    	$edit = \DataEdit::source(new Employee());
    	$edit->add('branch_id','Branch <span class="text-danger">*</span>','select')
    		 ->options([''=>'Select Branch'])
    		 ->options(Branch::lists("name", "id")->all())
    		 ->attributes(['data-target'=>'department_id','data-source'=>url('/department/json'), 'onchange'=>"populateSelect(this)"]);
        
        $edit->add('department_id','Department <span class="text-danger">*</span>','select')
			 ->options([''=>"Select Department"])
             ->options(Department::lists("name", "id")->all())
			 ->attributes(['data-target'=>'section_id','data-source'=>url('/section/json'), 'onchange'=>"populateSelect(this);setDesignation(this)"]);

	    $edit->add('section_id','Section <span class="text-danger">*</span>','select')
			 ->options([''=>"Select Section"])
             ->options(Section::lists("name", "id")->all())
			 ->attributes(['data-target'=>'line_id','data-source'=>url('/line/json'), 'onchange'=>"populateSelect(this)"]);

		$edit->add('line_id','Line <span class="text-danger">*</span>','select')
			 ->options([''=>"Select Line"])
             ->options(Line::lists("name", "id")->all());

        $edit->link("employee","Employee", "TR",['class' =>'btn btn-primary'])->back();

        $edit->add('employee_id','Employee ID <span class="text-danger">*</span>', 'text')->rule('required');
        $edit->add('name','Full Name <span class="text-danger">*</span>', 'text')->rule('required');
        $edit->add('designations','Designations','select')
             ->options([''=>'Select Designations'])
             ->options(Designation::lists('name','id')->all())
             ->attributes(['data-target'=>'grade','data-source'=>url('/grade/json'), 'onchange'=>"populateSelect(this)"]);

        $edit->add('grade','Grade','select')
             ->options([''=>'Select Grade'])
             ->options(Grade::lists('name','id')->all());

        $edit->add('gender','Gender <span class="text-danger">*</span>','select')->options(['1'=>'Male','2'=>'Female'])->rule('required');
        $edit->add('dob','Date Of Birth <span class="text-danger">*</span>','date')->format('d/m/Y', 'en')->rule('required');
        $edit->add('father_name','Father\'s Name <span class="text-danger">*</span>','text')->rule('required');
        $edit->add('present_address','Present Adress <span class="text-danger">*</span>','textarea')->attributes(['rows'=>3])->rule('required');
        $edit->add('permanent_address','Permanent Adress <span class="text-danger">*</span>','textarea')->attributes(['rows'=>3])->rule('required');
        $edit->add('primary_phone','Primary Phone <span class="text-danger">*</span>','text')->rule('required');
        $edit->add('secondary_phone','Secondary Phone','text');
        $edit->add('national_id','National ID','text');
        $edit->add('passport','Passport','text');
        $edit->add('birth_certificate','Birth Certificate','text');
        $edit->add('joining_date','Joining Date <span class="text-danger">*</span>','date')->format('d/m/Y', 'en')->rule('required');
        $edit->add('status','Status <span class="text-danger">*</span>','select')->options(['1'=>'Active','2'=>'Inactive'])->rule('required');
        $edit->add('image','Photo', 'image')->move('uploads/images/employees')->preview(80,80);
       
        $edit->build();
        return $edit->view('employee.edit', compact('edit')); 
    }
}
