@extends('layouts.app', ['title' => 'Dashboard'])
@section('content')
<div class="row mb-3">
    <p class="fw-bold h3">Dashboard</p>
</div>

<div class="row">
    {{-- Card side left --}}
    <div class="col-4" >
        <div class="d-flex justify-content-center" >
            <div class="card" style="width: 20rem; height:25rem;">
                <div class="card-body text-center">
                    <img src="{{ asset('img/' . Auth::user()->userDetails->gender . '.png') }}" class="rounded-circle mt-3 mb-3" alt="{{ Auth::user()->userDetails->gender }}" style="height: 11rem;">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item fw-bold mt-4 fs-4">{{ Auth::user()->name }}</li>
                        <li class="list-group-item fs-5">{{ Auth::user()->employee_number }}</li>
                        <li class="list-group-item fs-5">{{ Auth::user()->userDetails->position }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Card side right --}}
    <div class="col-8">
        <div class="row ">

            {{-- Not Present --}}
            <div class="card mb-3 mx-2" style="max-width: 47.5%;">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center justify-content-center bg-danger text-light">
                        <i class="fas fa-calendar-times fa-3x"></i>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">NOT PRESENT</h5>
                            <p class="card-text fs-4"> <span id="not_present">{{ rand(1, 10) }}</span> Day</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Medical Balance --}}
            <div class="card mb-3 mx-2" style="max-width: 47.5%;">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center justify-content-center bg-warning ">
                        <i class="fa-solid fa-briefcase-medical fa-3x"></i>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">MEDICAL BALANCE</h5>
                            <p class="card-text fs-4">  <span id="medical_balance">@currency(rand(1, 10) * 500000)</span> </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Leave Balance --}}
            <div class="card mb-3 mx-2" style="max-width: 47.5%;">
                <div class="row g-0">
                    <div class="col-md-4 d-flex align-items-center justify-content-center bg-primary text-light">
                        <i class="fa-solid fa-person-through-window fa-3x"></i>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">LEAVE BALANCE</h5>
                            <p class="card-text fs-4"> <span id="leave_balance">{{ rand(1, 10) }}</span> Day</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('js')
    <script>

    </script>
@endpush
