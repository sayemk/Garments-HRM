<?php

namespace App\Http\Controllers;

use App\Model\Attendance;
use App\Model\Employee;
use App\Model\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $employeePresents = Attendance::where('date',date('Y-m-d'))->count();
        $totalActiveEmployees = Employee::where('status','!=',3)->count();
        $newStaffs = Employee::where('status',2)->where('type',2)->count();
        $permanentStaffs = Employee::where('status',1)->where('type',2)->count();
        $resignedStaffs = Employee::where('status',3)->where('type',2)->count();
        $newWorkers = Employee::where('status',2)->where('type',1)->count();
        $permanentWorkers = Employee::where('status',1)->where('type',1)->count();
        $resignedWorkers = Employee::where('status',3)->where('type',1)->count();

        $totalResignedEmployees = Employee::where('status','=',3)->count();

        $totalHolidays = Holiday::where('year',date('Y'))->count();
        $startDay = new Carbon('first day of '.date('M').' '.date('Y') );
        $endDay = new Carbon('last day of '.date('M').' '.date('Y') );
        $totalHolidayInMonth = Holiday::whereBetween('date',[$startDay,$endDay])->count();

        return view('dashboard.index', compact('employeePresents','resignedWorkers',
            'totalActiveEmployees','newStaffs','permanentStaffs','resignedStaffs',
            'newWorkers','permanentWorkers','totalResignedEmployees','totalHolidays','totalHolidayInMonth'
        ));
    }
}
