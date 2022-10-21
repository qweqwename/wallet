@extends('layouts.base')

@section('title', 'Пополнить счет')

@section('content')

    <div class="row row-cards">
        <div class="col-12 col-md-6 d-flex order-md-1  order-1">
            <div class="card w-100 active">
                <x-card-header>
                    {{__('Пополнить счет')}}
                </x-card-header>
                <form method="POST" action="{{route('replenishment.store')}}">
                    @csrf
                    <div class="card-body">

                        @include('includes.card-alert')

                        <div class="mb-1 mt-2">
                            <label
                                class="form-label required mb-3">{{__('На сколько рублей хотите пополнить счет?')}}</label>
                            <input autocomplete="off" type="text" class="form-control" name="amount_replenish"
                                   placeholder="100">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <button type="submit" class="btn btn-primary w-100">
                                {{__('Перейти к пополнению')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 col-md-5 d-flex order-md-2  order-3 d-none">
            <div class="card w-100">
                <x-card-header>
                    {{__('Статистика за 30 дней')}}
                </x-card-header>
                <form action="">
                    <div class="card-body">
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 col-md-12 d-flex order-md-3  order-2 mb-4">
            <div class="card w-100">
                <x-card-header>
                    {{__('История пополнений')}}
                </x-card-header>
                @include('includes.history-replenishments')
            </div>
        </div>

    </div>

@endsection
