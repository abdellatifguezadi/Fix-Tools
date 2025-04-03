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
            });

        $categories = Category::where('type', 'service')->get();

        return view('client.services.index', compact('services', 'categories'));
    }

    } 