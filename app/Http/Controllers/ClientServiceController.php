<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ClientServiceController extends Controller
{
    

    public function index(Request $request)
    {
        $query = Service::with(['category', 'professional']);
        
        if ($request->has('professional_id') && !empty($request->professional_id)) {
            $query->where('professional_id', $request->professional_id);
        }
        
        $services = $query->latest()
            ->get()
            ->map(function ($service) {
                return $this->formatService($service);
            })->filter();

        $categories = Category::serviceCategories()->get();
        
        $pendingRequestsCount = 0;
        if (Auth::check()) {
            $pendingRequestsCount = ServiceRequest::where('client_id', Auth::id())
                ->whereIn('status', ['pending', 'priced'])
                ->count();
        }

        $professionalName = null;
        if ($request->has('professional_id') && !empty($request->professional_id)) {
            $professional = User::find($request->professional_id);
            $professionalName = $professional ? $professional->name : null;
        }

        return view('client.services.index', compact('services', 'categories', 'pendingRequestsCount', 'professionalName'));
    }

    public function search(Request $request)
    {
        $query = Service::with(['category', 'professional']);

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('category') && !empty($request->category)) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('price_range') && !empty($request->price_range)) {
            switch ($request->price_range) {
                case '0-50':
                    $query->where('base_price', '<=', 50);
                    break;
                case '51-100':
                    $query->where('base_price', '>', 50)->where('base_price', '<=', 100);
                    break;
                case '101+':
                    $query->where('base_price', '>', 100);
                    break;
            }
        }
        
        if ($request->has('professional_id') && !empty($request->professional_id)) {
            $query->where('professional_id', $request->professional_id);
        }

        $services = $query->latest()->get()->map(function ($service) {
            return $this->formatService($service);
        })->filter()->values();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($services);
        }
        
        $categories = Category::serviceCategories()->get();
        $pendingRequestsCount = 0;
        if (Auth::check()) {
            $pendingRequestsCount = ServiceRequest::where('client_id', Auth::id())
                ->whereIn('status', ['pending', 'priced'])
                ->count();
        }
        
        $professionalName = null;
        if ($request->has('professional_id') && !empty($request->professional_id)) {
            $professional = User::find($request->professional_id);
            $professionalName = $professional ? $professional->name : null;
        }
        
        return view('client.services.index', compact('services', 'categories', 'pendingRequestsCount', 'professionalName'));
    }

    private function formatService($service)
    {
        if (!$service->professional_id) {
            return null;
        }
        
        $alreadyBooked = false;
        if (Auth::check()) {
            $alreadyBooked = ServiceRequest::where('client_id', Auth::id())
                ->where('service_id', $service->id)
                ->whereIn('status', ['pending', 'priced', 'accepted'])
                ->exists();
        }

        return [
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'base_price' => $service->base_price,
            'image_path' => $service->image_path 
                ? Storage::url($service->image_path)
                : 'https://via.placeholder.com/400x300?text=No+Image',
            'category' => $service->category ? $service->category->name : 'Uncategorized',
            'is_available' => $service->is_available,
            'already_booked' => $alreadyBooked,
            'professional' => [
                'id' => $service->professional ? $service->professional->id : null,
                'name' => $service->professional ? $service->professional->name : 'Unknown Professional',
                'image' => $service->professional && $service->professional->image 
                    ? Storage::url($service->professional->image)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($service->professional ? $service->professional->name : 'Unknown') . '&background=4F46E5&color=ffffff',
                'rating' => $service->professional ? ($service->professional->receivedReviews()->avg('rating') ?? 0) : 0,
                'reviews_count' => $service->professional ? $service->professional->receivedReviews()->count() : 0
            ],
        ];
    }

    public function show(Service $service)
    {
        $service->load(['category', 'professional']);
        $formattedService = $this->formatService($service);
        
        return view('client.services.show', compact('formattedService'));
    }
    
    public function byCategory(Category $category)
    {
        $services = Service::with(['category', 'professional'])
            ->where('category_id', $category->id)
            ->where('is_available', true)
            ->latest()
            ->get()
            ->map(function ($service) {
                return $this->formatService($service);
            });
            
        $categories = Category::serviceCategories()->get();
        
        $pendingRequestsCount = 0;
        if (Auth::check()) {
            $pendingRequestsCount = ServiceRequest::where('client_id', Auth::id())
                ->whereIn('status', ['pending', 'priced'])
                ->count();
        }
        
        return view('client.services.index', compact('services', 'categories', 'pendingRequestsCount', 'category'));
    }
} 