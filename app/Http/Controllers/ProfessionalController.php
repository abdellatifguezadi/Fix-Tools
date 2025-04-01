<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Service;
use App\Models\MaterialPurchase;
use App\Models\Material;

class ProfessionalController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();

            $servicesCount = Service::where('professional_id', $user->id)->count();
            $materialPurchasesCount = MaterialPurchase::where('professional_id', $user->id)->count();
            $totalPurchasesAmount = MaterialPurchase::where('professional_id', $user->id)
                ->get()
                ->sum(function($purchase) {
                    return $purchase->quantity * $purchase->price_paid;
                });

            $recentServices = Service::where('professional_id', $user->id)
                ->latest()
                ->take(5)
                ->get();

            $recentPurchases = MaterialPurchase::where('professional_id', $user->id)
                ->with('material')
                ->latest()
                ->take(5)
                ->get();

            return view('professionals.index', compact(
                'user',
                'servicesCount',
                'materialPurchasesCount',
                'totalPurchasesAmount',
                'recentServices',
                'recentPurchases'
            ));
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors du chargement du tableau de bord.');
        }
    }

} 