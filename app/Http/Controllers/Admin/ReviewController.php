<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use App\Models\Service;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['client', 'professional', 'serviceRequest.service'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.reviews.index', compact('reviews'));
    }
    
    public function delete($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'L\'avis a été supprimé avec succès.');
    }
} 