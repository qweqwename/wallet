@extends('layouts.base')

@section('title', 'Изменить пароль')

@section('content')
    @include('includes.modal-alert')
    <div class="row row-cards justify-content-center mb-3">
        <div class="col-12 col-md-6 float-none">
            <div class="card w-100 active">
                <x-card-header>
                    {{__('Изменить пароль')}}
                </x-card-header>
                <form method="POST" action="{{route('user.update')}}">
                    @method('PUT')
                    @csrf
                    <div class="card-body">

                        @include('includes.card-alert')

                        <div class="mb-3 mt-2">
                            <label class="form-label required mb-3">{{__('Введите старый пароль')}}</label>
                            <input autofocus autocomplete="off" type="password" class="form-control" name="old_password" placeholder="Lxf6NewWPe8f">
                        </div>
                        <div class="mb-3 mt-2">
                            <label class="form-label required mb-3">{{__('Введите новый пароль')}}</label>
                            <input autofocus autocomplete="off" type="password" class="form-control" name="new_password" placeholder="Lxf6NewWPe8f">
                        </div>
                        <div class="mb-1 mt-2">
                            <label class="form-label required mb-3">{{__('Введите пароль еще раз')}}</label>
                            <input autofocus autocomplete="off" type="password" class="form-control" name="confirm_password" placeholder="Lxf6NewWPe8f">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <button type="submit" class="btn btn-primary w-100">
                                Обновить пароль
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
