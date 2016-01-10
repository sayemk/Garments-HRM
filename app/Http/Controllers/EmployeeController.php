<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Branch;
use App\Model\Department;
use App\Model\Designation;
use App\Model\Employee;
use App\Model\Line;
use App\Model\Section;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
    	// return Employee::with('line.section.department.branch','designations')->get();
        
        $filter = \DataFilter::source(Employee::with('line.section.department.branch','designations'));
        
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

        $filter->add('designations.name','Designations','tags')->options([''=>'Select Desination'])->options(Designation::lists("name", "id"));

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
        $grid->add('name','Employee Name',true); 
       
        $grid->add('{{ $line->section->department->branch->name }}','Branch','branch_id');
        $grid->add('{{ $line->section->department->name }}','Department','department_id');
        $grid->add('{{ $line->section->name }}','Section','section_id');
        $grid->add('{{ $line->name }}','Line','line_id');
        $grid->edit('employee/edit', 'Edit','show|modify|delete');
        $grid->link('employee/edit',"New Employee", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('id','ASC');
        
        $grid->paginate(config('hrm.pagination_per_page', 15));


        return  view('employee.index', compact('grid','filter'));
    }
}
