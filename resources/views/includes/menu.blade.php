<div class="sticky-top">
    <header class="navbar navbar-expand-md navbar-light sticky-top d-print-none">
        <div class="container">
            <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar-menu" aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
            </button>
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                <a href=".">
                    <img src="/images/wallet.svg" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                </a>
            </h1>
            <div class="navbar-nav flex-row order-md-last">
                <div class="nav-item dropdown">
                    <div class="nav-link d-flex lh-1 text-reset p-0 user-dropdown" data-bs-toggle="dropdown"
                       aria-label="Open user menu" aria-expanded="false">
                            <span class="avatar avatar-sm"
                                  style="background-image: url(./static/avatars/000m.jpg)">
                                <x-icons.user></x-icons.user>
                            </span>
                        <div class="ps-2 pe-2">
                            <div class="d-none d-md-block mb-1">{{Auth::user()->id}}</div>
                            <strong class="font-weight-bold">{{Auth::user()->balance}} руб.</strong>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <a class="dropdown-item" href="{{route('user.settings')}}">
                            {{__('Изменить пароль')}}
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('user.logout')}}">
                            {{__('Выход')}}
                        </a>
                    </div>
                </div>
            </div>
            <div class="navbar-collapse collapse" id="navbar-menu" style="">
                <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
                    <ul class="navbar-nav">
                        <li class="nav-item {{active_link('payment.transfer')}}">
                            <a class="nav-link" href="{{route('payment.transfer')}}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                      <x-icons.transfer/>
                    </span>
                                <span class="nav-link-title">
                      {{__('Платежи')}}
                    </span>
                            </a>
                        </li>
                        {{--<li class="nav-item {{active_link('payment.history')}}">
                            <a class="nav-link" href="{{route('payment.history')}}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
                        <x-icons.history/>
                    </span>
                                <span class="nav-link-title">
                      {{__('История')}}
                    </span>
                            </a>
                        </li>--}}

                        <li class="nav-item {{active_link('replenishment.create')}}">
                            <a class="nav-link" href="{{route('replenishment.create')}}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
<x-icons.replenish/>
                    </span>
                                <span class="nav-link-title">
                      {{__('Пополнить')}}
                    </span>
                            </a>
                        </li>

                        @if(auth()->user()->isAdmin())
                            <li class="nav-item {{active_link('admin')}}">
                                <a class="nav-link" href="{{route('admin')}}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
<x-icons.admin/>
                    </span>
                                    <span class="nav-link-title">
                      {{__('Админ панель')}}
                    </span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </header>
</div>
