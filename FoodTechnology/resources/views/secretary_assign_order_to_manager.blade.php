<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Order to Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>

    @include('users_sidemenu')

    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">



    <div class="container mt-5">
        <h1>Assign Order to Manager</h1>
        <div class="row">
            <div class="col-md-6">
                <h3>Order Details</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Company</th>
                        <td>{{ $order->company->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $order->description }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ $order->date }}</td>
                    </tr>
                    <tr>
                        <th>Deadline</th>
                        <td>{{ $order->deadline }}</td>
                    </tr>
                    <tr>
                        <th>Cost</th>
                        <td>{{ $order->cost }}</td>
                    </tr>
                    <tr>
                        <th>Product Count</th>
                        <td id="productCount">{{ count($order->products) }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h3>Select Manager</h3>
                <form action="{{ route('secretary.orders.assign', $order->id_order) }}" method="POST">
                    @csrf
                    <table class="table table-bordered mt-3">
                        <tr>
                            <th>Manager</th>
                            <td>
                                <select name="manager_id" id="manager_id" class="form-control" required>
                                    <option value="">Select a Manager</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->id_manager }}">
                                            {{ $manager->employee->first_name }} {{ $manager->employee->last_name }} (Efficiency: {{ number_format($manager->efficiency, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Orders Count</th>
                            <td id="orders_count"></td>
                        </tr>
                        <tr>
                            <th>Products Count</th>
                            <td id="products_count"></td>
                        </tr>
                        <tr>
                            <th>Food Technologist Count</th>
                            <td id="employees_count"></td>
                        </tr>
                        <tr>
                            <th>Efficiency</th>
                            <td id="efficiency"></td>
                        </tr>
                    </table>

                    <button type="submit" class="btn btn-primary mt-3">Assign</button>
                </form>
            </div>
        </div>
    </div>


</main>
@include('footer')

</div>
</div>
</div>

    <script>
        document.getElementById('manager_id').addEventListener('change', function () {
            const managerId = this.value;
            const productCount = parseInt("{{ count($order->products) }}");
            if (managerId) {
                fetch(`/managers/${managerId}/details/${productCount}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            document.getElementById('orders_count').textContent = 'N/A';
                            document.getElementById('products_count').textContent = 'N/A';
                            document.getElementById('employees_count').textContent = 'N/A';
                            document.getElementById('efficiency').textContent = 'N/A';
                        } else {
                            document.getElementById('orders_count').textContent = data.ordersCount;
                            document.getElementById('products_count').textContent = data.productsCount;
                            document.getElementById('employees_count').textContent = data.activeEmployeesCount;
                            document.getElementById('efficiency').textContent = data.efficiency.toFixed(2);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('orders_count').textContent = 'Error';
                        document.getElementById('products_count').textContent = 'Error';
                        document.getElementById('employees_count').textContent = 'Error';
                        document.getElementById('efficiency').textContent = 'Error';
                    });
            } else {
                document.getElementById('orders_count').textContent = '';
                document.getElementById('products_count').textContent = '';
                document.getElementById('employees_count').textContent = '';
                document.getElementById('efficiency').textContent = '';
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
