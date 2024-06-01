<?php

namespace App\Http\Controllers;

use App\Models\food_technologists;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\products;

class ManagerAssignProductToFoodTechnologistController extends Controller
{
    public function showAssignForm($productId)
    {
        $product = products::findOrFail($productId);
        $food_technologists = food_technologists::where('id_manager', $product->order->id_manager)
            ->whereHas('employee', function($query) {
                $query->where('status', 'active');
            })->with('employee')
            ->get()
            ->map(function ($technologist) {
                $technologist->assigned_products_count = products::where('id_food_technologist', $technologist->id_food_technologist)
                    ->where('status', 'assigned')
                    ->count();
                return $technologist;
            });

        $food_technologists = $food_technologists->sortBy('assigned_products_count');

        return view('manager_assign_product_to_food_technologist', compact('product', 'food_technologists'));
    }

    public function assign(Request $request, $productId)
    {
        $request->validate([
            'food_technologist_id' => 'required|exists:food_technologists,id_food_technologist',
        ]);

        $product = products::findOrFail($productId);
        $product->id_food_technologist = $request->food_technologist_id;
        $product->status = 'assigned';
        $product->save();

        return redirect()->route('manager.products.assignable')->with('success', 'Product assigned successfully');
    }

    public function getFoodTechnologistDetails($foodTechnologistId)
    {
        $foodtechnologist = food_technologists::with('employee')
            ->where('id_food_technologist', $foodTechnologistId)
            ->first();

        if (!$foodtechnologist) {
            return response()->json(['error' => 'Food Technologist not found'], 404);
        }

        // Liczba przydzielonych produktów w toku
        $assignedProductCount = products::where('id_food_technologist', $foodTechnologistId)
            ->where('status', 'assigned')
            ->count();

        // Liczba ukończonych produktów
        $completedProductCount = products::where('id_food_technologist', $foodTechnologistId)
            ->where('status', 'completed')
            ->count();

        return response()->json([
            'assignedProductCount' => $assignedProductCount,
            'completedProductCount' => $completedProductCount,
        ]);
    }
}
