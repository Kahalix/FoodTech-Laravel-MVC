<div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
        <div class="col-12 col-sm-3 col-xl-2 px-sm-2 px-0 bg-dark d-flex sticky-top">
            <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                <a href="/" class="d-flex align-items-center pb-sm-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5"><img src="{{ asset('images/logo.png') }}" height="30" alt="logo"><span class="d-none d-sm-inline">NutriPro</span></span>
                </a>
                <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="{{ route('user.dashboard')}}" class="nav-link px-sm-0 px-2">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-sm-inline">Home</span>
                        </a>
                    </li>
                    @if (Auth::user()->position === 'secretary')
                        <li>
                            <a href="{{ route('link.create') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-plus-circle"></i><span class="ms-1 d-none d-sm-inline">Create Link</span>
                            </a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-sm-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fs-5 bi-cart"></i><span class="ms-1 d-none d-sm-inline">Orders</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="{{ route('secretary.orders.finished') }}">Finished</a></li>
                                <li><a class="dropdown-item" href="{{ route('secretary.orders.assignable') }}">Assignable</a></li>
                            </ul>
                        </li>
                    @elseif (Auth::user()->position === 'manager')
                        <li>
                            <a href="{{ route('orders.overview') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-card-list"></i><span class="ms-1 d-none d-sm-inline">Orders Overview</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('manager.products.assignable') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-box-arrow-in-right"></i><span class="ms-1 d-none d-sm-inline">Assign Order Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tests.review') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-clipboard-check"></i><span class="ms-1 d-none d-sm-inline">Review Tests</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tests.overview') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-eye"></i><span class="ms-1 d-none d-sm-inline">Tests Overview</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('food_technologist.view') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-person-lines-fill"></i><span class="ms-1 d-none d-sm-inline">View Food Technologists</span>
                            </a>
                        </li>
                    @elseif (Auth::user()->position === 'food_technologist')
                        <li>
                            <a href="{{ route('food_technologist.products.overview') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-grid"></i><span class="ms-1 d-none d-sm-inline">Products Overview</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('food_technologist.products.assigned') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-arrow-left-right"></i><span class="ms-1 d-none d-sm-inline">Assigned Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('food_technologist.products.manage') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-tools"></i><span class="ms-1 d-none d-sm-inline">Manage Products</span>
                            </a>
                        </li>
                    @elseif (Auth::user()->position === 'admin')
                        <li>
                            <a href="{{ route('admin.employees') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.company.index') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-building"></i><span class="ms-1 d-none d-sm-inline">Companies</span>
                            </a>
                        </li>
                        </li>
                        <li>
                            <a href="{{ route('admin.ingredients') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-droplet"></i><span class="ms-1 d-none d-sm-inline">Ingredients</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.microorganisms') }}" class="nav-link px-sm-0 px-2">
                                <i class="fs-5 bi-capsule"></i><span class="ms-1 d-none d-sm-inline">Microorganisms</span>
                            </a>
                        </li>
                    @endif

                </ul>
                <div class="dropdown py-sm-4 mt-sm-auto ms-auto ms-sm-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset(Auth::user()->employee_image)}}" alt="user_image" height="38" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
