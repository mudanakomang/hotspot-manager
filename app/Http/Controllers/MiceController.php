<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;
use Mail;


class MiceController extends Controller
{

    public function approvestore($id)
    {
        $created = Carbon::parse($id)->format('Y-m-d H:i:s');
        $end = DB::table('mice')
            ->where('created', '=', $created)
            ->value('end');
        DB::table('mice')
            ->where('created', '=', $created)
            ->update(['approved' => '1', 'end' => Carbon::parse($end)->addMinutes(15)]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'MICE Activated successfully'
        ]);
        return redirect('mice');
    }

    public function activatepost($id)
    {
        $created = Carbon::parse($id)->format('Y-m-d H:i:s');
        $mice = DB::table('mice')
            ->where('created', '=', $created)
            ->get();
        if ($mice[0]->approved == '1') {
            $diff = Carbon::parse($mice[0]->start)->diffInSeconds(\Carbon\Carbon::parse($mice[0]->end));
            if ($mice[0]->status <> 1) {
                DB::table('mice')
                    ->where('created', '=', $created)
                    ->update(['status' => '1']);
                DB::table('radusergroup')
                    ->where('username', '=', $mice[0]->username)
                    ->delete();
                DB::table('radcheck')
                    ->insert([
                        ['username' => $mice[0]->username, 'attribute' => 'Cleartext-Password', 'op' => ':=', 'value' => $mice[0]->password],
                        ['username' => $mice[0]->username, 'attribute' => 'Simultaneous-Use', 'op' => ':=', 'value' => $mice[0]->number],
                        ['username' => $mice[0]->username, 'attribute' => 'Expiration', 'op' => ':=', 'value' => Carbon::parse($mice[0]->end)->format('d M Y H:i')]
                    ]);

                DB::table('radreply')
                    ->insert([
                        ['username' => $mice[0]->username, 'attribute' => 'Acct-Interim-Interval', 'op' => ':=', 'value' => '30'],
                        ['username' => $mice[0]->username, 'attribute' => 'Mikrotik-Rate-Limit', 'op' => ':=', 'value' => $mice[0]->service]
                    ]);

            }
            session()->flash('flash', [
                'level' => 'success',
                'message' => 'MICE Activated successfully'
            ]);
            return redirect('mice');
        }
    }

    public function approve($id)
    {
        $created = Carbon::parse($id)->format('Y-m-d H:i:s');
        $mice = DB::table('mice')
            ->where('created', '=', $created)
            ->get();
        $user = Auth::user();
        $page_title = 'Activate MICE';
        return view('mice.approve')->with(compact('user', 'page_title', 'id', 'mice'));
    }

    public function delete($id)
    {

        $online = DB::select(DB::raw('select username,framedipaddress from radacct where username in (select username from mice where id=\'' . $id . '\')'));

        foreach ($online as $key => $value) {
            $line = "#bin/bash/\n";
            $file = fopen('disconnect.sh', 'w');
            fwrite($file, $line);

            $command = 'ssh root@10.10.1.4 "echo "User-Name=' . $value->username . ',Framed-IP-Address=' . $value->framedipaddress . '" | radclient -x 10.10.1.1:3799 disconnect testing123"' . PHP_EOL;
            fwrite($file, $command);

            fclose($file);

            exec('chmod +x disconnect.sh');


            echo shell_exec("sh ./disconnect.sh");

        }

        $username = DB::table('mice')
            ->where('id', '=', $id)
            ->select('username')
            ->get();
        foreach ($username as $value) {
            DB::table('radcheck')
                ->where('username', '=', $value->username)
                ->delete();

            DB::table('radreply')
                ->where('username', '=', $value->username)
                ->delete();
            DB::table('radusergroup')
                ->where('username', '=', $value->username)
                ->delete();

        }
        DB::table('mice')
            ->where('id', '=', $id)
            ->delete();

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'MICE deleted successfully'
        ]);
        return redirect('mice');
    }

    public function index()
    {
        $data = DB::select(DB::raw('select * from mice'));
        $user = Auth::user();
        $page_title = 'MICE List';
        return view('mice.index')->with(compact('user', 'page_title', 'data'));
    }

    public function add()
    {
        $user = Auth::user();
        $page_title = 'Add MICE';
        return view('mice.add')->with(compact('user', 'page_title'));
    }

    public function addstore(Request $request)
    {
        $start = Input::get('from');
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'password' => array('required', 'NotIn:bali,kuta,rama,ramayana', 'Min:6', 'alpha_num'),
            'num' => 'required|numeric',
            'to' => 'after:' . $start . '',
        ]);
        $name = Input::get('name');
        $username = Input::get('username');
        $password = Input::get('password');
        $from = Carbon::parse(Input::get('from'));
        $to = Carbon::parse(Input::get('to'));
        $service = Input::get('service');
        $num = Input::get('num');
        $now = Carbon::now('Asia/Makassar')->format('Ymdhis');
        DB::table('mice')
            ->insert(['name' => $name, 'username' => $username, 'password' => $password, 'number' => $num, 'start' => $from, 'end' => $to, 'created' => $now, 'service' => $service]);

        DB::table('radusergroup')
            ->insert(['username' => $username, 'groupname' => 'daloRADIUS-Disabled-Users', 'priority' => '0']);


        $content = array(
            'mice_name' => $name,
            'from' => $from,
            'to' => $to,
            'num' => $num,
            'link' => 'http://10.10.1.3/hotspot-manager/public/mice/' . $now . '/approve',
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,

        );

        Mail::send('email.mice', $content, function ($message) {
            $email = Auth::user();
            $to_email = 'it6.support@rcoid.com';
            $message->from($email->email, $email->name);
            $message->to($to_email);
            $message->subject('MICE Request');
            $message->cc('it.sysdev@rcoid.com');
        });

        DB::table('logs')
            ->insert(['action' => 'Create', 'action_by' => Auth::user()->name, 'description' => 'Create MICE Event ' . $name . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'MICE ' . $name . ' added successfully'
        ]);
        return redirect('mice');
    }


}
