<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\ingredients;
use App\Models\microorganisms;
use App\Models\product_ingredients;
use App\Models\product_microorganisms;
use App\Models\result_images;
use App\Models\test_results;
use Illuminate\Support\Facades\Storage;

class FoodTechnologistProductTestController extends Controller
{
    public function show($id_product)
    {
        $product = products::with(['product_ingredients', 'product_microorganisms', 'test_result'])->findOrFail($id_product);
        $ingredients = ingredients::all();
        $microorganisms = microorganisms::all();
        return view('food_technologist_product_test', compact('product', 'ingredients', 'microorganisms'));
    }

    public function update(Request $request, $id_product)
    {
        $product = products::findOrFail($id_product);

        // Get existing product ingredients and microorganisms
        $existingProductIngredients = $product->product_ingredients->keyBy('id_product_ingredient');
        $existingProductMicroorganisms = $product->product_microorganisms->keyBy('id_product_microorganism');

        // Update or create product ingredients
        $updatedProductIngredients = [];
        foreach ($request->product_ingredients as $ingredient) {
            if (isset($ingredient['id_product_ingredient'])) {
                $productIngredient = product_ingredients::findOrFail($ingredient['id_product_ingredient']);
                $productIngredient->update($ingredient);
                $updatedProductIngredients[] = $ingredient['id_product_ingredient'];
            } else {
                // If no id_ingredient, create new ingredient
                if (empty($ingredient['id_ingredient'])) {
                    $newIngredient = ingredients::create([
                        'name' => $ingredient['custom_name'],
                        'safe_amount' => null,
                        'unit' => null,
                        'safety' => null,
                        'added_by' => $ingredient['completed_by'],
                    ]);
                    $ingredient['id_ingredient'] = $newIngredient->id_ingredient;
                }

                $newProductIngredient = product_ingredients::create([
                    'id_product' => $id_product,
                    'id_ingredient' => $ingredient['id_ingredient'] ?? null,
                    'name' => $ingredient['custom_name'] ?? microorganisms::findOrFail($ingredient['id_ingredient'])->name,
                    'ingredient_amount' => $ingredient['ingredient_amount'],
                    'unit' => $ingredient['unit'],
                    'completed_by' => $ingredient['completed_by'],
                ]);

                $updatedProductIngredients[] = $newProductIngredient->id_product_ingredient;
            }
        }

        // Delete removed product ingredients and associated ingredients if added by FoodTechnologist
        foreach ($existingProductIngredients as $id => $existingIngredient) {
            if (!in_array($id, $updatedProductIngredients)) {
                $ingredientToDelete = $existingIngredient->ingredient;
                $existingIngredient->delete(); // First, delete the product_ingredient
                // Then, delete the associated ingredient if it was added by FoodTechnologist
                if ($ingredientToDelete && $ingredientToDelete->added_by === 'FoodTechnologist') {
                    $ingredientToDelete->delete();
                }
            }
        }

        // Update or create product microorganisms
        $updatedProductMicroorganisms = [];
        if ($request->product_microorganisms !== null) {
        foreach ($request->product_microorganisms as $microorganism) {
            if (isset($microorganism['id_product_microorganism'])) {
                $productMicroorganism = product_microorganisms::findOrFail($microorganism['id_product_microorganism']);
                $productMicroorganism->update($microorganism);
                $updatedProductMicroorganisms[] = $microorganism['id_product_microorganism'];
            } else {
                // If no id_microorganism, create new microorganism
                if (empty($microorganism['id_microorganism'])) {
                    // Check if it's a custom microorganism
                    if (isset($microorganism['custom_name'])) {
                        // Create a new custom microorganism
                        $newMicroorganism = microorganisms::create([
                            'name' => $microorganism['custom_name'],
                            'type' => $microorganism['type'],
                            'safe_amount' => null,
                            'unit' => null,
                            'safety' => null,
                            'added_by' => $microorganism['completed_by'],
                        ]);
                        $microorganism['name'] = $microorganism['custom_name'];
                        $microorganism['id_microorganism'] = $newMicroorganism->id_microorganism;
                    } else {
                        // It's an existing microorganism, but not selected, so skip
                        continue;
                    }
                }

                $newProductMicroorganism = product_microorganisms::create([
                    'id_product' => $id_product,
                    'id_microorganism' => $microorganism['id_microorganism'] ?? null,
                    'name' => isset($microorganism['name']) ? $microorganism['name'] : microorganisms::findOrFail($microorganism['id_microorganism'])->name,
                    'type' => isset($microorganism['type']) ? $microorganism['type'] : microorganisms::findOrFail($microorganism['id_microorganism'])->type,
                    'amount' => $microorganism['amount'],
                    'unit' => $microorganism['unit'],
                    'completed_by' => $microorganism['completed_by'],
                ]);

                $updatedProductMicroorganisms[] = $newProductMicroorganism->id_product_microorganism;
            }
        }
    }
        // Delete removed product microorganisms and associated microorganisms if added by FoodTechnologist
        foreach ($existingProductMicroorganisms as $id => $existingMicroorganism) {
            if (!in_array($id, $updatedProductMicroorganisms)) {
                $microorganismToDelete = $existingMicroorganism->microorganism;

                $existingMicroorganism->delete(); // First, delete the product_microorganism
                if ($microorganismToDelete && $microorganismToDelete->added_by === 'FoodTechnologist') {
                    $microorganismToDelete->delete();
                }
            }
        }


        // Update test results
        $testResult = $product->test_result;
        if ($testResult) {
            $testResult->update($request->test_result);
        } else {
            $testResult = test_results::create([
                'id_product' => $id_product,
                'test_results' => $request->test_result['test_results'],
                'decision' => $request->test_result['decision'],
            ]);
        }

        // Handle image uploads
        if ($request->hasFile('result_images')) {
            foreach ($request->file('result_images') as $file) {
                $filePath = $file->store('result_images', 'public');
                result_images::create([
                    'id_test_result' => $testResult->id_test_result,
                    'image_path' => $filePath,
                ]);
            }
        }

        // Handle image removals
        if ($request->has('removed_images')) {
            foreach ($request->removed_images as $imageId) {
                $image = result_images::findOrFail($imageId);
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }

        $product->status = 'awaiting';
        $product->save();

        return redirect()->route('food_technologist.products.assigned')->with('success', 'Product updated successfully.');
    }
}
