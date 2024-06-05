<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>
<body>

    @include('users_sidemenu')

    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">

    <div class="container mt-5">
        <h1>Product Test: {{ $product->name }}</h1>

        <form action="{{ route('foodTechnologistProductTest.update', $product->id_product) }}" method="POST" enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <h2>Ingredients</h2>
            <div id="ingredients">
                @foreach($product->product_ingredients as $ingredient)
                    <div class="mb-3">
                        <input type="hidden" name="product_ingredients[{{ $loop->index }}][id_product_ingredient]" value="{{ $ingredient->id_product_ingredient }}">
                        <input type="hidden" name="product_ingredients[{{ $loop->index }}][id_ingredient]" value="{{ $ingredient->id_ingredient }}">

                        <div class="row g-2">
                            <div class="col-md-4">
                                <label for="ingredient_name_{{ $loop->index }}">Name</label>
                                <input readonly type="text" class="form-control" id="ingredient_name_{{ $loop->index }}" name="product_ingredients[{{ $loop->index }}][name]" value="{{ $ingredient->name ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <label for="ingredient_amount_{{ $loop->index }}">Amount</label>
                                <input type="text" class="form-control ingredient_amount" id="ingredient_amount_{{ $loop->index }}" name="product_ingredients[{{ $loop->index }}][ingredient_amount]" value="{{ $ingredient->ingredient_amount ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <label for="ingredient_unit_{{ $loop->index }}">Unit</label>
                                <input type="text" class="form-control ingredient_unit" id="ingredient_unit_{{ $loop->index }}" name="product_ingredients[{{ $loop->index }}][unit]" value="{{ $ingredient->unit ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="ingredient_completed_by_{{ $loop->index }}">Completed By</label>
                                <input readonly type="text" class="form-control" id="ingredient_completed_by_{{ $loop->index }}" name="product_ingredients[{{ $loop->index }}][completed_by]" value="{{ $ingredient->completed_by ?? '' }}">
                            </div>
                        <div class="row g-2 mt-2">
                        <div class="col-md-6">
                        <label for="ingredient_safe_amount_{{ $loop->index }}">Safe Amount</label>
                        <input readonly  class="form-control" name="product_ingredients[{{ $loop->index }}][safe_amount]" id="ingredient_safe_amount_{{ $loop->index }}" value="{{ $ingredient->ingredient->safe_amount ?? '???' }} {{ $ingredient->ingredient->unit ?? '' }}">
                        </div>
                        <div class="col-md-6">
                        <label for="ingredient_safety_{{ $loop->index }}">Safety</label>
                        <input  readonly class="form-control" name="product_ingredients[{{ $loop->index }}][safety]" id="ingredient_safety_{{ $loop->index }}" value="{{ $ingredient->ingredient->safety ?? '???' }}">
                        </div>
                    </div>
                        <div class="col-md-2 mt-2">
                                <button type="button" class="btn btn-danger mt-4" onclick="removeIngredient(this)">Remove</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-primary" onclick="addIngredient()">Add Ingredient</button>

            <h2>Microorganisms</h2>
            <div id="microorganisms">
                @foreach($product->product_microorganisms as $microorganism)
                    <div class="mb-3">
                        <input type="hidden" name="product_microorganisms[{{ $loop->index }}][id_product_microorganism]" value="{{ $microorganism->id_product_microorganism }}">
                        <input  type="hidden" name="product_microorganisms[{{ $loop->index }}][id_microorganism]" value="{{ $microorganism->id_microorganism }}">
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label for="microorganism_name_{{ $loop->index }}">Name</label>
                                <input readonly type="text" class="form-control" id="microorganism_name_{{ $loop->index }}" name="product_microorganisms[{{ $loop->index }}][name]" value="{{ $microorganism->name ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <label for="microorganism_type_{{ $loop->index }}">Type</label>
                                <input readonly type="text" class="form-control" id="microorganism_type_{{ $loop->index }}" name="product_microorganisms[{{ $loop->index }}][type]" value="{{ $microorganism->type ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <label for="microorganism_amount_{{ $loop->index }}">Amount</label>
                                <input type="text" class="form-control" id="microorganism_amount_{{ $loop->index }}" name="product_microorganisms[{{ $loop->index }}][amount]" value="{{ $microorganism->amount ?? '' }}">
                            </div>
                            <div class="col-md-2">
                                <label for="microorganism_unit_{{ $loop->index }}">Unit</label>
                                <input type="text" class="form-control" id="microorganism_unit_{{ $loop->index }}" name="product_microorganisms[{{ $loop->index }}][unit]" value="{{ $microorganism->unit ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label for="microorganism_completed_by_{{ $loop->index }}">Completed By</label>
                                <input readonly type="text" class="form-control" id="microorganism_completed_by_{{ $loop->index }}" name="product_microorganisms[{{ $loop->index }}][completed_by]" value="{{ $microorganism->completed_by ?? '' }}">
                            </div>
                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                <label for="microorganism_safe_amount_{{ $loop->index }}">Safe Amount</label>
                                <input  readonly class="form-control" name="microorganisms_ingredients[{{ $loop->index }}][safe_amount]" id="microorganism_safe_amount_{{ $loop->index }}" value="{{ $microorganism->microorganism->safe_amount ?? '???' }} {{ $microorganism->microorganism->unit ?? '' }}">
                                </div>
                                <div class="col-md-2 mt-2">
                                <label for="microorganism_safety_{{ $loop->index }}">Safety</label>
                                <input  readonly class="form-control" name="microorganisms_ingredients[{{ $loop->index }}][safety]" id="microorganism_safety_{{ $loop->index }}" value="{{ $microorganism->microorganism->safety ?? '???' }}">
                                </div>
                            </div>
                            <div class="col-md-2 mt-2">
                                <button type="button" class="btn btn-danger mt-4" onclick="removeMicroorganism(this)">Remove</button>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-primary" onclick="addMicroorganism()">Add Microorganism</button>

            <h2>Test Results</h2>
            <div class="mb-3">
                <label for="test_results">Test Results</label>
                <textarea class="form-control" id="test_results" required name="test_result[test_results]">{{ $product->test_result->test_results ?? '' }}</textarea>
            </div>
            <div class="mb-3">
                <label for="decision">Decision</label>
                <select class="form-control" id="decision" name="test_result[decision]">
                    <option value="passed" {{ ($product->test_result->decision ?? '') == 'passed' ? 'selected' : '' }}>Passed</option>
                    <option value="failed" {{ ($product->test_result->decision ?? '') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            @if ($product->test_result)
              <!-- Section for viewing and managing existing images -->
              <h2>Existing Test Result Images</h2>
              <div id="existing-images">
                <div class="row">
                  @foreach($product->test_result->resultImages as $image)
                  <div class="col-md-3">
                      <div class="image-preview mb-1" data-image-id="{{ $image->id_result_image }}">
                          <img src="{{ asset('storage/' . $image->image_path) }}" alt="Test Result Image" class="img-thumbnail" style="max-height: 100px;">

                      </div>
                      <button type="button" class="btn btn-danger" onclick="removeExistingImage(this, {{ $image->id_result_image }})">Remove Image</button>
                  </div>
                  @endforeach
                </div>
              </div>
            @endif

              <!-- Dynamic fields for uploading images -->
<h2>Upload Test Result Images</h2>
<div id="image-uploads">
    <div class="mb-3 image-upload">
        <div class="image-preview" style="margin-bottom: 5px;">
            <img src="#" alt="New Image Preview" class="img-thumbnail new-image-preview" style="max-height: 100px; display: none;">
        </div>
        <input required type="file" class="form-control" name="result_images[]" onchange="previewImage(this)">
        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(this)">Remove Image</button>
    </div>
</div>
              <button type="button" class="btn btn-primary" onclick="addImage()">Add Image</button>

            <div class="mb-3">
            <button type="submit" id="saveButton" class="btn btn-success mt-3" disabled>Save</button>
            </div>
        </form>
    </div>


</main>
@include('footer')

</div>
</div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
    checkFormValidity();
});
function addImage() {
    const imageUploadContainer = document.createElement('div');
    imageUploadContainer.className = 'mb-3 image-upload';
    imageUploadContainer.innerHTML = `
        <div class="image-preview" style="margin-bottom: 5px;">
            <img src="#" alt="New Image Preview" class="img-thumbnail new-image-preview" style="max-height: 100px; display: none;">
        </div>
        <input type="file" class="form-control" name="result_images[]" onchange="previewImage(this)">
        <button type="button" class="btn btn-danger mt-2" onclick="removeImage(this)">Remove Image</button>
    `;
    document.getElementById('image-uploads').appendChild(imageUploadContainer);
}
function previewImage(input) {
    const preview = input.parentElement.querySelector('.new-image-preview');
    const file = input.files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        preview.src = reader.result;
        preview.style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = '#';
    }
}


        function removeImage(button) {
            button.parentElement.remove();
        }

        function removeExistingImage(button, imageId) {
            const imagePreviewDiv = button.parentElement;
            imagePreviewDiv.remove();

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'removed_images[]';
            hiddenInput.value = imageId;
            document.getElementById('image-uploads').appendChild(hiddenInput);
        }
        function addIngredient() {
            let index = document.querySelectorAll('#ingredients .mb-3').length;
            let html = `
                <div class="mb-3 ingredient">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label for="ingredient_type_${index}">Ingredient Type</label>
                            <select class="form-control" id="ingredient_type_${index}" name="product_ingredients[${index}][type]" onchange="toggleIngredientFields(this)">
                                <option value="">Select Ingredient</option>
                                <option value="existing">Choose Existing Ingredient</option>
                                <option value="custom">Enter Custom Ingredient</option>
                            </select>
                        </div>
                        <div class="col-md-3 existing-ingredient" style="display:none;">
    <label for="existing_ingredient_${index}">Existing Ingredient</label>
    <select class="form-control" id="existing_ingredient_${index}" name="product_ingredients[${index}][id_ingredient]" onchange="updateUnitHint(this)">
        <option value="">Select Ingredient</option>
        @foreach($ingredients as $ingredient)
            @if($ingredient->added_by !== 'FoodTechnologist')
                <option value="{{ $ingredient->id_ingredient }}" data-unit="{{ $ingredient->unit }}" data-safe-amount="{{ $ingredient->safe_amount }} Safety: {{ $ingredient->safety }}">{{ $ingredient->name }}</option>
            @endif
        @endforeach
    </select>
    <span class="unit-hint"></span> <!-- Placeholder for unit hint -->
</div>

                        <div class="col-md-3 custom-ingredient" style="display:none;">
                            <label for="custom_ingredient_${index}">Custom Ingredient</label>
                            <input type="text" class="form-control" id="custom_ingredient_${index}" name="product_ingredients[${index}][custom_name]" placeholder="Custom Ingredient Name">
                        </div>
                        <div class="col-md-2">
                            <label for="ingredient_amount_${index}">Amount</label>
                            <input type="text" class="form-control ingredient_amount" id="ingredient_amount_${index}" name="product_ingredients[${index}][ingredient_amount]" placeholder="Amount">
                        </div>
                        <div class="col-md-2">
                            <label for="ingredient_unit_${index}">Unit</label>
                            <input type="text" class="form-control ingredient_unit" id="ingredient_unit_${index}" name="product_ingredients[${index}][unit]" placeholder="Unit">
                        </div>
                        <div style="display:none;" class="col-md-2">
                            <label for="ingredient_completed_by_${index}">Completed By</label>
                            <input type="text" class="form-control" id="ingredient_completed_by_${index}" name="product_ingredients[${index}][completed_by]" value="FoodTechnologist">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger mt-4" onclick="removeIngredient(this)">Remove</button>
                        </div>
                    </div>
                </div>`;
                document.getElementById('ingredients').insertAdjacentHTML('beforeend', html);
        checkFormValidity(); // Sprawdzenie poprawności formularza po dodaniu składnika

        }
        // Funkcja do sprawdzania, czy istnieją składniki przed wysłaniem formularza
    function checkFormValidity() {
        const ingredientsCount = document.querySelectorAll('#ingredients .mb-3').length;

        // Jeśli istnieją składniki, odblokuj przycisk "Save", w przeciwnym razie zablokuj go
        if (ingredientsCount > 0) {
            document.getElementById('saveButton').removeAttribute('disabled');
        } else {
            document.getElementById('saveButton').setAttribute('disabled', 'disabled');
        }
    }
         // Wywołanie funkcji checkFormValidity() przy usuwaniu składnika
    function removeIngredient(button) {
        button.closest('.mb-3').remove();
        checkFormValidity();
    }

        function toggleIngredientFields(select) {
            const ingredientType = select.value;
            const parent = select.closest('.ingredient');
            const existingIngredient = parent.querySelector('.existing-ingredient');
            const customIngredient = parent.querySelector('.custom-ingredient');

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
            const selectedOption = select.options[select.selectedIndex];
            const unitHint = selectedOption.dataset.unit;
            const safeAmount = selectedOption.dataset.safeAmount;
            const unitHintSpan = select.nextElementSibling;
            unitHintSpan.textContent = unitHint ? `Unit: ${unitHint}, Safe Amount: ${safeAmount}` : '';
        }

        function addMicroorganism() {
            let index = document.querySelectorAll('#microorganisms .mb-3').length;
            let html = `
                <div class="mb-3 microorganism">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <label for="microorganism_type_${index}">Microorganism Type</label>
                            <select class="form-control" id="microorganism_type_${index}" name="product_microorganisms[${index}][type]" onchange="toggleMicroorganismFields(this)">
                                <option value="">Select Microorganism</option>
                                <option value="existing">Choose Existing Microorganism</option>
                                <option value="custom">Enter Custom Microorganism</option>
                            </select>
                        </div>
                        <div class="col-md-3 existing-microorganism" style="display:none;">
    <label for="existing_microorganism_${index}">Existing Microorganism</label>
    <select class="form-control" id="existing_microorganism_${index}" name="product_microorganisms[${index}][id_microorganism]" onchange="updateUnitHint(this)">
        <option value="">Select Microorganism</option>
        @foreach($microorganisms as $microorganism)
            @if($microorganism->added_by !== 'FoodTechnologist')
                <option value="{{ $microorganism->id_microorganism }}" data-unit="{{ $microorganism->unit }}" data-safe-amount="{{ $microorganism->safe_amount }}  Safety: {{ $microorganism->safety }}">{{ $microorganism->name }}</option>
            @endif
        @endforeach
    </select>
    <span class="unit-hint"></span> <!-- Placeholder for unit hint -->
</div>

                        <div class="col-md-3 custom-microorganism" style="display:none;">
                            <label for="custom_microorganism_${index}">Custom Microorganism</label>
                            <input type="text" class="form-control" id="custom_microorganism_${index}" name="product_microorganisms[${index}][custom_name]" placeholder="Custom Microorganism Name">
                            <div class="col-md-2">
                            <label for="microorganism_type_${index}">Type</label>
                            <input type="text" class="form-control" id="microorganism_type_${index}" name="product_microorganisms[${index}][type]" placeholder="Type">
                        </div>
                            </div>
                        <div class="col-md-2">
                            <label for="microorganism_amount_${index}">Amount</label>
                            <input type="text" class="form-control" id="microorganism_amount_${index}" name="product_microorganisms[${index}][amount]" placeholder="Amount">
                        </div>
                        <div class="col-md-2">
                            <label for="microorganism_unit_${index}">Unit</label>
                            <input type="text" class="form-control" id="microorganism_unit_${index}" name="product_microorganisms[${index}][unit]" placeholder="Unit">
                        </div>
                        <div style="display:none;" class="col-md-2">
                            <label for="microorganism_completed_by_${index}">Completed By</label>
                            <input type="text" class="form-control" id="microorganism_completed_by_${index}" name="product_microorganisms[${index}][completed_by]" value="FoodTechnologist">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger mt-4" onclick="removeMicroorganism(this)">Remove</button>
                        </div>
                    </div>
                </div>`;
            document.getElementById('microorganisms').insertAdjacentHTML('beforeend', html);
        }

        function removeMicroorganism(button) {
            button.closest('.mb-3').remove();
            checkSafety();
        }

        function toggleMicroorganismFields(select) {
            const microorganismType = select.value;
            const parent = select.closest('.microorganism');
            const existingMicroorganism = parent.querySelector('.existing-microorganism');
            const customMicroorganism = parent.querySelector('.custom-microorganism');

            if (microorganismType === 'existing') {
                existingMicroorganism.style.display = 'block';
                customMicroorganism.style.display = 'none';
            } else if (microorganismType === 'custom') {
                existingMicroorganism.style.display = 'none';
                customMicroorganism.style.display = 'block';
            } else {
                existingMicroorganism.style.display = 'none';
                customMicroorganism.style.display = 'none';
            }
        }
    </script>
</body>
</html>
