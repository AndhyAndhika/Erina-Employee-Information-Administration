<!DOCTYPE html>
<html lang="en" class="notranslate">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{ asset('img/logo-tpl.png') }}" type="image/x-icon"/>
        <title>{{ $title }}</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
        <link href="{{ asset('css/datatables.css') }}" rel="stylesheet">
        <script src="{{ asset('js/jquery.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/jquerydatatables.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/fontawesome.js') }}" crossorigin="anonymous"></script>
        <link href="{{ asset('css/toastr.min.css') }}" rel="stylesheet" />
        @stack('css')
    </head>
    <body class="sb-nav-fixed" style="background-color: #f7fcf5">
        @yield('app')
        @include('sweetalert::alert')
        <script src="{{ asset('js/bootstrap.js') }}"></script>
        <script src="{{ asset('js/scripts.js') }}"></script>
        <script src="{{ asset('js/toastr.min.js')}}"></script>
        <script src="{{ asset('js/dataTables.rowsGroup.js')}}"></script>
        <script src="{{ asset('js/dataTables.rowReorder.js')}}"></script>
        <script>
            /* Untuk Rubah Title ketika sedang tidak dibuka */
            var title = document.title;
            document.addEventListener('visibilitychange', function() {
                document.title
                if (document.hidden) {
                    document.title = 'Hey, come back!';
                } else {
                    document.title = title;
                }
            });
        </script>
        @stack('js')
    </body>
</html>
