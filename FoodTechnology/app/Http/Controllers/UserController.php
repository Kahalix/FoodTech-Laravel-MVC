<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('users_dashboard', ['user' => $user]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user_edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:100',
            'phone_number' => 'required|string|max:20',
            'login' => 'required|string|max:50|unique:employees,login,' . $user->id_employee . ',id_employee',
            'password' => 'nullable|string|min:8|confirmed',
            'employee_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->login = $request->login;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('employee_image')) {
            $image = $request->file('employee_image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('employees_images'), $imageName);
            $user->employee_image = 'employees_images/' . $imageName;
        }

        $user->save();

        return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully!');
    }
}
