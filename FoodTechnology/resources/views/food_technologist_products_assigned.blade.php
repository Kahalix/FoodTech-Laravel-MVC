<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
    <div class="container mt-5">
        <h1>Manage Products</h1>
        <div class="accordion" id="productsAccordion">
            @foreach($products as $product)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $product->id_product }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $product->id_product }}" aria-expanded="true" aria-controls="collapse{{ $product->id_product }}">
                            {{ $product->name }} <br> Status: {{ $product->status }}
                        </button>
                    </h2>

                   <button class="btn btn-secondary mt-3" onclick="window.location.href='{{ route('foodTechnologistProductTest.show', $product->id_product) }}'">Edit Product</button>

                    <div id="collapse{{ $product->id_product }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $product->id_product }}" data-bs-parent="#productsAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="ingredientsAccordion{{ $product->id_product }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingIngredients{{ $product->id_product }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIngredients{{ $product->id_product }}" aria-expanded="false" aria-controls="collapseIngredients{{ $product->id_product }}">
                                            Ingredients
                                        </button>
                                    </h2>
                                    <div id="collapseIngredients{{ $product->id_product }}" class="accordion-collapse collapse" aria-labelledby="headingIngredients{{ $product->id_product }}" data-bs-parent="#ingredientsAccordion{{ $product->id_product }}">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Ingredient Name</th>
                                                        <th>Amount</th>
                                                        <th>Unit</th>
                                                        <th>Completed By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->product_ingredients as $ingredient)
                                                        <tr>
                                                            <td>{{ $ingredient->name }}</td>
                                                            <td>{{ $ingredient->ingredient_amount }}</td>
                                                            <td>{{ $ingredient->unit }}</td>
                                                            <td>{{ $ingredient->completed_by }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($product->product_microorganisms->count() > 0)
                                <div class="accordion" id="microorganismsAccordion{{ $product->id_product }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="headingMicroorganisms{{ $product->id_product }}">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMicroorganisms{{ $product->id_product }}" aria-expanded="false" aria-controls="collapseMicroorganisms{{ $product->id_product }}">
                                                Microorganisms
                                            </button>
                                        </h2>
                                        <div id="collapseMicroorganisms{{ $product->id_product }}" class="accordion-collapse collapse" aria-labelledby="headingMicroorganisms{{ $product->id_product }}" data-bs-parent="#microorganismsAccordion{{ $product->id_product }}">
                                            <div class="accordion-body">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Microorganism Name</th>
                                                            <th>Type</th>
                                                            <th>Amount</th>
                                                            <th>Unit</th>
                                                            <th>Completed By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($product->product_microorganisms as $microorganism)
                                                            <tr>
                                                                <td>{{ $microorganism->name }}</td>
                                                                <td>{{ $microorganism->type }}</td>
                                                                <td>{{ $microorganism->amount }}</td>
                                                                <td>{{ $microorganism->unit }}</td>
                                                                <td>{{ $microorganism->completed_by }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
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
    </script>
</body>
</html>
