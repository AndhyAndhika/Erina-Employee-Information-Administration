
{{-- Sidebar --}}
<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion text-dark" id="sidenavAccordion" style="background-color: #dcdce6;">
        <div class="sb-sidenav-menu">
            <div class="nav fs-5">
                {{-- Logo TPL --}}
                <a href="{{ route('dashboard') }}">
                    <img src="{{ asset('img/logo-tpl.png') }}" class="d-block mx-auto mt-3" alt="{{ asset('img/logo-tpl.png') }}" style="width: 12rem;">
                </a>

                <div class="sb-sidenav-menu-heading"></div>

                {{-- Menu link to dashboard --}}
                <a class="nav-link hover-text-dark" href="{{ route('dashboard') }}">
                    <div class="sb-nav-link-icon"><i class="fa-solid fa-chalkboard-user fa-lg"></i></div>
                    Dashboard
                </a>

                {{-- Menu link to Employee --}}
                <a class="nav-link hover-text-dark" href="{{ route('employee.MyProfile', ['id' => Crypt::encrypt(Auth::user()->id)]) }}">
                    <div class="sb-nav-link-icon"><i class="fa-regular fa-address-card fa-lg"></i></div>
                    My Profile
                </a>

                @if (Auth::user()->role == "admin")
                    {{-- Menu link to Employee --}}
                    <a class="nav-link hover-text-dark" href="{{ route('employee.index') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-users fa-lg"></i></div>
                        Employee
                    </a>
                @endif

            </div>
        </div>

        {{-- Footer to update Version --}}
        <div class="sb-sidenav-footer">
            <div class="d-flex align-items-center justify-content-center small">
                <p class="mb-0"><i class="text-muted fa-solid fa-code-commit small"> : V1.0.0 </i></p>
            </div>
        </div>
    </nav>
</div>


