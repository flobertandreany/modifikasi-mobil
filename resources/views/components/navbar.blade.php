<div class="container-fluid" style="text-align: center; background-color: #363636; height: 55px;">
    <img class="mt-3" src="img/login/Logo SpareCar.png" alt="image logo" width="250px" height="45px">
</div>
<nav class="navbar" style="background-color: #363636;">
    <div class="container-fluid">
        <div class="d-flex flex-column" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample"  style="display: grid; justify-items: center;">
            <i class="bi bi-list text-white fs-3"></i>
            <span class="text-white" style="font-size: 11px;">Menu</span>
        </div>

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
        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">

                @include('components.profileModal')

                @stack('content_profile_css')

                @stack('content_profile_js')

            </div>
        </div>
    </div>
</nav>
<div style="background-color: #363636; max-width: 0px;" class="collapse collapse-horizontal" id="collapseWidthExample">
    <div style="min-height: 120px;">
        <div class="collapse collapse-horizontal" id="collapseWidthExample">
            <div class="card card-body" style="width: 223px; background-color: #363636; border-radius: 0 0 10px 0;">
                @if(auth()->check())
                    @if(auth()->user()->isAdmin())
                        <!-- Navbar untuk admin -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.store.approval') }}">Store Approval List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('view.store.list') }}">Store List</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('car.model.list') }}">Manage Car Model</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('car.brand.list') }}">Manage Car Brand</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('car.part.list') }}">Manage Parts</a>
                            </li>
                        </ul>
                    @elseif(auth()->user()->isStore())
                        <!-- Navbar untuk pengguna biasa -->
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">Product List</a>
                            </li>
                            <!-- Opsi lain untuk pengguna biasa -->
                        </ul>
                    @else
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="#">user dan guest</a>
                            </li>
                        </ul>
                    @endif
                @else
                    <!-- Navbar untuk pengunjung tanpa login -->
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">user dan guest</a>
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
    </script>
@endpush
