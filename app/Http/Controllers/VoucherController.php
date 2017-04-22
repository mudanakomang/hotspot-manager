<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Voucher;
use Illuminate\Support\Facades\Input;
use DB;
use session;
use App\Http\Controllers\GuestInHouseController;


class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function expireduser($n)
    {
        $user = Auth::user();
        $page_title = 'Expired User';

        $users = DB::table('expired')
            ->where('voucher', '=', $n)
            ->select('id', 'username', 'type', 'created', 'status')
            ->get();
        return view('voucher.expireduser')->with(compact('user', 'page_title', 'users'));
    }

    public function expiredvoucher()
    {
        $user = Auth::user();
        $page_title = 'Expired Voucher';

        $group = DB::table('expired')
            ->select('voucher')
            ->groupBy('voucher')
            ->get();
        return view('voucher.expired')->with(compact('user', 'page_title', 'group'));
    }

    public function details($username)
    {
        $user = Auth::user();
        $page_title = 'Details ' . $username;
        $details = DB::select(DB::raw('select b.maxs,assigned, radacct.username,a.groups, concat(round(sum(acctoutputoctets)/1048576,2),\' Mb\') as download,  concat(round(sum(acctinputoctets)/1048576,2),\' Mb\') as upload, concat(round((sum(acctinputoctets)+sum(acctoutputoctets))/1048576,2),\' Mb\') as total from radacct
left join (select username,assigned,voucher_user.group as groups from voucher_user) a on a.username=radacct.username
left join (select max(acctstarttime) as maxs,username,callingstationid,framedipaddress from radacct where username=\'' . $username . '\') b on b.username=radacct.username
where radacct.username=\'' . $username . '\''));
        return view('voucher.details')->with(compact('user', 'page_title', 'details'));
    }

    public function searchpost()
    {
        $user = Auth::user();
        $page_title = 'Search Results';
        $username = Input::get('search');
        $lists = DB::select(DB::raw('select a.username as useracct,voucher_user.*
from voucher_user
left join (select acctstoptime,username from radacct) a on a.username=voucher_user.username
where voucher_user.username like \'%' . $username . '%\''));
        $expire = DB::select(DB::raw('select expired.* from expired
where expired.username like \'%' . $username . '%\''));


        if (count($lists) == 0 && count($expire) == 0) {
            session()->flash('flash', [
                'level' => 'danger',
                'message' => 'No Results']);

            return redirect('voucher/searchvoucher');
        } else {
            return view('voucher.searchresults')->with(compact('lists', 'user', 'page_title', 'expire'));
        }
    }


    public function searchvoucher()
    {
        $page_title = 'Search Voucher';
        $user = Auth::user();
        return view('voucher.search')->with(compact('page_title', 'user'));
    }

    public function disable($name)
    {
        $voucher = DB::select(DB::raw('select * from voucher where name=\'' . $name . '\''));
        $num = DB::select(DB::raw('select count(*) as c from voucher_user where voucher=\'' . $name . '\''));

        $exists = DB::select(DB::raw('select voucher_name from voucher_history where voucher_name=\'' . $name . '\''));
        if (count($exists) == 0) {
            foreach ($voucher as $v) {
                DB::table('voucher_history')
                    ->insert(['voucher_name' => $name, 'created' => $v->created, 'status' => 'Expired', 'deleted_by' => null, 'number' => $num[0]->c]);
            }
        }

        $users = DB::table('voucher_user')
            ->where('voucher', '=', $name)
            ->select('username', 'group')
            ->get();
        foreach ($users as $user) {
            $exists = DB::table('expired')
                ->where('voucher', '=', $name)
                ->where('username', '=', $user->username)
                ->select('username')
                ->get();
            if (count($exists) == 0) {
                DB::table('expired')
                    ->where('voucher', '=', $name)
                    ->insert(['voucher' => $name, 'username' => $user->username, 'type' => $user->group, 'created' => Carbon::now('Asia/Makassar'), 'status' => 'Expired']);
            }


            DB::table('radcheck')
                ->where('username', '=', $user->username)
                ->delete();
            DB::table('radusergroup')
                ->where('username', '=', $user->username)
                ->delete();

            DB::table('voucher')
                ->where('name', '=', $name)
                ->update(['status' => '0']);
        }
        session()->flash('flash', [
            'level' => 'success',
            'message' => 'User ' . $name . ' disabled successfully ']);
        return redirect('voucher/voucherlist');

    }

    public function assignstore()
    {
        $id = Input::get('id');
        $user = DB::table('voucher_user')
            ->where('id', '=', $id)
            ->value('username');
        $group = DB::table('voucher_user')
            ->where('id', '=', $id)
            ->value('voucher');
        $room = Input::get('room');
        $checkin = DB::table('checkin')
            ->where('username', '=', $room)
            ->value('status');
        $expire = DB::table('radcheck')
            ->where('username', '=', $room)
            ->where('attribute', '=', 'Expiration')
            ->value('value');
        $us = Input::get('user');
        if ($checkin == '1') {
            $this->activate($id);
            DB::table('voucher_user')
                ->where('id', '=', $id)
                ->update(['assigned' => $room, 'assigned_by' => $us . ' ' . Carbon::now('Asia/Makassar')->format('d M Y H:i'), 'assigned_date' => Carbon::now('Asia/Makassar')]);
            DB::table('radcheck')
                ->insert(['username' => $user, 'attribute' => 'Expiration', 'op' => ':=', 'value' => Carbon::now('Asia/Makassar')->addHours(24)->format('d M Y h:i')]);

            DB::table('logs')
                ->insert(['action' => 'Assign Voucher', 'action_by' => Auth::user()->name, 'description' => 'Assign Voucher ' . $user . ' to room ' . $room . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'User successfully assigned to room'
            ]);
            return redirect('voucher/' . $group . '/listuser');
        } else {
            session()->flash('flash', [
                'level' => 'danger',
                'message' => 'User is not checked In'
            ]);
            return redirect('voucher/' . $group . '/listuser');
        }
    }

    public function activate($id)
    {
        DB::table('voucher_user')
            ->where('id', '=', $id)
            ->update(['status' => '1']);

        $users = DB::select(DB::raw('select voucher.name,voucher.group,username,password from voucher_user
left join voucher on voucher.name=voucher_user.voucher
where voucher_user.id=\'' . $id . '\''));
        $voucher = $users[0]->name;
        $group = $users[0]->group;
        $username = $users[0]->username;
        $password = $users[0]->password;
        DB::table('radcheck')
            ->insert(['username' => $username, 'attribute' => 'User-Password', 'op' => ':=', 'value' => $password]);
        DB::table('radusergroup')
            ->insert(['username' => $username, 'groupname' => $group, 'priority' => '0']);
        return redirect('/voucher/' . $voucher . '/listuser');

    }

    public function assign($id)
    {
        $page_title = 'Assign Username';
        $user = Auth::user();
        $room = DB::table('radcheck')
            ->join('checkin', 'checkin.username', '=', 'radcheck.username')
            ->where('attribute', '=', 'Cleartext-Password')
            ->where('status', '=', '1')
            ->pluck('radcheck.username', 'radcheck.username');

        return view('voucher.assign')->with(compact('user', 'id', 'page_title', 'room'));
    }

    public function activategroup($name)
    {
        $id = DB::select(DB::raw('select id from voucher_user where voucher=\'' . $name . '\' and status=\'0\''));
        foreach ($id as $i) {
            $this->activate($i->id);
        }
        return redirect('voucher/voucherlist');
    }

    public function exdeletevoucher($name)
    {
        DB::table('expired')
            ->where('voucher', '=', $name)
            ->delete();

        DB::table('logs')
            ->insert(['action' => 'Delete', 'action_by' => Auth::user()->name, 'description' => 'Delete Expired Voucher ' . $name . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);


        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Voucher ' . $name . ' Deleted Successfully'
        ]);
        return redirect('voucher/expiredvoucher');
    }

    public function exusercheck(Request $request)
    {
        $this->validate($request, [
            'users' => 'required',
        ]);
        $users = Input::get('users');
        foreach ($users as $id) {
            $this->exdeleteuser($id);
        }
        DB::table('logs')
            ->insert(['action' => 'Delete', 'action_by' => Auth::user()->name, 'description' => 'Delete Expired user ' . implode(',', $user) . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Voucher ' . implode(', ', $users) . ' Deleted Successfully'
        ]);

        return redirect('/voucher/expiredvoucher');
    }

    public function exdeleteuser($id)
    {
        $group = DB::table('expired')
            ->where('username', '=', $id)
            ->value('voucher');

        DB::table('expired')
            ->where('username', '=', $id)
            ->delete();

        DB::table('logs')
            ->insert(['action' => 'Delete', 'action_by' => Auth::user()->name, 'description' => 'Delete Expired user ' . $id . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Voucher ' . $id . ' Deleted Successfully'
        ]);

        return redirect('voucher/' . $group . '/expired');
    }

    public function usercheck(Request $request)
    {

        $this->validate($request, ['users' => 'required']);
        $users = Input::get('users');

        if (Input::get('action') == 'Activate') {
            foreach ($users as $user) {
                $this->activate($user);
            }
            return redirect('voucher/voucherlist');

        } elseif (Input::get('action') == 'Delete') {
            foreach ($users as $user) {
                $this->deleteuser($user);
            }
            return redirect('voucher/voucherlist');
        }

    }

    public function deleteuser($id)
    {

        $user = DB::table('voucher_user')
            ->where('id', '=', $id)
            ->value('username');
        $type = DB::table('voucher_user')
            ->where('id', '=', $id)
            ->value('group');

        $acct = DB::select(DB::raw('select username, framedipaddress from radacct where username in (select username from voucher_user where id=\'' . $id . '\') '));
        if (count($acct) != null) {
            $d = new GuestInHouseController();
            $d->disconnect($user, $acct[0]->framedipaddress);
        }
        $v = DB::table('voucher_user')
            ->where('id', '=', $id)
            ->value('voucher');

        DB::table('expired')
            ->insert(['voucher' => $v, 'username' => $user, 'type' => $type, 'created' => Carbon::now('Asia/Makassar'), 'status' => 'deleted']);
        DB::table('radcheck')
            ->where('username', '=', $user)
            ->delete();
        DB::table('radusergroup')
            ->where('username', '=', $user)
            ->delete();
        DB::table('voucher_user')
            ->where('username', '=', $user)
            ->delete();

        DB::table('logs')
            ->insert(['action' => 'Delete User', 'action_by' => Auth::user()->name, 'description' => 'Delete User ' . $user . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);


        session()->flash('flash', [
            'level' => 'success',
            'message' => 'User ' . $user . ' successfully deleted ']);
        return redirect('voucher/' . $v . '/listuser');
    }

    public function voucherhistory()
    {
        $user = Auth::user();
        $page_title = 'Voucher History';
        $list = DB::select(DB::raw('select * from voucher_history
        left join (select count(username) as num, voucher from expired group by voucher) a on a.voucher=voucher_history.voucher_name'));
        return view('voucher.history')->with(compact('user', 'page_title', 'list'));
    }

    public function deletevoucher($name)
    {
        $num = DB::select(DB::raw('select count(*) as c from voucher_user where voucher=\'' . $name . '\''));
        $existsv = DB::table('voucher_history')
            ->where('voucher_name', '=', $name)
            ->select('voucher_name')
            ->get();
        if (count($existsv) == 0) {
            DB::table('voucher_history')
                ->insert(['voucher_name' => $name, 'created' => Carbon::now('Asia/Makassar'), 'status' => 'Deleted', 'deleted_by' => Auth::user()->name, 'number' => $num[0]->c]);
        }
        $users = DB::table('voucher_user')
            ->where('voucher', '=', $name)
            ->select('username', 'group')
            ->get();
        foreach ($users as $user) {
            $exists = DB::table('expired')
                ->where('voucher', '=', $name)
                ->where('username', '=', $user->username)
                ->select('username')
                ->get();
            if (count($exists) == 0) {
                DB::table('expired')
                    ->where('voucher', '=', $name)
                    ->insert(['voucher' => $name, 'username' => $user->username, 'type' => $user->group, 'created' => Carbon::now('Asia/Makassar'), 'status' => 'Deleted']);
            }
            DB::table('radcheck')
                ->where('username', '=', $user->username)
                ->delete();
            DB::table('radusergroup')
                ->where('username', '=', $user->username)
                ->delete();
        }
        DB::table('voucher_user')
            ->where('voucher', '=', $name)
            ->delete();
        DB::table('voucher')
            ->where('name', '=', $name)
            ->delete();

        DB::table('logs')
            ->insert(['action' => 'Delete', 'action_by' => Auth::user()->name, 'description' => 'Delete Voucher ' . $name . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);


        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Voucher ' . $name . ' Deleted Successfully'
        ]);

        return redirect('voucher/voucherlist');
    }

    public function listuserexp($v)
    {
        $user = Auth::user();
        $page_title = 'Expired/Deleted Voucher List';
        $lists = DB::select(DB::raw('select * from expired'));
        return view('voucher.listexp')->with(compact('user', 'page_title', 'lists'));
    }

    public function listuser($v)
    {
        $user = Auth::user();
        $page_title = 'Voucher List';
        $listuser = DB::select(DB::raw('select a.username as useracct,voucher_user.*,radcheck.value
from voucher_user
left join (select acctstoptime,username from radacct) a on a.username=voucher_user.username
left join radcheck on radcheck.username=voucher_user.username and  radcheck.attribute=\'Expiration\'
where voucher=\'' . $v . '\'  group by username '));
        $vgroup = DB::table('voucher')
            ->where('name', '=', $v)
            ->value('group');

        return view('voucher.listuser')->with(compact('user', 'page_title', 'listuser', 'vgroup'));
    }

    public function voucherstore(Request $request)
    {
        $this->validate($request, [

            'num' => 'required|alpha_num|digits_between:1,500',
        ]);

        $str = '123456789abcdefghjkmnpqrstuvwxyz';
        $desc = Input::get('description');
        $group = Input::get('group');
        $created = Carbon::now('Asia/Makassar');
        $valid = Carbon::now('Asia/Makassar')->addDays(180);
        $user = Auth::user();
        $num = (int)Input::get('num');

        DB::table('voucher')
            ->insert([
                'name' => $group . '-' . $created->format('Ymdhi'),
                'group' => $group,
                'status' => '1',
                'description' => $desc,
                'created' => $created,
                'valid' => $valid,
                'expired' => '0',
                'createdby' => $user->name

            ]);


        for ($i = 0; $i < $num; $i++) {

            $rand = substr(str_shuffle($str), 0, 6);
            $rand1 = substr(str_shuffle($str), 0, 6);
            if ($group == 'GuestInHouse') {
                DB::table('voucher_user')
                    ->insert([
                        'voucher' => $group . '-' . $created->format('Ymdhi'),
                        'username' => (string)$rand,
                        'password' => (string)$rand1,
                        'group' => $group,
                        'status' => '0',
                        'assigned' => 'None'
                    ]);
            } else {
                DB::table('voucher_user')
                    ->insert([
                        'voucher' => $group . '-' . $created->format('Ymdhi'),
                        'username' => (string)$rand,
                        'password' => (string)$rand,
                        'group' => $group,
                        'status' => '0',
                        'assigned' => 'None'
                    ]);
                $id = DB::table('voucher_user')
                    ->where('username', '=', $rand)
                    ->value('id');
                $this->activate($id);
            }
        }

        DB::table('logs')
            ->insert(['action' => 'Create', 'action_by' => Auth::user()->name, 'description' => 'Create Voucher ' . $group . '-' . $created->format('Ymdhi') . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Voucher successfully created'
        ]);
        return redirect('voucher/voucherlist');
    }

    public function addvoucher()
    {
        $user = Auth::user();
        $page_title = 'Add Batch Voucher';
        $model = Voucher::all();
        return view('voucher.add')->with(compact('user', 'page_title', 'model'));
    }

    public function voucherlist()
    {
        $user = Auth::user();
        $page_title = 'Batch Voucher List';
        $list = DB::select(DB::raw('select voucher.*,c.total,d.used,e.unused  from voucher
left join (select voucher,count(status) as total from voucher_user  group by voucher) c on c.voucher=voucher.name
left join (select voucher,count(username) as used from voucher_user where username in (select username from radacct) group by voucher) d on d.voucher=voucher.name
left join (select voucher,count(username) as unused from voucher_user where username not in (select username from radacct) group by voucher) e on e.voucher=voucher.name '));
        return view('voucher.list')->with(compact('user', 'page_title', 'list'));
    }

    public function index()
    {
        //
    }


    public function updatevoucher($name)
    {
        $add = Carbon::now('Asia/Makassar')->addMinutes(125);
        {
            DB::table('voucher')
                ->where('name', '=', $name)
                ->where('group', '=', 'Public')
                ->update(['valid' => $add, 'expired' => '1']);
        }
    }

    public function updatevoucherguest($name)
    {
        $add = Carbon::now('Asia/Makassar')->addHours(24);
        {
            DB::table('voucher')
                ->where('name', '=', $name)
                ->where('group', '=', 'GuestInHouse')
                ->update(['valid' => $add, 'expired' => '1']);
        }
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
        //
    }
}
