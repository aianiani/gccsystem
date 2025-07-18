@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex align-items-center justify-content-between" style="background: #f4f8fb;">
            <h5 class="mb-0"><i class="bi bi-chat-dots me-2"></i>Chat with {{ $otherUser->name }}</h5>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
        @php
            $getAvatar = function($user) {
                if (!empty($user->avatar)) {
                    return asset('storage/' . $user->avatar);
                }
                $name = urlencode($user->name ?? 'User');
                return 'https://ui-avatars.com/api/?name=' . $name . '&background=237728&color=fff';
            };
        @endphp
        <div class="card-body px-3 py-4" id="chat-messages" style="min-height: 350px; max-height: 400px; overflow-y: auto; background: #fff;">
            @forelse($messages as $msg)
                @php
                    $isSelf = $msg->sender_id === auth()->id();
                    $sender = $isSelf ? auth()->user() : $otherUser;
                @endphp
                <div class="mb-2 d-flex {{ $isSelf ? 'justify-content-end' : 'justify-content-start' }} align-items-end">
                    @if(!$isSelf)
                        <img src="{{ $getAvatar($sender) }}" class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                    @endif
                    <div class="{{ $isSelf ? 'bg-light-green text-dark' : 'bg-light text-dark' }} px-3 py-2 simple-bubble" style="max-width: 70%;">
                        <div class="small mb-1 text-muted" style="font-size: 12px;">
                            <strong>{{ $isSelf ? 'You' : $otherUser->name }}</strong>
                            <span class="ms-2">{{ $msg->created_at->format('M d, Y h:i A') }}</span>
                        </div>
                        <div>{{ $msg->content }}</div>
                    </div>
                    @if($isSelf)
                        <img src="{{ $getAvatar($sender) }}" class="rounded-circle ms-2" width="32" height="32" alt="Avatar">
                    @endif
                </div>
            @empty
                <div class="text-center text-muted" id="no-messages-placeholder">No messages yet. Start the conversation!</div>
            @endforelse
        </div>
        <div class="card-footer bg-white border-0">
            <form id="chat-form" method="POST" action="{{ route('chat.store', $otherUser->id) }}">
                @csrf
                <div class="input-group">
                    <input type="text" name="content" id="chat-input" class="form-control" placeholder="Type your message..." required maxlength="2000" autocomplete="off">
                    <button class="btn btn-primary" type="submit">Send</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .simple-bubble {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
        background: #f8f9fa;
        font-size: 15px;
    }
    .bg-light-green {
        background: #e6f4ea !important;
        border: 1px solid #b7e0c2 !important;
    }
    #chat-messages {
        background: #fff;
        border-radius: 0.5rem;
    }
    .rounded-circle {
        border: 1px solid #e0e0e0;
    }
    .input-group input:focus {
        box-shadow: 0 0 0 2px #23772833;
        border-color: #237728;
    }
</style>
@endsection

@section('scripts')
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script>
<script>
    window.Pusher = window.Pusher || Pusher;
    window.Echo = new window.Echo({
        broadcaster: 'pusher',
        key: '{{ env('PUSHER_APP_KEY') }}',
        cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
        forceTLS: true
    });
    const userId = {{ auth()->id() }};
    const otherUserName = @json($otherUser->name);
    const selfAvatar = @json($getAvatar(auth()->user()));
    const otherAvatar = @json($getAvatar($otherUser));

    window.Echo.channel('chat.' + userId)
        .listen('MessageSent', (e) => {
            appendMessage(e.message, e.message.sender_id === userId ? 'You' : otherUserName, e.message.sender_id === userId);
        })
        .listen('UserTyping', (e) => {
            showTypingIndicator(e.senderId === userId ? 'You' : otherUserName);
        });

    // Typing indicator logic
    let typingTimeout;
    document.getElementById('chat-input').addEventListener('input', function() {
        clearTimeout(typingTimeout);
        fetch('/chat/typing', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ receiver_id: {{ $otherUser->id }} })
        });
        typingTimeout = setTimeout(() => {
            // Optionally send a "stopped typing" event
        }, 2000);
    });

    function showTypingIndicator(senderName) {
        let indicator = document.getElementById('typing-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'typing-indicator';
            indicator.className = 'text-muted small mb-2';
            indicator.innerText = senderName + ' is typing...';
            document.getElementById('chat-messages').appendChild(indicator);
            document.getElementById('chat-messages').scrollTop = document.getElementById('chat-messages').scrollHeight;
        }
        clearTimeout(window.typingTimeout);
        window.typingTimeout = setTimeout(() => {
            if (indicator) indicator.remove();
        }, 2000);
    }

    // AJAX form submission for chat
    document.getElementById('chat-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const content = input.value.trim();
        if (!content) return;
        fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'content=' + encodeURIComponent(content)
        })
        .then(response => {
            appendMessage({
                content: content,
                created_at: (new Date()).toISOString(),
                sender_id: userId
            }, 'You', true);
            input.value = '';
            document.getElementById('no-messages-placeholder')?.remove();
        });
    });

    function appendMessage(message, senderName, isSelf) {
        // Remove the placeholder if it exists
        const placeholder = document.getElementById('no-messages-placeholder');
        if (placeholder) placeholder.remove();

        // Remove typing indicator if present
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) typingIndicator.remove();

        const chatMessages = document.getElementById('chat-messages');
        const wrapper = document.createElement('div');
        wrapper.className = 'mb-2 d-flex ' + (isSelf ? 'justify-content-end' : 'justify-content-start') + ' align-items-end';
        const avatarUrl = isSelf ? selfAvatar : otherAvatar;
        let avatarImg = `<img src="${avatarUrl}" class="rounded-circle ${isSelf ? 'ms-2' : 'me-2'}" width="32" height="32" alt="Avatar">`;
        let msgDiv = `<div class=\"bg-light text-dark px-3 py-2 simple-bubble\" style=\"max-width: 70%;\">`
            + `<div class=\"small mb-1 text-muted\" style=\"font-size: 12px;\"><strong>${senderName}</strong> <span class=\"ms-2\">${(new Date(message.created_at)).toLocaleString()}</span></div>`
            + `<div>${message.content}</div></div>`;
        if (isSelf) {
            msgDiv = `<div class=\"bg-light-green text-dark px-3 py-2 simple-bubble\" style=\"max-width: 70%;\">`
                + `<div class=\"small mb-1 text-muted\" style=\"font-size: 12px;\"><strong>${senderName}</strong> <span class=\"ms-2\">${(new Date(message.created_at)).toLocaleString()}</span></div>`
                + `<div>${message.content}</div></div>`;
        }
        wrapper.innerHTML = isSelf ? (msgDiv + avatarImg) : (avatarImg + msgDiv);
        chatMessages.appendChild(wrapper);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    // Auto-scroll to bottom on page load
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chat-messages');
        chatMessages.scrollTop = chatMessages.scrollHeight;
    });
</script>
@endsection 