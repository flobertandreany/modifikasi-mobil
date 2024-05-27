@if(auth()->check() && auth()->user()->isAdminOrStore())
    <nav class="navbar" style="background-color: #363636;">
        <div class="container-fluid">
            <div class="d-flex flex-column" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSidebar" style="margin-left: 2rem;">
                <i class="bi bi-list text-white fs-3"></i>
                <span class="text-white" style="font-size: 11px;">Menu</span>
            </div>
            <img class="mt-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
            <!-- Button profile trigger modal -->
            <div type="button" class="" style="display: grid; justify-items: center; margin-right: 3rem;" data-bs-toggle="modal" data-bs-target="#profileModal">
                <i class="bi bi-person-circle text-white fs-4"></i>
                <span class="text-white" style="font-size: 11px;">Profile</span>
            </div>
        </div>
    </nav>
@else
    <nav class="navbar" style="background-color: #363636;">
        <div class="container-fluid" style="justify-content: center;">
            <img class="mt-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
        </div>
        <div class="container-fluid">
            <div class="d-flex flex-column" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSidebar">
                <i class="bi bi-list text-white fs-3"></i>
                <span class="text-white" style="font-size: 11px;">Menu</span>
            </div>
            @if(auth()->check())
                @if (auth()->user()->isUser())
                    @if(auth()->user()->user_cars()->exists()){}
                    @php
                        $car = auth()->user()->user_cars()->first();
                        // $model =
                    @endphp
                    <div class="user_car" style="width: 154px; height: 51px; position: relative">
                        {{-- <div style="width: 154px; height: 51px; left: 0px; top: 0px; position: absolute; background: #202020; border-radius: 8px"></div> --}}
                        <img style="width: 57px; height: 38px; left: 3px; top: 6px; position: absolute" src="" />
                        <div style="width: 88px; height: 38px; left: 60px; top: 6px; position: absolute; color: white; font-size: 10px; font-family: Montserrat; font-weight: 500; line-height: 14px; letter-spacing: 0.50px; word-wrap: break-word">2024 Daihatsu<br/>All New Ertiga, K15C</div>
                    </div>
                    @endif
                @endif
            @endif
            <input class="form-control me-2" style="width: 50%;" type="search" placeholder="Search" aria-label="Search">
            <!-- Button profile trigger modal -->
            @auth
                <div type="button" class="" style="display: grid; justify-items: center; margin-right: 30px;" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="bi bi-person-circle text-white fs-4"></i>
                    <span class="text-white" style="font-size: 11px;">Profile</span>
                </div>
            @else
            <div type="button" class="">
                <a href="{{ route('view.login') }}" style="display: grid; justify-items: center; margin-right: 30px; text-decoration: none;">
                    <i class="bi bi-person-circle text-white fs-4"></i>
                    <span class="text-white" style="font-size: 11px;">Sign In</span>
                </a>
            </div>
            @endauth
        </div>
    </nav>
@endif
<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        @include('components.profileModal')

        @stack('content_profile_css')

        @stack('content_profile_js')

    </div>
</div>
<!-- Menu Sidebar -->
<div class="collapse collapse-horizontal" id="collapseSidebar" style="background-color: #363636; max-width: 0px; position: absolute;">
    <div style="min-height: 120px;">
        <div class="card card-body" style="width: 223px; background-color: #363636; border-radius: 0 0 10px 0;">
            @if(auth()->check())
                @if(auth()->user()->isAdmin())
                    <!-- Navbar untuk admin -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('admin.store.approval') }}">Store Approval List</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('view.store.list') }}">Store List</a>
                        </li>
                        <li class="nav-item">
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('car.brand.list') }}">Manage Car Brand</a>
                            </li>
                            <a class="nav-link text-white" href="{{ route('car.model.list') }}">Manage Car Model</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('car.engine.list') }}">Manage Car Engine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('car.part.list') }}">Manage Parts</a>
                        </li>
                    </ul>
                @elseif(auth()->user()->isStore())
                    <!-- Navbar untuk store -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('store.productList') }}">Product List</a>
                        </li>
                    </ul>
                @else
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#">user dan guest</a>
                        </li>
                    </ul>
                @endif
            @else
                <!-- Navbar untuk pengunjung tanpa login -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">user dan guest</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li> --}}
                </ul>
            @endif
        </div>
    </div>
</div>
@push('content_css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>

    </style>
@endpush
@push('content_js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        // Panggil fungsi reset saat modal profile ditutup
        $('#profileModal').on('hidden.bs.modal', function (e) {
            location.reload();
        });

        // Handler untuk mengatasi klik di luar div collapse
        $(document).click(function (event) {
            $('.collapse-horizontal').removeClass('show');
        });
    </script>
@endpush
