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
            if($employee->status == 1)
            {
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
                /*Calculate OT HOUR*/
                $ot_hour = $attendances->sum('overtime');

                $ot_amount = $ot_hour * $salaryStructure->ot_rate;

                $salaryPerDay = $salaryStructure->basic/$noOfDaysInMonth;

                $absentDeduction = $salaryPerDay*$absent;

                $salaryRegister = new SalaryRegister();

                $salaryRegister->employee_id = $employee->id;
                $salaryRegister->salary_structure_id = $salaryStructure->id;
                $salaryRegister->basic = $salaryStructure->basic;
                $salaryRegister->house_rent = $salaryStructure->house_rent;
                $salaryRegister->m_a = $salaryStructure->m_a;
                $salaryRegister->f_a = $salaryStructure->f_a;
                $salaryRegister->t_a = $salaryStructure->t_a;
                $salaryRegister->gross = $salaryStructure->gross;
                $salaryRegister->abs_days = $absent;
                $salaryRegister->abs_deduction = $absentDeduction;
                $salaryRegister->net_salary = $salaryStructure->gross - $absentDeduction;
                $salaryRegister->att_bonus = $attendanceBonus;
                $salaryRegister->ot_rate = $salaryStructure->ot_rate;
                $salaryRegister->ot_hours = $ot_hour;
                $salaryRegister->ot_amount = $ot_amount;
                $salaryRegister->payable = $salaryRegister->net_salary+$attendanceBonus+$ot_amount;
                $salaryRegister->adv_amount = 0;
                $salaryRegister->stamp =10;
                $salaryRegister->net_paid=0;
                $salaryRegister->month = $request->month;
                $salaryRegister->year = $request->year;

                $salaryRegister->save();

                echo 'if===';


            } else{
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
                /*Calculate OT HOUR*/
                $ot_hour = $attendances->sum('overtime');

                $ot_amount = $ot_hour * $salaryStructure->ot_rate;

                $salaryPerDay = $salaryStructure->gross/$noOfDaysInMonth;

                $absentDeduction = 0;

                $salaryRegister = new SalaryRegister();

                $salaryRegister->employee_id = $employee->id;
                $salaryRegister->salary_structure_id = $salaryStructure->id;
                $salaryRegister->basic = $salaryStructure->basic;
                $salaryRegister->house_rent = $salaryStructure->house_rent;
                $salaryRegister->m_a = $salaryStructure->m_a;
                $salaryRegister->f_a = $salaryStructure->f_a;
                $salaryRegister->t_a = $salaryStructure->t_a;
                $salaryRegister->gross = $salaryStructure->gross;
                $salaryRegister->abs_days = $absent;
                $salaryRegister->abs_deduction = $absentDeduction;
                $salaryRegister->net_salary = $salaryPerDay*$totalAttended;
                $salaryRegister->att_bonus = $attendanceBonus;
                $salaryRegister->ot_rate = $salaryStructure->ot_rate;
                $salaryRegister->ot_hours = $ot_hour;
                $salaryRegister->ot_amount = $ot_amount;
                $salaryRegister->payable = $salaryRegister->net_salary+$attendanceBonus+$ot_amount;
                $salaryRegister->adv_amount = 0;
                $salaryRegister->stamp =10;
                $salaryRegister->net_paid=0;
                $salaryRegister->month = $request->month;
                $salaryRegister->year = $request->year;

                $salaryRegister->save();

                echo  $totalAttended;
                echo "==else===";
            }
        }

        return $noOfDaysInMonth;
    }
}
