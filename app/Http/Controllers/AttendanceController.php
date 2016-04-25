<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Attendance;
use App\Model\Employee;
use App\Model\Setting;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filter = \DataFilter::source(Attendance::with('employees'));

        $filter->add('employees.employee_id','Employee','tags');
        //$filter->add('date','date','date')->format('Y:M:D');
      
        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        $grid = \DataGrid::source($filter);

        $grid->add('id','S_No', true)->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart; 
            return ($pageNumber-1)*20 +$serialStart;
        });
        
        $grid->add('{{$employees->employee_id}}','Employee');    
        $grid->add('date','Date',true);
        $grid->add('in_time','In Time',true);
        $grid->add('out_time','Out Time',true);
        $grid->add('duration','Duration',true);
        $grid->add('overtime','Overtime',true);
        $grid->add('let_time','Let Time',true);


        $grid->edit('attendance/edit', 'Action','show|modify');
        $grid->link('attendance/edit',"New Attendance", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('date','DESC');
        
        $grid->paginate(20);


        return  view('attendance.index', compact('grid','filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('attendance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|max:2000|mimes:csv,txt',
        ]);

        $destinationPath = 'uploads/attendance/'.date('d-m-Y');

        $file = fopen($request->file('file')->getRealPath(),'r');


            $results =[];
            $bufferTime =  Setting::where('string','attendance_buffer_time')->first();
            $office_opening_time = Setting::where('string','office_opening_time')->first();
            $office_duration_time = Setting::where('string','office_duration_time')->first();

            while(! feof($file))
            {
                $line = fgets($file);
                $line1 = $line;
                $flag =false;
                $line = str_replace("\t",' ',$line);

                $attRecord = array_values(array_filter(explode(" ",$line)));
                // echo "<pre>";
                // print_r($attRecord);
                // echo "</pre>";

                if (count($attRecord)>=8) {
                    $employee =Employee::where('employee_id',$attRecord[0])->first();

                    if(!empty($employee)){
                        $attendance = Attendance::where(['employee_id'=>$employee->id,'date'=>$attRecord[1]])->first();
                        if (!empty($attendance))
                        {

                            $attendance->out_time = $attRecord[2];
                            $attendance->duration = durationCalc($attendance->in_time,$attendance->out_time);
                            

                            $attendance->overtime = overtimeCalc($attendance->duration, $office_duration_time->value);
                            if($attendance->save()){
                                $flag = true;
                            }

                        } else{
                            
                            $attendance = new Attendance();
                            $attendance->employee_id= $employee->id;
                            $attendance->in_time = $attRecord[2];
                            $attendance->date = $attRecord[1];
                            
                            
                            $attendance->let_time = lateTimeCalc($attendance->in_time, $bufferTime->value, $office_opening_time->value);
                            if($attendance->save()){
                                $flag = true;
                            }
                        }
                    }
                } 
                

                $results[$line1] = $flag;
            }

            $name = $request->file('file')->getClientOriginalName();
            $fileName = rand('1111','9999').'_'.$name;
            $request->file('file')->move($destinationPath, $fileName);

            \Session::flash('system_message', 'Upload successfully');



        return view('attendance.message', compact('results'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $flag = false;

        if (!empty(\Input::get('insert'))) {
            $flag = true;
        } else if(!empty(\Input::get('update'))) {
            $flag = true;
        } else {
            $flag = false;
        }

        if($flag){
            
            $date = Carbon::createFromFormat('d/m/Y', $request->date)->toDateString('Y-m-d');
            
            $attendance = Attendance::where(['employee_id'=>$request->employee_id, 'date'=>$date])->get();

            if (!$attendance->isEmpty()) {
                
                $attendance = $attendance->first();
                
                $attendance->in_time = $request->in_time;
                $attendance->out_time = $request->out_time;
                $attendance->duration = $request->duration;
                $attendance->employee_id = $request->employee_id;
                $attendance->let_time = $request->let_time;
                $attendance->overtime = $request->overtime;
                $attendance->date = $date;
                $attendance->save();
            } else {
                $attendance = new Attendance();
                $attendance->in_time = $request->in_time;
                $attendance->out_time = $request->out_time;
                $attendance->duration = $request->duration;
                $attendance->employee_id = $request->employee_id;
                $attendance->let_time = $request->let_time;
                $attendance->overtime = $request->overtime;
                $attendance->date = $date;
                $attendance->save();
            }
            
           //$attendance->save();
            return redirect('/attendance');
        }

        

        $settings = Setting::whereIn('string', [   
                                                'office_duration_time',
                                                'office_opening_time',
                                                'office_closing_time',
                                                'attendance_buffer_time'
                                            ])
                            ->get()
                            ->toJson();
        
        $edit = \DataEdit::source(new Attendance());

        $edit->link("attendance","Attendance", "TR",['class' =>'btn btn-primary'])->back();

       $edit->add('employee_id','Employee <span style="color:red;">*</span>','select')
                ->options(Employee::lists("employee_id", "id")->all())
                ->rule('required|exists:employees,id');


        $edit->add('date','Date <span style="color:red;">*</span>', 'text');

        $edit->add('in_time','In Time <span style="color:red;">*</span>', 'text')->rule('required');
        $edit->add('out_time','Out Time <span style="color:red;">*</span>', 'text');
        $edit->add('duration','Duration <span style="color:red;">*</span>', 'text')->rule('required');
        $edit->add('let_time','Let Time <span style="color:red;">*</span>', 'text')->rule('required');
        $edit->add('overtime','Overtime <span style="color:red;">*</span>', 'text')->rule('required');

        $edit->build();

        return $edit->view('attendance.edit', compact('edit','settings')); 
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

    
}
