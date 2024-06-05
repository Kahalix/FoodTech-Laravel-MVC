<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Microorganism;
use App\Models\microorganisms;

class AdminMicroorganismsController extends Controller
{
    public function index(Request $request)
    {
        $query = microorganisms::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");

            $microorganisms = $query->paginate(10);

            return view('administrator_microorganisms_manage', compact('microorganisms', 'search'));
        }

        $microorganisms = $query->paginate(2);

        return view('administrator_microorganisms_manage', compact('microorganisms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|string|max:100',
            'safe_amount' => 'nullable|numeric',
            'unit' => 'nullable|string|max:100',
            'safety' => 'nullable|string|max:100',
        ]);

        microorganisms::create([
            'name' => $request->name,
            'type' => $request->type,
            'safe_amount' => $request->safe_amount,
            'unit' => $request->unit,
            'safety' => $request->safety,
            'added_by' => auth()->user()->position,
        ]);

        return redirect()->route('admin.microorganisms')->with('success', 'Microorganism added successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'type' => 'required|string|max:100',
            'safe_amount' => 'nullable|numeric',
            'unit' => 'nullable|string|max:100',
            'safety' => 'nullable|string|max:100',
        ]);

        $microorganism = microorganisms::findOrFail($id);
        $microorganism->update([
            'name' => $request->name,
            'type' => $request->type,
            'safe_amount' => $request->safe_amount,
            'unit' => $request->unit,
            'safety' => $request->safety,
        ]);

        return redirect()->route('admin.microorganisms')->with('success', 'Microorganism updated successfully');
    }

    public function destroy($id)
    {
        $microorganism = microorganisms::findOrFail($id);
        $microorganism->delete();

        return redirect()->route('admin.microorganisms')->with('success', 'Microorganism deleted successfully');
    }
}
