{{-- resources\views\manager_products_assignable.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignable Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        <h1>Assignable Products</h1>

        <div class="accordion" id="ordersAccordion">
            @foreach($orders as $order)
           @php
            $productCount = $order->products->count();
        @endphp
                @if($productCount > 0)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading{{ $order->id_order }}">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id_order }}" aria-expanded="true" aria-controls="collapse{{ $order->id_order }}">
                                Created: {{ $order->date }} <br> Deadline: {{ $order->deadline }} <br> Description: {{ $order->description }} <br> Total Products: {{ $productCount }}
                            </button>
                        </h2>
                        <div id="collapse{{ $order->id_order }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $order->id_order }}" data-bs-parent="#ordersAccordion">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Product Name</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Assign</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->products as $product)
                                            <tr class="expandable-row" data-bs-toggle="collapse" data-bs-target="#productDetails{{ $product->id_product }}" aria-expanded="false" aria-controls="productDetails{{ $product->id_product }}">
                                                <td class="expandable-row-icon collapsed">{{ $loop->iteration }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td><img src="{{ asset($product->product_image) }}" alt="{{ $product->name }}" height="50"></td>
                                                <td>{{ $product->status }}</td>
                                                <td>
                                                    <a href="{{ route('manager.products.assign', $product->id_product) }}" class="btn btn-primary btn-sm assign-btn">Assign</a>
                                                </td>
                                            </tr>
                                            <tr id="productDetails{{ $product->id_product }}" class="collapse">
                                                <td colspan="5">
                                                    <table class="table table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Ingredient Name</th>
                                                                <th>Amount</th>
                                                                <th>Unit</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($product->product_ingredients as $ingredient)
                                                                <tr>
                                                                    <td>{{ $ingredient->name }}</td>
                                                                    <td>{{ $ingredient->ingredient_amount }}</td>
                                                                    <td>{{ $ingredient->unit }}</td>
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
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning" role="alert">
                        No products found for order {{ $order->name }}
                    </div>
                @endif
            @endforeach
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
        document.querySelectorAll('.expandable-row').forEach(row => {
            row.addEventListener('click', function() {
                const icon = this.querySelector('.expandable-row-icon');
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
