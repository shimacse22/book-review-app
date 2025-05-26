<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfileController extends Controller
{
    //
    public function profile(){
        return view('admin.dashboard');
    }
    public function update(Request $request){

         $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('profiles', 'public');
        $user->image = $imagePath;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
    }

   
}
