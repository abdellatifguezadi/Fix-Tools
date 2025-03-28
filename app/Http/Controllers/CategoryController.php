<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories', compact('categories'));
    }

    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:service,material'
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès');
    }

    public function update(Request $request , Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:service,material'
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Catégorie modifiée avec succès');
    }



    public function destroy (Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès');
    }
   
} 