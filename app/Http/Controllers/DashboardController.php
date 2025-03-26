<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        switch ($user->role) {
            case 'admin':
                return view('admin.dashboard');
            case 'professional':
                $serviceController = new ServiceController();
                return $serviceController->myServices();
            case 'client':
                return view('welcome');
            default:
                return redirect()->route('login')->with('error', 'Rôle non reconnu');
        }

        // if (Auth::user()->role === 'professional') {
        //     $serviceController = new ServiceController();
        //     return $serviceController->myServices();
        // }
        

        // $categories = Category::all();
        // return view('dashboard', compact('categories'));
    }
} 