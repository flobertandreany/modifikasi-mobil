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
            <a href="/login" style="display: grid; justify-items: center; margin-right: 30px; text-decoration: none;">
                <i class="bi bi-person-circle text-white fs-4"></i>
                <span class="text-white" style="font-size: 11px;">Sign In</span>
            </a>
        </div>
        @endauth
        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content text-white" style="background-color: #363636;">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if(auth()->check())
                            <h5>Name: {{ auth()->user()->name }}</h5>
                            <h5>Username: {{ auth()->user()->username }}</h5>
                            <h5>Email: {{ auth()->user()->email }}</h5>
                            <h5>Role: {{ auth()->user()->role }}</h5>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <form action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-secondary" data-bs-dismiss="modal">Sign Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<div style="background-color: #363636; max-width: 0px;" class="collapse collapse-horizontal" id="collapseWidthExample">
    <div style="min-height: 120px;">
        <div class="collapse collapse-horizontal" id="collapseWidthExample">
            <div class="card card-body" style="width: 223px; background-color: #363636; border-radius: 0 0 10px 0;">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
