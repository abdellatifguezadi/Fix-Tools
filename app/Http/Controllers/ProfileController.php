<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return $this->getProfileView($user);
    }

    public function profile()
    {
        $user = Auth::user();
        return $this->getProfileView($user);
    }

    public function edit()
    {
        $user = Auth::user();
        return $this->getProfileView($user);
    }
    
    private function getProfileView($user)
    {
        switch ($user->role) {
            case 'admin':
                return view('admin.profile', compact('user'));
            case 'professional':
                return view('professionals.profile', compact('user'));
            case 'client':
                return view('clients.profile', compact('user'));
            default:
                return view('professionals.profile', compact('user'));
        }
    }

    public function update(Request $request)
    {
        try {
            $user = User::find(Auth::id());

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
            ]);

            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->specialty = $request->specialty;
            $user->experience = $request->experience;
            $user->is_available = $request->boolean('is_available');

            if ($request->filled('current_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return back()
                        ->withInput()
                        ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
                }

                if ($request->filled('password')) {
                    $request->validate([
                        'password' => 'required|string|min:8|confirmed'
                    ]);
                    $user->password = Hash::make($request->password);
                }
            }

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

            return redirect()->back()->with('success', 'Votre profil a été mis à jour avec succès.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => 'Une erreur est survenue lors de la mise à jour du profil : ' . $e->getMessage()]);
        }
    }
}
