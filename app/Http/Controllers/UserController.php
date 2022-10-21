<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function settings()
    {
        return view('user.settings');
    }

    public function update(Request $request)
    {
        validator($request->all(), [
            'old_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:6', 'max:100'],
            'confirm_password' => ['required', 'string'],
        ])->validate();

        if(!Hash::check($request['old_password'], Auth::user()->password)){
            return redirect()->back()->withErrors('Неправильный текущий пароль')->withInput();
        }

        if($request['new_password'] != $request['confirm_password']){
            return redirect()->back()->withErrors('Новый пароль не совпадает')->withInput();
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request['new_password']),
        ]);

        return redirect()->route('user.settings')->with('modal',
            (object)[
                'title' => 'Готово',
                'content' => 'Вы успешно изменили пароль!',
            ]
        );
    }

    public function logout()
    {
        Session::flush();

        Auth::logout();

        return redirect()->route('home');
    }
}
