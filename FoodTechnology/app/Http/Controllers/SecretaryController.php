<?php

namespace App\Http\Controllers;

use App\Models\companies;
use App\Models\Company;
use Illuminate\Http\Request;

class SecretaryController extends Controller
{
    public function showAssignableOrders()
    {
        $companies = companies::with(['orders' => function($query) {
            $query->where('status', 'assigned');
        }])->get();

        // Add a new property to each company object to store the count of assigned orders
        $companies->each(function($company) {
            $company->assignedOrderCount = $company->orders->count();
            $increment = 0;
        });


        return view('secretary_orders_assignable', compact('companies'));
    }
}
