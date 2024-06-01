<?php

namespace App\Http\Controllers;

use App\Models\companies;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Company;

class SecretaryController extends Controller
{
    public function showAssignableOrders()
    {
        $companies = companies::with(['orders' => function($query) {
            $query->where('status', 'assigned');
        }])->get();

        return view('secretary_orders_assignable', compact('companies'));
    }
}
