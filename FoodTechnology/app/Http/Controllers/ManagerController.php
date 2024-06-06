<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orders;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function showAssignableProducts()
    {
        $managerId = Auth::user()->managers->id_manager;

        // Get orders assigned to the current manager
        $orders = orders::with(['products' => function($query) {
            $query->whereNull('id_food_technologist');
        }])->where('id_manager', $managerId)->get();
        // Add product count to each order and check if there are any assignable products
        $orders->each(function($order) {
            $order->productCount = $order->products->count();
        });

        // Check if there are any orders with products to assign
        $hasProducts = $orders->contains(function($order) {
            return $order->productCount > 0;
        });



        return view('manager_products_assignable', compact('orders', 'hasProducts'));
    }
}
