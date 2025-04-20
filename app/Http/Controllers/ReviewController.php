<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ServiceRequest;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($serviceRequestId)
    {
        $serviceRequest = ServiceRequest::with(['service', 'professional'])->findOrFail($serviceRequestId);
        
        if ($serviceRequest->client_id !== Auth::id()) {
            return redirect()->route('client.my-requests')->with('error', 'You are not authorized to review this service.');
        }
        
        if ($serviceRequest->status !== 'completed') {
            return redirect()->route('client.my-requests')->with('error', 'You can only review completed services.');
        }
        
        if ($serviceRequest->review) {
            return redirect()->route('client.my-requests')->with('error', 'You have already reviewed this service.');
        }
        
        return view('reviews.create', compact('serviceRequest'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'service_request_id' => 'required|exists:service_requests,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
        ]);
        
        $serviceRequest = ServiceRequest::findOrFail($request->service_request_id);
        
        if ($serviceRequest->client_id !== Auth::id()) {
            return redirect()->route('client.my-requests')->with('error', 'You are not authorized to review this service.');
        }
        
        if ($serviceRequest->status !== 'completed') {
            return redirect()->route('client.my-requests')->with('error', 'You can only review completed services.');
        }
        
        if ($serviceRequest->review) {
            return redirect()->route('client.my-requests')->with('error', 'You have already reviewed this service.');
        }
        
        $review = new Review([
            'client_id' => Auth::id(),
            'professional_id' => $serviceRequest->professional_id,
            'service_request_id' => $serviceRequest->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true,
        ]);
        
        $review->save();
        
        $reviewPoints = $request->rating;
        $description = "Avis {$reviewPoints} étoiles pour le service: {$serviceRequest->service->name}";
        
        LoyaltyPoint::create([
            'professional_id' => $serviceRequest->professional_id,
            'service_request_id' => $serviceRequest->id,
            'points_earned' => $reviewPoints,
            'source' => 'review',
            'description' => $description
        ]);
        
        return redirect()->route('client.my-requests')->with('success', 'Thank you for your review! The professional earned ' . $reviewPoints . ' loyalty points.');
    }
}
