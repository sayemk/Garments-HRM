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
     *
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

        $grid = \DataGrid::source($filter);

        $grid->add('id','S_No', true)->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart;
            return ($pageNumber-1)*10 +$serialStart;
        });

        $grid->add('{{$employee->employee_id}}','Employee');
        $grid->add('month','Month',true);
        $grid->add('year','Year',true);
        $grid->add('gross','Gross',true);
        $grid->add('abs_days','Absent',true);
        $grid->add('net_salary','Net Salary',true);
        $grid->add('ot_amount','OT Amount',true);
        $grid->add('payable','Payable',true);
        $grid->add('adv_amount','Advance',true);
        $grid->add('stamp','Stamp',true);
        $grid->add('net_paid','Net Paid',true);


        $grid->edit('/salary/register/edit', 'Action','modify');

        $grid->orderBy('year','DESC');

        $grid->paginate(20);


        return  view('salary.register.index', compact('grid','filter'));
    }

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

                $ot_amount = floor($ot_hour * $salaryStructure->ot_rate);

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

                $salaryRegister->days_of_month = $noOfDaysInMonth;
                $salaryRegister->present_days = $totalAttended;
                $salaryRegister->no_holidays = $holidays;
                $salaryRegister->leave_days = $leaveDays;

                $salaryRegister->save();




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

                $ot_amount = floor($ot_hour * $salaryStructure->ot_rate);

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

                $salaryRegister->days_of_month = $noOfDaysInMonth;
                $salaryRegister->present_days = $totalAttended;
                $salaryRegister->no_holidays = $holidays;
                $salaryRegister->leave_days = $leaveDays;

                $salaryRegister->save();


            }
        }

        return redirect()->back();
    }

    public function edit(){
        $edit = \DataEdit::source(new SalaryRegister());

        $edit->link("salary/register","Salary Register", "TR",['class' =>'btn btn-primary'])->back();

        $edit->add('employee_id','Employee <span style="color:red;">*</span>','select')
            ->options(Employee::lists("employee_id", "id")->all())
            ->mode('readonly');


        $edit->add('month','Month <span style="color:red;">*</span>', 'text')->mode('readonly');
        $edit->add('year','Year <span style="color:red;">*</span>', 'text')->mode('readonly');

        $edit->add('adv_amount','Advance ', 'text');
        $edit->add('net_paid','Net Paid', 'text');


        $edit->build();

        return $edit->view('salary.register.edit', compact('edit'));
    }
}
