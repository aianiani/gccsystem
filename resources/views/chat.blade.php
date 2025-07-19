@extends('layouts.app')

@push('scripts')
<script>
    // Force cache refresh
    if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
        window.location.reload();
    }
</script>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>
                        Chat with {{ $otherUser->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ $otherUser->avatar_url }}" 
                             alt="{{ $otherUser->name }}" 
                             class="rounded-circle me-3" 
                             style="width: 50px; height: 50px; object-fit: cover;">
                        <div>
                            <h6 class="mb-0">{{ $otherUser->name }}</h6>
                            <small class="text-muted">{{ $otherUser->email }}</small>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                        @if(auth()->user()->role === 'student')
                            <a href="{{ route('chat.selectCounselor') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-users me-2"></i>Chat with Another Counselor
                            </a>
                        @else
                            <a href="{{ route('chat.selectStudent') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-users me-2"></i>Chat with Another Student
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Chat Area -->
        <div class="col-md-9">
            <div class="card h-100">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-comment-dots me-2"></i>
                            Messages
                        </h5>
                        <div class="text-muted">
                            <small id="last-seen"></small>
                        </div>
                    </div>
                </div>
                
                <!-- Messages Container -->
                <div class="card-body p-0" style="height: 500px; display: flex; flex-direction: column;">
                    <!-- Messages List -->
                    <div id="messages-container" class="flex-grow-1 overflow-auto p-3" style="background: #f8f9fa;">
                        @forelse($messages as $msg)
                            @php
                                $isSelf = $msg->sender_id === auth()->id();
                                $messageClass = $isSelf ? 'message-own' : 'message-other';
                                $alignment = $isSelf ? 'justify-content-end' : 'justify-content-start';
                            @endphp
                            
                            <div class="d-flex {{ $alignment }} mb-3">
                                <div class="message {{ $messageClass }}" style="max-width: 70%;">
                                    @if(!$isSelf)
                                        <div class="message-sender mb-1">
                                            <small class="text-muted">{{ $msg->sender->name }}</small>
                                        </div>
                                    @endif
                                    
                                    <div class="message-content p-3 rounded">
                                        @if($msg->content)
                                            <div class="message-text">{{ $msg->content }}</div>
                                        @endif
                                        
                                        @if($msg->image)
                                            <div class="message-image mt-2">
                                                <img src="{{ asset('storage/' . $msg->image) }}" 
                                                     alt="Message image" 
                                                     class="img-fluid rounded shadow-sm" 
                                                     style="max-width: 250px; max-height: 250px; object-fit: cover; cursor: pointer;"
                                                     onclick="openImageModal('{{ asset('storage/' . $msg->image) }}')">
                                            </div>
                                        @endif
                                        
                                        <div class="message-time mt-1">
                                            <small class="text-muted">{{ $msg->created_at->format('M j, g:i A') }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted mt-5">
                                <i class="fas fa-comments fa-3x mb-3" style="color: #dee2e6;"></i>
                                <p class="mb-2">No messages yet.</p>
                                <small>Start the conversation by typing a message below!</small>
                            </div>
                        @endforelse
                        
                        <!-- Scroll anchor -->
                        <div id="scroll-anchor"></div>
                    </div>
                    
                    <!-- Message Input -->
                    <div class="border-top bg-white p-3" id="message-input-area">
                        <form id="chat-form" method="POST" action="{{ route('chat.store', $otherUser->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-2">
                                <div class="col">
                                    <div class="input-group">
                                        <input type="text" 
                                               name="message" 
                                               id="message-input" 
                                               class="form-control" 
                                               placeholder="Type your message..." 
                                               autocomplete="off">
                                        <button type="button" 
                                                class="btn btn-outline-secondary" 
                                                onclick="document.getElementById('image-input').click()"
                                                title="Attach image (max 2MB)">
                                            <i class="fas fa-paperclip"></i>
                                        </button>
                                        <button type="submit" 
                                                class="btn btn-primary" 
                                                id="send-button">
                                            <i class="fas fa-paper-plane" id="send-icon"></i>
                                            <span id="send-text">Send</span>
                                        </button>
                                    </div>
                                    <input type="file" 
                                           name="image" 
                                           id="image-input" 
                                           accept="image/*" 
                                           style="display: none;">
                                </div>
                            </div>
                            
                            <!-- Image preview -->
                            <div id="image-preview" class="mt-2" style="display: none;">
                                <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                    <div class="d-flex align-items-center">
                                        <img id="preview-img" src="" alt="Preview" class="me-2" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 2px solid #dee2e6;">
                                        <div>
                                            <div id="file-name" class="fw-bold text-dark"></div>
                                            <div id="file-size" class="text-muted small"></div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImage()" title="Remove image">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Full size image" class="img-fluid">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a id="downloadImage" href="" download class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Download
                </a>
            </div>
        </div>
    </div>
</div>

<style>
.message-own .message-content {
    background: #007bff;
    color: white;
    border-bottom-right-radius: 4px;
}

.message-other .message-content {
    background: white;
    color: #333;
    border: 1px solid #e9ecef;
    border-bottom-left-radius: 4px;
}



.message-text {
    word-wrap: break-word;
    white-space: pre-wrap;
}

.message-image img:hover {
    transform: scale(1.02);
    transition: transform 0.2s ease;
}

#image-preview {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
}

#image-preview:hover {
    border-color: #007bff;
}

#messages-container {
    scroll-behavior: smooth;
}

#messages-container::-webkit-scrollbar {
    width: 6px;
}

#messages-container::-webkit-scrollbar-track {
    background: #f1f1f1;
}

#messages-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

#messages-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}




</style>

<script>
// Version: {{ time() }} - Force cache refresh
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    const messageInput = document.getElementById('message-input');
    const chatForm = document.getElementById('chat-form');
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');
    const sendButton = document.getElementById('send-button');
    const sendIcon = document.getElementById('send-icon');
    const sendText = document.getElementById('send-text');
    
    // Auto-scroll to bottom on page load
    scrollToBottom();
    
    // Scroll to bottom function
    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
    

    
    // Handle form submission
    chatForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        const imageFile = imageInput.files[0];
        
        if (!message && !imageFile) {
            return;
        }
        
        // Create form data
        const formData = new FormData();
        formData.append('message', message);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        if (imageFile) {
            formData.append('image', imageFile);
        }
        
        // Send message via AJAX
        const chatUrl = '/chat/{{ $otherUser->id }}';
        console.log('Sending to URL:', chatUrl);
        console.log('Other user ID:', {{ $otherUser->id }});
        
        fetch(chatUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            
            // Try to get response text first to debug
            return response.text().then(text => {
                console.log('Response text:', text);
                try {
                    return JSON.parse(text);
                } catch (e) {
                    console.error('Failed to parse JSON:', e);
                    throw new Error('Invalid JSON response');
                }
            });
        })
        .then(data => {
            console.log('Response received:', data); // Debug log
            if (data.success) {
                // Don't add message to UI here - let polling handle it
                // Just clear form and reset loading state
                messageInput.value = '';
                removeImage();
                
                // Message sent successfully
                console.log('Message sent successfully');
            } else {
                // Log error but don't show alert for validation errors
                console.log('Message not sent:', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Show specific error message for debugging
            if (error.message === 'Server returned non-JSON response') {
                console.error('Server error - likely a Laravel error or validation issue');
            }
        });
    });
    
    // Handle image selection
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, or GIF).');
                imageInput.value = '';
                return;
            }
            
            // Validate file size (2MB limit)
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            if (file.size > maxSize) {
                alert('Image size must be less than 2MB.');
                imageInput.value = '';
                return;
            }
            
            // Display file information
            const fileName = document.getElementById('file-name');
            const fileSize = document.getElementById('file-size');
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Remove image function
    window.removeImage = function() {
        imageInput.value = '';
        imagePreview.style.display = 'none';
    };
    
    // Format file size function
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Open image modal function
    window.openImageModal = function(imageSrc) {
        const modalImage = document.getElementById('modalImage');
        const downloadImage = document.getElementById('downloadImage');
        
        modalImage.src = imageSrc;
        downloadImage.href = imageSrc;
        
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    };
    
    // Append message function
    function appendMessage(message, isSelf = false) {
        const messagesContainer = document.getElementById('messages-container');
        const scrollAnchor = document.getElementById('scroll-anchor');
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `d-flex ${isSelf ? 'justify-content-end' : 'justify-content-start'} mb-3`;
        
        const messageClass = isSelf ? 'message-own' : 'message-other';
        
        let messageContent = '';
        if (message.message) {
            messageContent += `<div class="message-text">${message.message}</div>`;
        }
        if (message.image) {
            messageContent += `<div class="message-image mt-2">
                <img src="/storage/${message.image}" alt="Message image" class="img-fluid rounded shadow-sm" style="max-width: 250px; max-height: 250px; object-fit: cover; cursor: pointer;" onclick="openImageModal('/storage/${message.image}')">
            </div>`;
        }
        
        messageDiv.innerHTML = `
            <div class="message ${messageClass}" style="max-width: 70%;">
                ${!isSelf ? `<div class="message-sender mb-1">
                    <small class="text-muted">${message.sender_name}</small>
                </div>` : ''}
                <div class="message-content p-3 rounded">
                    ${messageContent}
                    <div class="message-time mt-1">
                        <small class="text-muted">${message.created_at || new Date().toLocaleString()}</small>
                    </div>
                </div>
            </div>
        `;
        
        messagesContainer.insertBefore(messageDiv, scrollAnchor);
    }
    
    // Poll for new messages
    let lastMessageId = {{ $messages->count() > 0 ? $messages->last()->id : 0 }};
    let processedMessageIds = new Set();
    
    function pollForMessages() {
        fetch(`{{ route('chat.messages', $otherUser->id) }}?last_id=${lastMessageId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                console.error('Server error:', data.error);
                return;
            }
            if (data.messages && data.messages.length > 0) {
                let hasNewMessages = false;
                data.messages.forEach(message => {
                    if (message.id > lastMessageId && !processedMessageIds.has(message.id)) {
                        appendMessage(message, message.is_self);
                        processedMessageIds.add(message.id);
                        lastMessageId = message.id;
                        hasNewMessages = true;
                    }
                });
                if (hasNewMessages) {
                    scrollToBottom();
                }
            }
        })
        .catch(error => {
            console.error('Polling error:', error);
            // Don't show alert for polling errors as they're expected when offline
        });
    }
    
    // Start polling
    setInterval(pollForMessages, 3000);
    
    // Handle Enter key
    messageInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            chatForm.dispatchEvent(new Event('submit'));
        }
    });
    

    
    // Auto-focus input
    messageInput.focus();
    
    // Drag and drop functionality
    const messageInputArea = document.getElementById('message-input-area');
    
    messageInputArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        messageInputArea.style.backgroundColor = '#f8f9fa';
        messageInputArea.style.border = '2px dashed #007bff';
    });
    
    messageInputArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        messageInputArea.style.backgroundColor = '';
        messageInputArea.style.border = '';
    });
    
    messageInputArea.addEventListener('drop', function(e) {
        e.preventDefault();
        messageInputArea.style.backgroundColor = '';
        messageInputArea.style.border = '';
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const file = files[0];
            if (file.type.startsWith('image/')) {
                imageInput.files = files;
                imageInput.dispatchEvent(new Event('change'));
            } else {
                alert('Please drop an image file.');
            }
        }
    });
});
</script>
@endsection 