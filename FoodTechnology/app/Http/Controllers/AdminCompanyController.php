<?php

namespace App\Http\Controllers;

use App\Models\companies;
use App\Models\Company;
use App\Models\food_technologists;
use App\Models\managers;
use App\Models\orders;
use App\Models\products;
use App\Models\secretaries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminCompanyController extends Controller
{
    // public function index()
    // {
    //     $companies = companies::with(['orders.products.product_ingredients', 'orders.products.product_microorganisms', 'orders.products.test_result.resultImages'])->paginate(2);
    //     $managers = managers::with('employee')->get();
    //     $secretaries = secretaries::with('employee')->get();
    //     $foodtechnologists = food_technologists::with('employee')->get();

    //     return view('administrator_company_manage', compact('companies', 'managers', 'secretaries', 'foodtechnologists'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = companies::with(['orders.products.product_ingredients', 'orders.products.foodtechnologist', 'orders.products.product_microorganisms', 'orders.products.test_result.resultImages', 'orders.products.foodTechnologist.employee', 'orders.secretary.employee', 'orders.manager.employee']);

        if ($search) {
            $companies = $query->where('name', 'LIKE', '%' . $search . '%')
                               ->orWhereHas('orders', function($query) use ($search) {
                                    $query->where('name', 'LIKE', '%' . $search . '%');
                               })
                               ->paginate(10);
        } else {
            $companies = $query->paginate(2);
        }


        $managers = managers::with('employee')->get();
        $secretaries = secretaries::with('employee')->get();
        $foodtechnologists = food_technologists::with('employee')->get();

        return view('administrator_company_manage', compact('companies', 'managers', 'secretaries', 'foodtechnologists', 'search'));
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
        return redirect()->route('admin.company.index')->with('success', 'Company created successfully');
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
        return redirect()->route('admin.company.index')->with('success', 'Company updated successfully');
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
        'id_manager' => 'nullable|integer|exists:managers,id_manager',
        'id_secretary' => 'nullable|integer|exists:secretaries,id_secretary',
    ]);


    orders::create($request->all());

    return redirect()->route('admin.company.index')->with('success', 'Order created successfully');
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
        'id_manager' => 'nullable|integer|exists:managers,id_manager',
        'id_secretary' => 'nullable|integer|exists:secretaries,id_secretary',
    ]);

    $order = orders::findOrFail($id);
    $order->update($request->all());

    return redirect()->route('admin.company.index')->with('success', 'Order updated successfully');
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
            'id_food_technologist' => 'nullable|integer|exists:food_technologists,id_food_technologist',
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
                'id_food_technologist' => $request->id_food_technologist,
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
            'id_food_technologist' => 'nullable|integer|exists:food_technologists,id_food_technologist',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = products::findOrFail($id);
        $product->update([
            'name' => $request->name,
            'status' => $request->status,
            'id_food_technologist' => $request->id_food_technologist,
        ]);

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('product_images'), $imageName);
            $imagePath = 'product_images/' . $imageName;

            // Usuwanie poprzedniego obrazu, jeśli istnieje
            if ($product->product_image) {
                Storage::delete($product->product_image);
            }

            $product->update([
                'product_image' => $imagePath,
            ]);
        }

        return redirect()->route('admin.company.index')->with('success', 'Product updated successfully');
    }

    public function destroyProduct($id)
    {
        $product = products::findOrFail($id);

        // Usuwanie obrazu
        if ($product->product_image) {
            Storage::delete($product->product_image);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }

}
