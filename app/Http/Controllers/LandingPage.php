<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use DB;
use App\Http\Controllers\GuestInHouseController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\In;


class LandingPage extends Controller
{

    public function login()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');

        return view('landing.login')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function login_mice()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.login_mice')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function alogin_single()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.alogin_single')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }


    public function alogin()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.alogin')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function alogin_mice()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.alogin_mice')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function status()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $loginby = Input::get('loginby');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.status')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function status_mice()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $loginby = Input::get('loginby');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.status_mice')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function status_single()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $loginby = Input::get('loginby');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.status_single')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function logout()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $loginby = Input::get('loginby');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.logout')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));

    }

    public function logout_mice()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $loginby = Input::get('loginby');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.logout_mice')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));

    }


    public function logout_single()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $loginby = Input::get('loginby');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.logout_single')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));

    }

    public function login_single()
    {
        $mac = Input::get('mac');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.login_single')->with(compact('mac', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function test()
    {
        $mac = Input::get('mac');
        $password = Input::get('password');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.test')->with(compact('mac', 'password', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));
    }

    public function resetpass()
    {
        $mac = Input::get('mac');

        $ip = Input::get('ip');

        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');

        $username = Input::get('username');
        $password = Input::get('password');
        $email = Input::get('email');
        $link = 'http://10.10.1.3/hotspot-manager/public/landing/resetpassword/' . $username . '/' . str_rot13($password);

        $exists = DB::table('user_email')
            ->where('email', '=', $email)
            ->select('email')
            ->get();
        if (count($exists) <= 0) {
            DB::table('user_email')
                ->insert(['room' => $username, 'email' => $email, 'created' => Carbon::now('Asia/Makassar')]);
        }
        $content = array(

            'username' => $username,
            'password' => $password,
            'link' => $link,


        );

        Mail::send('email.reset', $content, function ($message) use ($email) {


            $message->from('it.sysdev@rcoid.com', 'Admin Hotspot Manager Ramabeach Hotel');
            $message->to($email);
            $message->subject('Reset Password Request');

        });
        $flash = '1';
        return view('landing.index')->with(compact('flash', 'link', 'mac', 'password', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));

    }


    public function index()
    {
        $mac = Input::get('mac');
        $password = Input::get('password');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        $flash = 0;
        return view('landing.index')->with(compact('flash', 'mac', 'password', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));

    }

    public function index_mice()
    {
        $mac = Input::get('mac');
        $password = Input::get('password');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.index_mice')->with(compact('mac', 'password', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));

    }

    public function index_single()
    {
        $mac = Input::get('mac');
        $password = Input::get('password');
        $ip = Input::get('ip');
        $username = Input::get('username');
        $linklogin = Input::get('link-login');
        $linkorig = Input::get('link-orig');
        $error = Input::get('error');
        $trial = Input::get('trial');
        $chapid = Input::get('chap-id');
        $chapchallenge = Input::get('chap-challenge');
        $linkloginonly = Input::get('link-login-only');
        $linkorigesc = Input::get('link-orig-esc');
        $macesc = Input::get('mac-esc');
        $identity = Input::get('identity');
        $bytesinnice = Input::get('bytes-in-nice');
        $bytesoutnice = Input::get('bytes-out-nice');
        $sessiontimeleft = Input::get('session-time-left');
        $uptime = Input::get('uptime');
        $refreshtimeout = Input::get('refresh-timeout');
        $linkstatus = Input::get('link-status');
        return view('landing.index_single')->with(compact('mac', 'password', 'ip', 'username', 'linklogin', 'linkorig', 'error', 'trial', 'loginby', 'chapid', 'chapchallenge',
            'linkloginonly', 'linkorigesc', 'macesc', 'identity', 'bytesinnice', 'bytesoutnice', 'sessiontimeleft', 'uptime', 'refreshtimeout', 'linkstatus'));

    }

    public function resetpassword($username, $password)
    {

        $password = str_rot13($password);
        DB::table('radcheck')
            ->where('username', '=', $username)
            ->where('attribute', 'Cleartext-Password')
            ->update(['value' => $password]);

        $ips = DB::table('radacct')
            ->where('username', '=', $username)
            ->where('acctstoptime', '=', NULL)
            ->select('framedipaddress')
            ->get();

        foreach ($ips as $ip) {
            $line = "#bin/bash/\n";
            $file = fopen('disconnect.sh', 'w');
            fwrite($file, $line);

            $command = 'ssh root@10.10.1.4 "echo "User-Name=' . $username . ',Framed-IP-Address=' . $ip->framedipaddress . '" | radclient -x 10.10.1.1:3799 disconnect testing123"' . PHP_EOL;
            fwrite($file, $command);

            fclose($file);

            exec('chmod +x disconnect.sh');


            echo shell_exec("sh ./disconnect.sh");


        }
        DB::table('logs')
            ->insert(['action' => 'Reset password', 'action_by' => $username, 'description' => 'Disconnect user' . $username . ' by ' . $username, 'created' => Carbon::now('Asia/Makassar')]);


        return redirect('landing/login');
    }

    public function aloginget()
    {
        return redirect('http://10.10.8.1/alogin');
    }

    public function indexget_mice()
    {
        return redirect(config('app.ipmice') . '/index.html');
    }

    public function indexget_single()
    {
        return redirect(config('app.ippublic') . '/index.html');
    }

    public function indexget()
    {
        return redirect(config('app.ipguest') . '/index.html');
    }

    public function aloginget_mice()
    {
        return redirect(config('app.ipmice') . '/alogin');
    }

    public function loginget()
    {
        return redirect('http://10.10.8.1/login');
    }

    public function loginget_mice()
    {
        return redirect(config('app.ipmice') . '/login');
    }

    public function logoutget()
    {
        return redirect('http://10.10.8.1/logout');
    }

    public function logoutget_mice()
    {
        return redirect(config('app.ipmice') . '/logout');
    }

    public function aloginget_single()
    {
        return redirect('http://10.10.7.1/alogin');
    }

    public function loginget_single()
    {
        return redirect('http://10.10.7.1/login');
    }

    public function logoutget_single()
    {
        return redirect('http://10.10.7.1/logout');
    }
}
