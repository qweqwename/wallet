<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function settings(Request $request)
    {
        $fee = Setting::first()->fee;

        if($request->input('find_id_payment')){
            $payments = Payment::where('id', '=', $request->input('find_id_payment'))->where(function ($query) {
                $query->where('from', '=', Auth::user()->id)->orWhere('to', '=', Auth::user()->id);
            })->paginate(10);
        } else {
            $payments = Payment::orderBy('id', 'desc')->paginate(10);
        }

        return view('admin.settings', compact('fee', 'payments'));
    }

    public function update(Request $request)
    {
        validator($request->all(), [
            'fee' => ['required', 'numeric', 'between:0.00,10.00', 'regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/'],
        ])->validate();

        Setting::whereId(1)->update([
            'fee' => $request->fee,
        ]);

        return redirect()->route('admin')->with('modal',
            (object)[
                'title' => 'Готово',
                'content' => 'Комиссия за переводы изменена на '.$request->fee.'%',
            ]
        );
    }
}
