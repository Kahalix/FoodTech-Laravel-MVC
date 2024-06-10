<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignable Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .expandable-row {
            cursor: pointer;
        }
        .expandable-row:hover {
            background-color: #f8f9fa;
        }
        .expandable-row-icon::before {
            content: "\25B6"; /* Right-pointing arrow */
            display: inline-block;
            margin-right: 5px;
            transition: transform 0.2s;
        }
        .expandable-row-icon.collapsed::before {
            transform: rotate(90deg); /* Down-pointing arrow */
        }
    </style>
</head>
<body>
    @include('users_sidemenu')

    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">

            <div class="container mt-5">
                <h1>Assignable Orders</h1>
                @if ($hasOrders)
                <div class="accordion" id="ordersAccordion">
                    @foreach($companies as $company)
                        @if($company->assignedOrderCount > 0)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $company->id_company }}">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $company->id_company }}" aria-expanded="true" aria-controls="collapse{{ $company->id_company }}">
                                        {{ $company->name }} - Total Orders: {{ $company->assignedOrderCount }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $company->id_company }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $company->id_company }}" data-bs-parent="#ordersAccordion">
                                    <div class="accordion-body">

                                        <!-- Table for larger screens -->
                                        <div class="d-none d-lg-block">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Name</th>
                                                        <th>Description</th>
                                                        <th>Date</th>
                                                        <th>Deadline</th>
                                                        <th>Cost</th>
                                                        <th>Product Count</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($company->orders as $order)
                                                        <tr class="expandable-row" data-bs-toggle="collapse" data-bs-target="#orderDetails{{ $order->id_order }}" aria-expanded="false" aria-controls="orderDetails{{ $order->id_order }}">
                                                            <td class="expandable-row-icon collapsed">{{ $company->increment++ }}</td>
                                                            <td>{{ $order->name }}</td>
                                                            <td>{{ $order->description }}</td>
                                                            <td>{{ $order->date }}</td>
                                                            <td>{{ $order->deadline }}</td>
                                                            <td>{{ $order->cost }}</td>
                                                            <td>{{ count($order->products) }}</td>
                                                            <td>
                                                                <a href="{{ route('secretary.orders.showAssignForm', $order->id_order) }}" class="btn btn-primary btn-sm assign-btn">Assign</a>
                                                            </td>
                                                        </tr>
                                                        <tr id="orderDetails{{ $order->id_order }}" class="collapse">
                                                            <td colspan="7">
                                                                <table class="table table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Product Image</th>
                                                                            <th>Name</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($order->products as $product)
                                                                            <tr>
                                                                                <td><img src="{{ asset($product->product_image)}}" alt="{{ $product->name }}" height="50"></td>
                                                                                <td>{{ $product->name }}</td>
                                                                                <td></td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Cards for smaller screens -->
                                        <div class="d-lg-none">
                                            @foreach($company->orders as $order)
                                                <div class="card mb-3">
                                                    <div class="card-header expandable-row" data-bs-toggle="collapse" data-bs-target="#cardDetails{{ $order->id_order }}" aria-expanded="false" aria-controls="cardDetails{{ $order->id_order }}">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span>{{ $company->increment++ }}. {{ $order->name }}</span>
                                                            <i class="bi bi-chevron-down"></i>
                                                        </div>
                                                    </div>
                                                    <div id="cardDetails{{ $order->id_order }}" class="collapse">
                                                        <div class="card-body">
                                                            <p><strong>Description:</strong> {{ $order->description }}</p>
                                                            <p><strong>Date:</strong> {{ $order->date }}</p>
                                                            <p><strong>Deadline:</strong> {{ $order->deadline }}</p>
                                                            <p><strong>Cost:</strong> {{ $order->cost }}</p>
                                                            <p><strong>Product Count:</strong> {{ count($order->products) }}</p>
                                                            <a href="{{ route('secretary.orders.showAssignForm', $order->id_order) }}" class="btn btn-primary btn-sm assign-btn">Assign</a>
                                                            <div class="mt-3">
                                                                <h6>Products:</h6>
                                                                @foreach($order->products as $product)
                                                                    <div class="d-flex mb-2">
                                                                        <img src="{{ asset($product->product_image)}}" alt="{{ $product->name }}" height="50" class="me-2">
                                                                        <div>{{ $product->name }}</div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                @else
                <div class="alert alert-info" role="alert">
                    There are no assignable orders at the moment.
                </div>
                @endif
            </div>

        </main>
        @include('footer')

    </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script>
        document.querySelectorAll('.expandable-row').forEach(row => {
            row.addEventListener('click', function() {
                const icon = this.querySelector('.bi-chevron-down');
                if (icon) {
                    icon.classList.toggle('collapsed');
                }
            });
        });
        document.querySelectorAll('.assign-btn').forEach(button => {
        button.addEventListener('click', function(event) {

            window.location.href = this.href; // Redirect to the clicked button's href

        });
    });
    </script>
</body>
</html>
