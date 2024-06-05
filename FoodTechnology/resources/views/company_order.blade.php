<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"> --}}

    <style>
        .product {
            margin-bottom: 10px;
        }
        .remove-product {
            margin-left: 10px;
            cursor: pointer;
        }
        .product-details {
            display: none;
        }
        .product-image-preview {
            max-width: 100px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1>Create Order</h1>
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Client Selection Section -->
    <div id="clientSelection" class="mb-4">
        <h3>Select Client Type</h3>
        <button class="btn btn-primary" id="newClientButton">New Client</button>
        <button class="btn btn-secondary" id="existingClientButton">Existing Client</button>
    </div>

    <!-- NIP Form for Existing Client -->
    <div id="existingClientForm" class="mb-4" style="display: none;">
        <h3>Enter Company NIP</h3>
        <form id="nipForm">
            <div class="form-group">
                <label for="nip">NIP:</label>
                <input type="text" class="form-control" id="nipInput" name="nip" required>
            </div>
            <button type="button" class="btn btn-primary" id="checkNipButton">Check NIP</button>
            <button type="button" class="btn btn-secondary" id="backToSelection1">Back</button>
        </form>
    </div>

    <!-- Order Form -->
    <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data" id="orderForm" style="display: none;">
        @csrf

        <div id="clientDetails">
            <div class="form-group">
                <label for="company_name">Company Name:</label>
                <input type="text" class="form-control" name="company_name" id="company_name">
            </div>
            <div class="form-group">
                <label for="nip">NIP:</label>
                <input type="text" class="form-control" name="nip" id="nip">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address" id="address">
            </div>
            <div class="form-group">
                <label for="postal_code">Postal Code:</label>
                <input type="text" class="form-control" name="postal_code" id="postal_code">
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" class="form-control" name="city" id="city">
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="text" class="form-control" name="phone_number" id="phone_number">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" name="email" id="email">
            </div>
        </div>

        <div class="form-group">
            <label for="name">Order Subject:</label>
            <input type="text" class="form-control" name="name" id="name">
        </div>
        <div class="form-group">
            <label for="description">Order Description:</label>
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
        <div class="form-group">
            <label for="cost">Cost:</label>
            <input type="text" class="form-control" name="cost" id="cost">
        </div>

        <div id="products"></div>
        <button type="button" class="btn btn-info" id="addProduct">Add Product</button>

        <button type="submit" class="btn btn-success mt-3">Submit</button>
        <button type="button" class="btn btn-secondary mt-3" id="backToSelection2">Back</button>
    </form>
</div>

<script>
    document.getElementById('newClientButton').addEventListener('click', function() {
        document.getElementById('clientSelection').style.display = 'none';
        document.getElementById('orderForm').style.display = 'block';
        document.getElementById('clientDetails').style.display = 'block';
    });

    document.getElementById('existingClientButton').addEventListener('click', function() {
        document.getElementById('clientSelection').style.display = 'none';
        document.getElementById('existingClientForm').style.display = 'block';
    });

    document.getElementById('checkNipButton').addEventListener('click', function() {
        const nip = document.getElementById('nipInput').value;
        fetch('{{ route('order.checkNip') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ nip: nip })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('company_name').value = data.company.name;
                document.getElementById('nip').value = data.company.nip;
                document.getElementById('address').value = data.company.address;
                document.getElementById('postal_code').value = data.company.postal_code;
                document.getElementById('city').value = data.company.city;
                document.getElementById('phone_number').value = data.company.phone_number;
                document.getElementById('email').value = data.company.email;

                document.getElementById('clientDetails').style.display = 'none';
            } else {
                alert(data.message);
            }
            document.getElementById('existingClientForm').style.display = 'none';
            document.getElementById('orderForm').style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
    });

    document.getElementById('backToSelection1').addEventListener('click', function() {
        document.getElementById('existingClientForm').style.display = 'none';
        document.getElementById('clientSelection').style.display = 'block';
    });

    document.getElementById('backToSelection2').addEventListener('click', function() {
        document.getElementById('orderForm').style.display = 'none';
        document.getElementById('clientSelection').style.display = 'block';
    });
    document.getElementById('backToSelection1').addEventListener('click', function() {
    document.getElementById('existingClientForm').style.display = 'none';
    document.getElementById('clientSelection').style.display = 'block';

    // Resetowanie pól formularza firmy
    document.getElementById('company_name').value = '';
    document.getElementById('nip').value = '';
    document.getElementById('address').value = '';
    document.getElementById('postal_code').value = '';
    document.getElementById('city').value = '';
    document.getElementById('phone_number').value = '';
    document.getElementById('email').value = '';
});

document.getElementById('backToSelection2').addEventListener('click', function() {
    document.getElementById('orderForm').style.display = 'none';
    document.getElementById('clientSelection').style.display = 'block';

    // Resetowanie pól formularza firmy
    document.getElementById('company_name').value = '';
    document.getElementById('nip').value = '';
    document.getElementById('address').value = '';
    document.getElementById('postal_code').value = '';
    document.getElementById('city').value = '';
    document.getElementById('phone_number').value = '';
    document.getElementById('email').value = '';
});
    document.getElementById('addProduct').addEventListener('click', function() {
        const productCount = document.querySelectorAll('.product').length;
        const productInput = `
            <div class="product">
                <hr>
                <label for="products_${productCount}_name">Product Name:</label>
                <input type="text" class="form-control" name="products[${productCount}][name]" id="products_${productCount}_name">

                <label for="products_${productCount}_image">Product Image:</label>
                <input type="file" class="form-control" name="products[${productCount}][product_image]" id="products_${productCount}_image" onchange="previewImage(this)">
                <img class="product-image-preview" id="products_${productCount}_image_preview" src="#" alt="Product Image Preview">

                <div class="ingredients mt-3">
                    <div class="ingredient">
                        <label for="products_${productCount}_ingredients_0_type">Ingredient Type:</label>
                        <select class="form-control" name="products[${productCount}][ingredients][0][type]" onchange="toggleIngredientInput(this)">
                            <option value="select">Select Ingredient</option>
                            <option value="existing">Choose Existing Ingredient</option>
                            <option value="custom">Enter Custom Ingredient</option>
                        </select>
                        <div class="existing-ingredient mt-2" style="display: none;">
                            <label for="products_${productCount}_ingredients_0_existing">Existing Ingredient:</label>
                            <select class="form-control" name="products[${productCount}][ingredients][0][id_ingredient]" onchange="updateUnitHint(this)">
                                <option value="">Select Ingredient</option>
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id_ingredient }}" data-unit="{{ $ingredient->unit }}">{{ $ingredient->name }}</option>
                                @endforeach
                            </select>
                            <span class="unit-hint"></span>
                        </div>
                        <div class="custom-ingredient mt-2" style="display: none;">
                            <label for="products_${productCount}_ingredients_0_custom">Custom Ingredient:</label>
                            <input type="text" class="form-control" name="products[${productCount}][ingredients][0][custom_name]" placeholder="Custom Ingredient Name">
                        </div>
                        <input type="text" class="form-control mt-2" name="products[${productCount}][ingredients][0][ingredient_amount]" placeholder="Amount">
                        <input type="text" class="form-control mt-2" name="products[${productCount}][ingredients][0][unit]" placeholder="Unit">
                        <span class="remove-ingredient btn btn-danger mt-2" onclick="removeIngredient(this)">Remove Ingredient</span>
                    </div>
                </div>
                <button type="button" class="add-ingredient btn btn-info mt-3" onclick="addIngredient(this, ${productCount})">Add Ingredient</button>
                <span class="remove-product btn btn-danger mt-3" onclick="removeProduct(this)">Remove Product</span>
            </div>
        `;
        document.getElementById('products').insertAdjacentHTML('beforeend', productInput);
    });

    function addIngredient(button, productIndex) {
        const productDiv = button.closest('.product');
        const ingredientCount = productDiv.querySelectorAll('.ingredient').length;
        const ingredientInput = `
            <div class="ingredient">
                <label for="products_${productIndex}_ingredients_${ingredientCount}_type">Ingredient Type:</label>
                <select class="form-control" name="products[${productIndex}][ingredients][${ingredientCount}][type]" onchange="toggleIngredientInput(this)">
                    <option value="select">Select Ingredient</option>
                    <option value="existing">Choose Existing Ingredient</option>
                    <option value="custom">Enter Custom Ingredient</option>
                </select>
                <div class="existing-ingredient mt-2" style="display: none;">
                    <label for="products_${productIndex}_ingredients_${ingredientCount}_existing">Existing Ingredient:</label>
                    <select class="form-control" name="products[${productIndex}][ingredients][${ingredientCount}][id_ingredient]" onchange="updateUnitHint(this)">
                        <option value="">Select Ingredient</option>
                        @foreach($ingredients as $ingredient)
                            <option value="{{ $ingredient->id_ingredient }}" data-unit="{{ $ingredient->unit }}">{{ $ingredient->name }}</option>
                        @endforeach
                    </select>
                    <span class="unit-hint"></span>
                </div>
                <div class="custom-ingredient mt-2" style="display: none;">
                    <label for="products_${productIndex}_ingredients_${ingredientCount}_custom">Custom Ingredient:</label>
                    <input type="text" class="form-control" name="products[${productIndex}][ingredients][${ingredientCount}][custom_name]" placeholder="Custom Ingredient Name">
                </div>
                <input type="text" class="form-control mt-2" name="products[${productIndex}][ingredients][${ingredientCount}][ingredient_amount]" placeholder="Amount">
                <input type="text" class="form-control mt-2" name="products[${productIndex}][ingredients][${ingredientCount}][unit]" placeholder="Unit">
                <span class="remove-ingredient btn btn-danger mt-2" onclick="removeIngredient(this)">Remove Ingredient</span>
            </div>
        `;
        productDiv.querySelector('.ingredients').insertAdjacentHTML('beforeend', ingredientInput);
    }

    function previewImage(input) {
        const preview = input.nextElementSibling;
        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
        }

        reader.readAsDataURL(file);
    }

    function removeProduct(element) {
        const productDiv = element.parentElement;
        productDiv.remove();
    }

    function removeIngredient(element) {
        const ingredientDiv = element.parentElement;
        ingredientDiv.remove();
    }

    function toggleIngredientInput(select) {
        const ingredientType = select.value;
        const existingIngredient = select.closest('.ingredient').querySelector('.existing-ingredient');
        const customIngredient = select.closest('.ingredient').querySelector('.custom-ingredient');

        if (ingredientType === 'existing') {
            existingIngredient.style.display = 'block';
            customIngredient.style.display = 'none';
        } else if (ingredientType === 'custom') {
            existingIngredient.style.display = 'none';
            customIngredient.style.display = 'block';
        } else {
            existingIngredient.style.display = 'none';
            customIngredient.style.display = 'none';
        }
    }

    function updateUnitHint(select) {
        const unitHint = select.parentElement.querySelector('.unit-hint');
        const selectedOption = select.options[select.selectedIndex];
        const unit = selectedOption.getAttribute('data-unit');
        unitHint.textContent = unit ? `Unit: ${unit}` : '';
    }
    document.getElementById('orderForm').addEventListener('submit', function(event) {
        const productCount = document.querySelectorAll('.product').length;
        if (productCount < 1) {
            event.preventDefault(); // Zatrzymaj domyślne działanie przycisku przesyłania formularza
            alert('Please add at least one product.'); // Wyświetl ostrzeżenie
        }
    });
</script>
</body>
</html>
