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
@elseif(auth()->check() && auth()->user()->isUser())
    <nav class="navbar" style="background-color: #363636;">
        <a href="{{ route('home') }}" class="container-fluid" style="justify-content: center;">
            <img class="mt-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
        </a>
        <div class="container-fluid" style="flex: 1">
            <div class="d-flex flex-row" style="padding-left: 10px;">
                <div class="d-flex flex-column" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSidebar" style="align-items: center; padding-top: 10px;">
                    <img src="{{ asset('img/Logo/burger.png') }}" style="width: 22px;" alt="">
                    <span class="text-white" style="font-size: 12px;">Menu</span>
                </div>
            </div>
            <div style="flex: 0.1;">
                @if(auth()->check())
                    @if (auth()->user()->isUser())
                        @if (isset($user_car))
                        <div type="button" class="user_car open-modal" data-bs-toggle="modal" data-bs-target="#popUpUserCar{{ $user_car->id }}" style="width:200px; height: 51px; position: relative; background: #202020; border-radius: 8px;">
                            <div style="width: 194px; height: 51px; left: 0px; top: 0px; position: absolute;"></div>
                            <img style="height: 38px; left: 8px; top: 6px; position: absolute" src="{{ route('brand.image', ['imageName' => $user_car->car_brand_logo]) }}" />
                            <div class="car-details" >{{ $user_car->car_year }}<br/>{{ $user_car->car_model_name }}, {{ $user_car->car_engine_name }}</div>
                        </div>
                        @endif
                    @endif
                @endif
            </div>
            <div class="" style="flex: 0.6;">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            </div>
            <!-- Button profile trigger modal -->
            @auth
            <div style="flex: 0.2; justify-content: space-around;" class="d-flex flex-row">
                <div class="d-flex flex-column justify-content-center">
                    <button class="find-store"><img style="width: 14px; padding-right: 2px; padding-bottom: 3px;" src="{{ asset('img/Logo/find.png') }}" alt="">Find Store</button>
                </div>
                <div class="d-flex flex-column" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSidebar" style="align-items: center; padding: 10px 20px 0px 20px;">
                    <img src="{{ asset('img/Logo/favorite.png') }}" style="width: 22px; padding-bottom: 6px;" alt="">
                    <span class="text-white" style="font-size: 11px;">Favorite</span>
                </div>
                <div type="button" class="d-flex flex-column" style="align-items: center; padding-right: 10px;" data-bs-toggle="modal" data-bs-target="#profileModal">
                    <i class="bi bi-person-circle text-white fs-4"></i>
                    <span class="text-white" style="font-size: 11px;">Profile</span>
                </div>
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
@else
<nav class="navbar" style="background-color: #363636;">
    <div class="container-fluid" style="justify-content: center;">
        <a href="{{ route('home') }}">
            <img class="mt-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
        </a>
    </div>
    <div class="container-fluid">
        <div class="d-flex flex-column" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSidebar" style="margin-left: 2rem;">
            <i class="bi bi-list text-white fs-3"></i>
            <span class="text-white" style="font-size: 11px;">Menu</span>
        </div>
        <input class="form-control me-2" style="width: 50%;" type="search" placeholder="Search" aria-label="Search">
        <!-- Button profile trigger modal -->
        @auth
            <div type="button" class="" style="display: grid; justify-items: center; margin-right: 3rem;" data-bs-toggle="modal" data-bs-target="#profileModal">
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
{{-- user car modal --}}
@if(auth()->check())
    @if (auth()->user()->isUser())
        @if (isset($user_car))
            @include('components.userCarModal')

            @stack('content_profile_css')

            @stack('content_profile_js')
        @endif
    @endif
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
        <div class="card card-body menu-burger" style="width: 223px; background-color: #363636; border-radius: 0 0 10px 0; margin-top: 3.5rem;">
            @if(auth()->check() && auth()->user()->isAdmin())
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
            @elseif(auth()->check() && auth()->user()->isStore())
                <!-- Navbar untuk store -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="{{ route('store.productList') }}">Product List</a>
                    </li>
                </ul>
            @else
                <!-- Navbar untuk user dan guest -->
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <i class="fa fa-cog" style="color: white;"></i>
                        <span class="text-white mb-2" style="font-size: 1.2em; font-weight: bold;">Spareparts</span>
                    </li>
                    <li class="nav-item-user">
                        <a class="text-decoration-none text-white" href="#">Batteries</a>
                    </li>
                    <li class="nav-item-user">
                        <a class="text-decoration-none text-white" href="#">Engine Oil</a>
                    </li>
                    <li class="nav-item-user">
                        <a class="text-decoration-none text-white" href="#">Air Filter</a>
                    </li>
                    <li class="nav-item">
                        <i class="fa fa-wrench" style="color: white;"></i>
                        <span class="text-white mt-3 mb-2" style="font-size: 1.2em; font-weight: bold;">Modifications</span>
                    </li>
                    <li class="nav-item-user">
                        <a class="text-decoration-none text-white" href="#">Rims</a>
                    </li>
                    <li class="nav-item-user">
                        <a class="text-decoration-none text-white" href="#">Suspension</a>
                    </li>
                    <li class="nav-item-user">
                        <a class="text-decoration-none text-white" href="#">Exhaust</a>
                    </li>
                    <li class="nav-item-user">
                        <a class="text-decoration-none text-white" href="#" style="font-weight: bold;">About Us</a>
                    </li>
                    <li class="nav-item-user">
                        <a class="text-decoration-none text-white" href="#" style="font-weight: bold;">Terms and Conditions</a>
                    </li>
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

        $(document).click(function(event) {
            var target = $(event.target);
            if (!target.closest('.menu-burger').length) {
                $('.collapse-horizontal').removeClass('show');
            }
        });
    </script>
@endpush
