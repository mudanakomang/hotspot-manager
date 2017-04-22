<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
use Illuminate\Support\Facades\Input;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function restepassPost(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'password_confirmation' => 'required|min:6|same:password'
        ]);

        $old_pass = Input::get('pass');
        if (Hash::check(Input::get('password'), $old_pass)) {

            session()->flash('flash', [
                'level' => 'warning',
                'message' => 'Password not changed'
            ]);
            return redirect('guestinhouse');
        } else {
            DB::table('users')
                ->where('id', '=', Input::get('id'))
                ->update(['password' => Hash::make(Input::get('password'))]);

            DB::table('logs')
                ->insert(['action' => 'Update', 'action_by' => Auth::user()->name, 'description' => 'Reset Password of ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'Password updated'
            ]);
            return redirect('guestinhouse');
        }
    }


    public function restepass($id)
    {
        $email = Auth::user()->email;
        $user = Auth::user();
        $page_title = 'Reset Password';
        $pass = Auth::user()->password;
        return view('user.resetpass')->with(compact('pass', 'id', 'email', 'user', 'page_title'));
    }

    public function useradd()
    {
        $user = Auth::user();
        $page_title = 'Add Administrator';
        $ops = User::all();
        $first = DB::table('roles')
            ->select('id', 'name');
        $sec = DB::table('roles')
            ->join('role_user', 'role_user.role_id', '=', 'roles.id')
            ->join('users', 'users.id', '=', 'role_user.user_id')
            ->select('roles.id', 'roles.name')
            ->union($first)
            ->pluck('name', 'id');


        return view('user.add')->with(compact('user', 'page_title', 'ops', 'sec'));

    }

    public function userstore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'pass' => 'required'
        ]);
        $name = Input::get('name');
        $email = Input::get('email');
        $pass = bcrypt(Input::get('pass'));
        $role = Input::get('role');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $pass,

        ]);
        $user->attachRole($role);

        DB::table('logs')
            ->insert(['action' => 'Insert', 'action_by' => Auth::user()->name, 'description' => 'Add new Administrator ' . $name . ' with role ' . $role . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Administrator added successfully'
        ]);

        return redirect('user/manage');
    }

    public function index()
    {
        $user = Auth::user();
        $page_title = 'Administrator List';
        $operator = DB::select(DB::raw('select users.id,users.name,email,roles.name as role from users
left join role_user on role_user.user_id=users.id
left join roles on roles.id=role_user.role_id'));
        $rolecount = DB::select(DB::raw('select count(roles.name) as rolecount from users
left join role_user on role_user.user_id=users.id
left join roles on roles.id=role_user.role_id where roles.name=\'master\''));
        $count = $rolecount[0]->rolecount;

        return view('user.index')->with(compact('user', 'operator', 'page_title', 'count'));

        // return view('user.index')->with(compact('user', 'page_title', 'operator'));
    }

    public function showedit($id)
    {
        $user = Auth::user();
        $page_title = 'Edit Administrator';
        $ops = User::find($id);
        $first = DB::table('roles')
            ->select('id', 'name');
        $sec = DB::table('roles')
            ->join('role_user', 'role_user.role_id', '=', 'roles.id')
            ->join('users', 'users.id', '=', 'role_user.user_id')
            ->where('user_id', '=', $id)
            ->select('roles.id', 'roles.name')
            ->union($first)
            ->pluck('name', 'id');


        return view('user.edit')->with(compact('user', 'page_title', 'ops', 'sec'));
    }

    public function storeedit(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
        ]);
        $user = User::find($id);
        $user->update($request->all());

        $role = Input::get('role');

        DB::table('role_user')
            ->where('user_id', '=', $id)
            ->delete();
        $user->attachRole($role);

        DB::table('logs')
            ->insert(['action' => 'Update', 'action_by' => Auth::user()->name, 'description' => 'Edit Administrator ' . $user->name . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Administrator updated successfully'
        ]);

        return redirect('user/manage');
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        DB::table('role_user')
            ->where('user_id', '=', $id)
            ->delete();
        User::destroy($id);

        DB::table('logs')
            ->insert(['action' => 'Delete', 'action_by' => Auth::user()->name, 'description' => 'Delete Administrator ' . $user->name . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);


        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Administrator  deleted successfully'
        ]);

        return redirect('user/manage');
    }
}
