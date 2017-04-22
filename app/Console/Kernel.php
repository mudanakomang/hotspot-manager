<?php

namespace App\Console;

use App\Http\Controllers\GuestInHouseController;
use App\Http\Controllers\VoucherController;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\MiceController;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function () {

            $download = DB::select(DB::raw('select sum(acctoutputoctets) as download from radacct where acctstarttime between concat(curdate(),\' 00:00:00\') and now()'));
            $upload = DB::select(DB::raw('select sum(acctinputoctets) as upload from radacct where acctstarttime between concat(curdate(),\' 00:00:00\') and now()'));

            DB::table('updown')
                ->update([
                    'upload' => $upload[0]->upload,
                    'download' => $download[0]->download,
                ]);
            $guest = DB::select(DB::raw('select count(username) as cuser from radacct where acctstoptime is null and username in (select username from radcheck where attribute=\'Cleartext-password\')'));
            $public = DB::select(DB::raw('select count(username) as cuser from radacct where acctstoptime is null and username  in (select username from voucher_user)'));
            $mice = DB::select(DB::raw('select count(username) as cuser from radacct where acctstoptime is null and username  in (select username from mice)'));

            DB::table('chart')
                ->insert(['time' => Carbon::now('Asia/Makassar'), 'guest' => $guest[0]->cuser, 'public' => $public[0]->cuser, 'mice' => $mice[0]->cuser]);
            DB::select(DB::raw('DELETE FROM chart WHERE id NOT IN ( SELECT id FROM (SELECT id FROM chart ORDER BY id DESC LIMIT 50 ) chart)'));
        })->everyMinute();

        $schedule->call(function () {
            $mi = New MiceController();
            $mice = DB::select(DB::raw('select created from mice where start < now()'));
            foreach ($mice as $value) {
                $val = Carbon::parse($value->created)->format('Ymdhis');
                $mi->activatepost($val);
            }
        })->everyMinute();

        $schedule->call(function () {
            $m = New MiceController();
            $mice = DB::select(DB::raw('select id from mice where end < now()'));
            foreach ($mice as $value) {
                $m->delete($value->id);
            }
        })->everyMinute();


        $schedule->call(function () {
            $vou = New VoucherController();
            $ba = DB::select(DB::raw('select voucher.name,c.total,d.used,e.unused,status  from voucher
left join (select voucher,count(status) as total from voucher_user  group by voucher) c on c.voucher=voucher.name
left join (select voucher,count(username) as used from voucher_user where username in (select username from radacct) group by voucher) d on d.voucher=voucher.name
left join (select voucher,count(username) as unused from voucher_user where username not in (select username from radacct) group by voucher) e on e.voucher=voucher.name where unused is null  and voucher.group=\'GuestInHouse\' and status=\'1\' and expired=\'0\''));
            foreach ($ba as $batch) {
                $vou->updatevoucherguest($batch->name);
            }
        })->everyMinute();


        $schedule->call(function () {
            $v = new VoucherController();
            $batch = DB::select(DB::raw('select voucher.name,c.total,d.used,e.unused,status  from voucher
left join (select voucher,count(status) as total from voucher_user  group by voucher) c on c.voucher=voucher.name
left join (select voucher,count(username) as used from voucher_user where username in (select username from radacct) group by voucher) d on d.voucher=voucher.name
left join (select voucher,count(username) as unused from voucher_user where username not in (select username from radacct) group by voucher) e on e.voucher=voucher.name where unused is null and status=\'1\' and expired=\'0\''));
            foreach ($batch as $b) {
                $v->updatevoucher($b->name);
            }
        })->everyMinute();


        $schedule->call(function () {
            $guest = new GuestInHouseController();
            $expired = DB::select(DB::raw('select radcheck.username,a.value,framedipaddress
from radcheck
left join radacct on radacct.username=radcheck.username
left join checkin on checkin.username=radcheck.username
left join (select str_to_date(value, \'%d%M%Y %H:%i\') as value,username from radcheck where attribute=\'Expiration\') a on a.username=radcheck.username
left join (select value,username from radcheck where attribute=\'Simultaneous-Use\') b on b.username=radcheck.username
where checkin.status=\'1\' and radcheck.username  not in (select username from radacct where acctstoptime is null) and radcheck.attribute <> \'Auth-Type\' and a.value<now() group by username'));
            foreach ($expired as $ex) {
                $null = DB::table('radcheck')
                    ->join('checkin', 'radcheck.username', '=', 'checkin.username')
                    ->select('radcheck.*', 'radcheck.username')
                    ->where('radcheck.username', '=', $ex->username)
                    ->first();

                if ($null == null) {
                    DB::table('checkin')->insert(
                        ['username' => $ex->username, 'status' => '0', 'checkout' => Carbon::now('Asia/Makassar')]
                    );
                } else {
                    DB::table('checkin')
                        ->where('username', '=', $ex->username)
                        ->update(['status' => '0', 'checkout' => Carbon::now('Asia/Makassar')]);
                }
            }

            $voucher = new VoucherController();
            $vexpired = DB::select(DB::raw('select name from voucher where valid<now()'));
            foreach ($vexpired as $vex) {
                $num = DB::select(DB::raw('select count(*) as c from voucher_user where voucher=\'' . $vex->name . '\''));
                $existsv = DB::table('voucher_history')
                    ->where('voucher_name', '=', $vex->name)
                    ->select('voucher_name')
                    ->get();
                if (count($existsv) == 0) {
                    DB::table('voucher_history')
                        ->insert(['voucher_name' => $vex->name, 'created' => Carbon::now('Asia/Makassar'), 'status' => 'Deleted', 'deleted_by' => 'Schedule', 'number' => $num[0]->c]);
                }
                $users = DB::table('voucher_user')
                    ->where('voucher', '=', $vex->name)
                    ->select('username', 'group')
                    ->get();
                foreach ($users as $user) {
                    $exists = DB::table('expired')
                        ->where('voucher', '=', $vex->name)
                        ->where('username', '=', $user->username)
                        ->select('username')
                        ->get();
                    if (count($exists) == 0) {
                        DB::table('expired')
                            ->where('voucher', '=', $vex->name)
                            ->insert(['voucher' => $vex->name, 'username' => $user->username, 'type' => $user->group, 'created' => Carbon::now('Asia/Makassar'), 'status' => 'Deleted']);
                    }
                    DB::table('radcheck')
                        ->where('username', '=', $user->username)
                        ->delete();
                    DB::table('radusergroup')
                        ->where('username', '=', $user->username)
                        ->delete();
                }
                DB::table('voucher_user')
                    ->where('voucher', '=', $vex->name)
                    ->delete();
                DB::table('voucher')
                    ->where('name', '=', $vex->name)
                    ->delete();
            }

        })->everyMinute();


    }


    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
