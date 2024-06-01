<?php

namespace App\Http\Controllers;

use App\Models\companies;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Order;
use App\Models\orders;
use App\Models\Product;
use App\Models\test_results;
use App\Models\TestResult;

class StatisticsController extends Controller
{
    public function getStatistics()
    {
        $companyCount = companies::count();
        $completedOrdersCount = orders::where('status', 'completed')->count();
        $randomTestResults = test_results::with('resultImages')
            ->inRandomOrder()
            ->limit(9)
            ->get()
            ->map(function ($testResult) {
                return [
                    'test_results' => $testResult->test_results,
                    'decision' => $testResult->decision,
                    'image_path' => $testResult->resultImages->isNotEmpty() ? asset('storage/' . $testResult->resultImages->first()->image_path) : null,
                ];
            });

        return response()->json([
            'companyCount' => $companyCount,
            'completedOrdersCount' => $completedOrdersCount,
            'randomTestResults' => $randomTestResults,
        ]);
    }
}
