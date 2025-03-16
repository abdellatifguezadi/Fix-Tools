<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function index()
    {
        $professionals = User::where('role', 'professional')
            ->withCount('serviceRequests')
            ->withAvg('receivedReviews', 'rating')
            ->paginate(12);

        return view('professionals.index', compact('professionals'));
    }

    public function show(User $professional)
    {
        if ($professional->role !== 'professional') {
            abort(404);
        }

        $professional->load(['services', 'receivedReviews.client']);
        
        return view('professionals.show', compact('professional'));
    }
} 