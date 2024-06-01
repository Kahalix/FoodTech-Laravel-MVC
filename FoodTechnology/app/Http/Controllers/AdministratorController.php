<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\employees;
use App\Models\food_technologists;
use App\Models\Manager;
use App\Models\Secretary;
use App\Models\FoodTechnologist;
use App\Models\managers;
use App\Models\secretaries;

class AdministratorController extends Controller
{
    public function employees()
    {
        $employees = employees::all();
        return view('admin_employees', compact('employees'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'phone_number' => 'required|string|max:20',
            'login' => 'required|string|max:50',
            'password' => 'required|string|max:100',
            'position' => 'required|in:manager,secretary,food_technologist',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->only(['first_name', 'last_name', 'email', 'phone_number', 'login', 'position', 'status']);
        $data['employee_image'] = 'employee_images/default_image.jpg';
        $data['password'] = Hash::make($request->password);

        $employee = employees::create($data);

        // Assign the employee to the appropriate position table
        if ($request->position == 'manager') {
            managers::create(['id_employee' => $employee->id_employee]);
        } elseif ($request->position == 'secretary') {
            secretaries::create(['id_employee' => $employee->id_employee]);
        } elseif ($request->position == 'food_technologist') {
            food_technologists::create(['id_employee' => $employee->id_employee]);
        }

        return redirect()->route('admin.employees')->with('success', 'Employee added successfully!');
    }

 public function show(employees $employee)
{
    // Sprawdzamy, czy pozycja pracownika to food_technologist
    if ($employee->position === 'food_technologist') {
        // Jeśli tak, pobieramy managerów
        $managers = managers::all();
    } else {
        $managers = collect(); // Tworzymy pustą kolekcję
    }

    return view('admin_user_view', compact('employee', 'managers'));
}


    public function edit(employees $employee)
    {
        return view('admin_user_edit', compact('employee')); // Edycja danych użytkownika
    }

    public function update(Request $request, employees $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:100',
            'phone_number' => 'required|string|max:20',
            'login' => 'required|string|max:50',
            'password' => 'nullable|string|max:100',
        ]);

        $data = $request->only(['first_name', 'last_name', 'email', 'phone_number', 'login']);

        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        $employee->update($data);

        return redirect()->route('admin.employees')->with('success', 'Employee updated successfully!');
    }

    public function assignPosition(Request $request, employees $employee)
    {
        $request->validate([
            'position' => 'required|in:manager,secretary,food_technologist',
        ]);

        $position = $request->position;

        // Usuwamy wszystkie związane rekordy z innych tabel
        managers::where('id_employee', $employee->id_employee)->delete();
        secretaries::where('id_employee', $employee->id_employee)->delete();
        food_technologists::where('id_employee', $employee->id_employee)->delete();

        // Aktualizujemy pozycję pracownika
        $employee->position = $position;
        $employee->save();

        // Przypisujemy pracownika do wybranej pozycji
        if ($position == 'manager') {
            managers::create(['id_employee' => $employee->id_employee]);
        } elseif ($position == 'secretary') {
            secretaries::create(['id_employee' => $employee->id_employee]);
        } elseif ($position == 'food_technologist') {
            food_technologists::create(['id_employee' => $employee->id_employee]);
        }

        return redirect()->route('admin.employees')->with('success', 'Employee position assigned successfully!');
    }

    public function assignManager(Request $request, employees $employee)
    {
        $request->validate([
            'manager_id' => 'required|exists:managers,id_manager',
        ]);

        $managerId = $request->input('manager_id');

        $manager = managers::findOrFail($managerId);

        $foodTechnologist = food_technologists::updateOrCreate(
            ['id_employee' => $employee->id_employee],
            ['id_manager' => $manager->id_manager]
        );

        return redirect()->route('admin.employees')->with('success', 'Manager assigned successfully!');
    }

       public function changeStatus(Request $request, employees $employee)
{
    $request->validate([
        'status' => 'required|in:active,inactive,on_leave',
    ]);

    $employee->status = $request->status;
    $employee->save();

    return redirect()->route('admin.employees')->with('success', 'Employee status changed successfully!');
}
public function destroy(employees $employee)
{
    $employee->delete();

    return redirect()->route('admin.employees')->with('success', 'Employee deleted successfully!');
}
}
