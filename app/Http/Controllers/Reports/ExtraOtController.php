<?php

namespace App\Http\Controllers\Reports;

use App\Model\SalaryRegister;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ExtraOtController extends Controller
{
    /**
     * @return mixed
     */
    public function index()
    {
        $filter = \DataFilter::source(SalaryRegister::with('employee'));

        $filter->add('employee.employee_id','Employee','tags');
        $filter->add('month','Month','select')->options([''=>'Select Month'])
            ->options(months());
        $filter->add('year','Year','date')->format('Y');

        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();


        $salaries = SalaryRegister::where(function($query){
            if(!empty(Input::get('month')))
            {
                return $query->where('month',Input::get('month'));
            }else{
                return $query;
            }
        })->where(function($query){
            if(!empty(Input::get('year')))
            {
                return $query->where('year',Input::get('year'));
            }else{
                return $query;
            }
        })->where(function($query){
            if(!empty(Input::get('employee_employee_id')))
            {
                return $query->where('employee_id',Input::get('employee_employee_id'));
            }else{
                return $query;
            }
        })
            ->with('employee.designations','employee.grade','salaryStructure')
            ->paginate(config('hrm.report_row_per_page'));


        //return $salaries;


        return view('report.extra_ot.index',compact('filter','salaries'));
    }

    /**
     * @return mixed
     */
    public function download()
    {

        $salaries = SalaryRegister::where(function($query){
            if(!empty(Input::get('month')))
            {
                return $query->where('month',Input::get('month'));
            }else{
                return $query;
            }
        })->where(function($query){
            if(!empty(Input::get('year')))
            {
                return $query->where('year',Input::get('year'));
            }else{
                return $query;
            }
        })->where(function($query){
            if(!empty(Input::get('employee_employee_id')))
            {
                return $query->where('employee_id',Input::get('employee_employee_id'));
            }else{
                return $query;
            }
        })
            ->with('employee.designations','employee.grade','salaryStructure')
            ->get();


        //return $salaries;


        \Excel::create('Salary_'.date('d-m-Y'), function($excel) use($salaries) {
            $excel->setTitle('Our new awesome title');
            $excel->sheet('New sheet', function($sheet) use($salaries) {

                $sheet->loadView('report.extra_ot.download')->with('salaries',$salaries);

            })->download('xlsx');;

        });
    }
}
