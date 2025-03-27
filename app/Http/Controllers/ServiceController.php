<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['category', 'professional'])->latest()->paginate(10);
        return view('services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $validated['professional_id'] = Auth::id();
        $validated['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('services', $imageName);
            $validated['image_path'] = 'services/' . $imageName;
        }


            $service = Service::create($validated);
            return redirect()->route('dashboard')->with('success', 'Service ajouté avec succès');

    }

    public function show(Service $service)
    {
        $service->load(['category', 'professional', 'serviceRequests']);
        return view('services.show', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $validated['is_available'] = $request->has('is_available');
        
        $validated['professional_id'] = $service->professional_id;

        if ($request->hasFile('image')) {
            if ($service->image_path) {
                Storage::delete('public/' . $service->image_path);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('services', $imageName);
            $validated['image_path'] = 'services/' . $imageName;
        }

        $service->update($validated);
        return redirect()->route('services.my-services')->with('success', 'Service mis à jour avec succès');
    }

    public function destroy(Service $service)
    {

        if ($service->serviceRequests()->where('status', 'pending')->exists()) {
            return redirect()->route('services.index')
                ->with('error', 'Impossible de supprimer ce service car il a des demandes en cours');
        }

        if ($service->image_path) {
            Storage::delete('public/' . $service->image_path);
        }

        $service->delete();
        // return redirect()->route('services.index')->with('success', 'Service supprimé avec succès');
        return redirect()->route('dashboard')->with('success', 'Service supprimé avec succès');
        
    }

    public function byCategory(Category $category)
    {
        $services = Service::with(['category', 'professional'])
            ->where('category_id', $category->id)
            ->where('is_available', true)
            ->latest()
            ->paginate(10);

        return view('services.by-category', compact('services', 'category'));
    }

    public function myServices()
    {
        $categories = Category::all();

        if (!Auth::check() || Auth::user()->role !== 'professional') {
            return view('professionals.index', ['services' => [], 'categories' => $categories]);
        }

        $services = Service::with(['category'])
            ->where('professional_id', Auth::id())
            ->latest()
            ->get()
            ->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'category' => $service->category->name,
                    'category_id' => $service->category_id,
                    'description' => $service->description,
                    'base_price' => $service->base_price,
                    'image_path' => $service->image_path 
                        ? Storage::url($service->image_path)
                        : 'https://via.placeholder.com/400x300?text=No+Image',
                    'is_available' => $service->is_available
                ];
            });

        $service = Service::where('professional_id', Auth::id())->first();

        return view('professionals.index', compact('services', 'categories', 'service'));
    }
} 