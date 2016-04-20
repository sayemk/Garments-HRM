<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aginev\Acl\Http\Models\Role as Role;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function getIndex()
    {


        $filter = \DataFilter::source(User::with('role'));
        $filter->add('id','User ID', 'text')->clause('where')->operator('=');
        $filter->add('email','email', 'text');
        // $filter->add('user_id','Assign To','select')
        //             ->options(User::lists('id','name'));

        $filter->submit('search');
        $filter->reset('reset');
        $filter->build();

        $grid = \DataGrid::source($filter);

        $grid->add('id','ID', true);
        $grid->add('name','Name',true);

        $grid->add('{{ $role->role_title }}','Role','role_id');

        $grid->add('email','Email',true);

        $grid->edit('user/edit', 'Edit','modify|delete');

        $grid->link('user/edit',"New User", "TR",['class' =>'btn btn-success']);
        $grid->orderBy('id','desc');

        $grid->paginate(10);

        return  view('auth.index', compact('grid','filter'));
    }

    public function anyEdit()
    {
        if (\Input::get('do_delete')==1) return  "Don't try to delete admin";

        $edit = \DataEdit::source(new User());
        $edit->label('Edit/Create User');
        $edit->link("user","User List", "TR",['class' =>'btn btn-success'])->back();
        $edit->add('name','Name', 'text')->rule('required');

        $edit->add('email','Email','text')->rule('required|email');
        $edit->add('password','Password', 'password')->rule('required|min:6|confirmed');
        $edit->add('password_confirmation','Confirm Password', 'password')->rule('required|min:6');

        $edit->add('role_id','Role','select')
            ->options(Role::lists("role_title", "id")->all())
            ->rule('required|exists:roles,id');


        $edit->build();

        return $edit->view('auth.register', compact('edit'));

    }

    public function userList()
    {
        return User::where("name","like", '%'.\Input::get("q")."%")
            ->take(10)
            ->get();
    }

    public function getTask()
    {
        $task =  \App\Task::where(function($query){
            $query->where('user_id', \Auth::user()->id)
                ->where('status', 1);

        })->get();

        return response()->json(['status' => '1', 'data' => ['count'=>$task->count(), 'tasks'=>$task]]);
    }
}
