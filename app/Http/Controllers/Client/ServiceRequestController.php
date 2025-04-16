<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ServiceRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'professional_id' => 'required|exists:users,id',
            'description' => 'required|string|min:10',
        ]);

        $serviceRequest = ServiceRequest::create([
            'client_id' => Auth::id(),
            'professional_id' => $validated['professional_id'],
            'service_id' => $validated['service_id'],
            'description' => $validated['description'],
            'requested_date' => Carbon::now(),
            'status' => 'pending',
        ]);

        return redirect()->route('client.services.index')
            ->with('success', 'Service request submitted successfully!');
    }
    
    public function index()
    {
        $requests = ServiceRequest::where('client_id', Auth::id())
            ->with(['service.category', 'professional', 'professional.receivedReviews'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('client.services.my-requests', compact('requests'));
    }
    
    public function cancel(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->client_id === auth()->id() && $serviceRequest->status === 'pending') {
            $serviceRequest->update(['status' => 'cancelled']);
            return redirect()->back()->with('success', 'Service request has been cancelled.');
        }
        
        return redirect()->back()->with('error', 'Unable to cancel this request. Either it is not yours or its status is not pending.');
    }
    
    public function acceptPrice(ServiceRequest $serviceRequest)
    {
        // Check if the request belongs to the authenticated user
        if ($serviceRequest->client_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
        
        // Check if the request is in the correct status
        if ($serviceRequest->status !== 'priced') {
            return redirect()->back()->with('error', 'Only priced requests can be accepted.');
        }
        
        // Update the request status
        $serviceRequest->update(['status' => 'accepted']);
        
        return redirect()->back()->with('success', 'Price accepted. The professional will start working on your request.');
    }
} 