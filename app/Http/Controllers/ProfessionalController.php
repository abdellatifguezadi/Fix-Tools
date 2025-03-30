<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfessionalController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('professionals.index', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('professionals.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('professionals.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|max:2048',
            'specialty' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->specialty = $request->specialty;
        $user->experience = $request->experience;
        $user->is_available = $request->boolean('is_available');

        // Gestion du mot de passe
        if ($request->filled('current_password') && $request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
            }
            $user->password = Hash::make($request->password);
        }

        // Gestion de la photo de profil
        if ($request->hasFile('profile_photo')) {
            if ($user->image) {
                Storage::delete($user->image);
            }
            
            $image = $request->file('profile_photo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('profile', $imageName);
            $user->image = 'profile/' . $imageName;
        }

        $user->save();

        return back()->with('success', 'Votre profil a été mis à jour avec succès.');
    }
} 