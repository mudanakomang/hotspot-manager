<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Input;

class LogController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $page_title = 'Activity Logs';
        $logs = DB::table('logs')
            ->get();
        return view('logs.index')->with(compact('user', 'page_title', 'logs'));
    }

    public function groupcheck(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required',
        ]);
        $act = Input::get('action');
        if ($act == 'Delete') {
            $ids = array_unique(Input::get('ids'));
            foreach ($ids as $key => $id) {
                DB::table('logs')
                    ->where('id', '=', $id)
                    ->delete();
            }
        }
        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Selected Logs Deleted Successfully !!'
        ]);


        return redirect('logs');
    }

    public function delete($id)
    {
        DB::table('logs')
            ->where('id', '=', $id)
            ->delete();

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Selected Logs Deleted Successfully !!'
        ]);


        return redirect('logs');
    }
}
