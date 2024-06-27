<footer class="text-center text-lg-start custom-footer">
        <div class="p-4" style="margin-left: 5rem;">
            <div class="row">
                @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="col-lg-3 col-md-6 text-footer">
                        <div>
                            <img class="mt-3 me-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 25px; width: 240px; color: inherit; text-decoration: none;">
                            <a class="text-decoration-none" style="color: inherit;" href="https://www.facebook.com/profile.php?id=61560989996217&mibextid=ZbWKwL" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/sparecarid?igsh=MTk1ODBpd212NnBteA==" style="color: inherit;" target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://twitter.com/SparecarID?t=QoNEYmMCIhPs4ShkviLxSQ&s=09" style="color: inherit;" target="_blank">
                                <i class="bi bi-twitter"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">Manage Store</h5>
                        <ul class="list-unstyled">
                            <li class="text-footer">
                                <a href="{{ route('admin.store.approval') }}" class="text-white text-decoration-none">Store Approval List</a>
                            </li>
                            <li class="text-footer">
                                <a href="{{ route('view.store.list') }}" class="text-white text-decoration-none">Store List</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">Manage Car</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="text-footer">
                                <a href="{{ route('car.brand.list') }}" class="text-white text-decoration-none">Manage Car Brand</a>
                            </li>
                            <li class="text-footer">
                                <a href="{{ route('car.model.list') }}" class="text-white text-decoration-none">Manage Car Model</a>
                            </li>
                            <li class="text-footer">
                                <a href="{{ route('car.engine.list') }}" class="text-white text-decoration-none">Manage Car Engine</a>
                            </li>
                            <li class="text-footer">
                                <a href="{{ route('car.part.list') }}" class="text-white text-decoration-none">Manage Car Parts</a>
                            </li>
                        </ul>
                    </div>
                    <div class="email-footer col-lg-3 col-md-6 text-footer d-flex flex-column align-items-center text-center">
                        <i class="fa fa-envelope fa-5x me-3"></i>
                        <span class="">sparecar.ind@gmail.com</span>
                    </div>
                @elseif(auth()->check() && auth()->user()->isStore())
                    <div class="col-lg-4 col-md-6 text-footer">
                        <div>
                            <img class="mt-3 me-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 25px; width: 225px; color: inherit; text-decoration: none;">
                            <a class="text-decoration-none" style="color: inherit;" href="https://www.facebook.com/profile.php?id=61560989996217&mibextid=ZbWKwL" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/sparecarid?igsh=MTk1ODBpd212NnBteA==" style="color: inherit;" target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://twitter.com/SparecarID?t=QoNEYmMCIhPs4ShkviLxSQ&s=09" style="color: inherit;" target="_blank">
                                <i class="bi bi-twitter"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">ALL PRODUCT LIST</h5>
                    </div>
                    <div class="col-lg-4 col-md-6 text-footer d-flex flex-column align-items-center text-center">
                        <i class="fa fa-envelope fa-5x me-3"></i>
                        <span class="">sparecar.ind@gmail.com</span>
                    </div>
                @else
                    <div class="col-lg-3 col-md-6 text-footer">
                        <div>
                            <img class="mt-3 me-3" src="{{ asset('img/login/Logo SpareCar.png') }}" alt="image logo" width="250px" height="45px">
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 25px; width: 235px; color: inherit; text-decoration: none;">
                            <a class="text-decoration-none" style="color: inherit;" href="https://www.facebook.com/profile.php?id=61560989996217&mibextid=ZbWKwL" target="_blank">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://www.instagram.com/sparecarid?igsh=MTk1ODBpd212NnBteA==" style="color: inherit;" target="_blank">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="https://twitter.com/SparecarID?t=QoNEYmMCIhPs4ShkviLxSQ&s=09" style="color: inherit;" target="_blank">
                                <i class="bi bi-twitter"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">Spareparts</h5>
                        <ul class="list-unstyled">
                            @foreach ($spareparts as $sparepart)
                                <li class="text-footer">
                                    <a href="{{ route('user.productList', ['type' => $sparepart->type, 'name' => $sparepart->product_name]) }}" class="text-white text-decoration-none">
                                        {{ $sparepart->product_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">Modification</h5>
                        <ul class="list-unstyled mb-0">
                            @foreach ($modifications as $modification)
                                <li class="text-footer">
                                    <a href="{{ route('user.productList', ['type' => $modification->type, 'name' => $modification->product_name]) }}" class="text-white text-decoration-none">
                                        {{ $modification->product_name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-6 text-footer">
                        <h5 class="text-footer" style="font-weight: bold;">About</h5>
                        <ul class="list-unstyled">
                            <li class="text-footer">
                                <a href="{{ route('user.aboutUs') }}" class="text-white text-decoration-none">About SpareCar</a>
                            </li>
                            <li class="text-footer">
                                <a href="{{ route('user.termAndCondition') }}" class="text-white text-decoration-none">Terms and Conditions</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-6 text-footer d-flex flex-column align-items-center text-center">
                        <i class="fa fa-envelope fa-5x me-3"></i>
                        <span class="">sparecar.ind@gmail.com</span>
                    </div>
                @endif
            </div>
        </div>
        <div class="orange-line"></div>
        <div class="text-left" style="margin-left: 6rem; padding-top: .5rem; padding-bottom: 4rem;">
            ©2024 SpareCar, All Rights Reserved.
        </div>
</footer>
