<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ServiceController;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Service;
use App\Models\ServiceRequest;
use Carbon\Carbon;

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
                return $this->adminDashboard();
            case 'professional':
                return view('professionals.index', compact('user'));
            case 'client':
                return view('welcome');
            default:
                return view('welcome')->with('error', 'Rôle non reconnu');
        }
    }
    
    public function adminDashboard()
    {
        $totalUsers = User::count();
        $activeProfessionals = User::where('role', 'professional')->where('is_available', true)->count();
        $completedServices = ServiceRequest::where('status', 'completed')->count();
        $totalRevenue = ServiceRequest::where('status', 'completed')->sum('final_price');
        
        
        $servicesOverview = Category::where('type', 'service')
            ->withCount(['services as total_services'])
            ->withCount(['services as active_services' => function($query) {
                $query->where('is_available', true);
            }])
            ->orderByDesc('total_services')
            ->take(3)
            ->get()
            ->map(function($category) {
                $activePercentage = $category->total_services > 0 
                    ? round(($category->active_services / $category->total_services) * 100) 
                    : 0;

                return [
                    'name' => $category->name,
                    'total' => $category->total_services,
                    'active' => $activePercentage
                ];
            });
        
        
        $monthlyRevenue = [];
        $previousMonthRevenue = 0;
        
        for ($i = 2; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthName = $month->format('M Y');
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();
            
            $currentMonthRevenue = ServiceRequest::where('status', 'completed')
                                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                                ->sum('final_price');
            
            $growth = 0;
            if ($previousMonthRevenue > 0) {
                $growth = round((($currentMonthRevenue - $previousMonthRevenue) / $previousMonthRevenue) * 100, 1);
            } elseif ($currentMonthRevenue > 0 && $i < 2) {
                $growth = 100; 
            }
            
            $monthlyRevenue[$monthName] = [
                'revenue' => $currentMonthRevenue,
                'growth' => $growth
            ];
            
            $previousMonthRevenue = $currentMonthRevenue;
        }
        
        // Recent services (limité à 3)
        $recentServices = ServiceRequest::with(['service.category', 'client'])
                        ->latest()
                        ->take(3)
                        ->get()
                        ->map(function($request) {
                            return [
                                'name' => $request->service->name ?? 'Unknown Service',
                                'client' => $request->client->name ?? 'Unknown Client',
                                'status' => $request->status
                            ];
                        });
        
        
        $newUsers = User::where('role', '!=', 'admin')
                   ->latest()
                   ->take(3)
                   ->get()
                   ->map(function($user) {
                       return [
                           'name' => $user->name,
                           'role' => $user->role,
                           'created_at' => $user->created_at->diffForHumans()
                       ];
                   });
        
        return view('admin.dashboard', compact(
            'totalUsers', 
            'activeProfessionals', 
            'completedServices',
            'totalRevenue',
            'servicesOverview',
            'monthlyRevenue',
            'recentServices',
            'newUsers'
        ));
    }
} 