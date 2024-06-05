<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\products;
use PDF;
use ZipArchive;

class SecretaryFinishedOrdersController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Orders::where('status', 'completed')->with('products');

        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                      ->orWhereHas('company', function($query) use ($search) {
                          $query->where('name', 'LIKE', '%' . $search . '%');
                      });
            });
        }

        $orders = $query->paginate(2);

        return view('secretary_orders_finished', compact('orders', 'search'));
    }

    public function generateOrderReportPDF($orderId)
    {
        $order = Orders::with('products.product_ingredients', 'products.product_microorganisms', 'products.test_result.resultImages')->findOrFail($orderId);

        $pdf = PDF::loadView('orders_report', compact('order'));

        return $pdf->download('order_report_'.$orderId.'.pdf');
    }

    public function downloadProductImages($productId)
    {
        $product = products::findOrFail($productId);

        $images = $product->test_result->resultImages;

        // Create a zip file
        $zip = new \ZipArchive();
        $zipFileName = 'product_images_'.$product->name.'.zip';
        if ($zip->open($zipFileName, \ZipArchive::CREATE) === TRUE) {
            foreach ($images as $image) {
                $imagePath = storage_path('app/public/' . $image->image_path);
                if(file_exists($imagePath)) {
                    $zip->addFile($imagePath, basename($imagePath));
                }
            }
            $zip->close();
        }

        // Download the zip file
        return response()->download($zipFileName)->deleteFileAfterSend(true);
    }
}
