<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientServiceController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'client']);
    // }

    public function index()
    {
        $services = Service::with(['category', 'professional'])
            ->latest()
            ->get()
            ->map(function ($service) {
                return $this->formatService($service);
            });

        $categories = Category::where('type', 'service')->get();

        return view('client.services.index', compact('services', 'categories'));
    }

    public function search(Request $request)
    {
        $query = Service::with(['category', 'professional']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('price_range') && $request->price_range != '') {
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

        $services = $query->latest()->get()->map(function ($service) {
            return $this->formatService($service);
        });

        return response()->json($services);
    }

    private function formatService($service)
    {
        return [
            'id' => $service->id,
            'name' => $service->name,
            'description' => $service->description,
            'base_price' => $service->base_price,
            'image_path' => $service->image_path 
                ? Storage::url($service->image_path)
                : 'https://via.placeholder.com/400x300?text=No+Image',
            'category' => $service->category->name,
            'is_available' => $service->is_available,
            'professional' => [
                'id' => $service->professional->id,
                'name' => $service->professional->name,
                'image' => $service->professional->image 
                    ? Storage::url($service->professional->image)
                    : 'https://via.placeholder.com/150x150?text=No+Image',
                'rating' => $service->professional->receivedReviews()->avg('rating') ?? 0,
                'reviews_count' => $service->professional->receivedReviews()->count()
            ],
        ];
    }

    public function show(Service $service)
    {
        $service->load(['category', 'professional']);
        $formattedService = $this->formatService($service);
        
        return view('client.services.show', compact('formattedService'));
    }
} 