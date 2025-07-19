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
            'message' => 'nullable|string|max:2000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'message.max' => 'Message cannot exceed 2000 characters.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif.',
            'image.max' => 'The image may not be greater than 2MB.',
        ]);
        
        $otherUser = User::findOrFail($userId);
        $currentUser = Auth::user();
        
        // Prevent sending messages to yourself
        if ($currentUser->id === $otherUser->id) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot send messages to yourself.'
                ], 400);
            }
            
            return redirect()->back()->with('error', 'You cannot send messages to yourself.');
        }
        
        try {
            $messageContent = $request->input('message') ?: $request->input('content') ?: '';
            $hasImage = $request->hasFile('image');
            
            // Check if at least one of message content or image is provided
            if (empty($messageContent) && !$hasImage) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please provide a message or image.'
                    ], 400);
                }
                
                return redirect()->back()->with('error', 'Please provide a message or image.');
            }
            
            $messageData = [
                'sender_id' => $currentUser->id,
                'recipient_id' => $otherUser->id,
                'content' => $messageContent,
            ];
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('chat-images', 'public');
                $messageData['image'] = $imagePath;
            }
            
            $message = Message::create($messageData);
            
            // Load the sender relationship for JSON response
            $message->load('sender');

            // If AJAX, return JSON
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => [
                        'id' => $message->id,
                        'message' => $message->content,
                        'image' => $message->image,
                        'sender_name' => 'You',
                        'created_at' => $message->created_at->format('M j, g:i A')
                    ]
                ]);
            }

            // Otherwise, redirect (for non-AJAX fallback)
            return redirect()->route('chat.index', $otherUser->id);
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send message. Please try again.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Failed to send message. Please try again.');
        }
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

    // Get new messages for polling
    public function messages($userId)
    {
        try {
            $otherUser = User::findOrFail($userId);
            $currentUser = Auth::user();
            $lastId = request('last_id', 0);
            
            $messages = Message::where(function($q) use ($currentUser, $otherUser) {
                    $q->where('sender_id', $currentUser->id)->where('recipient_id', $otherUser->id);
                })->orWhere(function($q) use ($currentUser, $otherUser) {
                    $q->where('sender_id', $otherUser->id)->where('recipient_id', $currentUser->id);
                })
                ->where('id', '>', $lastId)
                ->orderBy('created_at')
                ->get()
                ->map(function($message) use ($currentUser) {
                    return [
                        'id' => $message->id,
                        'message' => $message->content,
                        'image' => $message->image,
                        'sender_name' => $message->sender->name,
                        'is_self' => $message->sender_id === $currentUser->id,
                        'created_at' => $message->created_at->format('M j, g:i A')
                    ];
                });
                
            return response()->json(['messages' => $messages]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch messages'], 500);
        }
    }
} 