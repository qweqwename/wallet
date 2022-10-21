@extends('layouts.base')

@section('title', 'Отправить деньги')

@section('content')

    <div class="row row-cards justify-content-center">
        <div class="col-12 col-md-7 d-flex order-md-1  order-1">
            <div class="card w-100 active">
                <x-card-header>
                    {{__('Отправить деньги')}}
                </x-card-header>
                <form method="POST" action="{{route('payment.store')}}">
                    @csrf
                    <div class="card-body">

                        @include('includes.card-alert')

                        <div class="mb-3 mt-2">
                            <label class="form-label required mb-3">{{__('Введите номер кошелька')}}</label>
                            <input pattern="^\d*$" value="{{request()->old('id')}}" autocomplete="off" type="text" class="form-control"
                                   name="id" placeholder="123456789">
                        </div>
                        <div class="mb-3">
                            <label class="form-label required mb-3">{{__('Сумма платежа')}}</label>
                            <input onchange="inputAmountChanged(this.value)"
                                   oninput="inputAmountChanged(this.value)" value="{{request()->old('amount')}}"
                                   autocomplete="off" replacecomma="true" pattern="^\d*([\,\.]\d{0,2})?$" type="text" class="form-control" id="inputAmount" name="amount"
                                   placeholder="100.45">
                        </div>

                        <div class="alert alert-primary py-2">Будет списано <strong><span id="amountWithFee">0</span>
                                руб.</strong> с учетом комиссии <strong><span id="fee">{{$fee}}</span>%</strong></div>

                    </div>
                    <div class="card-footer">
                        <div class="row align-items-center">
                            <button type="submit" class="btn btn-primary w-100">
                                Отправить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 col-md-5 d-flex order-md-2  order-3">
            <div class="card w-100">
                <x-card-header>
                    {{__('Статистика за 30 дней')}}
                </x-card-header>
                <form action="">
                    <div class="card-body">
                        <canvas id="myChart" style="width:100%; height:100%;max-height: 300px"></canvas>
                    </div>
                </form>
            </div>
        </div>


        <div class="col-12 col-md-12 d-flex order-md-3  order-2 mb-4">
            <div class="card w-100">
                <x-card-header>
                    {{__('История платежей')}}
                </x-card-header>
                @include('includes.history-payments')
            </div>
        </div>

        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Отправлено {{$stats->transfer}} руб.', 'Получено {{$stats->get}} руб.'],
                    datasets: [{
                        label: ' рублей',
                        data: [{{$stats->transfer}}, {{$stats->get}}],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                        ],
                        borderWidth: 1
                    }]
                },

                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    return context.label;
                                }
                            }
                        }
                    },
                    animation: {
                        duration: 0
                    },
                },
            });


            let fee = {{$fee}};

            Number.prototype.toFixedNoRounding = function (n) {
                const reg = new RegExp("^-?\\d+(?:\\.\\d{0," + n + "})?", "g")
                const a = this.toString().match(reg)[0];
                const dot = a.indexOf(".");
                if (dot === -1) { // integer, insert decimal dot and pad up zeros
                    return a + "." + "0".repeat(n);
                }
                const b = n - (a.length - dot) + 1;
                return b > 0 ? (a + "0".repeat(b)) : a;
            }


            inputAmountChanged(document.querySelector('#inputAmount').value);


            $(document).on('keydown', 'input[pattern]', function(e){
                var input = $(this);
                var oldVal = input.val();
                var regex = new RegExp(input.attr('pattern'), 'g');

                setTimeout(function(){
                    var newVal = input.val();
                    if(!regex.test(newVal)){
                        input.val(oldVal);
                    }

                    if(input.attr('replacecomma')){
                        input.val(input.val().replace(',', '.'));
                    }
                }, 1);
            });

            function inputAmountChanged(value) {
                console.log(value);
                if (value == null || value == '') {
                    value = '0';
                }

                let withFee = (0.00).toFixedNoRounding(2);

                try {
                    let newVal = parseFloat(parseFloat(value.replace(',', '.')).toFixedNoRounding(2));

                    withFee = (newVal + (newVal / 100 * fee)).toFixedNoRounding(2);
                } catch (e) {
                    console.log(e);
                }

                document.querySelector('#amountWithFee').textContent = withFee;
                document.querySelector('#fee').textContent = fee;
            }
        </script>
    </div>
@endsection
