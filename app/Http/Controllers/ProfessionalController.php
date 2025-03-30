<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfessionalController extends Controller
{
    public function index()
    {
        return view('professionals.index');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('professionals.index', compact('user'));
    }
} 