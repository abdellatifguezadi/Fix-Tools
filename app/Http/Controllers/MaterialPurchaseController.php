<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialPurchaseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $materials = Material::where('is_available', true)->paginate(9);
        $categories = Category::where('type', 'material')->get();

        return view('professionals.marketplace', compact('materials', 'categories', 'user'));
    }
} 