<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('app.name'))</title>

    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta12/dist/js/tabler.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta12/dist/css/tabler.min.css">
    <link rel="stylesheet" href="/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script
        src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ="
        crossorigin="anonymous"></script>

</head>
<body>
@include('includes.modal-alert')
<div class="page pb-1">
    @include('includes.menu')
    <div class="page-wrapper">
        {{--<x-page-header>
            @yield('title')
        </x-page-header>--}}

        <div class="container-sm">

            @yield('content')
        </div>

    </div>



</div>




</body>
</html>
