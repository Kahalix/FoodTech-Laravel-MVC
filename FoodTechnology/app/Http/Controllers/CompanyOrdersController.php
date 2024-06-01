<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use Illuminate\Http\Request;
use App\Models\Ingredients;
use App\Models\Orders;
use App\Models\product_ingredients;
use App\Models\Products;
use App\Models\ProductIngredients;

class CompanyOrdersController extends Controller
{
    public function create()
    {
        $ingredients = Ingredients::where('added_by', '!=', 'FoodTechnologist')->get();
        return view('company_order', compact('ingredients'));
    }

    public function checkNip(Request $request)
{
    $company = companies::where('nip', $request->nip)->first();

    if ($company) {
        return response()->json([
            'success' => true,
            'company' => $company
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Company not found'
        ]);
    }
}
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:100',
            'nip' => 'required|string|max:50',
            'address' => 'required|string|max:100',
            'postal_code' => 'required|string|max:50',
            'city' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'email' => 'required|string|max:100|email',
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'cost' => 'required|string|max:20',
            'products.*.name' => 'required|string|max:100',
            'products.*.product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
            'products.*.ingredients.*.type' => 'required|in:select,existing,custom',
            'products.*.ingredients.*.id_ingredient' => 'sometimes|required_if:products.*.ingredients.*.type,existing',
            'products.*.ingredients.*.custom_name' => 'nullable|required_unless:products.*.ingredients.*.type,existing|string|max:100',
            'products.*.ingredients.*.ingredient_amount' => 'required|numeric',
            'products.*.ingredients.*.unit' => 'required|string|max:20',
        ]);

        $company = Companies::where('nip', $request->nip)->first();
        if (!$company) {
            $company = Companies::create([
                'name' => $request->company_name,
                'nip' => $request->nip,
                'address' => $request->address,
                'postal_code' => $request->postal_code,
                'city' => $request->city,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
            ]);
        }

        $order = Orders::create([
            'id_company' => $company->id_company,
            'name' => $request->name,
            'description' => $request->description,
            'cost' => $request->cost,
        ]);

        foreach ($request->products as $productData) {
            $image = $productData['product_image'];
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('product_images'), $imageName);
            $imagePath = 'product_images/' . $imageName;

            $product = Products::create([
                'id_order' => $order->id_order,
                'name' => $productData['name'],
                'product_image' => $imagePath,
                'status' => 'pending',
            ]);

            if (isset($productData['ingredients'])) {
                foreach ($productData['ingredients'] as $ingredientData) {
                    $ingredientType = $ingredientData['type'];
                    $ingredientName = '';
                    $ingredientId = null;

                    if ($ingredientType === 'existing') {
                        $ingredientId = $ingredientData['id_ingredient'];
                        $ingredient = Ingredients::find($ingredientId);
                        $ingredientName = $ingredient->name;
                    } elseif ($ingredientType === 'custom') {
                        $ingredientName = $ingredientData['custom_name'];
                    }

                    product_ingredients::create([
                        'id_product' => $product->id_product,
                        'id_ingredient' => $ingredientId,
                        'name' => $ingredientName,
                        'ingredient_amount' => $ingredientData['ingredient_amount'],
                        'unit' => $ingredientData['unit'],
                        'completed_by' => 'company',
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Order created successfully!');
    }
}
