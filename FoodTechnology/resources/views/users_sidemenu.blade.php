<div class="container-fluid overflow-hidden">
    <div class="row vh-100 overflow-auto">
        <div class="col-12 col-md-3 col-xl-2 px-md-2 px-0 bg-dark d-flex sticky-top">
            <div class="d-flex flex-md-column flex-row flex-grow-1 align-items-center align-items-md-start px-3 pt-2 text-white">
                <a href="/" class="d-flex align-items-center pb-md-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5"><img src="{{ asset('images/logo.png') }}" height="30" alt="logo"><span class="d-none d-md-inline">NutriPro</span></span>
                </a>
                <ul class="nav nav-pills flex-md-column flex-row flex-nowrap flex-shrink-1 flex-md-grow-0 flex-grow-1 mb-md-auto mb-0 justify-content-center align-items-center align-items-md-start" id="menu">
                    <li class="nav-item">
                        <a href="{{ route('user.dashboard')}}" class="nav-link px-md-0 px-2">
                            <i class="fs-5 bi-house"></i><span class="ms-1 d-none d-md-inline">Home</span>
                        </a>
                    </li>
                    @if (Auth::user()->position === 'secretary')
                    <li>
                        <a id="generateOrderLinkButton" href="#" class="nav-link px-md-0 px-2">
                            <i class="fs-5 bi-plus-circle"></i><span class="ms-1 d-none d-md-inline">Create Link</span>
                        </a>
                    </li>
                        <li class="dropdown">
                            <a href="#" class="nav-link dropdown-toggle px-md-0 px-1" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fs-5 bi-cart"></i><span class="ms-1 d-none d-md-inline">Orders</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown">
                                <li><a class="dropdown-item" href="{{ route('secretary.orders.finished') }}">Finished</a></li>
                                <li><a class="dropdown-item" href="{{ route('secretary.orders.assignable') }}">Assignable</a></li>
                            </ul>
                        </li>
                    @elseif (Auth::user()->position === 'manager')
                        <li>
                            <a href="{{ route('orders.overview') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-card-list"></i><span class="ms-1 d-none d-md-inline">Orders Overview</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('manager.products.assignable') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-box-arrow-in-right"></i><span class="ms-1 d-none d-md-inline">Assign Order Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tests.review') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-clipboard-check"></i><span class="ms-1 d-none d-md-inline">Review Tests</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tests.overview') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-eye"></i><span class="ms-1 d-none d-md-inline">Tests Overview</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('food_technologist.view') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-person-lines-fill"></i><span class="ms-1 d-none d-md-inline">View Food Technologists</span>
                            </a>
                        </li>
                    @elseif (Auth::user()->position === 'food_technologist')
                        <li>
                            <a href="{{ route('food_technologist.products.overview') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-grid"></i><span class="ms-1 d-none d-md-inline">Products Overview</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('food_technologist.products.assigned') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-arrow-left-right"></i><span class="ms-1 d-none d-md-inline">Assigned Products</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('food_technologist.products.manage') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-tools"></i><span class="ms-1 d-none d-md-inline">Manage Products</span>
                            </a>
                        </li>
                    @elseif (Auth::user()->position === 'admin')
                        <li>
                            <a href="{{ route('admin.employees') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-md-inline">Employees</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.company.index') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-building"></i><span class="ms-1 d-none d-md-inline">Companies</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.ingredients') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-droplet"></i><span class="ms-1 d-none d-md-inline">Ingredients</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.microorganisms') }}" class="nav-link px-md-0 px-2">
                                <i class="fs-5 bi-capsule"></i><span class="ms-1 d-none d-md-inline">Microorganisms</span>
                            </a>
                        </li>
                    @endif
                </ul>
                <div class="dropdown py-md-4 mt-md-auto ms-auto ms-md-0 flex-shrink-1">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset(Auth::user()->employee_image)}}" alt="user_image" height="38" class="rounded-circle">
                        <span class="d-none d-md-inline mx-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
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

        <div class="modal fade" id="orderlinkModal" tabindex="-1" aria-labelledby="orderlinkModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="orderlinkModalLabel">Generated Order Link</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="generatedOrderLink" class="form-control" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="copyOrderLinkToClipboard()">Copy Link</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    document.getElementById('generateOrderLinkButton').addEventListener('click', function() {
        fetch('{{ route("order.generateTemporaryLink") }}', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('generatedOrderLink').value = data.link;
                var linkModal = new bootstrap.Modal(document.getElementById('orderlinkModal'));
                linkModal.show();
            } else {
                alert('Failed to generate order link.');
            }
        });
    });

    function copyOrderLinkToClipboard() {
        var copyText = document.getElementById("generatedOrderLink");
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("Copied the order link: " + copyText.value);
    }
</script>
