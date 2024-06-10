<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Companies</title>
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





            @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif

<div class="container mt-5">
    <h1>Manage Companies</h1>

    <!-- Pagination Search -->
    <div class="mb-3">
        <form method="GET" action="{{ route('admin.company.index') }}">
            <div class="input-group">
                <input type="text" name="search" id="searchBar" class="form-control" placeholder="Search for companies or orders" value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>
    </div>

    <!-- Dynamic Search -->
    <div class="mb-3">
        <input type="text" id="searchCompany" class="form-control" placeholder="Search for companies or orders on current page">
    </div>

    <!-- Display Search Results -->
    @if($companies->isEmpty())
        <p>No results found.</p>
    @endif
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addCompanyModal">Add New Company</button>
    <div class="accordion" id="companiesAccordion">
        @foreach($companies as $company)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $company->id_company }}">
                    <button class="accordion-button companyaccordion" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $company->id_company }}" aria-expanded="true" aria-controls="collapse{{ $company->id_company }}">
                        {{ $company->name }}
                    </button>
                </h2>
                <div id="collapse{{ $company->id_company }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $company->id_company }}" data-bs-parent="#companiesAccordion">
                    <div class="accordion-body">
                        <p>{{ $company->address }}, {{ $company->city }}, {{ $company->postal_code }}</p>
                        <p>Phone Number: {{ $company->phone_number }}</p>
                        <p>Email: {{ $company->email }}</p>
                        <p>NIP: {{ $company->nip }}</p>
                        <button class="btn btn-secondary btn-sm mb-2" data-bs-target="#editCompanyModal" onclick="editCompany({{ $company->id_company }})">Edit</button>
                        <button class="btn btn-danger btn-sm mb-2" onclick="confirmDeleteCompany({{ $company->id_company }})">Delete</button>
                        <h5>Orders</h5>
                        <!-- Button to Open Add Order Modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOrderModal{{ $company->id_company }}">
                            Add Order
                        </button>


                        <!-- Add Order Modal -->
                        <div class="modal fade" id="addOrderModal{{ $company->id_company }}" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form method="post" action="{{ route('admin.company.storeOrder', ['companyId' => $company->id_company]) }}">
                                        @csrf
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addOrderModalLabel">Add New Order</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id_company" value="{{ $company->id_company }}">
                                            <div class="form-group">
                                                <label for="order_name">Name</label>
                                                <input type="text" class="form-control" id="order_name" name="name" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="order_description">Description</label>
                                                <textarea class="form-control" id="order_description" name="description" required></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="order_status">Status</label>
                                                <select class="form-control" id="order_status" name="status" required>
                                                    <option value="assigned">Assigned</option>
                                                    <option value="in progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="order_deadline">Deadline</label>
                                                <input type="date" class="form-control" id="order_deadline" name="deadline" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="order_cost">Cost</label>
                                                <input type="text" class="form-control" id="order_cost" name="cost" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="order_manager">Manager</label>
                                                <select class="form-control" id="order_manager" name="id_manager">
                                                    <option value="">Select Manager (Optional)</option>
                                                    @foreach($managers as $manager)
                                                        <option value="{{ $manager->id_manager }}">{{ $manager->employee->first_name }} {{ $manager->employee->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="order_secretary">Secretary</label>
                                                <select class="form-control" id="order_secretary" name="id_secretary">
                                                    <option value="">Select Secretary (Optional)</option>
                                                    @foreach($secretaries as $secretary)
                                                        <option value="{{ $secretary->id_secretary }}">{{ $secretary->employee->first_name }} {{ $secretary->employee->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <div class="accordion" id="ordersAccordion{{ $company->id_company }}">
                            @foreach($company->orders as $order)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOrder{{ $order->id_order }}">
                                        <button class="accordion-button companyaccordion collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOrder{{ $order->id_order }}" aria-expanded="false" aria-controls="collapseOrder{{ $order->id_order }}">
                                            {{ $order->name }}
                                        </button>
                                    </h2>
                                    <div id="collapseOrder{{ $order->id_order }}" class="accordion-collapse collapse" aria-labelledby="headingOrder{{ $order->id_order }}" data-bs-parent="#ordersAccordion{{ $company->id_company }}">
                                        <div class="accordion-body">
                                            <h6>Description</h6>
                                            <p>{{ $order->description }}</p>
                                            <h6>Date</h6>
                                            <p>{{ $order->date }}</p>
                                            <h6>Deadline</h6>
                                            <p>{{ $order->deadline }}</p>
                                            <h6>Status</h6>
                                            <p>{{ $order->status }}</p>
                                            <h6>Cost</h6>
                                            <p>{{ $order->cost }}</p>
                                            @if ($order->secretary)
                                            <h6>Secretary</h6>
                                            <p>{{ $order->secretary->employee->first_name }} {{ $order->secretary->employee->last_name }}</p>
                                            @else
                                                <p>No Secretary Assigned</p>
                                            @endif
                                            @if ($order->manager)
                                                <h6>Manager</h6>
                                                <p>{{ $order->manager->employee->first_name }} {{ $order->manager->employee->last_name }}</p>
                                            @else
                                                <p>No Manager Assigned</p>
                                            @endif
                                            <!-- Button to Open Edit Order Modal -->
                                            <button onclick="editOrder({{ $order->id_order }})" class="btn btn-secondary">Edit</button>

                                            <!-- Button to Delete Order -->
                                            <button onclick="confirmDeleteOrder({{ $order->id_order }})" class="btn btn-danger">Delete</button>
                                            <h6>Products</h6>
                                            <!-- Button to Open Add Product Modal -->
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                            Add Product
                                        </button>
                                        <!-- Add Product Modal -->
                                        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form method="post" action="{{ route('admin.company.storeProduct', ['orderId' => $order->id_order]) }}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_order" value="{{ $order->id_order }}">
                                                            <div class="form-group">
                                                                <label for="product_name">Name</label>
                                                                <input type="text" class="form-control" id="product_name" name="name" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="product_status">Status</label>
                                                                <select class="form-control" id="product_status" name="status" required>
                                                                    <option value="assigned">Assigned</option>
                                                                    <option value="awaiting">Awaiting</option>
                                                                    <option value="completed">Completed</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="product_foodtechnologist">Food Technologist</label>
                                                                <select class="form-control" id="product_foodtechnologist" name="id_food_technologist">
                                                                    <option value="">Select Food Technologist (Optional)</option>
                                                                    @foreach($foodtechnologists as $foodtechnologist)
                                                                        <option value="{{ $foodtechnologist->id_food_technologist }}">{{ $foodtechnologist->employee->first_name }} {{ $foodtechnologist->employee->last_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="product_image">Image</label>
                                                                <input type="file" class="form-control" id="product_image" name="product_image" required>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="accordion" id="productsAccordion{{ $order->id_order }}">
                                                @foreach($order->products as $product)
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingProduct{{ $product->id_product }}">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseProduct{{ $product->id_product }}" aria-expanded="false" aria-controls="collapseProduct{{ $product->id_product }}">
                                                               <img src="{{ asset($product->product_image) }}" alt="product image" style="max-height: 50px;"> {{ $product->name }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapseProduct{{ $product->id_product }}" class="accordion-collapse collapse" aria-labelledby="headingProduct{{ $product->id_product }}" data-bs-parent="#productsAccordion{{ $order->id_order }}">
                                                            <div class="accordion-body">
                                                                <h6>Status</h6>
                                                                <p>{{ $product->status }}</p>

                                                                @if ($product->id_food_technologist)
                                                                <h6>Food Technologist</h6>

                                                                <p>Food Technologist: {{ $product->foodTechnologist->employee->first_name }} {{ $product->foodTechnologist->employee->last_name }}</p>
                                                                @else
                                                                <p>No Food Technologist Assigned</p>
                                                                @endif
                                                                <button type="button" class="btn btn-primary" onclick="editProduct({{ $product->id_product }})">
                                                                    Edit Product
                                                                </button>
                                                                <button type="button" class="btn btn-danger" onclick="confirmDeleteProduct({{ $product->id_product }})">
                                                                    Delete Product
                                                                </button>

                                                                <h6>Ingredients</h6>
                                                                <ul>
                                                                    @foreach($product->product_ingredients as $ingredient)
                                                                        <li>{{ $ingredient->name }} - {{ $ingredient->ingredient_amount }} {{ $ingredient->unit }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                <h6>Microorganisms</h6>
                                                                <ul>
                                                                    @foreach($product->product_microorganisms as $microorganism)
                                                                        <li>{{ $microorganism->name }} - {{ $microorganism->amount }} {{ $microorganism->unit }}, {{ $microorganism->type }}</li>
                                                                    @endforeach
                                                                </ul>
                                                                @if ($product->test_result)
                                                                <h6>Test Results</h6>
                                                                <div class="accordion" id="testResultsAccordion{{ $product->id_product }}">
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="headingTestResult{{ $product->test_result->id_test_result }}">
                                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTestResult{{ $product->test_result->id_test_result }}" aria-expanded="false" aria-controls="collapseTestResult{{ $product->test_result->id_test_result }}">
                                                                                {{ $product->test_result->decision }}
                                                                            </button>
                                                                        </h2>
                                                                        <div id="collapseTestResult{{ $product->test_result->id_test_result }}" class="accordion-collapse collapse" aria-labelledby="headingTestResult{{ $product->test_result->id_test_result }}" data-bs-parent="#testResultsAccordion{{ $product->id_product }}">
                                                                            <div class="accordion-body">
                                                                                <p>{{ $product->test_result->test_results }}</p>
                                                                                <h6>Result Images</h6>
                                                                                <div class="row">
                                                                                    @foreach($product->test_result->resultImages as $image)
                                                                                        <div class="col-6 col-md-4 mb-3">
                                                                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Result Image" width="300px" class="img-fluid">
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                        </div>
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
        @endforeach
    </div>
</div>

<!-- Add Company Modal -->
<div class="modal fade" id="addCompanyModal" tabindex="-1" role="dialog" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.company.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCompanyModalLabel">Add New Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" class="form-control" id="nip" name="nip" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="postal_code">Postal Code</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" class="form-control" id="city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Company Modal -->
<div class="modal fade" id="editCompanyModal" tabindex="-1" role="dialog" aria-labelledby="editCompanyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editCompanyForm" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editCompanyModalLabel">Edit Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editCompanyId" name="id">
                    <div class="form-group">
                        <label for="edit_name">Name</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_nip">NIP</label>
                        <input type="text" class="form-control" id="edit_nip" name="nip" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_address">Address</label>
                        <input type="text" class="form-control" id="edit_address" name="address" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_postal_code">Postal Code</label>
                        <input type="text" class="form-control" id="edit_postal_code" name="postal_code" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_city">City</label>
                        <input type="text" class="form-control" id="edit_city" name="city" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_phone_number">Phone Number</label>
                        <input type="text" class="form-control" id="edit_phone_number" name="phone_number" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>





<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editOrderForm" method="post" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editOrderId" name="id">
                    <div class="form-group">
                        <label for="edit_order_name">Name</label>
                        <input type="text" class="form-control" id="edit_order_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_order_description">Description</label>
                        <textarea class="form-control" id="edit_order_description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit_order_status">Status</label>
                        <select class="form-control" id="edit_order_status" name="status" required>
                            <option value="assigned">Assigned</option>
                            <option value="in progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_order_deadline">Deadline</label>
                        <input type="date" class="form-control" id="edit_order_deadline" name="deadline" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_order_cost">Cost</label>
                        <input type="text" class="form-control" id="edit_order_cost" name="cost" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_order_manager">Manager</label>
                        <select class="form-control" id="edit_order_manager" name="id_manager">
                            <option value="">None</option>
                            @foreach($managers as $manager)
                                <option value="{{ $manager->id_manager }}">{{ $manager->employee->first_name }} {{ $manager->employee->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_order_secretary">Secretary</label>
                        <select class="form-control" id="edit_order_secretary" name="id_secretary">
                            <option value="">None</option>
                            @foreach($secretaries as $secretary)
                                <option value="{{ $secretary->id_secretary }}">{{ $secretary->employee->first_name }} {{ $secretary->employee->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editOrder(id) {
        fetch(`/admin/order/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editOrderId').value = data.id_order;
                document.getElementById('edit_order_name').value = data.name;
                document.getElementById('edit_order_description').value = data.description;
                document.getElementById('edit_order_status').value = data.status;
                document.getElementById('edit_order_deadline').value = data.deadline;
                document.getElementById('edit_order_cost').value = data.cost;
                document.getElementById('edit_order_manager').value = data.id_manager ? data.id_manager : '';
                document.getElementById('edit_order_secretary').value = data.id_secretary ? data.id_secretary : '';
                const editForm = document.getElementById('editOrderForm');
                editForm.action = `/admin/order/${id}`;
                const modal = new bootstrap.Modal(document.getElementById('editOrderModal'));
                modal.show();
            });
    }
    function confirmDeleteOrder(id) {
        if (confirm('Are you sure you want to delete this order?')) {
            fetch(`/admin/order/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    alert('Order deleted successfully');
                    window.location.reload();
                } else {
                    alert('Failed to delete the order');
                }
            });
        }
    }
</script>



<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="editProductForm" method="post" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editProductId" name="id">
                    <div class="form-group">
                        <label for="edit_product_name">Name</label>
                        <input type="text" class="form-control" id="edit_product_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_status">Status</label>
                        <select class="form-control" id="edit_product_status" name="status" required>
                            <option value="assigned">Assigned</option>
                            <option value="awaiting">Awaiting</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_foodtechnologist">Food Technologist</label>
                        <select class="form-control" id="edit_product_foodtechnologist" name="id_food_technologist">
                            <option value="">Select Food Technologist (Optional)</option>
                            @foreach($foodtechnologists as $foodtechnologist)
                                <option value="{{ $foodtechnologist->id_food_technologist }}">{{ $foodtechnologist->employee->first_name }} {{ $foodtechnologist->employee->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_image">Image</label>
                        <input type="file" class="form-control" id="edit_product_image" name="product_image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function editProduct(id) {
        fetch(`/admin/product/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editProductId').value = data.id_product;
                document.getElementById('edit_product_name').value = data.name;
                document.getElementById('edit_product_status').value = data.status;
                document.getElementById('edit_product_foodtechnologist').value = data.id_food_technologist;
                const editForm = document.getElementById('editProductForm');
                editForm.action = `/admin/product/${id}`;
                const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
                modal.show();
            });
    }

    function confirmDeleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            fetch(`/admin/product/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    alert('Product deleted successfully');
                    location.reload();
                }
                else {
                    alert('Failed to delete the product');
                }
            });
        }
    }
</script>


 <!-- Pagination Links -->
                 <div class="d-flex justify-content-center">
                    {{ $companies->links('pagination::bootstrap-5') }}
                </div>



</main>
@include('footer')


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script>
    document.querySelectorAll('.companyaccordion').forEach(item => {
        item.addEventListener('click', () => {
            // Move accordion company/order list item to top
            const accordion = item.closest('.accordion');
            if (accordion) {
                accordion.insertBefore(item.closest('.accordion-item'), accordion.firstChild);
            }

            // Clear search input field
            document.getElementById('searchCompany').value = '';

            // Hide selected accordion item
            document.querySelectorAll('.accordion-item').forEach(item => {
                item.style.display = '';
            });
        });
    });

    function editCompany(id) {
        fetch(`/admin/company/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editCompanyId').value = data.id_company;
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_nip').value = data.nip;
                document.getElementById('edit_address').value = data.address;
                document.getElementById('edit_postal_code').value = data.postal_code;
                document.getElementById('edit_city').value = data.city;
                document.getElementById('edit_phone_number').value = data.phone_number;
                document.getElementById('edit_email').value = data.email;
                const editForm = document.getElementById('editCompanyForm');
                editForm.action = `/admin/company/${id}`;
                const modal = new bootstrap.Modal(document.getElementById('editCompanyModal'));
                modal.show();
            });
    }

    function confirmDeleteCompany(id) {
        if (confirm('Are you sure you want to delete this company?')) {
            fetch(`/admin/company/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if (response.ok) {
                    alert('Company deleted successfully');
                    window.location.reload();
                } else {
                    alert('Failed to delete the company');
                }
            });
        }
    }

    document.getElementById('searchCompany').addEventListener('input', function() {
        let filter = this.value.toUpperCase();
        let items = document.querySelectorAll('.accordion-item');

        items.forEach(function(item) {
            let companyName = item.querySelector('.accordion-button').textContent.toUpperCase();
            let orders = item.querySelectorAll('.accordion-body .accordion-button');

            let matchFound = companyName.indexOf(filter) > -1;

            orders.forEach(function(order) {
                let orderName = order.textContent.toUpperCase();
                if (orderName.indexOf(filter) > -1) {
                    matchFound = true;
                }
            });

            if (matchFound) {
                item.style.display = '';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
</body>
</html>
