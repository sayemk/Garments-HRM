<?php

namespace App\Http\Controllers;

use App\Model\Attendance;
use App\Model\Employee;
use App\Model\Holiday;
use App\Model\Leave;
use App\Model\SalaryRegister;
use App\Model\SalaryStructure;
use App\Model\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SalaryController extends Controller
{
    /**
     * @return mixed
     */
    public function create()
    {
        return view('salary.register.create');
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'year' => 'required|numeric',
            'month' =>'required|numeric|min:1|max:12',
        ]);

        $salaryFlag = SalaryRegister::where(['year'=>$request->year, 'month' => $request->month])->count();

        if ($salaryFlag) {
            $request->session()->flash('system_message', 'Salary  already created for this month! '.$request->month);
            return redirect('salary/create')
                ->withInput();
        }
        //Get all Active Employee
        $employees = Employee::where('status','!=','3')->get();

        $startDay = new Carbon('first day of '.months()[$request->month].' '.$request->year );
        $endDay = new Carbon('last day of '.months()[$request->month].' '.$request->year );

        //Get all Holidays for the requested month
        $holidays = Holiday::whereBetween('date',[$startDay,$endDay])->count();

        $noOfDaysInMonth = Carbon::create($request->year,$request->month)->daysInMonth;

        foreach ($employees as $employee){
            /*get employee attendance register */
            $attendances = Attendance::where('employee_id',$employee->id)
                                        ->whereBetween('date',[$startDay,$endDay])
                                        ->get();
            //Count the attended date
            $totalAttended = $attendances->count();

            /*Employee's approved Leaves*/
            $leaveDays = Leave::where('employee_id',$employee->id)
                                ->whereBetween('start_day',[$startDay,$endDay])
                                ->count();
            /*Calculate Absent*/
            $absent = $noOfDaysInMonth-($totalAttended+$leaveDays+$holidays);
            /*Get number of Late attended days*/
            $lateCount = Attendance::where('employee_id',$employee->id)
                                ->whereBetween('date',[$startDay,$endDay])
                                ->where('let_time','!=','00:00:00')
                                ->count();
            /*Get Employee's Salary Structure*/
            $salaryStructure = SalaryStructure::where('employee_id',$employee->id)->first();

            if($employee->type ==1){
                if(!$absent && $lateCount<3){
                    $bonusSetting = Setting::where('string','attendance_bonus')->first();
                    $attendanceBonus = $bonusSetting->value;
                }else{
                    $attendanceBonus= 0;
                }
            }else {
                $attendanceBonus = 0;
            }
            return $lateCount;

        }

        return $noOfDaysInMonth;
    }
}
