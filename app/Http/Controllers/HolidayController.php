<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Holiday;
use App\Model\Setting;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return LeaveEmployee::with('leaveType')->get();
        //$query = \DB::table('holidays');
        $filter = \DataFilter::source(Holiday::where(function($query){
            if(!empty(\Input::get('year'))){
                return $query->where('year', \Input::get('year'));
            } else {
                return $query->where('year', date('Y'));
            }
        }));

        $filter->add('year','Year','date')->format('Y');
        $filter->add('type','Type','select')
            ->options([''=>'Select Type','1'=>'Weekly','2'=>'Government']);
                
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
        
        $grid->add('name','Name');    
        $grid->add('date','Date',true);
        $grid->add('year','Year',true);
        $grid->add('type','Leave Type',true)->cell(function($value){
            if ($value==1) {
                return 'Weekly';
            } else {
                return 'Government';
            }
            
        });
        
        $grid->edit('holiday/destroy', 'Action','delete');
        $grid->link('holiday/create',"New Holiday", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('year','DESC');

        $grid->paginate(20);


        return  view('leave.holiday.index', compact('grid', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leaveType = Holiday::leaveType();
        return view('leave.holiday.create', compact('leaveType'));
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
            'holiday_type' => 'required',
            'name' => 'required|max:100',
            'year' => 'required|numeric',
            'date' =>'required_if:holiday_type,2'
        ]);

        if($request->holiday_type=='1'){

            $weekly_holiday_year = Holiday::where(['year'=>$request->year, 'type' => $request->holiday_type])->count();
           
            if ($weekly_holiday_year) {
                $request->session()->flash('system_message', 'The Weekend Holidays are already created for this year! '.$request->year);
                return redirect('holiday/create')
                          ->withInput();
            }

            $weekly_holiday = Setting::where('string','weekly_holiday')->get();

            $days =  getDaysInaYear($request->year, $weekly_holiday[0]->value, 'Y-m-d','Asia/Dhaka');
            
            $extra = ['name'=>$request->name,'year'=>$request->year,'type'=>$request->holiday_type];

            $holidays =[];

            foreach ($days as $day) {
                $holidays[] = array_merge($extra,$day);
            }

           // return $holidays;
            Holiday::insert($holidays);

            $request->session()->flash('system_message', 'The Weekend Holidays are created successfully for this year! '.$request->year);
            
        } else {

            $holiday = new Holiday();
            $holiday->name = $request->name;
            $holiday->type = $request->holiday_type;
            $holiday->year = $request->year;
            $holiday->date =  $request->date;

            if ($holiday->save()) {
                $request->session()->flash('system_message', 'The Government Holiday is created successfully for this date! '.$request->date);
            } else {
                $request->session()->flash('system_message', 'Fail to create Government holiday! Please Try again.');
            }
        }

        return redirect('holiday/create');
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
    public function destroy(Request $request)
    {
        $holiday = Holiday::find($request->delete);
        if($holiday->delete()){
            $request->session()->flash('system_message', "Holiday Deleted Successfully");
            return redirect('holiday');
        } else {
            $request->session()->flash('system_message', "Fail! to delete Holiday");
            return redirect('holiday');
        }
    }
}
