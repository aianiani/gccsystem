@extends('layouts.app')

@section('content')
<style>
    :root {
        --forest-green: #2d5016;
        --forest-green-light: #4a7c59;
        --forest-green-lighter: #e8f5e8;
        --yellow-maize: #f4d03f;
        --yellow-maize-light: #fef9e7;
        --white: #ffffff;
        --gray-50: #f8f9fa;
        --gray-100: #f1f3f4;
        --gray-200: #e9ecef;
        --gray-600: #6c757d;
        --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    .page-header {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        color: white;
        border-radius: 20px;
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        box-shadow: var(--shadow-lg);
        text-align: center;
    }

    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .page-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .counselor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .counselor-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-100);
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .counselor-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
        border-color: var(--forest-green-light);
    }

    .counselor-header {
        background: linear-gradient(135deg, var(--forest-green-lighter) 0%, var(--yellow-maize-light) 100%);
        padding: 1.5rem;
        text-align: center;
        position: relative;
    }

    .counselor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--forest-green);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 2rem;
        margin: 0 auto 1rem;
        border: 4px solid white;
        box-shadow: var(--shadow-sm);
    }

    .counselor-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--forest-green);
        margin-bottom: 0.5rem;
    }

    .counselor-role {
        color: var(--gray-600);
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .status-indicator {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #28a745;
        border: 2px solid white;
        box-shadow: 0 0 0 2px var(--forest-green-lighter);
    }

    .counselor-body {
        padding: 1.5rem;
    }

    .counselor-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: var(--gray-50);
        border-radius: 8px;
    }

    .counselor-info i {
        color: var(--forest-green);
        font-size: 1.1rem;
        width: 20px;
    }

    .counselor-info span {
        color: var(--gray-600);
        font-size: 0.9rem;
    }

    .counselor-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: var(--gray-50);
        border-radius: 8px;
        border: 1px solid var(--gray-100);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--forest-green);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .chat-btn {
        background: linear-gradient(135deg, var(--forest-green) 0%, var(--forest-green-light) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        text-decoration: none;
    }

    .chat-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        color: white;
        text-decoration: none;
    }

    .chat-btn:active {
        transform: translateY(0);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--gray-600);
        background: var(--gray-50);
        border-radius: 16px;
        border: 2px dashed var(--gray-200);
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--gray-600);
        margin-bottom: 1.5rem;
        opacity: 0.5;
    }

    .empty-state h3 {
        color: var(--gray-600);
        margin-bottom: 1rem;
    }

    .back-btn {
        background: var(--forest-green);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
    }

    .back-btn:hover {
        background: var(--forest-green-light);
        color: white;
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 2rem;
        }

        .counselor-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .counselor-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid py-4">
    <div class="page-header">
        <h1>
            <i class="bi bi-chat-dots me-3"></i>
            Choose Your Counselor
        </h1>
        <p>Select a counselor to start a conversation and get the support you need</p>
    </div>

    <div class="container">
        <a href="{{ route('dashboard') }}" class="back-btn">
            <i class="bi bi-arrow-left"></i>
            Back to Dashboard
        </a>

        @if($counselors->count() > 0)
            <div class="counselor-grid">
        @foreach($counselors as $counselor)
                    <div class="counselor-card">
                        <div class="counselor-header">
                            <div class="status-indicator"></div>
                            @if($counselor->avatar)
                                <img src="{{ $counselor->avatar_url }}" 
                                     alt="Avatar" 
                                     class="counselor-avatar" 
                                     style="object-fit: cover;">
                            @else
                                <div class="counselor-avatar">
                                    {{ strtoupper(substr($counselor->name ?? 'C', 0, 1)) }}
                                </div>
                            @endif
                            <h3 class="counselor-name">{{ $counselor->name }}</h3>
                            <p class="counselor-role">Professional Counselor</p>
                        </div>
                        <div class="counselor-body">
                            <div class="counselor-info">
                                <i class="bi bi-envelope"></i>
                                <span>{{ $counselor->email }}</span>
                            </div>
                            
                            <div class="counselor-stats">
                                <div class="stat-item">
                                    <div class="stat-number">
                                        @php
                                            $completedSessions = \App\Models\Appointment::where('counselor_id', $counselor->id)
                                                ->where('status', 'completed')
                                                ->count();
                                        @endphp
                                        {{ $completedSessions }}
                                    </div>
                                    <div class="stat-label">Sessions</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">
                                        @php
                                            $avgRating = \App\Models\SessionFeedback::whereHas('appointment', function($q) use ($counselor) {
                                                $q->where('counselor_id', $counselor->id);
                                            })->avg('rating');
                                            $avgRating = $avgRating ? round($avgRating, 1) : 0;
                                        @endphp
                                        {{ $avgRating }}
                                    </div>
                                    <div class="stat-label">Rating</div>
                                </div>
                            </div>

                            <a href="{{ route('chat.index', $counselor->id) }}" class="chat-btn">
                                <i class="bi bi-chat-dots"></i>
                                Start Chat
                            </a>
                        </div>
                    </div>
        @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <h3>No Counselors Available</h3>
                <p class="mb-0">There are currently no counselors available for chat. Please check back later or contact support for assistance.</p>
            </div>
        @endif
    </div>
</div>
@endsection 