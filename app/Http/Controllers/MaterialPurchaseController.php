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
        $materials = Material::where('is_available', true)->paginate(9);
        $categories = Category::where('type', 'material')->get();

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
            list($min, $max) = explode('-', $request->price_range);
            if ($max === '+') {
                $query->where('price', '>=', $min);
            } else {
                $query->whereBetween('price', [$min, $max]);
            }
        }

        if ($request->filled('points_range')) {
            list($min, $max) = explode('-', $request->points_range);
            if ($max === '+') {
                $query->where('points_cost', '>=', $min);
            } else {
                $query->whereBetween('points_cost', [$min, $max]);
            }
        }

        $materials = $query->where('is_available', true)->paginate(9);

        $userPoints = $user->loyalty_points;
        if($userPoints === null) {
            $userPoints = LoyaltyPoint::where('professional_id', $user->id)->sum('points_earned') - 
                        MaterialPurchase::where('professional_id', $user->id)->sum('points_used');
        }

        if ($request->ajax()) {
            return view('components.marketplace.materials-grid', compact('materials'))->render();
        }

        $categories = Category::where('type', 'material')->get();
        return view('professionals.marketplace', compact('materials', 'categories', 'user', 'userPoints'));
    }
    

    // public function cart()
    // {
    //     $user = Auth::user();
        
    //     $cart = Cart::where('professional_id', $user->id)
    //                ->where('is_active', true)
    //                ->with('items.material.category')
    //                ->first();
        
    //     if (!$cart) {
    //         $cart = Cart::create([
    //             'professional_id' => $user->id,
    //             'is_active' => true
    //         ]);
    //     }
        
    //     $userPoints = $user->loyalty_points;
    //     if($userPoints === null) {
    //         $userPoints = LoyaltyPoint::where('professional_id', $user->id)->sum('points_earned') - 
    //                      MaterialPurchase::where('professional_id', $user->id)->sum('points_used');
    //     }
        
    //     return redirect()->back()->with(compact('cart', 'userPoints'));
    // }
} 