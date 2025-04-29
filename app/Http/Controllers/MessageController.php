<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function index()
    {
        $authUser = Auth::id();
        

        $hasMessages = Message::where(function($query) use ($authUser) {
                $query->where('sender_id', $authUser)
                    ->orWhere('receiver_id', $authUser);
            })
            ->exists();

        $users = User::whereHas('receivedMessages', function($query) use ($authUser) {
                $query->where('sender_id', $authUser);
            })
            ->orWhereHas('sentMessages', function($query) use ($authUser) {
                $query->where('receiver_id', $authUser);
            })
            ->withTrashed() 
            ->get();
            
        foreach ($users as $user) {
            $user->unread_count = Message::where('sender_id', $user->id)
                ->where('receiver_id', $authUser)
                ->unread()
                ->count();
        }
            
        return view('messages.index', compact('users', 'hasMessages'));
    }

    public function show(User $user)
    {
        Message::where('sender_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
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


    public function store(Request $request, User $user)
    {
        $request->validate([
            'content' => 'required|string'
        ]);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $request->content,
            'is_read' => false
        ]);

        broadcast(new MessageSent($message, Auth::user()))->toOthers();
        
        if ($request->ajax()) {
            return response()->json($message);
        }
        
        return redirect()->route('messages.show', $user)
            ->with('success', 'Message sent successfully');
    }
    

    // public function getUnreadCount()
    // {
    //     $unreadCount = Message::where('receiver_id', Auth::id())
    //         ->unread()
    //         ->count();
            
    //     return response()->json(['unread_count' => $unreadCount]);
    // }
    

    // public function markAsRead(User $user)
    // {
    //     Message::where('sender_id', $user->id)
    //         ->where('receiver_id', Auth::id())
    //         ->where('is_read', false)
    //         ->update(['is_read' => true]);
            
    //     return response()->json(['success' => true]);
    // }
    

    // public function getMessages(User $user)
    // {
    //     $messages = Message::where(function($query) use ($user) {
    //             $query->where('sender_id', Auth::id())
    //                 ->where('receiver_id', $user->id);
    //         })
    //         ->orWhere(function($query) use ($user) {
    //             $query->where('sender_id', $user->id)
    //                 ->where('receiver_id', Auth::id());
    //         })
    //         ->with(['sender'])
    //         ->orderBy('created_at', 'asc')
    //         ->get();
            
    //     return response()->json(['messages' => $messages]);
    // }
} 