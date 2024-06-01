<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;

class FoodTechnologistController extends Controller
{
    public function manage()
    {
        $products = products::with(['product_ingredients', 'product_microorganisms'])
                            ->where('id_food_technologist', auth()->user()->food_technologists->id_food_technologist)
                            ->where('status', 'assigned')
                            ->get();

        return view('food_technologist_products_assigned', compact('products'));
    }
}
