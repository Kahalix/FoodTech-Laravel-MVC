<?php

namespace App\Http\Controllers;

use App\Models\companies;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function showAssignableOrders()
    {
        $companies = companies::with(['orders' => function($query) {
            $query->whereNot('status', 'completed')
            ->whereNull('id_manager');
        }])->get();

        // Add a new property to each company object to store the count of assigned orders
        $companies->each(function($company) {
            $company->assignedOrderCount = $company->orders->count();
            $company->increment = 1; // Initialize increment here
        });

        // Check if there are any companies with assigned orders
        $hasOrders = $companies->contains(function($company) {
            return $company->assignedOrderCount > 0;
        });

        return view('secretary_orders_assignable', compact('companies', 'hasOrders'));
    }
}
