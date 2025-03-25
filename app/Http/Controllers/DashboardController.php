<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        switch ($user->role) {
            case 'admin':
                return view('admin.dashboard');
            case 'professional':
                return view('professionals.index');
            case 'client':
                return view('welcome');
            default:
                return redirect()->route('login')->with('error', 'Rôle non reconnu');
        }
    }
} 