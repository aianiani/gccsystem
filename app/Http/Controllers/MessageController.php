<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Show chat page between current user and another user
    public function index($userId)
    {
        $otherUser = User::findOrFail($userId);
        $currentUser = Auth::user();
        // Fetch messages between these two users
        $messages = Message::where(function($q) use ($currentUser, $otherUser) {
                $q->where('sender_id', $currentUser->id)->where('recipient_id', $otherUser->id);
            })->orWhere(function($q) use ($currentUser, $otherUser) {
                $q->where('sender_id', $otherUser->id)->where('recipient_id', $currentUser->id);
            })->orderBy('created_at')->get();
        return view('chat', compact('messages', 'otherUser'));
    }

    // Send a message
    public function store(Request $request, $userId)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
        ]);
        $otherUser = User::findOrFail($userId);
        $currentUser = Auth::user();
        $message = Message::create([
            'sender_id' => $currentUser->id,
            'recipient_id' => $otherUser->id, // Use recipient_id to match DB schema
            'content' => $request->input('content'),
        ]);
        event(new \App\Events\MessageSent($message, $otherUser->id));

        // If AJAX, return JSON
        if ($request->ajax()) {
            return response()->json([
                'message' => $message,
                'sender_name' => 'You',
            ]);
        }

        // Otherwise, redirect (for non-AJAX fallback)
        return redirect()->route('chat.index', $otherUser->id);
    }

    // Fetch messages for AJAX (optional, for real-time or polling)
    public function fetch($userId)
    {
        $otherUser = User::findOrFail($userId);
        $currentUser = Auth::user();
        $messages = Message::where(function($q) use ($currentUser, $otherUser) {
                $q->where('sender_id', $currentUser->id)->where('recipient_id', $otherUser->id);
            })->orWhere(function($q) use ($currentUser, $otherUser) {
                $q->where('sender_id', $otherUser->id)->where('recipient_id', $currentUser->id);
            })->orderBy('created_at')->get();
        return response()->json($messages);
    }

    public function typing(Request $request)
    {
        event(new \App\Events\UserTyping(auth()->id(), $request->receiver_id));
        return response()->json(['status' => 'ok']);
    }

    public function selectCounselor()
    {
        $counselors = \App\Models\User::where('role', 'counselor')->get();
        return view('chat_select_counselor', compact('counselors'));
    }

    public function selectStudent()
    {
        $students = \App\Models\User::where('role', 'student')->get();
        return view('chat_select_student', compact('students'));
    }
} 