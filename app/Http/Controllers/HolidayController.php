<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Holiday;
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
        $query = \DB::table('holidays');
        $filter = \DataFilter::source($query);

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
            return ($pageNumber-1)*10 +$serialStart;

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
        

        $grid->edit('holiday/edit', 'Action','show|modify');
        $grid->link('holiday/edit',"New Holiday", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('year','DESC');
        
        $grid->paginate(10);


        return  view('leave.holiday.index', compact('grid', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
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
    public function destroy($id)
    {
        //
    }
}
