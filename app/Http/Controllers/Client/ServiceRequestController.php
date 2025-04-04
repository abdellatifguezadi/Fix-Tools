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
} 