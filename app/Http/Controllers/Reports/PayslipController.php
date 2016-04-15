<?php

namespace App\Http\Controllers\Reports;

use App\Model\SalaryRegister;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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

        $month = (!empty(Input::get('month'))) ? Input::get('month') : date('M');

        $year = (!empty(Input::get('year'))) ? Input::get('year') : date('Y');


        $salaries = SalaryRegister::where(function($query) use($month){
            if(!empty($month))
            {
                return $query->where('month',$month);
            }else{
                return $query;
            }
        })->where(function($query) use($year){
            if(!empty($year))
            {
                return $query->where('year',$year);
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


        return view('report.payslip.index',compact('filter','salaries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function download()
    {


        $month = (!empty(Input::get('month'))) ? Input::get('month') : date('M');

        $year = (!empty(Input::get('year'))) ? Input::get('year') : date('Y');


        $salaries = SalaryRegister::where(function($query) use($month){
            if(!empty($month))
            {
                return $query->where('month',$month);
            }else{
                return $query;
            }
        })->where(function($query) use($year){
            if(!empty($year))
            {
                return $query->where('year',$year);
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


        \Excel::create('Payslip_'.date('d-m-Y'), function($excel) use($salaries) {
            $excel->setTitle('Payslip');
            $excel->sheet('New sheet', function($sheet) use($salaries) {

                $sheet->loadView('report.payslip.pdf')->with('salaries',$salaries);
                $sheet->setWidth(array(
                    'A'     =>  25,
                    'B'     =>  20
                ));

            })->download('xlsx');

        });
    }


}
