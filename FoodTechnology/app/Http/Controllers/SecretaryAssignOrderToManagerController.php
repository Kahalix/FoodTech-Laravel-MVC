<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employees;
use App\Models\food_technologists;
use App\Models\managers;
use App\Models\orders;
use App\Models\products;

class SecretaryAssignOrderToManagerController extends Controller
{
    public function showAssignForm($orderId)
    {
        $order = orders::findOrFail($orderId);
        $managers = managers::whereHas('employee', function($query) {
            $query->where('status', 'active');
        })->with('employee')->get();

        $managers = $managers->map(function($manager) use ($order) {
            $activeEmployeesCount = food_technologists::where('id_manager', $manager->id_manager)
                ->whereHas('employee', function ($query) {
                    $query->where('status', 'active');
                })
                ->count();

            $activeProductsCount = products::whereHas('order', function ($query) use ($manager) {
                $query->where('id_manager', $manager->id_manager)
                      ->where('status', '!=', 'completed');
            })->count();

            $newProductsCount = $order->products()->count();

            $efficiency = $activeEmployeesCount/($activeProductsCount + $newProductsCount);

            $manager->efficiency = $efficiency;
            return $manager;
        });

        // Sortuj menedżerów po efektywności malejąco
        $managers = $managers->sortByDesc('efficiency');

        return view('secretary_assign_order_to_manager', compact('order', 'managers'));
    }

    public function assign(Request $request, $orderId)
    {
        $request->validate([
            'manager_id' => 'required|exists:managers,id_manager',
        ]);

        $order = orders::findOrFail($orderId);
        $order->id_manager = $request->manager_id;
        $order->status = 'in progress';
        $order->save();

        return redirect()->route('secretary.orders.assignable')->with('success', 'Order assigned successfully');
    }

    public function getManagerDetails($managerId, $productCount)
    {
        $manager = managers::with('employee')
            ->where('id_manager', $managerId)
            ->first();

        if (!$manager) {
            return response()->json(['error' => 'Manager not found'], 404);
        }

        // Liczba zleceń w toku
        $ordersCount = orders::where('id_manager', $managerId)
            ->where('status', 'in progress')
            ->count();

        // Liczba produktów o stanie innym niż completed (liczba produktów w toku)
        $activeProductsCount = products::whereHas('order', function ($query) use ($managerId) {
            $query->where('id_manager', $managerId)
                  ->where('status', '!=', 'completed');
        })->count();

        // Liczba aktywnych pracowników (z tabeli food_technologists)
        $activeEmployeesCount = food_technologists::where('id_manager', $managerId)
            ->whereHas('employee', function ($query) {
                $query->where('status', 'active');
            })
            ->count();

        // Obliczam efektywność na podstawie średniej ilości produktów na pracownika
        $efficiency = $activeEmployeesCount/($activeProductsCount + $productCount);

        return response()->json([
            'ordersCount' => $ordersCount,
            'productsCount' => $activeProductsCount,
            'activeEmployeesCount' => $activeEmployeesCount,
            'efficiency' => $efficiency,
        ]);
    }
}
