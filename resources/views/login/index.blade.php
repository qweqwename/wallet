@extends('layouts.bootstrap')

@section('title', __('Авторизация'))

@section('content')

    <body class="border-top-wide border-primary d-flex flex-column theme-light">
    <div class="page">
        <div class="container container-tight py-1">
            <div class="text-center mb-1">
                <a href="{{route('home')}}" class="navbar-brand navbar-brand-autodark"><img src="images/wallet.svg"
                                                                                            height="74" alt=""></a>
            </div>
            <div class="card card-md">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">{{__('Авторизация')}}</h2>

                    @include('includes.card-alert')

                    <form action="{{route('login.store')}}" method="post" autocomplete="off" novalidate="">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label required">{{__('ID кошелька')}}</label>
                            <input autofocus autocomplete="off" value="{{request()->old('id')}}" name="id"
                                   type="text" class="form-control" placeholder="123456789" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">
                                {{__('Пароль')}}
                            </label>
                            <div class="input-group input-group-flat">
                                <input autocomplete="off" id="password" value="{{request()->old('password')}}"
                                       name="password" type="password" class="form-control"
                                       placeholder="{{__('Ваш пароль')}}" autocomplete="off">
                                <span class="input-group-text">
                                    <a onclick="(document.getElementById('password').type == 'password' ? document.getElementById('password').type = 'text' : document.getElementById('password').type = 'password')"
                                       class="link-secondary pointer" data-bs-toggle="tooltip"
                                       aria-label="Show password"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                           viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                           stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                                d="M0 0h24v24H0z"
                                                                                                fill="none"></path><circle
                                              cx="12" cy="12" r="2"></circle><path
                                              d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7"></path></svg>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="mb-2">
                            <label class="form-check">
                                <input {{request()->old('remember') ? 'checked' : ''}} value="1" name="remember"
                                       type="checkbox" class="form-check-input">
                                <span class="form-check-label">{{__('Запомнить меня')}}</span>
                            </label>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-block w-100">{{__('Войти')}}</button>
                        </div>

                        <div class="hr-text">{{__('ИЛИ')}}</div>

                        <a href="{{route('loginAsAdmin')}}" class="btn btn-success btn-block w-100">{{__('Войти как администратор')}}</a>


                    </form>
                </div>
            </div>
            <div class="text-center text-muted mt-3">
                <p>{{__('Нет аккаунта?')}} <a href="{{route('register')}}">Быстрая регистрация</a></p>
            </div>
        </div>
    </div>
    </body>
@endsection
