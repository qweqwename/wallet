<?php

namespace App\Http\Controllers;

use App\Libraries\Payments;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    public function transfer(Request $request)
    {
        $dateStart = Carbon::now()->subMonth(1);

        $transferLastMonth = Payment::where([
            ['created_at', '>=', $dateStart],
            ['from', '=', \auth()->user()->id],
        ])->sum(DB::raw('amount + fee'));

        $getLastMonth = Payment::where([
            ['created_at', '>=', $dateStart],
            ['to', '=', \auth()->user()->id],
        ])->sum(DB::raw('amount'));

        $stats = (object)[
            'transfer' => $transferLastMonth,
            'get' => $getLastMonth,
        ];

        $fee = Setting::first()->fee;

        if($request->input('find_id_payment')){
            $payments = Payment::where('id', '=', $request->input('find_id_payment'))->where(function ($query) {
                $query->where('from', '=', Auth::user()->id)->orWhere('to', '=', Auth::user()->id);
            })->paginate(10);
        } else {
            $payments = Payment::where('from', '=', Auth::user()->id)->orWhere('to', '=', Auth::user()->id)->orderBy('id', 'desc')->paginate(25);
        }

        return view('payment.transfer', compact('fee', 'payments', 'stats'));
    }

    public function store(Request $request)
    {
        validator($request->all(), [
            'id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric', 'min:0.01', 'regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/'],
        ])->validate();

        $payment = Payments::createPayment($request->id, $request->input('amount'));
        if($payment->status == true){
            return redirect()->route('payment.transfer')->with('modal',
                (object)[
                    'title' => 'Готово',
                    'content' => 'Перевод успешно выполнен!',
                ]
            );
        } else {
            return redirect()->back()->withErrors($payment->message)->withInput();
        }
    }

    public function show($id)
    {
        return view('payment.show');
    }
}
