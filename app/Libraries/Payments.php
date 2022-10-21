<?php

namespace App\Libraries;

use App\Models\Setting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Payments
{
    static public function createPayment($to, $amountTransfer){
        DB::beginTransaction();
        $userTo = DB::table('users')->where('id', '=', $to)->get()->first();

        if($userTo != null){
            $userFrom = DB::table('users')->where('id', '=', Auth::user()->id)->get()->first();

            $settings = Setting::first();
            $fee = $settings->fee;
            $feeTransfer = $amountTransfer / 100 * $fee;
            preg_match('/^-?[0-9]+(?:\.[0-9]{1,2})?/', $feeTransfer, $matches);
            $feeTransfer = floatval($matches[0]);

            if($userFrom->balance >= ($amountTransfer + $feeTransfer)){
                DB::table('users')->where('id', '=', Auth::user()->id)->decrement(
                    'balance', ($amountTransfer + $feeTransfer)
                );

                DB::table('users')->where('id', '=', $userTo->id)->increment(
                    'balance', $amountTransfer
                );

                DB::table('users')->where('id', '=', $settings->admin_id)->increment(
                    'balance', $feeTransfer
                );

                $date = Carbon::now();

                DB::table('payments')->insert([
                    'amount' => $amountTransfer,
                    'from' => Auth::user()->id,
                    'to' => $userTo->id,
                    'fee' => $feeTransfer,
                    'created_at' => $date,
                ]);
            } else {
                DB::rollBack();
                return (object)[
                    "status" => false,
                    "message" => 'На Вашем счету недостаточно средств',
                ];}
        } else {
            DB::rollBack();
            return (object)[
                "status" => false,
                "message" => 'Пользователя с таким кошельком не существует',
            ];
        }

        DB::commit();

        return (object)[
            "status" => true,
            "message" => '',
        ];

    }

    static public function getReplenishLink($amount){

        $insert_id = DB::table('replenishments')->insertGetId([
            "user_id" => Auth::user()->id,
            "amount" => $amount,
            "status" => 0,
            "created_at" => Carbon::now()
        ]);

        $merchant_id = '11923';
        $secret_word = '=ysH8!gV&L^j3Ur';
        $order_id = $insert_id;
        $order_amount = $amount;
        $currency = 'RUB';
        $sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$currency.':'.$order_id);

        return 'https://pay.freekassa.ru/?m='.$merchant_id.'&oa='.$order_amount.'&o='.$order_id.'&s='.$sign.'&currency='.$currency;
    }
}
