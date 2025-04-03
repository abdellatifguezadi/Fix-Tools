<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function suspend(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot suspend admin users.');
        }

        $user->is_available = false;
        $user->save();

        return back()->with('success', 'User has been suspended successfully.');
    }

    public function activate(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot activate admin users.');
        }

        $user->is_available = true;
        $user->save();

        return back()->with('success', 'User has been activated successfully.');
    }
} 