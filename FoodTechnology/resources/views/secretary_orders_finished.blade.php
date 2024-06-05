<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finished Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>

    @include('users_sidemenu')

    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">



    <div class="container mt-5">
        <h1 class="text-center mb-4">Finished Orders</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


          <!-- Search Bar -->
          <div class="mb-3">
            <form method="GET" action="{{ route('secretary.orders.finished') }}">
                <div class="input-group">
                    <input type="text" name="search" id="searchBar" class="form-control" placeholder="Search orders or companies" value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>


        <div class="accordion" id="ordersAccordion">
            @foreach($orders as $order)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $order->id_order }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $order->id_order }}" aria-expanded="true" aria-controls="collapse{{ $order->id_order }}">
                           Company: {{ $order->company->name }}
                            <br> Name: {{ $order->name }}
                        </button>
                    </h2>

                    <div id="collapse{{ $order->id_order }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $order->id_order }}" data-bs-parent="#ordersAccordion">
                        <div class="accordion-body">
                            <h3>Order Information</h3>
                            <p>Date: {{ $order->date }}</p>
                            <p>Name: {{ $order->name }}</p>
                            <p>Description: {{ $order->description }}</p>
                            <p>Cost: {{ $order->cost }}</p>

                            <h3>Products</h3>
                            <ul class="list-group">
                                @foreach($order->products as $product)
                                    <li class="list-group-item">
                                       <img src="{{ asset($product->product_image) }}" alt="Product Image" style="max-width: 100px;">
                                          {{ $product->name }}
                                        <ul>
                                            <li>Product Ingredients:</li>
                                            <ul>
                                                @foreach($product->product_ingredients as $ingredient)
                                                    <li>{{ $ingredient->name }} - {{ $ingredient->ingredient_amount }} {{ $ingredient->unit }}</li>
                                                @endforeach
                                            </ul>
                                            <li>Product Microorganisms:</li>
                                            <ul>
                                                @foreach($product->product_microorganisms as $microorganism)
                                                    <li>{{ $microorganism->name }} - {{ $microorganism->amount }} {{ $microorganism->unit }}</li>
                                                @endforeach
                                            </ul>
                                            <li>Test Result:</li>
                                            <ul>
                                                @if($product->test_result)
                                                    <li>Test Results: {{ $product->test_result->test_results }}</li>
                                                    <li>Decision: {{ $product->test_result->decision }}</li>
                                                    <li>Result Images:</li>
                                                    <ul class="list-inline">
                                                        @foreach($product->test_result->resultImages as $image)
                                                            <li class="list-inline-item"><img src="{{ asset('storage/' . $image->image_path) }}" alt="Result Image" style="max-width: 100px;"></li>
                                                        @endforeach
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('download.product.images', $product->id_product) }}" class="btn btn-primary btn-sm">Download Images</a>
                                                        </li>
                                                    </ul>
                                                @else
                                                    <li>No test results available.</li>
                                                @endif
                                            </ul>
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                            <a href="{{ route('secretary.orders.report', $order->id_order) }}" class="btn btn-primary mt-4">Download Report</a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>


         <!-- Pagination Links -->
         <div class="mt-4">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>


    </div>


</main>
@include('footer')

</div>
</div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
