<?php

namespace App\Http\Controllers;

use App\Models\companies;
use App\Models\Company;
use App\Models\orders;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCompanyController extends Controller
{
    public function index()
    {
        $companies = companies::with(['orders.products.product_ingredients', 'orders.products.product_microorganisms', 'orders.products.test_result.resultImages'])->get();
        return view('administrator_company_manage', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        companies::create($request->all());
        return redirect()->route('admin.company.index');
    }

    public function edit($id)
    {
        $company = companies::findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:companies,id_company',
            'name' => 'required|string|max:255',
            'nip' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'postal_code' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $company = companies::findOrFail($request->id);
        $company->update($request->all());
        return redirect()->route('admin.company.index');
    }

    public function destroy($id)
    {
        $company = companies::findOrFail($id);
        $company->delete();

        return response()->json(['message' => 'Company deleted successfully']);
    }




  // Metoda do dodawania nowego zamówienia dla danej firmy
public function storeOrder(Request $request, $companyId)
{
    // Debug: Wyświetlenie danych z żądania
    // dd($request->all());

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string|max:50',
        'deadline' => 'required|date',
        'cost' => 'required|string|max:100',
        'id_company' => 'required|integer|exists:companies,id_company',
    ]);

    // $request->merge(['id_company' => $companyId]);

    orders::create($request->all());

    return redirect()->route('admin.company.index');
}
// Metoda do pobierania danych zamówienia do edycji
public function editOrder($id)
{
    $order = orders::findOrFail($id);
    return response()->json($order);
}

// Metoda do aktualizacji danych zamówienia
public function updateOrder(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'status' => 'required|string|max:50',
        'deadline' => 'required|date',
        'cost' => 'required|string|max:100',
    ]);

    $order = orders::findOrFail($id);
    $order->update($request->all());

    return redirect()->route('admin.company.index');
}

// Metoda do usuwania zamówienia
public function destroyOrder($id)
{
    $order = orders::findOrFail($id);
    $order->delete();

    return response()->json(['message' => 'Order deleted successfully']);
}



public function storeProduct(Request $request, $orderId)
{
     // Debug: Wyświetlenie danych z żądania
    // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_order' => 'required|integer|exists:orders,id_order',
        ]);

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('product_images'), $imageName);
            $imagePath = 'product_images/' . $imageName;

            products::create([
                'id_order' => $request->id_order,
                'name' => $request->name,
                'status' => $request->status,
                'product_image' => $imagePath,
            ]);

            return redirect()->route('admin.company.index')->with('success', 'Product added successfully');
        } else {
            return back()->withErrors(['product_image' => 'File upload failed']);
        }
    }
public function editProduct($id)
{
    $product = products::findOrFail($id);
    return response()->json($product);
}

public function updateProduct(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'status' => 'required|string|max:50',
    ]);

    $product = products::findOrFail($id);
    $product->update([
        'name' => $request->name,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.company.index');
}

public function destroyProduct($id)
{
    $product = products::findOrFail($id);

    Storage::delete($product->product_image);

    $product->delete();

    return response()->json(['message' => 'Product deleted successfully']);
}

}
