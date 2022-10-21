<div class="card-body border-bottom py-3">
    <div class="ms-auto text-muted">
        {{__('Поиск по ID')}}:
        <div class="ms-2 d-inline-block">
            <form action="">

                <div class="row g-2">
                    <div class="col">
                        <input name="find_id_payment" type="text" class="form-control" placeholder="123">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-icon" aria-label="Button">
                            <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><circle cx="10" cy="10" r="7"></circle><line x1="21" y1="21" x2="15" y2="15"></line></svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="table card-table table-vcenter text-nowrap datatable">
        <thead>
        <tr>
            <th>{{__('ID')}}</th>
            <th>{{__('Сумма')}}</th>
            @if(Route::is('admin*'))
                <th>{{__('Комиссия')}}</th>
            @endif
            <th>{{__('Отправитель')}}</th>
            <th>{{__('Получатель')}}</th>
            <th>{{__('Дата')}}</th>
        </tr>
        </thead>
        <tbody>

        @foreach($payments as $data)
            <tr>
                <td>
                    <strong>{{$data->id}}</strong>
                </td>
                <td>
                    @if(Route::is('admin*'))
                        <strong class="">{{$data->amount}} руб.</strong>
                    @else
                        @if($data->from == Auth::user()->id)
                            <strong class="text-danger">-{{$data->amount + $data->fee}} руб.</strong>
                        @else
                            <strong class="text-success">+{{$data->amount}} руб.</strong>
                        @endif
                    @endif

                </td>
                @if(Route::is('admin*'))
                    <td>
                        <strong class="text-success">+{{$data->fee}} руб.</strong>
                    </td>
                @endif
                <td>
                    <strong><a>{!! $data->from == Auth::user()->id ? '<span class="text-primary">Я</span>' : $data->from !!}</a></strong>
                </td>
                <td>
                    <strong><a>{!! $data->to == Auth::user()->id ? '<span class="text-primary">Я</span>' : $data->to !!}</a></strong>
                </td>
                <td>
                    <strong class="text-muted">{{ $data->created_at ? $data->created_at->format('d.m.Y H:i:s') : '' }}</strong>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if($payments->isEmpty())
        <p class="text-center mt-3 text-muted w-100"><strong class="">{{__('Нет платежей')}}</strong></p>
    @endif

</div>

@if(!$payments->isEmpty())
<div class="card-footer d-flex align-items-center">

    <div class="d-flex">
        {!! $payments->links() !!}
    </div>

</div>

@endif

<script>
    let name_body_scroll_route = localStorage.getItem("body-scroll-name");
    if(name_body_scroll_route == null || name_body_scroll_route != "{{Route::currentRouteName()}}"){
        localStorage.setItem("body-scroll-name", "{{Route::currentRouteName()}}");
    } else {
        let body_scroll = localStorage.getItem("body-scroll");
        if (body_scroll !== null) {
            window.scrollTo({ top:body_scroll, left:0, behavior: "instant"});
        }
    }


    window.addEventListener('scroll', function() {
        console.log('scrolling');
        localStorage.setItem("body-scroll", window.scrollY);

    });
</script>
