<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Models\ingredients;

class AdminIngredientsController extends Controller
{
    public function index()
    {
        $ingredients = ingredients::all();
        return view('administrator_ingredients_manage', compact('ingredients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'safe_amount' => 'nullable|numeric',
            'unit' => 'nullable|string|max:100',
            'safety' => 'nullable|string|max:100',
        ]);

        ingredients::create([
            'name' => $request->name,
            'safe_amount' => $request->safe_amount,
            'unit' => $request->unit,
            'safety' => $request->safety,
            'added_by' => auth()->user()->position,
        ]);

        return redirect()->route('admin.ingredients')->with('success', 'Ingredient added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'safe_amount' => 'nullable|numeric',
            'unit' => 'nullable|string|max:100',
            'safety' => 'nullable|string|max:100',
        ]);

        $ingredient = ingredients::findOrFail($id);
        $ingredient->update([
            'name' => $request->name,
            'safe_amount' => $request->safe_amount,
            'unit' => $request->unit,
            'safety' => $request->safety,
        ]);

        return redirect()->route('admin.ingredients')->with('success', 'Ingredient updated successfully');
    }

    public function destroy($id)
    {
        $ingredient = ingredients::findOrFail($id);
        $ingredient->delete();

        return redirect()->route('admin.ingredients')->with('success', 'Ingredient deleted successfully');
    }
}
