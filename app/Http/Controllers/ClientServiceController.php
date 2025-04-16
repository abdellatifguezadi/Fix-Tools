<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ClientServiceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'client']);
    // }

    public function index()
    {
        try {
            $services = Service::with(['category', 'professional'])
                ->latest()
                ->get()
                ->map(function ($service) {
                    try {
                        return $this->formatService($service);
                    } catch (\Exception $e) {
                        \Log::error('Error formatting service', [
                            'service_id' => $service->id, 
                            'error' => $e->getMessage()
                        ]);
                        return null;
                    }
                })->filter();

            $categories = Category::where('type', 'service')->get();
            
            // Count pending service requests for the current user
            $pendingRequestsCount = 0;
            if (Auth::check()) {
                $pendingRequestsCount = ServiceRequest::where('client_id', Auth::id())
                    ->whereIn('status', ['pending', 'priced'])
                    ->count();
            }

            return view('client.services.index', compact('services', 'categories', 'pendingRequestsCount'));
        } catch (\Exception $e) {
            \Log::error('Error in index method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()->with('error', 'An error occurred while loading services: ' . $e->getMessage());
        }
    }

    public function search(Request $request)
    {
        try {
            $query = Service::with(['category', 'professional']);

            // Recherche par texte
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

            // Filtre par catégorie
            if ($request->has('category') && !empty($request->category)) {
                $query->where('category_id', $request->category);
            }

            // Filtre par prix
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

            // Récupérer les services et les formater
            $services = $query->latest()->get()->map(function ($service) {
                // Vérifier si l'utilisateur est authentifié et a déjà réservé ce service
                $alreadyBooked = false;
                if (Auth::check()) {
                    $alreadyBooked = ServiceRequest::where('client_id', Auth::id())
                        ->where('service_id', $service->id)
                        ->whereIn('status', ['pending', 'priced', 'accepted'])
                        ->exists();
                }

                // Formater les données du service
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
                        'rating' => $service->professional && $service->professional->receivedReviews()->count() > 0 
                            ? $service->professional->receivedReviews()->avg('rating') 
                            : 0,
                        'reviews_count' => $service->professional 
                            ? $service->professional->receivedReviews()->count() 
                            : 0
                    ],
                ];
            })->filter()->values();

            // Retourner les résultats
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json($services);
            }
            
            // Si ce n'est pas une requête AJAX, afficher la vue avec les résultats
            $categories = Category::where('type', 'service')->get();
            $pendingRequestsCount = 0;
            if (Auth::check()) {
                $pendingRequestsCount = ServiceRequest::where('client_id', Auth::id())
                    ->whereIn('status', ['pending', 'priced'])
                    ->count();
            }
            
            return view('client.services.index', compact('services', 'categories', 'pendingRequestsCount'));
            
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Une erreur est survenue lors de la recherche des services',
                    'details' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la recherche des services: ' . $e->getMessage());
        }
    }

    private function formatService($service)
    {
        // Check if the current user has already booked this service
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
    
    /**
     * Display services filtered by category
     */
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
            
        $categories = Category::where('type', 'service')->get();
        
        // Count pending service requests for the current user
        $pendingRequestsCount = 0;
        if (Auth::check()) {
            $pendingRequestsCount = ServiceRequest::where('client_id', Auth::id())
                ->whereIn('status', ['pending', 'priced'])
                ->count();
        }
        
        return view('client.services.index', compact('services', 'categories', 'pendingRequestsCount', 'category'));
    }
} 