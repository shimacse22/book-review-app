<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BackendAuthController extends Controller
{
    //

    public function dashboard(){
        return view('admin.dashboard');
    }

    public function showLoginForm(){
        return view('admin.auth.login');
    }

    public function showRegisterForm(){
        return view('admin.auth.register');
    }

    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

    // Create user
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // Redirect to login after registration
    return redirect()->route('admin.login')->with('success', 'Registration successful! Please login.');
}

public function login(Request $request)
{
    // Validate inputs
    $validator = Validator::make($request->all(), [
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    // Redirect back with errors if validation fails
    if ($validator->fails()) {
        return redirect()->back()
                         ->withErrors($validator)
                         ->withInput();
    }

    // Attempt to log the user in
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        // Authentication passed
        return redirect()->route('admin.dashboard');
    }

    // Authentication failed
    return redirect()->back()
                     ->withErrors(['email' => 'Invalid email or password.'])
                     ->withInput();
}


public function changePassword(){
    return view('admin.change-password');    
}

public function updateChangePassword(Request $request){
     // Validate input
     $request->validate([
        'current_password' => ['required'],
        'new_password' => ['required', 'string', 'min:8'],
        'new_password_confirmation' => ['required', 'same:new_password'],
    ]);

    $user = Auth::user(); // use guard('web') here

    // Check if old password matches
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Old password does not match our records.'])->withInput();
    }

    // Update the password
    $user->password = Hash::make($request->new_password);

    $user->save();

    return back()->with('success', 'Password changed successfully.');
}

public function logout(Request $request){
     // Log the admin out
     Auth::logout();

     // Invalidate the session
     $request->session()->invalidate();

       // Redirect to the login page or wherever you want after logout
    return redirect('/admin/login')->with('success', 'Admin successfully logged out');
}

}
