<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
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
    <h1>Create Order</h1>
    @if($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="company_name">Company Name:</label>
        <input type="text" name="company_name" id="company_name" value="ABC Company">

        <label for="nip">NIP:</label>
        <input type="text" name="nip" id="nip" value="1234567890">

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" value="123 Main Street">

        <label for="postal_code">Postal Code:</label>
        <input type="text" name="postal_code" id="postal_code" value="12345">

        <label for="city">City:</label>
        <input type="text" name="city" id="city" value="City Name">

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" value="123-456-7890">

        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="info@abccompany.com">

        <hr>

        <label for="description">Order Description:</label>
        <textarea name="description" id="description">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</textarea>

        <label for="cost">Cost:</label>
        <input type="text" name="cost" id="cost" value="1000">

        <hr>

        <div id="products">
            <div class="product">
                <hr>
                <label for="product_0_name">Product Name:</label>
                <input type="text" name="products[0][name]" id="product_0_name" value="Product 1">

                <label for="product_0_image">Product Image:</label>
                <input type="file" name="products[0][product_image]" id="product_0_image" onchange="previewImage(this)">
                <img class="product-image-preview" id="product_0_image_preview" src="#" alt="Product Image Preview">

                <div class="ingredients">
                    <div class="ingredient">
                        <label for="ingredient_0_type">Ingredient Type:</label>
                        <select name="products[0][ingredients][0][type]">
                            <option value="select">Select Ingredient</option>
                            <option value="existing">Choose Existing Ingredient</option>
                            <option value="custom">Enter Custom Ingredient</option>
                        </select>
                        <div class="existing-ingredient" style="display: none;">
                            <label for="ingredient_0_existing">Existing Ingredient:</label>
                            <select name="products[0][ingredients][0][id_ingredient]">
                                <option value="">Select Ingredient</option>
                                @foreach($ingredients as $ingredient)
                                    <option value="{{ $ingredient->id_ingredient }}">{{ $ingredient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="custom-ingredient" style="display: none;">
                            <label for="ingredient_0_custom">Custom Ingredient:</label>
                            <input type="text" name="products[0][ingredients][0][custom_name]" placeholder="Custom Ingredient Name">
                        </div>
                        <input type="text" name="products[0][ingredients][0][ingredient_amount]" placeholder="Amount">
                        <input type="text" name="products[0][ingredients][0][unit]" placeholder="Unit">
                        <span class="remove-ingredient" onclick="removeIngredient(this)">Remove Ingredient</span>
                    </div>
                </div>

                <button type="button" class="add-ingredient" onclick="addIngredient(this)">Add Ingredient</button>
            </div>
        </div>

        <button type="button" id="addProduct">Add Another Product</button>

        <hr>

        <button type="submit">Submit</button>
    </form>

    <script>
        document.getElementById('addProduct').addEventListener('click', function() {
            const productCount = document.querySelectorAll('.product').length;
            const productInput = `
                <div class="product">
                    <hr>
                    <label for="product_${productCount}_name">Product Name:</label>
                    <input type="text" name="products[${productCount}][name]" id="product_${productCount}_name" value="Product ${productCount + 1}">

                    <label for="product_${productCount}_image">Product Image:</label>
                    <input type="file" name="products[${productCount}][product_image]" id="product_${productCount}_image" onchange="previewImage(this)">
                    <img class="product-image-preview" id="product_${productCount}_image_preview" src="#" alt="Product Image Preview">

                    <div class="ingredients">
                        <div class="ingredient">
                            <label for="ingredient_${productCount}_type">Ingredient Type:</label>
                            <select name="products[${productCount}][ingredients][0][type]">
                                <option value="select">Select Ingredient</option>
                                <option value="existing">Choose Existing Ingredient</option>
                                <option value="custom">Enter Custom Ingredient</option>
                            </select>
                            <div class="existing-ingredient" style="display: none;">
                                <label for="ingredient_${productCount}_existing">Existing Ingredient:</label>
                                <select name="products[${productCount}][ingredients][0][id_ingredient]">
                                    <option value="">Select Ingredient</option>
                                    @foreach($ingredients as $ingredient)
                                        <option value="{{ $ingredient->id_ingredient }}">{{ $ingredient->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-ingredient" style="display: none;">
                                <label for="ingredient_${productCount}_custom">Custom Ingredient:</label>
                                <input type="text" name="products[${productCount}][ingredients][0][custom_name]" placeholder="Custom Ingredient Name">
                            </div>
                            <input type="text" name="products[${productCount}][ingredients][0][ingredient_amount]" placeholder="Amount">
                            <input type="text" name="products[${productCount}][ingredients][0][unit]" placeholder="Unit">
                            <span class="remove-ingredient" onclick="removeIngredient(this)">Remove Ingredient</span>
                        </div>
                    </div>

                    <button type="button" class="add-ingredient" onclick="addIngredient(this)">Add Ingredient</button>

                    <span class="remove-product" onclick="removeProduct(this)">Remove Product</span>
                </div>
            `;
            document.getElementById('products').insertAdjacentHTML('beforeend', productInput);
        });

        function removeProduct(element) {
            const productDiv = element.parentElement;
            productDiv.remove();
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

        function addIngredient(element) {
            const productDiv = element.parentElement;
            const ingredientCount = productDiv.querySelectorAll('.ingredient').length;
            const ingredientInput = `
                <div class="ingredient">
                    <label for="ingredient_${ingredientCount}_type">Ingredient Type:</label>
                    <select name="products[${ingredientCount}][ingredients][${ingredientCount}][type]">
                        <option value="select">Select Ingredient</option>
                        <option value="existing">Choose Existing Ingredient</option>
                        <option value="custom">Enter Custom Ingredient</option>
                    </select>
                    <div class="existing-ingredient" style="display: none;">
                        <label for="ingredient_${ingredientCount}_existing">Existing Ingredient:</label>
                        <select name="products[${ingredientCount}][ingredients][${ingredientCount}][id_ingredient]">
                            <option value="">Select Ingredient</option>
                            @foreach($ingredients as $ingredient)
                                <option value="{{ $ingredient->id_ingredient }}">{{ $ingredient->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="custom-ingredient" style="display: none;">
                        <label for="ingredient_${ingredientCount}_custom">Custom Ingredient:</label>
                        <input type="text" name="products[${ingredientCount}][ingredients][${ingredientCount}][custom_name]" placeholder="Custom Ingredient Name">
                    </div>
                    <input type="text" name="products[${ingredientCount}][ingredients][${ingredientCount}][ingredient_amount]" placeholder="Amount">
                    <input type="text" name="products[${ingredientCount}][ingredients][${ingredientCount}][unit]" placeholder="Unit">
                    <span class="remove-ingredient" onclick="removeIngredient(this)">Remove Ingredient</span>
                </div>
            `;
            productDiv.querySelector('.ingredients').insertAdjacentHTML('beforeend', ingredientInput);
        }

        function removeIngredient(element) {
            const ingredientDiv = element.parentElement;
            ingredientDiv.remove();
        }

        document.addEventListener('change', function(event) {
            const target = event.target;
            if (target && target.tagName === 'SELECT' && target.parentElement.className === 'ingredient') {
                const ingredientType = target.value;
                const existingIngredient = target.parentElement.querySelector('.existing-ingredient');
                const customIngredient = target.parentElement.querySelector('.custom-ingredient');

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
        });
    </script>
</body>
</html>
