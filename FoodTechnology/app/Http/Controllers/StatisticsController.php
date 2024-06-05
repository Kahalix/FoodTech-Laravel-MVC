<?php


namespace App\Http\Controllers;

use App\Models\companies;
use App\Models\Company;
use App\Models\Order;
use App\Models\orders;
use App\Models\test_results;
use App\Models\TestResult;
use Illuminate\Http\Request;

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
                $images = $testResult->resultImages->map(function ($image) {
                    return asset('storage/' . $image->image_path);
                })->toArray();

                return [
                    'test_results' => $testResult->test_results,
                    'decision' => $testResult->decision,
                    'images' => $images,
                ];
            });

        $completedOrdersPerMonth = orders::where('status', 'completed')
            ->get()
            ->groupBy(function($date) {
                return \Carbon\Carbon::parse($date->date)->format('m'); // grouping by months
            })
            ->map(function ($row) {
                return count($row);
            });

        return response()->json([
            'companyCount' => $companyCount,
            'completedOrdersCount' => $completedOrdersCount,
            'randomTestResults' => $randomTestResults,
            'completedOrdersPerMonth' => $completedOrdersPerMonth,
        ]);
    }
}
