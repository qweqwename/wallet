<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    //

    public function index(Request $request){

        $password = Str::random(12);

        $user = User::create([
            'balance' => 1000,
            'password' => $password,
        ]);

        auth()->login($user);

        return redirect()->route('payment.transfer')->with('modal',
            (object)[
                'title' => 'Запишите Ваши данные для входа:',
                'content' => "<label class='form-label'>Это Ваш логин:</label>
                <input readonly class='form-control' value='$user->id'>
                <label class='form-label mt-2'>Это Ваш пароль:</label>
                <input readonly class='form-control' value='$password'>",
            ]
        );
    }
}
