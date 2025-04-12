<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $serviceRequests = ServiceRequest::with(['service', 'professional', 'service.category'])
            ->where('client_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.services.my-requests', compact('serviceRequests'));
    }

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

        return redirect()->route('client.service-requests.index')
            ->with('success', 'Service request submitted successfully!');
    }

    public function cancel(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->client_id === auth()->id() && $serviceRequest->status === 'pending') {
            $serviceRequest->update(['status' => 'cancelled']);
        }
        
        return redirect()->back();
    }
} 