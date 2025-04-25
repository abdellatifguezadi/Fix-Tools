<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['category', 'professional'])->latest()->paginate(10);
        
        return view('admin.services.index', compact('services'));
    }

    public function toggleStatus(Service $service)
    {
        $service->is_available = !$service->is_available;
        $service->save();
        
        $status = $service->is_available ? 'activated' : 'deactivated';
        return redirect()->route('admin.services.index')
            ->with('success', "Service {$status} successfully");
    }
} 