<?php

namespace App\Http\Controllers;

use App\Radacct;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;



use DB;
use App\Radcheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Usergroup;
use Carbon\Carbon;
use PDF;

include "phpqrcode/qrlib.php";
use Illuminate\Support\Facades\Session;

class GuestInHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function print($username)
    {
       $printed=DB::table('checkin')
           ->where('username','=',$username)
           ->value('printed');
        if($printed==='N') {
            $data = DB::select(DB::raw('select radcheck.username,attribute,radcheck.value as password,a.value as expire,b.value as shared from radcheck
left join (select username,value from radcheck where username =\'' . $username . '\' and attribute=\'Expiration\') as a on a.username=radcheck.username
left join (select username,value from radcheck where username =\'' . $username . '\' and attribute=\'Simultaneous-Use\') as b on b.username=radcheck.username 
where attribute=\'Cleartext-Password\' and radcheck.username=\'' . $username . '\''));
  

            DB::table('checkin')
                ->where('username','=',$username);
                //->update(['printed'=>'Y']);
            \QRCode::png('10.10.8.1/login?username='.$username.'&password='.$data[0]->password,'images/'.$username.'-rbc.png','M','4','4');

            DB::table('logs')
                ->insert(['action' => 'Print', 'action_by' => Auth::user()->name, 'description' => 'Print Guest In House Username  & Password for user' . $username . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);



            view()->share('data', $data);

            PDF::SetTitle('Print Guest In Username & Password');
            PDF::AddPage('P', 'A4');
            PDF::writeHTML(view('guestinhouse.print')->render());
            PDF::Output('guestinhouse-' . $username . '.pdf');
        } else
        {
            return view('errors.print');
        }
    }

    public function dashboard()
    {
        $totalbytes=DB::select(DB::raw('select upload as up_user, download as down_user from updown '));
        $user = Auth::user();
        $page_title = 'Dashboard';
        $totalguest=DB::select(DB::raw('select count(username) as total from radcheck where attribute=\'Cleartext-Password\''));
        $guest = DB::select(DB::raw('select count(username) as cuser from radacct where acctstoptime is null and username in (SELECT username FROM radcheck WHERE username REGEXP \'^[0-9]+$\' and attribute = \'Cleartext-Password\')'));
        $public = DB::select(DB::raw('select count(username) as cuser from radacct where acctstoptime is null and username  in (select username from voucher_user)'));
        $mice = DB::select(DB::raw('select count(username) as cuser from radacct where acctstoptime is null and username  in (select username from mice)'));


        $times = [];
        $tguests = [];
        $tpublics =[];
        $tmices = [];
        $time = DB::table('chart')
            ->select('time')
            ->orderBy('id','desc')
            ->take(10)
            ->get();
        $time=$time->reverse();
        
        foreach ($time as $t) {
            $tguest = DB::table('chart')
                ->where('time', '=', $t->time)
                ->select('guest')
                ->get();

            $tpublic = DB::table('chart')
                ->where('time', '=', $t->time)
                ->select('public')
                ->get();

            $tmice = DB::table('chart')
                ->where('time', '=', $t->time)
                ->select('mice')
                ->get();

            foreach ($tguest as $tg ){
                array_push($tguests, $tg->guest);
            }

            foreach ($tpublic as $tp ){
                array_push($tpublics, $tp->public);
            }

            foreach ($tmice as $tm ){
                array_push($tmices, $tm->mice);
            }

            array_push($times, Carbon::parse($t->time)->format('d M Y H:i'));
           
        }
        
        return view('guestinhouse.dashboard')->with(compact('totalbytes','user', 'page_title', 'guest', 'public','mice', 'times','tguests','tpublics','tmices','totalguest'));
    }

    public function roomdelete($username)
    {
        DB::table('radcheck')
            ->where('username','=',$username)
            ->delete();
        DB::table('radusergroup')
            ->where('username','=',$username)
            ->delete();
            DB::table('logs')
            ->insert(['action'=>'Delete','action_by'=>Auth::user()->name,'description'=>'Delete Room '.$username.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Room Deleted !!'
        ]);

        return redirect('guestinhouse/room');
    }

    public function roomeditstore(Request $request)
    {
        $this->validate($request,[
            'shared'=>'required|numeric|max:10',
        ]);

        $room=Input::get('room');
        $shared=Input::get('shared');

        $exists=DB::table('radcheck')
            ->where('username','=',$room)
            ->where('attribute','=','Simultaneous-Use')
            ->value('value');

        if($exists !=null){

            DB::table('radcheck')
                ->where('username','=',$room)
                ->where('attribute','=','Simultaneous-Use')
                ->update(['value'=>$shared]);
        } else
        {
            DB::table('radcheck')
                ->insert(['username'=>$room,'attribute'=>'Simultaneous-Use','op'=>':=','value'=>$shared]);

        }
        DB::table('logs')
        ->insert(['action'=>'Update','action_by'=>Auth::user()->name,'description'=>'Update Room '.$room.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);


        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Room Updated !!'
        ]);
        return redirect('guestinhouse/room');

    }

    public  function roomedit($username)
    {
        $user=Auth::user();
        $page_title='Edit Room';
        $room=DB::select(DB::raw('select radcheck.id,radcheck.username,b.value as shared from radcheck
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
 where attribute=\'Cleartext-Password\' and radcheck.username=\''.$username.'\''));

        return view('guestinhouse.roomedit')->with(compact('user','page_title','username','room'));
    }

    public function roomlist()
    {
        $user=Auth::user();
        $page_title='Room List';

        $lists=DB::select(DB::raw('select radcheck.id,radcheck.username,b.value as shared from radcheck
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
 where attribute=\'Cleartext-Password\' and radcheck.username not in (select username from radreply)'));

        return view('guestinhouse.roomlist')->with(compact('user','page_title','lists'));
    }

    public function roomstore(Request $request)
    {

        $this->validate($request,[
            'room'=>'required|numeric|max:1000',
            'shared'=>'required|numeric|max:10',
        ]);
        $room=Input::get('room');
        $shared=Input::get('shared');
        $exists=DB::table('radcheck')
            ->where('username','=',$room)
            ->where('attribute','=','Cleartext-Password')
            ->value('username');



        if($exists!=$room)
        {
            DB::table('radcheck')
                ->insert(['username'=>$room,'attribute'=>'Cleartext-Password','op'=>':=','value'=>'null']);
            DB::table('radcheck')
                ->insert(['username'=>$room,'attribute'=>'Simultaneous-Use','op'=>':=','value'=>$shared]);
            DB::table('radusergroup')
                ->insert(['username'=>$room,'groupname'=>'GuestInHouse','priority'=>'0']);
            DB::table('checkin')
                ->insert(['username'=>$room,'status'=>'0','lastcheckin'=>Carbon::now('Asia/Makassar'),'checkout'=>'']);

                DB::table('logs')
                ->insert(['action'=>'Insert','action_by'=>Auth::user()->name,'description'=>'Add new Room '.$room.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'Room added successfully !!'
            ]);
            return redirect('guestinhouse');
        } else {
            session()->flash('flash', [
                'level' => 'danger',
                'message' => 'Room already exists !!'
            ]);

            return redirect('guestinhouse');
        }

    }

    public function addroom()
    {
        $user=Auth::user();
        $page_title='Add Room';
        return view('guestinhouse.addroom')->with(compact('user','page_title'));
    }



    public function extendstore()
    {
      $username=Input::get('username');
      $radio=Input::get('radio');

      if($radio=='late')
      {
        $now=Carbon::now('Asia/Makassar')->format('H:i');
        $time = Carbon::parse(Input::get('late'))->format('H:i');
        $expired = DB::table('radcheck')
            ->where('username', '=', $username)
            ->where('attribute', '=', 'Expiration')
            ->value('value');
        $ex = substr($expired, 0, -5);
        $extime=Carbon::parse($expired)->format('H:i');

        if($now<$time && $extime<$time) {

            $newexp = $ex . $time;

            DB::table('radcheck')
                ->where('username', '=', $username)
                ->where('attribute', '=', 'Expiration')
                ->update(['value' => $newexp]);
                DB::table('logs')
                ->insert(['action'=>'Update','action_by'=>Auth::user()->name,'description'=>'Update check out time for '.$username.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'Checkout time for user' . $username . ' updated  successfully !!'
            ]);
            return redirect('guestinhouse');
        } else
        {
            session()->flash('flash', [
                'level' => 'danger',
                'message' => 'Time must be greater than previous time !!'
            ]);
            return redirect('guestinhouse');
        }
      } else {
        $exp_date=Input::get('extend');
        DB::table('radcheck')
        ->where('username','=',$username)
        ->where('attribute','=','Expiration')
        ->update(['value'=>$exp_date]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Checkout time for user' . $username . ' updated  successfully !!'
        ]);
        return redirect('guestinhouse');

      }
    }

    public function latecheckoutstore()
    {
        $username = Input::get('username');

        $now=Carbon::now('Asia/Makassar')->format('H:i');
        $time = Carbon::parse(Input::get('time'))->format('H:i');
        $expired = DB::table('radcheck')
            ->where('username', '=', $username)
            ->where('attribute', '=', 'Expiration')
            ->value('value');
        $ex = substr($expired, 0, -5);
        $extime=Carbon::parse($expired)->format('H:i');

        if($now<$time && $extime<$time) {

            $newexp = $ex . $time;

            DB::table('radcheck')
                ->where('username', '=', $username)
                ->where('attribute', '=', 'Expiration')
                ->update(['value' => $newexp]);
                DB::table('logs')
                ->insert(['action'=>'Update','action_by'=>Auth::user()->name,'description'=>'Update check out time for '.$username.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'Checkout time for user' . $username . ' updated  successfully !!'
            ]);
            return redirect('guestinhouse');
        } else
        {
            session()->flash('flash', [
                'level' => 'danger',
                'message' => 'Time must be greater than previous time !!'
            ]);
            return redirect('guestinhouse');
        }
    }



    public function extend($username)
    {
      $user=Auth::user();
      $page_title='Extend';
      return view('guestinhouse.extend')->with(compact('user','page_title','username'));
    }


    public function latecheckout($username)
    {
        $user=Auth::user();
        $page_title='Late Check Out';
        return view('guestinhouse.latecheckout')->with(compact('user','page_title','username'));
    }

    public  function voucher()
    {
        $user=Auth::user();
        $page_title='Wifi Voucher';
        return view('guestinhouse.voucher')->with(compact('user','page_title'));
    }

    public function online()
    {
        $user=Auth::user();
        $page_title='Online Users';
        $online=DB::select(DB::raw(('select f.voucher,e.count, radcheck.id,radcheck.username,acctstoptime,callingstationid,d.attribute, framedipaddress,lastcheckin,a.value,b.value as shared,c.value as pass
from radcheck
left join radacct on radacct.username=radcheck.username
left join checkin on checkin.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Expiration\') a on a.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Cleartext-Password\') c on c.username=radcheck.username
left join (select attribute,username from radcheck where attribute=\'User-Password\') d on d.username=radcheck.username
left join (select count(*) as count , username from radacct where acctstoptime is null group by username) e on e.username=radcheck.username
left join (select username,voucher from voucher_user) f on f.username=radcheck.username
where    acctstoptime is null and radcheck.username  not in (select username from radcheck where attribute in (\'Auth-Type\')) and callingstationid is not null and framedipaddress is not null group by callingstationid')));
        $macauth=DB::select(DB::raw('select radcheck.id,macauthlog.user,acctstoptime,callingstationid, framedipaddress,checkin,a.value,b.value as shared
from radcheck
left join radacct on radcheck.username=radacct.username
left join macauthlog on macauthlog.mac=radcheck.username
left join (select value,username from radcheck where attribute=\'Expiration\') a on a.username=macauthlog.user
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
where acctstoptime is null and radacct.callingstationid in (select mac from macauthlog)  and macauthlog.user is not null   group by callingstationid'));

        return view('guestinhouse.online')->with(compact('user','page_title','online','macauth'));
    }

    public  function passstore(Request $request)
    {
        $this->validate($request,[
            'userpassword'=>array('required','NotIn:bali,kuta,rama,ramayana','Min:6','alpha_num')
        ]);

        $users=Input::get('users');
        $ip=DB::table('radacct')
            ->where('username','=',$users)
            ->where('acctstoptime','=',NULL)
            ->select('framedipaddress')
            ->get();
        foreach ($ip as $item) {
            $this->disconnect($users, $item->framedipaddress);
        }
        $pass=Input::get('userpassword');
        DB::table('radcheck')
            ->where('username','=',$users)
            ->where('attribute','=','Cleartext-Password')
            ->update(['value'=>$pass]);
        DB::table('checkin')
            ->where('username','=',$users)
            ->update(['printed'=>'N']);

            DB::table('logs')

            ->insert(['action'=>'Update','action_by'=>Auth::user()->name,'description'=>'Reset Password '.$users.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'Password updated !!'
        ]);

        return redirect('guestinhouse');
    }
    public  function resetpass($users)
    {
        $user=Auth::user();
        $page_title='Reset Password';
        return view('guestinhouse.resetpass')->with(compact('users','user','page_title'));
    }

    public function gcheckinstore(Request $request)
    {
        $users=explode(',',Input::get('input'));
        $pass = Input::get('userpassword');
        $alpha=ctype_alnum($pass);
        if ($pass == Null || strlen($pass)<6 || !$alpha) {
            session()->flash('flash', [
                'level' => 'danger',
                'message' => 'Password can not be empty or less than 6 character or contain non Alpha Numeric character !!'
            ]);


            return redirect('operator');
        } else {
            foreach ($users as $u)
            {
                $checked=DB::table('checkin')
                    ->where('username','=',$u)
                    ->value('status');
                $id=DB::table('radcheck')
                    ->where('username','=',$u)
                    ->value('id');
                if(!$checked=='1') {
                    $now=Carbon::now('Asia/Makassar')->toDateTimeString();

                    $expired=date('d M Y H:i',strtotime(Input::get('checkoutdate')));

                    $pass=Input::get('userpassword');
                    $user=Radcheck::find($id);


                    $null=DB::table('radcheck')
                        ->join('checkin','radcheck.username','=','checkin.username')
                        ->select('radcheck.*','radcheck.username')
                        ->where('id','=',$id)
                        ->first();

                    $exists=DB::table('radcheck')->select('attribute')
                        ->where('username','=',$user->username)
                        ->where('attribute','=','Expiration')
                        ->first();

                    if(empty($exists))
                    {
                        DB::table('radcheck')
                            ->insert(['username'=>$user->username,'op'=>':=','attribute'=>'Expiration','value'=>$expired]);

                    } else {

                        DB::table('radcheck')
                            ->where('username','=',$user->username)
                            ->where('attribute','=','Expiration')
                            ->update(['value'=>$expired]);

                    }


                    if(($null)!=null)
                    {
                        DB::table('checkin')
                            ->where('username','=',$user->username)
                            ->update(['status'=>'1','lastcheckin'=>$now,'checkout'=>$expired]);

                    }
                    else
                    {
                        DB::table('checkin')->insert(
                            ['username' => $user->username,'status'=>'1', 'lastcheckin' =>$now,'checkout'=>$expired]
                        );
                    }

                    DB::table('radcheck')
                        ->where('username','=',$user->username)
                        ->where('attribute','=','Cleartext-Password')
                        ->update(['value'=>$pass]);
                    DB::table('radusergroup')
                        ->where('username','=',$user->username)
                        ->where('groupname','=','daloRADIUS-Disabled-Users')
                        ->update(['groupname'=>'GuestInHouse']);


                }
            }
            DB::table('logs')
            ->insert(['action'=>'Checkin','action_by'=>Auth::user()->name,'description'=>'Checkin user '.implode(',',$users).' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'User ' . implode(',',$users) . ' Checked in Successfully !!'
            ]);
            return redirect('operator');
        }
    }


    public function groupcheck(Request $request)
    {
        $this->validate($request,[
            'users'=>'required',
        ]);
        $checkin=Input::get('checkin');
        if($checkin=='Checkin')
        {
            $user = Auth::user();
            $page_title = 'Group Checkin';
            $users = Input::get('users');

            return view('guestinhouse.groupcheck')->with(compact('user', 'page_title', 'users','model'));
        } elseif($checkin=='Checkout') {

            $users = array_unique(Input::get('users'));
            foreach ($users as $u) {
                $checked=DB::table('checkin')
                    ->where('username','=',$u)
                    ->value('status');
                $mac=DB::table('radcheck')
                    ->join('macauthlog','macauthlog.mac','=','radcheck.username')
                    ->join('radacct','radacct.username','=','radcheck.username')
                    ->where('user','=',$u)
                    ->groupBy('mac')
                    ->select('mac','framedipaddress')
                    ->get();
                foreach($mac as $m){
                    $this->disconnectmac($m->mac,$m->framedipaddress);
                }

                $ip = DB::table('radcheck')
                    ->join('radacct', 'radacct.username', '=', 'radcheck.username')
                    ->join('checkin', 'checkin.username', '=', 'radcheck.username')
                    ->where('checkin.status', '=', '1')
                    ->where('radcheck.username', '=', $u)
                    ->value('framedipaddress');
                if($checked=='1') {
                    $this->checkout($u, $ip);
                }
            }

            DB::table('logs')
            ->insert(['action'=>'Check out','action_by'=>Auth::user()->name,'description'=>'Check out user '.implode(',',$users).' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'User ' . implode(',',$users) . ' Checked Out Successfully !!'
            ]);


            return redirect('operator');
        }
    }





    public function macauthStore(Request $request)
    {
        $this->validate($request,[
            'address'=>array('required','regex:/([a-fA-F0-9])/','min:12','max:17'),
            'user'=>'required',
        ]);

        $now=Carbon::now('Asia/Makassar')->toDateTimeString();
        $macaddress=strtoupper(Input::get('address'));
        $user=Input::get('user');
        $opr=Auth::user();
        $macaddress=str_replace(':','',$macaddress);
        $mac=join(":",str_split($macaddress,2));

        $val=DB::table('radcheck')
            ->where('username','=',$user)
            ->where('attribute','=','Simultaneous-Use')
            ->value('value');


        $checkin=DB::table('checkin')
            ->where('username','=',$user)
            ->value('status');

        $log = DB::table('macauthlog')
            ->where('mac', '=', $mac)
            ->value('mac');
        $log2 = DB::table('checkin')
            ->where('username', '=', $mac)
            ->value('username');
        $maccount=DB::select(DB::raw('select count(*) as count from radacct where username in (select mac from macauthlog where user=\''.$user.'\') and acctstoptime is null  '));
        $shared=DB::table('radcheck')
            ->where('username','=',$user)
            ->where('attribute','=','Simultaneous-Use')
            ->value('value');

        $online=DB::table('radacct')
            ->where('username','=',$user)
            ->where('acctstoptime','=',NULL)
            ->count();

        $radcheck = DB::table('radcheck')
            ->select('username')
            ->where('username', '=', $mac)
            ->first();
        if(!empty($checkin) || $checkin='0' ) {
            if($radcheck==null){
                if (($maccount[0]->count+ $online) < (int)$shared || ($maccount[0]->count+ $online)==1   ) {
                    if ((int)$val <= 0) {

                        $this->disable($user);
                    } else {
                        DB::table('radcheck')
                            ->where('username', '=', $user)
                            ->where('attribute', '=', 'Simultaneous-Use')
                            ->update(['value' => (int)$val - 1]);
                    }

                    if (empty($log2)) {
                        DB::table('checkin')
                            ->insert(['username' => $mac, 'status' => '1', 'lastcheckin' => $now]);
                    } else {
                        DB::table('checkin')
                            ->where('username', '=', $mac)
                            ->update(['username' => $mac, 'status' => '1', 'lastcheckin' => $now]);

                    }

                    if (empty($log)) {
                        DB::table('macauthlog')
                            ->insert(['mac' => $mac, 'user' => $user, 'checkin' => Carbon::now('Asia/Makassar'), 'checkedby' => $opr->name]);

                    } else {
                        DB::table('macauthlog')
                            ->where('mac', '=', $mac)
                            ->update(['user' => $user, 'checkin' => Carbon::now('Asia/Makassar'), 'checkedby' => $opr->name]);

                    }


                    if ($radcheck == null) {
                        DB::table('radcheck')
                            ->insert(['username' => $mac, 'attribute' => 'Auth-Type', 'op' => ':=', 'value' => 'Accept']);
                    } else {
                        DB::table('radcheck')
                            ->where('username', '=', $mac)
                            ->update(['username' => $mac, 'attribute' => 'Auth-Type', 'op' => ':=', 'value' => 'Accept']);
                    }


                    $radgroup = DB::table('radusergroup')
                        ->select('username')
                        ->where('username', '=', $mac)
                        ->first();
                    if ($radgroup == null) {
                        DB::table('radusergroup')
                            ->insert(['username' => $mac, 'groupname' => 'GuestInHouse', 'priority' => '0']);
                    } else {
                        DB::table('radusergroup')
                            ->where('username', '=', $mac)
                            ->update(['username' => $mac, 'groupname' => 'GuestInHouse', 'priority' => '0']);

                    }

                    DB::table('logs')
                    ->insert(['action'=>'MAC Bypass','action_by'=>Auth::user()->name,'description'=>'Mac Bypass '.$mac.' for user'.$user.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);


                    session()->flash('flash', [
                        'level' => 'success',
                        'message' => 'User ' . $user . ' Checked in Successfully !!'
                    ]);

                    return redirect('guestinhouse');
                } else
                {
                    session()->flash('flash', [
                        'level' => 'danger',
                        'message' => 'No More MAC Bypass Allowed  !!'
                    ]);

                    return redirect('guestinhouse');
                }
            } else {
                session()->flash('flash', [
                    'level' => 'danger',
                    'message' => 'MAC already registered !!'
                ]);

                return redirect('guestinhouse');
            }

        } else
        {
            session()->flash('flash', [
                'level' => 'danger',
                'message' => 'User '.$user.' Not Checked In!!'
            ]);
            return redirect('guestinhouse');
        }


    }

    public function macauth()
    {
        $user=Auth::user();
        $page_title='MAC Authentication';
        $list=DB::table('radcheck')
            ->join('checkin','checkin.username','=','radcheck.username')
            ->where('attribute','=','Cleartext-Password')
            ->where('status','=','1')
            ->pluck('radcheck.username','radcheck.username');

        return view('guestinhouse.macauth')->with(compact('user','page_title','list'));
    }

    public function disconnect($user,$ip)
    {
        $line="#bin/bash/\n";
        $file=fopen('disconnect.sh','w');
        fwrite($file,$line);

        $command='ssh root@10.10.1.4 "echo "User-Name='.$user.',Framed-IP-Address='.$ip.'" | radclient -x 10.10.1.1:3799 disconnect testing123"'.PHP_EOL;
        fwrite($file,$command);

        fclose($file);

        exec('chmod +x disconnect.sh');


        echo shell_exec("sh ./disconnect.sh");

        DB::table('radcheck')
            ->where('username','=',$user)
            ->where('attribute','=','Auth-Type')
            ->delete();
        DB::select(DB::raw('delete from radusergroup where radusergroup.username in (select username from radcheck where attribute=\'Auth-Type\')'));

        DB::table('logs')
        ->insert(['action'=>'Disconnect','action_by'=>Auth::user()->name,'description'=>'Disconnect user'.$user.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

        session()->flash('flash', [
            'level' => 'success',
            'message' => 'User '.$user .' disconnected successfully'
        ]);
        return redirect('guestinhouse');


    }

    public function disconnectmac($user,$ip)
    {
        $username=DB::table('macauthlog')
            ->where('mac','=',$user)
            ->value('user');
        $val=DB::table('radcheck')
            ->where('username','=',$username)
            ->where('attribute','=','Simultaneous-Use')
            ->value('value');

        DB::table('radcheck')
            ->where('username','=',$username)
            ->where('attribute','=','Simultaneous-Use')
            ->update(['value'=>(int)$val+1]);

        if((int)$val>0)  {
            $this->enable($username);
        }

        $this->disconnect($user,$ip);

        DB::table('radcheck')
            ->where('username','=',$user)
            ->delete();

        DB::table('radusergroup')
            ->where('username','=',$user)
            ->delete();

            DB::table('logs')
            ->insert(['action'=>'Disconnect MAC','action_by'=>Auth::user()->name,'description'=>'Disconnect MAC '.$user.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);




        return redirect('guestinhouse');

    }

    public function disable($user)
    {

        DB::table('radusergroup')
            ->where('username','=',$user)
            ->update(['groupname'=>'daloRADIUS-Disabled-Users']);


        session()->flash('flash', [
            'level' => 'success',
            'message' => 'User '.$user .' disabled successfully'
        ]);
        return redirect('guestinhouse');
    }

    public  function enable($user)
    {


        DB::table('radusergroup')
            ->where('username','=',$user)
            ->where('groupname','=','daloRADIUS-Disabled-Users')
            ->update(['groupname'=>'GuestInHouse']);
        session()->flash('flash', [
            'level' => 'success',
            'message' => 'User '.$user .' enabled'
        ]);
        return redirect('guestinhouse');
    }


    public function checkin($id)
    {


        $this->enable($id);
        $page_title="Checkin Form Guest In House";
        $user=Auth::user();

        $guest=Radcheck::find($id);
        $username=DB::table('radcheck')->select('username')->where('id','=',$id)->first();
        $totalbyte=DB::select(DB::raw('select (sum(acctinputoctets) + sum(acctoutputoctets)) as totalbyte from radacct where acctstarttime between concat(curdate(),\' 00:00:00\') and now() and username=\''.$username->username.'\''));
        $limit=DB::select(DB::raw('select value from fup where username=\''.$username->username.'\' and attribute=\'Mikrotik-Total-Limit\''));

        if((float)$totalbyte>=(float)$limit)
        {
            DB::select(DB::raw('delete from radacct where acctstarttime BETWEEN concat(curdate(),\' 00:00:00\') and now() and username=\''.$username->username.'\''));
        }

        return view('guestinhouse.checkin')->with(compact('user','page_title','username','guest'));
    }


    public function checkinStore(Request $request ,$id)
    {
        $this->validate($request,[
            'checkoutdate'=>'required',
            'userpassword'=>array('required','NotIn:bali,kuta,rama,ramayana','Min:6','alpha_num'),
        ]);


        $now=Carbon::now('Asia/Makassar')->toDateTimeString();

        $expired=date('d M Y H:i',strtotime(Input::get('checkoutdate')));

        $pass=Input::get('userpassword');
        $user=Radcheck::find($id);

        DB::table('checkin')
            ->where('username','=',$user->username)
            ->update(['printed'=>'N']);

        $null=DB::table('radcheck')
            ->join('checkin','radcheck.username','=','checkin.username')
            ->select('radcheck.*','radcheck.username')
            ->where('id','=',$id)
            ->first();

        $exists=DB::table('radcheck')->select('attribute')
            ->where('username','=',$user->username)
            ->where('attribute','=','Expiration')
            ->first();

        if(empty($exists))
        {
            DB::table('radcheck')
                ->insert(['username'=>$user->username,'op'=>':=','attribute'=>'Expiration','value'=>$expired]);

        } else {

            DB::table('radcheck')
                ->where('username','=',$user->username)
                ->where('attribute','=','Expiration')
                ->update(['value'=>$expired]);

        }


        if(($null)!=null)
        {
            DB::table('checkin')
                ->where('username','=',$user->username)
                ->update(['status'=>'1','lastcheckin'=>$now,'checkout'=>$expired]);

        }
        else
        {
            DB::table('checkin')->insert(
                ['username' => $user->username,'status'=>'1', 'lastcheckin' =>$now,'checkout'=>$expired]
            );
        }

        DB::table('radcheck')
            ->where('username','=',$user->username)
            ->where('attribute','=','Cleartext-Password')
            ->update(['value'=>$pass]);
        DB::table('radusergroup')
            ->where('username','=',$user->username)
            ->where('groupname','=','daloRADIUS-Disabled-Users')
            ->update(['groupname'=>'GuestInHouse']);


            DB::table('logs')
            ->insert(['action'=>'Checkin','action_by'=>Auth::user()->name,'description'=>'Checkin user'.$user->username.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);


        session()->flash('flash', [
            'level' => 'success',
            'message' => 'User '.$user->username .' checked in successfully'
        ]);
        return redirect('guestinhouse');
    }

    public function checkout($user,$ip)
    {
        $mac=DB::select(DB::raw('select mac,framedipaddress from radacct,macauthlog where radacct.username=macauthlog.mac and macauthlog.user=\''.$user.'\' and radacct.acctstoptime is null or mac in (select username from radcheck,macauthlog where macauthlog.mac=radcheck.username and user=\''.$user.'\' ) group by mac'));
        $voucher=DB::select(DB::raw('select username from radcheck where username in (select username from voucher_user where assigned=\''.$user.'\' )'));
        if($ip!='null')
        {
            $this->disconnect($user,$ip);
            $this->disable($user);
        } else
        {
            $this->disable($user);
        }

        foreach ($voucher as $v)
        {
            DB::table('radcheck')
                ->where('username','=',$v->username)
                ->delete();


            DB::table('radusergroup')
                ->where('username','=',$v->username)
                ->delete();

        }

        foreach ($mac as $m)
        {

            if($m->framedipaddress==null){

                DB::table('radcheck')
                    ->where('username','=',$m->mac)
                    ->delete();
                DB::table('macauthlog')
                    ->where('mac','=',$m->mac)
                    ->delete();
                DB::table('radusergroup')
                    ->where('username','=',$m->mac)
                    ->delete();
            }
            else {

                $this->disconnectmac($m->mac, $m->framedipaddress);

            }
        }


        $null=DB::table('radcheck')
            ->join('checkin','radcheck.username','=','checkin.username')
            ->select('radcheck.*','radcheck.username')
            ->where('radcheck.username','=',$user)
            ->first();

        if($null==null){
            DB::table('checkin')->insert(
                ['username' => $user,'status'=>'0', 'checkout' => Carbon::now('Asia/Makassar')]
            );
        } else {
            DB::table('checkin')
                ->where('username','=',$user)
                ->update(['status'=>'0','checkout'=>Carbon::now('Asia/Makassar')]);
        }

        DB::table('logs')
        ->insert(['action'=>'Check out','action_by'=>Auth::user()->name,'description'=>'Check out user '.$user.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);


        session()->flash('flash', [
            'level' => 'success',
            'message' => 'User '.$user.' checked out successfully'
        ]);
        return redirect('guestinhouse');
    }



public function index()
{
$user=Auth::user();
if($user->hasRole('mice')){
  $data=DB::select(DB::raw('select * from mice'));
  $user=Auth::user();
  $page_title='MICE List';
  return view('mice.index')->with(compact('user','page_title','data'));
} else {

$new=DB::select(DB::raw('select radcheck.* from radcheck,radacct  where attribute="Cleartext-Password" and  radcheck.username not in (select username from radacct  group by username) and attribute<>"Auth-Type" group by radcheck.username'));

$now=Carbon::now('Asia/Makassar')->format('d M Y h:i');
$page_title="Guest In House";
$user=Auth::user();

$onlineuser=DB::select(DB::raw(('select  count,radcheck.id,radcheck.username,acctstoptime,callingstationid, framedipaddress,lastcheckin,a.value,b.value as shared,c.value as pass
from radcheck
left join radacct on radacct.username=radcheck.username
left join checkin on checkin.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Expiration\') a on a.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Cleartext-Password\') c on c.username=radcheck.username
left join (select count(*) as count , username from radacct where acctstoptime is null group by username) d on d.username=radcheck.username
where    acctstoptime is null and radcheck.username  not in (select username from radcheck where attribute in (\'Auth-Type\',\'User-Password\')) and callingstationid is not null and  framedipaddress is not null and radcheck.username not in (select username from mice) group by callingstationid')));
        $macauth=DB::select(DB::raw('select radcheck.id,macauthlog.user,acctstoptime,callingstationid, framedipaddress,checkin,a.value,b.value as shared
from radcheck
left join radacct on radcheck.username=radacct.username
left join macauthlog on macauthlog.mac=radcheck.username
left join (select value,username from radcheck where attribute=\'Expiration\') a on a.username=macauthlog.user
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
where acctstoptime is null and radacct.callingstationid in (select mac from macauthlog)  and macauthlog.user is not null   group by callingstationid'));

        $checkedin=DB::select(DB::raw('select id,radcheck.username,a.value,b.value as shared,c.value as pass ,lastcheckin,acctstoptime,framedipaddress
from radcheck
left join radacct on radacct.username=radcheck.username
left join checkin on checkin.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Expiration\') a on a.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Cleartext-Password\') c on c.username=radcheck.username
where checkin.status=\'1\' and radcheck.username  not in (select username from radacct where acctstoptime is null) and radcheck.attribute not IN (\'User-Password\',\'Auth-Type\') group by username'));



        $checkedout=DB::select(DB::raw('select id,radcheck.username,c.value as pass,lastcheckin,b.value as shared
from radcheck
left join radacct on radacct.username=radcheck.username
left join checkin on checkin.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Cleartext-Password\') c on c.username=radcheck.username
where checkin.status=\'0\'  or radcheck.username not in (select username from checkin)  and attribute not IN (\'User-Password\',\'Auth-Type\')  group by radcheck.username'));

        $onlinear=DB::select(DB::raw('select count(*) as count from radacct where acctstoptime is null '));


        $maclist=DB::select(DB::raw('select user,mac ,a.acctstoptime,a.framedipaddress from radcheck
left join macauthlog on mac=username
left join (select acctstoptime,framedipaddress,username from radacct where acctstoptime is null) a on a.username=radcheck.username
where mac=radcheck.username'));


        return view('guestinhouse.index')->with(compact('page_title','user','onlinear','onlineuser','macauth','checkedin','checkedout','now','new','maclist'));

    }

    }


    public function deletemac($mac,$ip)
    {
        if($ip=='0')
        {
            $user=DB::table('macauthlog')
                ->where('mac','=',$mac)
                ->value('user');
            $val=DB::table('radcheck')
                ->where('username','=',$user)
                ->where('attribute','=','Simultaneous-Use')
                ->value('value');
            DB::table('radcheck')
                ->where('username','=',$user)
                ->where('attribute','=','Simultaneous-Use')
                ->update(['value'=>(int)$val+1]);
            DB::table('radcheck')
                ->where('username','=',$mac)
                ->delete();
            DB::table('radusergroup')
                ->where('username','=',$mac)
                ->delete();

                DB::table('logs')
                ->insert(['action'=>'Delete MAC','action_by'=>Auth::user()->name,'description'=>'Delete MAC '.$mac.' by '.Auth::user()->name,'created'=>Carbon::now('Asia/Makassar')]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'Mac '.$mac.' deleted  successfully'
            ]);


            return redirect('guestinhouse');
        } else
        {
            $this->disconnect($mac,$ip);
            $username=DB::table('macauthlog')
                ->where('mac','=',$mac)
                ->value('user');
            $val=DB::table('radcheck')
                ->where('username','=',$username)
                ->where('attribute','=','Simultaneous-Use')
                ->value('value');

            DB::table('radcheck')
                ->where('username','=',$username)
                ->where('attribute','=','Simultaneous-Use')
                ->update(['value'=>(int)$val+1]);

            session()->flash('flash', [
                'level' => 'success',
                'message' => 'Mac '.$mac.' deleted  successfully'
            ]);


            return redirect('guestinhouse');
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
    public function details($id)
    {
        $test=(float)'2.34'+(float)'3.21';
        $page_title="Guest In House";
        $user=Auth::user();
        $curr=Carbon::now('Asia/Makassar');
        $u=Radcheck::find($id);
        $status=DB::table('checkin')
            ->select('status')
            ->where('username','=',$u->username)
            ->get();
        $checkout=DB::table('radcheck')
            ->where('username','=',$u->username)
            ->where('attribute','=','Expiration')
            ->value('value');
        $username=DB::table('radcheck')
            ->join('checkin','radcheck.username','=','checkin.username')
            ->select('radcheck.username','lastcheckin')->where('id','=',$id)
            ->get();
        $exp=DB::table('radcheck')
            ->where('username','=',$u->username)
            ->where('attribute','=','Expiration')
            ->value(DB::raw('STR_TO_DATE(value,\'%d %M %Y %H:%i\') as value'));
        $lastcheckin=DB::select(DB::raw('select lastcheckin from checkin where username=\''.$u->username.'\''));
        ##$daily=DB::select(DB::raw('SELECT round(((acctinputoctets+acctoutputoctets)/1024/1024),2) as totalbyte from radacct where username=\''.$u->username.'\' and acctstarttime between (STR_TO_DATE(CONCAT(CURDATE(),\' \',\'00:00:00\'),\'%Y-%m-%d %H:%i:%s\')) and (STR_TO_DATE(CONCAT(CURDATE(),\' \',\'23:59:59\'),\'%Y-%m-%d %H:%i:%s\'))  or username in (select mac from macauthlog where user=\''.$u->username.'\') and acctstarttime between (STR_TO_DATE(CONCAT(CURDATE(),\' \',\'00:00:00\'),\'%Y-%m-%d %H:%i:%s\')) and (STR_TO_DATE(CONCAT(CURDATE(),\' \',\'23:59:59\'),\'%Y-%m-%d %H:%i:%s\'))'));
        $daily=DB::select(DB::raw('select round(((sum(acctinputoctets) + sum(acctoutputoctets))/1024/1024),2) as totalbyte from radacct where acctstarttime between concat(curdate(),\' 00:00:00\') and now() and username=\''.$u->username.'\''));
        $all=DB::select(DB::raw('SELECT username, round(((acctinputoctets+acctoutputoctets)/1024/1024),2) as totalbyte from radacct where  radacct.username=\''.$u->username.'\'
and acctstarttime between \''.$lastcheckin[0]->lastcheckin.'\' and \''.$exp.'\' or radacct.username in (select mac from macauthlog where user=\''.$u->username.'\')
and acctstarttime between \''.$lastcheckin[0]->lastcheckin.'\' and \''.$exp.'\''));
        $limit = DB::select(DB::raw('select round((((value)/1024)/1024),2) as totallimit from fup where attribute=\'Mikrotik-Total-Limit\' and username=\''.$u->username.'\''));
        $tdaily=0;
        $tall=0;
        $tlimit=0;
        

        foreach ($limit as $l)
        {
            $tlimit=$tlimit+(float)$l->totallimit;
        }
        foreach($daily as $d)
        {
            $tdaily=$tdaily+(float)$d->totalbyte;
        }
        foreach($all as $a)
        {
            $tall=$tall+(float)$a->totalbyte;
        }

        $guest=DB::select(DB::raw('SELECT radacct.username,framedipaddress,callingstationid,acctterminatecause,lastcheckin,acctstarttime,acctstoptime,TIMEDIFF(acctstoptime,acctstarttime) as totaltime,acctinputoctets,acctoutputoctets,round(((acctinputoctets+acctoutputoctets)/1024/1024),2) as totalbyte
from radacct,checkin where radacct.username=checkin.username and radacct.username=\''.$u->username.'\'
and acctstarttime between \''.$lastcheckin[0]->lastcheckin.'\' and \''.$exp.'\' or radacct.username in (select mac from macauthlog where user=\''.$u->username.'\')
and acctstarttime between \''.$lastcheckin[0]->lastcheckin.'\' and \''.$exp.'\' group by radacctid'));



        return view('guestinhouse.show')->with(compact('user','page_title','guest','username','status','tdaily','checkout','tall','tlimit'));
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
