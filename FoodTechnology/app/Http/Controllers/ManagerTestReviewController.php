<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\employees;
use App\Models\food_technologists;
use App\Models\test_results;
use App\Models\product_ingredients;
use App\Models\product_microorganisms;
use App\Models\result_images;

class ManagerTestReviewController extends Controller
{
    public function review()
    {
        $products = products::with(['test_result', 'product_ingredients', 'product_microorganisms'])
                            ->where('status', 'awaiting')
                            ->get();

        return view('manager_tests_review', compact('products'));
    }

    public function accept($id)
    {
        $product = products::findOrFail($id);
        $product->status = 'completed';
        $product->save();

        return redirect()->back()->with('success', 'Product accepted successfully.');
    }

    public function decline($id)
    {
        $product = products::findOrFail($id);
        $product->status = 'assigned';
        $product->save();

        return redirect()->back()->with('success', 'Product declined successfully.');
    }

    public function reassign($id, Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id_employee,status,active'
        ]);

        $employee = employees::findOrFail($request->employee_id);
        $foodTechnologistId = $employee->food_technologists->id_food_technologist;

        $product = products::findOrFail($id);
        $product->status = 'assigned';
        $product->id_food_technologist = $foodTechnologistId;
        $product->save();

        return redirect()->back()->with('success', 'Product reassigned successfully.');
    }

    public function getActiveEmployees()
    {
        $managerId = $this->getManagerId();
        $activeEmployees = employees::whereHas('food_technologists', function ($query) use ($managerId) {
            $query->where('id_manager', $managerId);
        })->where('status', 'active')->get();

        return response()->json($activeEmployees);
    }

    private function getManagerId()
    {
        // Placeholder for getting the manager ID. Adjust this according to your authentication logic.
        return auth()->user()->managers->id_manager;
    }
}
