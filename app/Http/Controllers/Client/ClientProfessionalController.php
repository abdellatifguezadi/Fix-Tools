<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Review;
use App\Models\Category;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientProfessionalController extends Controller
{

    public function index(Request $request)
    {
        $query = User::where('role', 'professional')
            ->withCount(['providedServices as completed_services_count' => function($query) {
                $query->completed();
            }])
            ->withAvg('receivedReviews as average_rating', 'rating');
        

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('specialty', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('service')) {
            $service = $request->input('service');
            $query->whereHas('services.category', function($q) use ($service) {
                $q->where('name', $service);
            });
        }
        
        if ($request->filled('experience')) {
            $experience = $request->input('experience');
            switch ($experience) {
                case '1-5':
                    $query->whereBetween('experience', [1, 5]);
                    break;
                case '5-10':
                    $query->whereBetween('experience', [5, 10]);
                    break;
                case '10-15':
                    $query->whereBetween('experience', [10, 15]);
                    break;
                case '15+':
                    $query->where('experience', '>=', 15);
                    break;
            }
        }
        
        $professionals = $query->paginate(9);
        
        $professionals->getCollection()->transform(function ($professional) {
            $professional->skills = Service::where('professional_id', $professional->id)
                ->with('category')
                ->get()
                ->pluck('category.name')
                ->unique()
                ->values()
                ->all();
            return $professional;
        });
        
        $serviceCategories = Category::pluck('name')->toArray();
        
        return view('client.professionals.index', compact('professionals', 'serviceCategories'));
    }
    

    public function show($id)
    {
        $professional = User::where('role', 'professional')
            ->withCount(['providedServices as completed_services_count' => function($query) {
                $query->completed();
            }])
            ->withAvg('receivedReviews as average_rating', 'rating')
            ->findOrFail($id);
        
        $professional->skills = Service::where('professional_id', $professional->id)
            ->with('category')
            ->get()
            ->pluck('category.name')
            ->unique()
            ->values()
            ->all();
        
        $services = Service::where('professional_id', $professional->id)
            ->where('is_available', true)
            ->get();
        
        $reviews = Review::whereHas('serviceRequest', function($query) use ($professional) {
                $query->where('professional_id', $professional->id);
            })
            ->with(['client', 'serviceRequest.service'])
            ->latest()
            ->get();
        
        return view('client.professionals.show', compact('professional', 'services', 'reviews'));
    }
} 