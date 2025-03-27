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
    
    public function adminDashboard()
    {
        // User statistics
        $totalUsers = User::count();
        
        // Professionals statistics
        $activeProfessionals = User::where('role', 'professional')->where('is_available', true)->count();
        
        // Services statistics
        $completedServices = ServiceRequest::where('status', 'completed')->count();
        
        // Revenue statistics
        $totalRevenue = ServiceRequest::where('status', 'completed')->sum('final_price');
        
        // Services overview by category (limité à 3)
        $servicesOverview = Category::withCount(['services as total'])
                          ->withCount(['services as active_count' => function($query) {
                              $query->where('is_available', true);
                          }])
                          ->take(3)
                          ->get()
                          ->map(function($category) {
                              return [
                                  'name' => $category->name,
                                  'total' => $category->total,
                                  'active' => $category->total > 0 ? round(($category->active_count / $category->total) * 100) : 0
                              ];
                          });
        
        // Monthly revenue with growth calculation (limité à 3 mois)
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
                $growth = 100; // First month with revenue shows 100% growth
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
        
        // New users (limité à 3, sans les admins)
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