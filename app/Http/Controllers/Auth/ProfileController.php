<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();
        
        return view('profile.index', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        
        return redirect()->route('profile.index')->with('success', 'Profile updated!');
    }

    /**
     * Display the change password form.
     */
    public function changePassword()
    {
        return view('profile.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('profile.index')->with('success', 'Password changed!');
    }
}