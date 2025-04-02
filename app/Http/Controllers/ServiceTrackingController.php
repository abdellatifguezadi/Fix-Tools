<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ServiceTrackingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Récupérer les services complétés ce mois
        $completedServices = $user->providedServices()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'completed')
            ->with(['latestReview' => function($query) {
                $query->with('client');
            }])
            ->get();

        // Compter les services complétés
        $completedServicesCount = $completedServices->count();

        // Calculer les points totaux (utiliser points_earned au lieu de points)
        $totalPoints = $user->loyaltyPoints()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('points_earned');

        return view('professionals.service-tracking', compact(
            'completedServices',
            'completedServicesCount',
            'totalPoints'
        ));
    }
} 