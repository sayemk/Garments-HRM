<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Model\Branch;
use App\Model\Organization;
use Illuminate\Http\Request;


class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $grid = \DataGrid::source(Branch::with('organization'));

        $grid->add('id','ID', true);
        $grid->add('name','Branch Name',true); 
       
        $grid->add('{{ $organization->name }}','Oranization','organization_id');
        $grid->add('address','Adress'); 
        $grid->edit('branch/edit', 'Edit','show|modify|delete');
        $grid->link('branch/edit',"New Task", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('name','ASC');
        
        $grid->paginate(10);


        return  view('branch.index', compact('grid'));
    }

    public function edit()
    {
        
        $edit = \DataEdit::source(new Branch());
        $edit->link("branch","Branch", "TR",['class' =>'btn btn-primary'])->back();
        $edit->add('organization_id','Organization <i class="fa fa-asterisk text-danger"></i>','select')
                ->options(Organization::lists("name", "id")->all())
                ->rule('required|exists:organizations,id');
        $edit->add('name','Branch Name <i class="fa fa-asterisk text-danger"></i>', 'text')->rule('required');

        $edit->add('address','Address <i class="fa fa-asterisk text-danger"></i>', 'textarea')->rule('required');
        
        $edit->build();

        return $edit->view('branch.edit', compact('edit')); 
    }

}
