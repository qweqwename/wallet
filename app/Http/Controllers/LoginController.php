<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('login.index');
    }

    public function loginAsAdmin(Request $request){
        Auth::loginUsingId(1);
        $request->session()->regenerate();
        return redirect()->route('admin');
    }

    public function store(Request $request)
    {
        $validated = validator($request->all(), [
            'id' => ['required', 'string'],
            'password' => ['required', 'string'],
            'remember' => ['boolean'],
        ])->validate();

        if (Auth::attempt([
            'id' => $validated['id'],
            'password' => $validated['password'],
        ], isset($validated['remember']) ?? false)) {
            $request->session()->regenerate();
            return redirect()->route('payment.transfer');
        } else {
            return redirect()->back()->withErrors('Неправильный кошелек или пароль')->withInput();
        }

    }
}
