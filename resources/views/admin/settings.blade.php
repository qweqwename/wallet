@extends('layouts.base')

@section('title', 'Админ панель')

@section('content')

    <div class="row row-cards">
        <div class="col-12 col-md-7 d-flex order-md-1  order-1">
            <div class="card w-100 active">
                <div class="card-header">
                    <div class="col">
                        <div class="card-title">
                            {{__('Изменить комиссию')}}
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{route('admin.update')}}">
                    @method('PUT')
                    @csrf
                    <div class="card-body">

                        @include('includes.card-alert')

                        <div class="mb-0">
                            <label
                                    class="form-label required mb-3 mt-2">{{__('Сколько процентов Вы будете получать с платежей пользователей')}}</label>
                            <div class="input-group mb-2">
                                <input value="{{$fee}}" oninput="inputFeeCnanged(this.value)"
                                       onchange="inputFeeCnanged(this.value)" id="inputFee" name="fee" type="text"
                                       class="form-control" placeholder="5" autocomplete="off">
                                <span class="input-group-text">
                                %
                            </span>
                            </div>
                            <input id="rangeFee" oninput="rangeFeeCnanged(this.value)"
                                   onchange="rangeFeeCnanged(this.value)" type="range" class="form-range mb-0"
                                   value="{{$fee}}" min="0" max="10" step="0.1">
                            <script>
                                function rangeFeeCnanged(value) {
                                    document.querySelector('#inputFee').value = value;
                                }

                                function inputFeeCnanged(value) {
                                    document.querySelector('#rangeFee').value = value;
                                }
                            </script>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <button type="submit" class="btn btn-primary w-100">
                                {{__('Сохранить')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 col-md-5 d-flex order-md-2  order-3 d-none">
            <div class="card w-100">
                <div class="card-header">
                    <div class="col">
                        <div class="card-title">
                            {{__('Статистика за 30 дней')}}
                        </div>
                    </div>
                </div>
                <form action="">
                    <div class="card-body">
                        <canvas id="myChart" style="width:100%; height:100%;max-height: 300px"></canvas>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 col-md-12 d-flex order-md-3  order-2 mb-4">
            <div class="card w-100">
                <div class="card-header">
                    <div class="col">
                        <div class="card-title">
                            {{__('История заработка с комиссии')}}
                        </div>
                    </div>
                </div>
                @include('includes.history-payments')
            </div>
        </div>
    </div>

@endsection
