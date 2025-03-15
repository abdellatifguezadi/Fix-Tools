<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:service,material',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255'
        ]);

        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès');
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:service,material',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255'
        ]);

        $category->update($validated);
        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès');
    }
} 