<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ServiceRequest;
use App\Models\LoyaltyPoint;

class ServiceTrackingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $completedServices = ServiceRequest::where('professional_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'completed')
            ->with(['latestReview' => function($query) {
                $query->with('client');
            }])
            ->get();

        $completedServicesCount = $completedServices->count();

        $totalPoints = LoyaltyPoint::where('professional_id', $user->id)
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