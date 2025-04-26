<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function suspend(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot suspend admin users.');
        }

        $user->is_available = false;
        $user->save();

        return back()->with('success', 'User has been suspended successfully.');
    }

    public function activate(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot activate admin users.');
        }

        $user->is_available = true;
        $user->save();

        return back()->with('success', 'User has been activated successfully.');
    }

    public function delete(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin users.');
        }

        DB::beginTransaction();
        
        try {
            // Anonymize messages
            $user->sentMessages()->update([
                'sender_id' => null
            ]);
            
            $user->receivedMessages()->update([
                'receiver_id' => null
            ]);
            
            // Anonymize reviews
            $user->givenReviews()->update([
                'client_id' => null
            ]);
            
            $user->receivedReviews()->update([
                'professional_id' => null
            ]);

            // Cancel pending service requests
            $user->requestedServices()->where('status', 'pending')->update([
                'status' => 'cancelled',
                'client_id' => null
            ]);

            $user->providedServices()->where('status', 'pending')->update([
                'status' => 'cancelled',
                'professional_id' => null
            ]);

            // Delete related data
            $user->services()->delete();
            $user->materialPurchases()->delete();
            $user->loyaltyPoints()->delete();

            // Finally delete the user
            $user->delete();
            
            DB::commit();
            
            return redirect()->route('admin.users.index')
                ->with('success', 'User has been permanently deleted. Their messages and reviews have been anonymized.');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.users.index')
                ->with('error', 'An error occurred while deleting the user: ' . $e->getMessage());
        }
    }
}