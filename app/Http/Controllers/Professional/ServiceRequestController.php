<?php

namespace App\Http\Controllers\Professional;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $requests = ServiceRequest::where('professional_id', Auth::id())
            ->with(['client', 'service'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('professional.requests.index', compact('requests'));
    }
    
    public function updatePrice(Request $request, ServiceRequest $serviceRequest)
    {
        // Check if the request belongs to this professional
        if ($serviceRequest->professional_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        
        // Validate the request
        $validated = $request->validate([
            'final_price' => 'required|numeric|min:0',
        ]);
        
        // Update the service request with the final price
        $serviceRequest->update([
            'final_price' => $validated['final_price'],
            'status' => 'priced', // Change status to indicate price has been set
        ]);
        
        return redirect()->back()->with('success', 'Price proposal submitted successfully.');
    }
    
    public function complete(ServiceRequest $serviceRequest)
    {
        // Check if the request belongs to this professional
        if ($serviceRequest->professional_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        
        // Check if the request is in the right status
        if ($serviceRequest->status !== 'accepted') {
            return redirect()->back()->with('error', 'Only accepted requests can be marked as completed.');
        }
        
        // Update the service request status
        $serviceRequest->update([
            'status' => 'completed',
            'completion_date' => now()
        ]);
        
        // Attribuer 5 points pour le service complété
        $points = 5;
        $description = "Service complété: {$serviceRequest->service->name}";
        
        // Ajouter des points supplémentaires si un avis existe déjà (rare, mais possible)
        if ($serviceRequest->review) {
            $reviewPoints = $serviceRequest->review->rating;
            $points += $reviewPoints;
            $description .= " + {$reviewPoints} points pour un avis {$serviceRequest->review->rating} étoiles";
        }
        
        // Enregistrer les points de fidélité
        \App\Models\LoyaltyPoint::create([
            'professional_id' => Auth::id(),
            'service_request_id' => $serviceRequest->id,
            'points_earned' => $points,
            'source' => 'service_completion',
            'description' => $description
        ]);
        
        return redirect()->back()->with('success', 'Service request marked as completed. You earned ' . $points . ' loyalty points!');
    }
} 