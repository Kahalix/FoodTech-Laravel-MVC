<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\orders;
use App\Models\Product;
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

        return view('manager_products_assignable', compact('orders'));
    }
}
