<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Product to Food Technologist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>

    @include('users_sidemenu')

    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">



    <div class="container mt-5">
        <h1>Assign Product to Food Technologist</h1>
        <div class="row">
            <div class="col-md-6">
                <h3>Product Details</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Product image</th>
                        <td><img src="{{ asset($product->product_image) }}" alt="Product Image" height="50"></td>
                    </tr>
                    <tr>
                        <th>Created</th>
                        <td>{{ $product->order->date }}</td>
                    </tr>
                    <tr>
                        <th>Deadline</th>
                        <td>{{ $product->order->deadline }}</td>
                    </tr>

                </table>
            </div>
            <div class="col-md-6">
                <h3>Select Food Technologist</h3>
                <form action="{{ route('manager.products.assign', $product->id_product) }}" method="POST">
                    @csrf
                    <table class="table table-bordered mt-3">
                        <tr>
                            <th>Food Technologist</th>
                            <td>
                                <select name="food_technologist_id" id="food_technologist_id" class="form-control" required>
                                    <option value="">Select a Food Technologist</option>
                                    @foreach($food_technologists as $technologist)
                                        <option value="{{ $technologist->id_food_technologist }}">
                                            {{ $technologist->employee->first_name }} {{ $technologist->employee->last_name }}  (Assigned Products: {{ $technologist->assigned_products_count }})
                                       </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Completed Products</th>
                            <td id="completedProductCount"></td>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('food_technologist_id').addEventListener('change', function () {
    const foodTechnologistId = this.value;
    if (foodTechnologistId) {
        fetch(`/food-technologists/${foodTechnologistId}/details`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('completedProductCount').textContent = data.completedProductCount;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('completedProductCount').textContent = 'Error';
            });
    } else {
        document.getElementById('activeProductCount').textContent = '';
        document.getElementById('completedProductCount').textContent = '';
    }
});

    </script>
</body>
</html>
