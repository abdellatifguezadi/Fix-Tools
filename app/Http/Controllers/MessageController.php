<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display all conversations
     */
    public function index()
    {
        $users = User::whereHas('receivedMessages', function($query) {
                $query->where('sender_id', Auth::id());
            })
            ->orWhereHas('sentMessages', function($query) {
                $query->where('receiver_id', Auth::id());
            })
            ->get();
            
        return view('messages.index', compact('users'));
    }

    /**
     * Display conversation with a specific user
     */
    public function show(User $user)
    {
        // Mark messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        // Get conversation messages
        $messages = Message::where(function($query) use ($user) {
                $query->where('sender_id', Auth::id())
                    ->where('receiver_id', $user->id);
            })
            ->orWhere(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
            
        return view('messages.show', compact('user', 'messages'));
    }

    /**
     * Send a new message
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string'
        ]);
        
        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->content,
            'is_read' => false
        ]);
        
        return redirect()->route('messages.show', $user)
            ->with('success', 'Message sent successfully');
    }
} 