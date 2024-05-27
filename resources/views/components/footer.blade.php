<footer class="text-center text-lg-start custom-footer">
        <div class="p-4" style="margin-left: 5rem;">
            <div class="row">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="col-lg-3 col-md-6 text-footer">
                        <img class="mt-3 me-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
                    </div>
                    <div class="col-lg-3 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">Manage Store</h5>
                        <ul class="list-unstyled">
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Store Approval List</a>
                            </li>
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Store List</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">Manage Store</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Car Brand</a>
                            </li>
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Car Model</a>
                            </li>
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Car Engine</a>
                            </li>
                        </ul>
                    </div>
                    <div class="email-footer col-lg-3 col-md-6 text-footer d-flex flex-column align-items-center text-center">
                        <i class="fa fa-envelope fa-5x me-3"></i>
                        <span class="">SpareCar@gmail.com</span>
                    </div>
                @elseif(auth()->check() && auth()->user()->isStore())
                    <div class="col-lg-4 col-md-6 text-footer">
                        <img class="mt-3 me-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
                    </div>
                    <div class="col-lg-4 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">ALL PRODUCT LIST</h5>
                    </div>
                    <div class="col-lg-4 col-md-6 text-footer d-flex flex-column align-items-center text-center">
                        <i class="fa fa-envelope fa-5x me-3"></i>
                        <span class="">SpareCar@gmail.com</span>
                    </div>
                @else
                    <div class="col-lg-3 col-md-6 text-footer">
                        <img class="mt-3 me-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
                    </div>
                    <div class="col-lg-2 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">Spareparts</h5>
                        <ul class="list-unstyled">
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Batteries</a>
                            </li>
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Engine Oil</a>
                            </li>
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Air Filter</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">Modification</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Rims</a>
                            </li>
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Suspension</a>
                            </li>
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Exhaust</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">About</h5>
                        <ul class="list-unstyled">
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">About SpareCar</a>
                            </li>
                            <li class="text-footer">
                                <a href="#!" class="text-white text-decoration-none">Terms and Condition</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 text-footer d-flex flex-column align-items-center text-center">
                        <i class="fa fa-envelope fa-5x me-3"></i>
                        <span class="">SpareCar@gmail.com</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="orange-line"></div>
        <div class="text-left" style="margin-left: 6rem; padding-top: .5rem; padding-bottom: 4rem;">
            ©2024 SpareCar, All Rights Reserved.
        </div>
</footer>
