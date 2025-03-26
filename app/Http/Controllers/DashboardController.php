<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ServiceController;
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
                $serviceController = new ServiceController();
                return $serviceController->myServices();
            case 'client':
                return view('welcome');
            default:
                return redirect()->route('login')->with('error', 'Rôle non reconnu');
        }
    }
} 