<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'professional_id' => 'required|exists:users,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'boolean'
        ]);

        $validated['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/services', $imageName);
            $validated['image_path'] = 'services/' . $imageName;
        }

        Service::create($validated);
        return redirect()->route('services.index')->with('success', 'Service ajouté avec succès');
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
            'professional_id' => 'required|exists:users,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'boolean'
        ]);

        $validated['is_available'] = $request->has('is_available');

        if ($request->hasFile('image')) {

            if ($service->image_path) {
                Storage::delete('public/' . $service->image_path);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/services', $imageName);
            $validated['image_path'] = 'services/' . $imageName;
        }

        $service->update($validated);
        return redirect()->route('services.index')->with('success', 'Service mis à jour avec succès');
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
        return redirect()->route('services.index')->with('success', 'Service supprimé avec succès');
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
        $services = Service::with(['category'])
            ->where('professional_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('services.my-services', compact('services'));
    }
} 