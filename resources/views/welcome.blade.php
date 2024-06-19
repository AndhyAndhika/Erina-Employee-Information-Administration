@extends('layouts.core', ['title' => 'Welcome!'])
@section('app')
<main>
    <div class="container-fluid">

        <nav class="navbar px-4">
            <span class="navbar-text ms-auto text-dark align-items-center">
                @auth
                    <a class="fs-5 text-decoration-none btn btn-light" href="{{ route('dashboard') }}">Back to dashboard <i class="fa-solid fa-chalkboard-user"></i></a>
                @else
                    <a class="fs-5 text-decoration-none btn btn-light" href="{{ route('login') }}">Log in <i class="fa-solid fa-right-to-bracket"></i></a>
                @endauth
            </span>
        </nav>

        <div class="d-flex align-items-center justify-content-center" style="height: 80vh;">
            <div class="card text-center shadow-lg p-3 mb-5 bg-body-tertiary rounded" style="width: 80vw;">
                <div class="mt-3 text-center">
                    <img src="{{ asset('img/logo-tpl.png') }}" class="rounded mx-auto d-block my-3" alt="{{ asset('img/logo-tpl.png') }}" style="width: 15rem;">
                    <p class="display-5 fw-bold text-uppercase ">E R I N A</p>
                    <p class="display-5">Employee Information & Administration </p>
                </div>
            </div>
        </div>

        <footer class="footer fixed-bottom d-flex bg-muted justify-content-end align-items-end p-3">
            <p class="mb-0 fs-6"><i class="fa-brands fa-laravel text-danger fs-5"></i> Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})</p>
        </footer>
    </div>
</main>
@endsection
