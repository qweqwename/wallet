<?php

namespace App\Http\Controllers;

use App\Libraries\Payments;
use App\Models\Payment;
use App\Models\Replenishment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReplenishmentController extends Controller
{
    //
    public function create(Request $request){
        if($request->input('find_id_payment')){
            $replenishments = Replenishment::where('id', '=', $request->input('find_id_payment'))->where(function ($query) {
                $query->where('user_id', '=', Auth::user()->id);
            })->paginate(10);
        } else {
            $replenishments = Replenishment::where('user_id', '=', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        }
        return view('replenishment.index',compact( 'replenishments'));
    }

    public function store(Request $request){

        $amountReplenish = str_replace(',', '.', $request->amount_replenish ?? '');
        if(preg_match('/^-?[0-9]+(?:\.[0-9]{1,2})?/', $amountReplenish, $matches)){
            $amountReplenish = floatval($matches[0]);
        }

        $request->merge([
            'amount_replenish' => $amountReplenish,
        ]);

        validator($request->all(), [
            'amount_replenish' => ['required', 'numeric', 'min:0.01', 'regex:/^-?[0-9]+(?:\.[0-9]{1,2})?$/'],
        ])->validate();

        DB::beginTransaction();
        DB::table('users')->where('id', '=', Auth::user()->id)->increment(
            'balance', ($amountReplenish)
        );
        $insert_id = DB::table('replenishments')->insertGetId([
            "user_id" => Auth::user()->id,
            "amount" => $amountReplenish,
            "status" => 1,
            "created_at" => Carbon::now()
        ]);
        DB::commit();

        return redirect()->route('replenishment.create')->with('modal',
            (object)[
                'title' => 'Готово',
                'content' => "Ваш счет пополнен на $amountReplenish рублей!",
            ]
        );

        /*return redirect(Payments::getReplenishLink($amountReplenish));*/
    }
}
