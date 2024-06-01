<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\employees;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class EmployeeRegistrationController extends Controller
{
    public function generateTemporaryLink()
    {
        // Create a signed URL with a 24-hour expiration time
        $temporaryLink = URL::temporarySignedRoute(
            'employee.registration.form', // Named route for the registration form
            Carbon::now()->addHours(24),
            ['token' => Str::random(40)]  // Random token for additional security
        );

        return response()->json([
            'success' => true,
            'link' => $temporaryLink
        ]);
    }

    public function showRegistrationForm(Request $request)
    {
        // Ensure the token is valid and has not expired
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        return view('employee.registration');
    }


    public function register(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'phone_number' => 'required|unique:employees,phone_number',
            'login' => 'required|unique:employees,login',
            'password' => 'required',
            'employee_image' => 'image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);


        // Handle image upload
        if ($request->hasFile('employee_image')) {
            $image = $request->file('employee_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('employee_images'), $imageName);
            $imagePath = 'employee_images/' . $imageName;
        } else {
            $imagePath = 'employee_images/' . 'default_image.jpg'; // Default image path
        }

        // Create new employee
        $employee = new employees();
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->position = $request->position;
        $employee->email = $request->email;
        $employee->phone_number = $request->phone_number;
        $employee->login = $request->login;
        $employee->password = bcrypt($request->password);
        $employee->status = 'inactive';
        $employee->position = 'unassigned';
        $employee->employee_image = $imagePath;
        $employee->created_at = now();
        $employee->updated_at = now();
        $employee->save();

        return redirect()->route('home');
    }
}
