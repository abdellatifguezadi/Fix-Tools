<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ServiceRequest;
use App\Models\LoyaltyPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Show the form for creating a new review.
     *
     * @param  int  $serviceRequestId
     * @return \Illuminate\Http\Response
     */
    public function create($serviceRequestId)
    {
        $serviceRequest = ServiceRequest::with(['service', 'professional'])->findOrFail($serviceRequestId);
        
        // Check if the service request belongs to the current user
        if ($serviceRequest->client_id !== Auth::id()) {
            return redirect()->route('client.my-requests')->with('error', 'You are not authorized to review this service.');
        }
        
        // Check if the request is completed
        if ($serviceRequest->status !== 'completed') {
            return redirect()->route('client.my-requests')->with('error', 'You can only review completed services.');
        }
        
        // Check if a review already exists
        if ($serviceRequest->review) {
            return redirect()->route('client.my-requests')->with('error', 'You have already reviewed this service.');
        }
        
        // Use a view in the root reviews directory, not in a client subdirectory
        return view('reviews.create', compact('serviceRequest'));
    }
    
    /**
     * Store a newly created review in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'service_request_id' => 'required|exists:service_requests,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:500',
        ]);
        
        $serviceRequest = ServiceRequest::findOrFail($request->service_request_id);
        
        // Check if the service request belongs to the current user
        if ($serviceRequest->client_id !== Auth::id()) {
            return redirect()->route('client.my-requests')->with('error', 'You are not authorized to review this service.');
        }
        
        // Check if the request is completed
        if ($serviceRequest->status !== 'completed') {
            return redirect()->route('client.my-requests')->with('error', 'You can only review completed services.');
        }
        
        // Check if a review already exists
        if ($serviceRequest->review) {
            return redirect()->route('client.my-requests')->with('error', 'You have already reviewed this service.');
        }
        
        $review = new Review([
            'client_id' => Auth::id(),
            'professional_id' => $serviceRequest->professional_id,
            'service_request_id' => $serviceRequest->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true, // Auto approve for now, you can change this to require admin approval later
        ]);
        
        $review->save();
        
        // Attribuer des points de fidélité au professionnel en fonction des étoiles
        $reviewPoints = $request->rating;
        $description = "Avis {$reviewPoints} étoiles pour le service: {$serviceRequest->service->name}";
        
        // Créer un nouvel enregistrement de points de fidélité
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
