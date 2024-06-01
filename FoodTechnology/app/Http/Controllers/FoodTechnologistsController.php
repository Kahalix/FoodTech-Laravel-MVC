<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoodTechnologistsController extends Controller
{
    public function index()
    {
        return view('FTproduct');
    }
    public function dashboard()
    {
        return view('FTdashboard');
    }
}
