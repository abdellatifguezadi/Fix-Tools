<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('category')->latest()->paginate(10);
        return view('materials.index', compact('materials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'points_cost' => 'required|integer|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/materials', $imageName);
            $validated['image_path'] = 'materials/' . $imageName;
        }

        Material::create($validated);
        return redirect()->route('materials.index')->with('success', 'Matériel ajouté avec succès');
    }

    public function show(Material $material)
    {
        return view('materials.show', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'points_cost' => 'required|integer|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_available' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($material->image_path) {
                Storage::delete('public/' . $material->image_path);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/materials', $imageName);
            $validated['image_path'] = 'materials/' . $imageName;
        }

        $material->update($validated);
        return redirect()->route('materials.index')->with('success', 'Matériel mis à jour avec succès');
    }

    public function destroy(Material $material)
    {

        if ($material->image_path) {
            Storage::delete('public/' . $material->image_path);
        }

        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Matériel supprimé avec succès');
    }
} 