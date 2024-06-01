<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Report</title>

</head>
<body>
    <h1>Order Report</h1>
    <h2>Order Information</h2>
    <p>Date: {{ $order->date }}</p>
    <p>Name: {{ $order->name }}</p>
    <p>Description: {{ $order->description }}</p>
    <p>Cost: {{ $order->cost }}</p>

    <h2>Products</h2>
    <ul>
        @foreach($order->products as $product)
            <li>
                Name: {{ $product->name }}
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
                            {{-- <li>Result Images:</li> --}}
                            {{-- <ul>
                                @foreach($product->test_result->resultImages as $image)
                                    <li><img src="{{ $image->image_path }}" alt="Result Image"></li>
                                @endforeach
                            </ul> --}}
                        @else
                            <li>No test results available.</li>
                        @endif
                    </ul>
                </ul>
            </li>
        @endforeach
    </ul>
</body>
</html>
