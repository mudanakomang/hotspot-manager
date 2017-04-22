<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;

class PrintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function printvoucher($name)
    {
        $data = DB::select(DB::raw('select a.username as useracct,voucher_user.* from voucher_user
            left join (select acctstoptime,username from radacct) a on a.username=voucher_user.username
            where voucher_user.voucher=\'' . $name . '\' and a.username is null'));

        if (count($data) == null) {

            session()->flash('flash', [
                'level' => 'danger',
                'message' => 'No more username can be used '
            ]);
            return redirect('voucher/voucherlist');
        } else {
            Excel::create('Voucher ' . $name, function ($excel) use ($data) {
                $excel->setTitle('Voucher')
                    ->setCreator(Auth::user()->name);
                $excel->sheet('Sheet1', function ($sheet) use ($data) {
                    $row = 1;

                    $sheet->row($row, [
                        'No',
                        'Username',
                        'Password',

                    ]);
                    $sheet->cell('A1:C1', function ($cell) {
                        $cell->setFontWeight('bold');
                    });

                    foreach ($data as $value) {
                        $sheet->row(++$row, [
                            $row - 1,
                            $value->username,
                            $value->password,

                        ]);
                    }
                });
            })->export('xls');

        }
        DB::table('logs')
            ->insert(['action' => 'Print', 'action_by' => Auth::user()->name, 'description' => 'Print Voucher ' . $name . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

    }

    public function printvoucherguest(Request $request, $id)
    {
        $ids = DB::table('voucher_user')
            ->where('id', '=', $id)
            ->value('username');
        $data = DB::select(DB::raw('select voucher_user.* ,value from voucher_user,radcheck where voucher_user.id=\'' . $id . '\' and voucher_user.username=radcheck.username and attribute=\'Expiration\''));
        DB::table('logs')
            ->insert(['action' => 'Print', 'action_by' => Auth::user()->name, 'description' => 'Print Guest Voucher ' . $ids . ' by ' . Auth::user()->name, 'created' => Carbon::now('Asia/Makassar')]);

        view()->share('data', $data);

        PDF::SetTitle('Print Guest In House Voucher');
        PDF::AddPage('P', 'A4');
        PDF::writeHTML(view('voucher.view')->render());
        PDF::Output('voucherguestinhouse.pdf');


    }

    public function index()
    {
        //
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
