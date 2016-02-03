<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\Setting;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
         $grid = \DataGrid::source('settings');

        $grid->add('id','S_No', true)->cell(function($value, $row){
            $pageNumber = (\Input::get('page')) ? \Input::get('page') : 1;

            static $serialStart =0;
            ++$serialStart; 
            return ($pageNumber-1)*10 +$serialStart;

        });
        $grid->add('string','String',true); 
        $grid->add('value','value',true); 
       
        
        $grid->edit('setting/edit', 'Edit','modify');
        $grid->link('setting/edit',"New Settings", "TR",['class' =>'btn btn-success']);
        //$grid->orderBy('name','ASC');
        
        $grid->paginate(10);


        return  view('setting.index', compact('grid'));
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
    public function edit()
    {
         
        $edit = \DataEdit::source(new Setting());
        $edit->link("setting","Manage Setting", "TR",['class' =>'btn btn-primary'])->back();
        
        $edit->add('string','string<i class="fa fa-asterisk text-danger"></i>', 'text')->rule('required');
        $edit->add('value','Value<i class="fa fa-asterisk text-danger"></i>', 'text')->rule('required');
        
        $edit->build();

        return $edit->view('setting.edit', compact('edit')); 
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
