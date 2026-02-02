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
    <style>
        /* Homepage theme variables (mapped into existing dashboard vars) */
        :root {
            --primary-green: #1f7a2d;
            /* Homepage forest green */
            --primary-green-2: #13601f;
            /* darker stop */
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

            /* Map dashboard-specific names to homepage palette for compatibility */
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-600: var(--text-light);
            --danger: #dc3545;
            --warning: #ffc107;
            --success: #28a745;
            --info: #17a2b8;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        @media (max-width: 768px) {
            .home-zoom {
                zoom: 1 !important;
                transform: none !important;
            }
        }

        body,
        .profile-card,
        .stats-card,
        .main-content-card {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .custom-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 240px;
            background: var(--forest-green);
            color: #fff;
            z-index: 1040;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 18px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
            padding-bottom: 1rem;
        }

        .custom-sidebar .sidebar-logo {
            text-align: center;
            padding: 2.5rem 1.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.05);
        }

        .custom-sidebar .sidebar-logo h3 {
            font-family: 'Outfit', sans-serif;
            letter-spacing: 0.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .sidebar-logo p {
            letter-spacing: 1px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem !important;
        }

        .custom-sidebar .sidebar-nav {
            flex: 1;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .custom-sidebar .sidebar-link {
            display: flex;
            align-items: center;
            gap: 1.1rem;
            padding: 0.9rem 1.25rem;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin: 0.1rem 0;
        }

        .custom-sidebar .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transform: translateX(5px);
        }

        .custom-sidebar .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            color: #f4d03f;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .custom-sidebar .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: -0.75rem;
            top: 15%;
            bottom: 15%;
            width: 5px;
            background: #f4d03f;
            border-radius: 0 6px 6px 0;
            box-shadow: 2px 0 15px rgba(244, 208, 63, 0.5);
        }

        .custom-sidebar .sidebar-link .bi {
            font-size: 1.25rem;
            transition: all 0.3s ease;
        }

        .custom-sidebar .sidebar-link.active .bi {
            transform: scale(1.1);
            filter: drop-shadow(0 0 5px rgba(244, 208, 63, 0.3));
        }

        .custom-sidebar .sidebar-bottom {
            padding: 1.5rem 1rem;
            background: rgba(0, 0, 0, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-sidebar .sidebar-link.logout {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            text-align: left;
            padding: 0.85rem 1.25rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 1.1rem;
        }

        .custom-sidebar .sidebar-link.logout:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(220, 53, 69, 0.4);
        }

        @media (max-width: 991.98px) {
            .custom-sidebar {
                width: 200px;
            }

            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 991.98px) {
            .custom-sidebar {
                width: 200px;
            }

            .main-dashboard-content {
                margin-left: 200px;
            }
        }

        @media (max-width: 767.98px) {

            /* Off-canvas behavior on mobile */
            .custom-sidebar {
                position: fixed;
                z-index: 1040;
                height: 100vh;
                left: 0;
                top: 0;
                width: 240px;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                flex-direction: column;
                padding: 0;
                box-shadow: 10px 0 30px rgba(0, 0, 0, 0.2);
            }

            .custom-sidebar.show {
                transform: translateX(0);
            }

            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem;
            }

            /* Toggle button */
            #studentSidebarToggle {
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1100;
                background: var(--forest-green);
                color: #fff;
                border: none;
                border-radius: 10px;
                padding: 0.6rem 0.8rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
                display: flex !important;
                align-items: center;
                justify-content: center;
            }
        }

        .main-dashboard-content {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
            min-height: 100vh;
            padding: 1rem 1.5rem;
            margin-left: 240px;
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .main-dashboard-content {
                margin-left: 0;
                padding: 1rem 0.75rem !important;
            }
        }

        /* Constrain inner content and center it within the available area */
        .main-dashboard-inner {
            max-width: 100%;
            margin: 0 auto;
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Mobile Sidebar Toggle -->
            <button id="studentSidebarToggle" class="d-md-none">
                <i class="bi bi-list"></i>
            </button>
            <!-- Sidebar -->
            @if(auth()->check() && auth()->user()->isCounselor())
                @include('counselor.sidebar')
            @else
                <div class="custom-sidebar">
                    <div class="sidebar-logo">
                        <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo"
                            style="width: 80px; height: 80px; border-radius: 50%; margin-bottom: 0.75rem; display: block; margin-left: auto; margin-right: auto; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        <h3
                            style="margin: 0.5rem 0 0.25rem 0; font-size: 1.1rem; font-weight: 700; color: #f4d03f; line-height: 1.3;">
                            CMU Guidance and Counseling Center</h3>
                        <p
                            style="margin: 0; font-size: 0.8rem; color: #fff; opacity: 0.7; text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">
                            Student Portal</p>
                    </div>
                    <nav class="sidebar-nav">
                        <a href="{{ route('dashboard') }}"
                            class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i
                                class="bi bi-house-door"></i>Dashboard</a>
                        <a href="{{ route('profile') }}"
                            class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i
                                class="bi bi-person"></i>Profile</a>
                        <a href="{{ route('appointments.index') }}"
                            class="sidebar-link{{ request()->routeIs('appointments.*') && !request()->routeIs('appointments.completedWithNotes') ? ' active' : '' }}"><i
                                class="bi bi-calendar-check"></i>Appointments</a>
                        <a href="{{ route('appointments.completedWithNotes') }}"
                            class="sidebar-link{{ request()->routeIs('appointments.completedWithNotes') ? ' active' : '' }}"><i
                                class="bi bi-journal-text"></i>Sessions & Feedback</a>
                        <a href="{{ route('assessments.index') }}"
                            class="sidebar-link{{ request()->routeIs('assessments.*') ? ' active' : '' }}"><i
                                class="bi bi-clipboard-data"></i>Assessments</a>
                        <a href="{{ route('chat.selectCounselor') }}"
                            class="sidebar-link{{ request()->routeIs('chat.selectCounselor') ? ' active' : '' }}"><i
                                class="bi bi-chat-dots"></i>Chat with a Counselor</a>

                        <div class="sidebar-divider my-3" style="border-top: 1px solid rgba(255, 255, 255, 0.1);"></div>
                        <div class="sidebar-resources">
                            <div class="text-uppercase small px-3 mb-2"
                                style="color: rgba(255,255,255,0.5); font-weight:700; font-size: 0.75rem; letter-spacing: 1px;">
                                Resources</div>
                            <a href="#" class="sidebar-link"><i class="bi bi-play-circle"></i>Orientation</a>
                            <a href="#" class="sidebar-link"><i class="bi bi-book"></i>Library</a>
                            <a href="#" class="sidebar-link"><i class="bi bi-gear"></i>Settings</a>
                        </div>
                    </nav>
                    <div class="sidebar-bottom w-100">
                        <a href="{{ route('logout') }}" class="sidebar-link logout"
                            onclick="event.preventDefault(); document.getElementById('logout-form-chat').submit();">
                            <i class="bi bi-box-arrow-right"></i>Logout
                        </a>
                        <form id="logout-form-chat" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            @endif

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1">
                <div class="main-dashboard-inner" style="max-width: 100%;">
                    <div class="container-fluid p-0">
                        <div class="row g-0">
                            <div class="col-12">
                                <div class="card chat-card">
                                    <div class="row g-0 h-100">
                                        <!-- Sidebar -->
                                        <div class="col-md-4 col-lg-3 inbox-sidebar">
                                            <div class="inbox-header">
                                                <h5 class="mb-0 font-weight-bold text-dark">Inbox</h5>
                                            </div>
                                            <div class="inbox-list">
                                                @forelse($activeConversations as $conversationUser)
                                                    <a href="{{ route('chat.index', $conversationUser->id) }}"
                                                        class="inbox-item {{ $otherUser->id === $conversationUser->id ? 'active' : '' }}">
                                                        <div class="avatar-container">
                                                            <img src="{{ $conversationUser->avatar_url }}" class="avatar-img">
                                                            <!-- Optional status dot if we had online status -->
                                                        </div>
                                                        <div class="text-truncate">
                                                            <div class="fw-bold mb-1">{{ $conversationUser->name }}</div>
                                                            <small class="text-muted d-block text-truncate">
                                                                @if($conversationUser->last_message)
                                                                    @if($conversationUser->last_message->sender_id === auth()->id())
                                                                        <span class="fw-bold text-dark">You:</span>
                                                                    @endif
                                                                    {{ $conversationUser->last_message->content ?: ($conversationUser->last_message->image ? 'Sent an image' : '') }}
                                                                @else
                                                                    {{ $conversationUser->email }}
                                                                @endif
                                                            </small>
                                                        </div>
                                                    </a>
                                                @empty
                                                    <div class="p-4 text-center text-muted">
                                                        <i class="bi bi-chat-square-text display-6 mb-3 d-block opacity-50"></i>
                                                        No active conversations.
                                                    </div>
                                                @endforelse
                                            </div>
                                            <div class="p-3 border-top">
                                                @if(auth()->user()->role === 'student')
                                                    <a href="{{ route('chat.selectCounselor') }}"
                                                        class="btn btn-outline-success w-100 rounded-pill">
                                                        <i class="bi bi-plus-lg me-1"></i> New Chat
                                                    </a>
                                                @else
                                                    <a href="{{ route('chat.selectStudent') }}"
                                                        class="btn btn-outline-success w-100 rounded-pill">
                                                        <i class="bi bi-plus-lg me-1"></i> New Chat
                                                    </a>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Chat Area -->
                                        <div class="col-md-8 col-lg-9 chat-main">
                                            <div class="chat-header">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $otherUser->avatar_url }}" class="rounded-circle me-3"
                                                        style="width: 40px; height: 40px; object-fit: cover; border: 2px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                                    <div>
                                                        <h6 class="mb-0 font-weight-bold">{{ $otherUser->name }}</h6>
                                                        <small class="text-muted">{{ $otherUser->email }}</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Messages Container -->
                                            <div id="messages-container" class="messages-area">
                                                @forelse($messages as $msg)
                                                    @php
                                                        $isSelf = $msg->sender_id === auth()->id();
                                                        $wrapperClass = $isSelf ? 'own' : 'other';
                                                    @endphp

                                                    <div class="message-wrapper {{ $wrapperClass }}">
                                                        @if(!$isSelf)
                                                            <img src="{{ $msg->sender->avatar_url }}"
                                                                class="rounded-circle me-2 align-self-end mb-1"
                                                                style="width: 28px; height: 28px; object-fit: cover;">
                                                        @endif

                                                        <div class="message-bubble">
                                                            @if(!$isSelf)
                                                                <div class="message-sender">{{ $msg->sender->name }}</div>
                                                            @endif

                                                            @if($msg->content)
                                                                <div class="message-text">{{ $msg->content }}</div>
                                                            @endif

                                                            @if($msg->image)
                                                                <div class="message-image mt-2">
                                                                    <img src="{{ asset('storage/' . $msg->image) }}"
                                                                        class="img-fluid rounded shadow-sm"
                                                                        style="max-width: 250px; max-height: 250px; object-fit: cover; cursor: pointer;"
                                                                        onclick="openImageModal('{{ asset('storage/' . $msg->image) }}')">
                                                                </div>
                                                            @endif

                                                            <span
                                                                class="message-time">{{ $msg->created_at->format('g:i A') }}</span>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="text-center text-muted mt-5 opacity-75">
                                                        <div class="mb-3">
                                                            <i class="bi bi-chat-dots display-4 text-success opacity-25"></i>
                                                        </div>
                                                        <p class="mb-1">No messages yet.</p>
                                                        <small>Start the conversation!</small>
                                                    </div>
                                                @endforelse

                                                <div id="scroll-anchor"></div>
                                            </div>

                                            <!-- Input Area -->
                                            <div class="chat-input-wrapper">
                                                <form id="chat-form" method="POST"
                                                    action="{{ route('chat.store', $otherUser->id) }}"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <!-- Image preview -->
                                                    <div id="image-preview" style="display: none;">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <img id="preview-img" src="" alt="Preview" class="me-3"
                                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                                                <div>
                                                                    <div id="file-name" class="fw-bold text-dark small">
                                                                    </div>
                                                                    <div id="file-size" class="text-muted small"
                                                                        style="font-size: 0.75rem;"></div>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-sm btn-link text-danger"
                                                                onclick="removeImage()">
                                                                <i class="bi bi-x-circle-fill"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex align-items-end">
                                                        <div class="chat-input-group flex-grow-1">
                                                            <button type="button" class="btn-attach"
                                                                onclick="document.getElementById('image-input').click()"
                                                                title="Attach image">
                                                                <i class="bi bi-paperclip"></i>
                                                            </button>
                                                            <input type="text" name="message" id="message-input"
                                                                class="chat-input" placeholder="Type a message..."
                                                                autocomplete="off">
                                                        </div>
                                                        <button type="submit" class="btn-send" id="send-button">
                                                            <i class="bi bi-send-fill"></i>
                                                        </button>
                                                    </div>
                                                    <input type="file" name="image" id="image-input" accept="image/*"
                                                        style="display: none;">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Chat Layout */
        .chat-card {
            border: none;
            box-shadow: var(--shadow-md);
            border-radius: 16px;
            overflow: hidden;
            height: calc(100vh - 100px);
            min-height: 600px;
        }

        @media (max-width: 768px) {
            .chat-card {
                height: calc(100vh - 80px);
                min-height: 500px;
            }

            .inbox-sidebar {
                display: none;
                /* simple mobile chat: show conversation only if active */
            }

            .chat-main {
                width: 100%;
            }

            .message-bubble {
                max-width: 85%;
            }
        }

        /* Sidebar Styles */
        .inbox-sidebar {
            background: white;
            border-right: 1px solid var(--gray-100);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .inbox-header {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .inbox-list {
            overflow-y: auto;
            flex: 1;
        }

        .inbox-item {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-50);
            transition: all 0.2s ease;
            text-decoration: none;
            color: var(--text-dark);
            border-left: 4px solid transparent;
        }

        .inbox-item:hover {
            background-color: var(--gray-50);
            color: var(--text-dark);
        }

        .inbox-item.active {
            background-color: var(--light-green);
            border-left-color: var(--primary-green);
        }

        .avatar-container {
            position: relative;
            margin-right: 1rem;
        }

        .avatar-img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .status-dot {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #28a745;
            border: 2px solid white;
            border-radius: 50%;
        }

        /* Chat Area Styles */
        .chat-main {
            display: flex;
            flex-direction: column;
            height: 100%;
            background: #f0f2f5;
        }

        .chat-header {
            padding: 1rem 1.5rem;
            background: white;
            border-bottom: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.02);
            z-index: 10;
        }

        .messages-area {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            background-image: radial-gradient(#e1e8e1 1px, transparent 1px);
            background-size: 20px 20px;
        }

        .message-wrapper {
            display: flex;
            margin-bottom: 1rem;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .message-wrapper.own {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 18px;
            position: relative;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .message-wrapper.own .message-bubble {
            background: var(--primary-green);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-wrapper.other .message-bubble {
            background: white;
            color: var(--text-dark);
            border-bottom-left-radius: 4px;
        }

        .message-time {
            font-size: 0.7rem;
            margin-top: 4px;
            display: block;
            opacity: 0.8;
            text-align: right;
        }

        .message-sender {
            font-size: 0.75rem;
            color: var(--text-light);
            margin-bottom: 4px;
            margin-left: 12px;
        }

        /* Input Area */
        .chat-input-wrapper {
            background: white;
            padding: 1.25rem;
            border-top: 1px solid var(--gray-100);
        }

        .chat-input-group {
            background: var(--gray-50);
            border-radius: 24px;
            padding: 4px;
            border: 1px solid transparent;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .chat-input-group:focus-within {
            background: white;
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(31, 122, 45, 0.1);
        }

        .chat-input {
            border: none;
            background: transparent;
            padding: 10px 16px;
            flex: 1;
            outline: none;
        }

        .btn-attach {
            color: var(--text-light);
            padding: 8px 12px;
            border: none;
            background: transparent;
            transition: color 0.2s;
        }

        .btn-attach:hover {
            color: var(--primary-green);
        }

        .btn-send {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-green);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 8px;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(31, 122, 45, 0.3);
        }

        .btn-send:hover {
            background: var(--primary-green-2);
            transform: scale(1.05);
        }

        /* Scrollbar */
        .messages-area::-webkit-scrollbar {
            width: 6px;
        }

        .messages-area::-webkit-scrollbar-track {
            background: transparent;
        }

        .messages-area::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
        }

        .messages-area::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.2);
        }

        /* Image Preview */
        #image-preview {
            margin-bottom: 1rem;
            border: 1px solid var(--gray-100);
            border-radius: 12px;
            padding: 8px;
            background: var(--gray-50);
        }
    </style>

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

    <script>
        // Version: {{ time() }} - Force cache refresh
        document.addEventListener('DOMContentLoaded', function () {
            const messagesContainer = document.getElementById('messages-container');
            const messageInput = document.getElementById('message-input');
            const chatForm = document.getElementById('chat-form');
            const imageInput = document.getElementById('image-input');
            const imagePreview = document.getElementById('image-preview');
            const previewImg = document.getElementById('preview-img');
            const sendButton = document.getElementById('send-button');

            // Auto-scroll to bottom on page load
            scrollToBottom();

            // Scroll to bottom function
            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Handle form submission
            chatForm.addEventListener('submit', function (e) {
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

                fetch(chatUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            messageInput.value = '';
                            removeImage();

                            // Append the sent message to the view immediately
                            appendMessage(data.message, true); // true = isSelf
                            scrollToBottom();
                        } else {
                            console.log('Message not sent:', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });

            // Handle image selection
            imageInput.addEventListener('change', function (e) {
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
                    reader.onload = function (e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Remove image function
            window.removeImage = function () {
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
            window.openImageModal = function (imageSrc) {
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

                const wrapperDiv = document.createElement('div');
                wrapperDiv.className = `message-wrapper ${isSelf ? 'own' : 'other'}`;

                let messageContent = '';
                if (message.message) {
                    messageContent += `<div class="message-text">${message.message}</div>`;
                }
                if (message.image) {
                    messageContent += `<div class="message-image mt-2">
                                                    <img src="/storage/${message.image}" alt="Message image" class="img-fluid rounded shadow-sm" style="max-width: 250px; max-height: 250px; object-fit: cover; cursor: pointer;" onclick="openImageModal('/storage/${message.image}')">
                                                </div>`;
                }

                // Avatar for other user
                let avatarHtml = '';
                if (!isSelf) {
                    avatarHtml = `<img src="{{ $otherUser->avatar_url }}" class="rounded-circle me-2 align-self-end mb-1" style="width: 28px; height: 28px; object-fit: cover;">`;
                }

                wrapperDiv.innerHTML = `
                                                ${avatarHtml}
                                                <div class="message-bubble">
                                                    ${!isSelf ? `<div class="message-sender">${message.sender_name}</div>` : ''}
                                                    ${messageContent}
                                                    <span class="message-time">${message.created_at || new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                                                </div>
                                            `;

                messagesContainer.insertBefore(wrapperDiv, scrollAnchor);
            }

            // Listen for new messages using Laravel Echo
            console.log('Listening on channel: chat.{{ auth()->id() }}');

            window.Echo.private(`chat.{{ auth()->id() }}`)
                .listen('.message.sent', (data) => {
                    console.log('Message received:', data);
                    // Check if the message is from the user we are currently chatting with
                    if (parseInt(data.sender_id) === {{ $otherUser->id }}) {
                        appendMessage(data, false);
                        scrollToBottom();

                        // Optional: Mark as read via AJAX if window is focused
                    } else {
                        // Optional: Show notification for other users
                    }
                });

            // Handle Enter key
            messageInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatForm.dispatchEvent(new Event('submit'));
                }
            });

            // Auto-focus input
            messageInput.focus();

            // Drag and drop functionality
            const messageInputArea = document.querySelector('.chat-input-wrapper');

            if (messageInputArea) {
                messageInputArea.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    messageInputArea.style.backgroundColor = '#f8f9fa';
                    messageInputArea.style.borderTop = '2px dashed #007bff';
                });

                messageInputArea.addEventListener('dragleave', function (e) {
                    e.preventDefault();
                    messageInputArea.style.backgroundColor = '';
                    messageInputArea.style.borderTop = '';
                });

                messageInputArea.addEventListener('drop', function (e) {
                    e.preventDefault();
                    messageInputArea.style.backgroundColor = '';
                    messageInputArea.style.borderTop = '';

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
            }
        });
    </script>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.custom-sidebar');
            const toggleBtn = document.getElementById('studentSidebarToggle');
            if (toggleBtn && sidebar) {
                toggleBtn.addEventListener('click', function () {
                    if (window.innerWidth < 768) {
                        sidebar.classList.toggle('show');
                    }
                });
                document.addEventListener('click', function (e) {
                    if (window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        const clickInside = sidebar.contains(e.target) || toggleBtn.contains(e.target);
                        if (!clickInside) sidebar.classList.remove('show');
                    }
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape' && window.innerWidth < 768 && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
@endsection