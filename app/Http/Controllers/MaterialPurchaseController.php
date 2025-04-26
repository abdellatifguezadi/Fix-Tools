<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Category;
use App\Models\Cart;
use App\Models\LoyaltyPoint;
use App\Models\MaterialPurchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaterialPurchaseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $materials = Material::available()->paginate(9);
        $categories = Category::materialCategories()->get();

        $userPoints = $user->loyalty_points;
        if($userPoints === null) {
            $userPoints = LoyaltyPoint::where('professional_id', $user->id)->sum('points_earned') - 
                         MaterialPurchase::where('professional_id', $user->id)->sum('points_used');
        }

        if (request()->ajax()) {
            return view('components.marketplace.materials-grid', compact('materials'))->render();
        }

        return view('professionals.marketplace', compact('materials', 'categories', 'user', 'userPoints'));
    }

    public function filter(Request $request)
    {
        $user = Auth::user();
        $query = Material::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('price_range')) {
            if (strpos($request->price_range, '+') !== false) {
                $min = (int) str_replace('+', '', $request->price_range);
                $query->where('price', '>=', $min);
            } else {
                list($min, $max) = explode('-', $request->price_range);
                $query->whereBetween('price', [$min, $max]);
            }
        }

        if ($request->filled('points_range')) {
            if (strpos($request->points_range, '+') !== false) {
                $min = (int) str_replace('+', '', $request->points_range);
                $query->where('points_cost', '>=', $min);
            } else {
                list($min, $max) = explode('-', $request->points_range);
                $query->whereBetween('points_cost', [$min, $max]);
            }
        }

        $materials = $query->available()->paginate(9);

        $userPoints = $user->loyalty_points;
        if($userPoints === null) {
            $userPoints = LoyaltyPoint::where('professional_id', $user->id)->sum('points_earned') - 
                        MaterialPurchase::where('professional_id', $user->id)->sum('points_used');
        }

        if ($request->ajax()) {
            return view('components.marketplace.materials-grid', compact('materials'))->render();
        }

        $categories = Category::materialCategories()->get();
        return view('professionals.marketplace', compact('materials', 'categories', 'user', 'userPoints'));
    }
    


} 