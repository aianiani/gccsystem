@extends('layouts.app')

@section('content')
<div class="home-zoom">
    @include('counselor.sidebar')
    <div class="main-dashboard-content">
        <div class="container py-4 assessment-summary-page" style="max-width: 1100px;">
    @php
        $studentName = $assessment->user->name ?? 'Student';
        $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($studentName) . '&background=0D8ABC&color=fff';
        
        // Initialize scores
        $scores = ['depression' => 0, 'anxiety' => 0, 'stress' => 0];
        $score_interpretation = [];
        
        // Get student answers
        $studentAnswers = [];
        if ($assessment->score) {
            if (is_array($assessment->score)) {
                $studentAnswers = $assessment->score;
            } elseif (is_string($assessment->score)) {
                $studentAnswers = json_decode($assessment->score, true) ?? [];
            }
        }
        
        if ($assessment->type === 'DASS-42') {
            // DASS-42 Scoring
            // Depression items: 3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42 (14 items)
            $depressionItems = [3, 5, 10, 13, 16, 17, 21, 24, 26, 31, 34, 37, 38, 42];
            // Anxiety items: 2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41 (14 items)
            $anxietyItems = [2, 4, 7, 9, 15, 19, 20, 23, 25, 28, 30, 36, 40, 41];
            // Stress items: 1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39 (14 items)
            $stressItems = [1, 6, 8, 11, 12, 14, 18, 22, 27, 29, 32, 33, 35, 39];
            
            // Calculate raw scores
            foreach ($depressionItems as $item) {
                $score = $studentAnswers[$item] ?? 0;
                $scores['depression'] += (int)$score;
            }
            foreach ($anxietyItems as $item) {
                $score = $studentAnswers[$item] ?? 0;
                $scores['anxiety'] += (int)$score;
            }
            foreach ($stressItems as $item) {
                $score = $studentAnswers[$item] ?? 0;
                $scores['stress'] += (int)$score;
            }
            
            // Multiply by 2 for DASS-42 scoring
            $scores['depression'] *= 2;
            $scores['anxiety'] *= 2;
            $scores['stress'] *= 2;
            
            // Interpretation based on DASS-42 thresholds
            // Depression thresholds: Normal 0-9, Mild 10-13, Moderate 14-20, Severe 21-27, Extremely Severe 28+
            if ($scores['depression'] <= 9) {
                $score_interpretation['depression'] = 'Normal';
            } elseif ($scores['depression'] <= 13) {
                $score_interpretation['depression'] = 'Mild';
            } elseif ($scores['depression'] <= 20) {
                $score_interpretation['depression'] = 'Moderate';
            } elseif ($scores['depression'] <= 27) {
                $score_interpretation['depression'] = 'Severe';
            } else {
                $score_interpretation['depression'] = 'Extremely Severe';
            }
            
            // Anxiety thresholds: Normal 0-7, Mild 8-9, Moderate 10-14, Severe 15-19, Extremely Severe 20+
            if ($scores['anxiety'] <= 7) {
                $score_interpretation['anxiety'] = 'Normal';
            } elseif ($scores['anxiety'] <= 9) {
                $score_interpretation['anxiety'] = 'Mild';
            } elseif ($scores['anxiety'] <= 14) {
                $score_interpretation['anxiety'] = 'Moderate';
            } elseif ($scores['anxiety'] <= 19) {
                $score_interpretation['anxiety'] = 'Severe';
            } else {
                $score_interpretation['anxiety'] = 'Extremely Severe';
            }
            
            // Stress thresholds: Normal 0-14, Mild 15-18, Moderate 19-25, Severe 26-33, Extremely Severe 34+
            if ($scores['stress'] <= 14) {
                $score_interpretation['stress'] = 'Normal';
            } elseif ($scores['stress'] <= 18) {
                $score_interpretation['stress'] = 'Mild';
            } elseif ($scores['stress'] <= 25) {
                $score_interpretation['stress'] = 'Moderate';
            } elseif ($scores['stress'] <= 33) {
                $score_interpretation['stress'] = 'Severe';
            } else {
                $score_interpretation['stress'] = 'Extremely Severe';
            }
            
            $max = 0; // Not used for DASS
            $total = 0;
        } elseif ($assessment->type === 'Academic Stress Survey') {
            $max = 45;
            $total = is_array($assessment->score) ? ($assessment->score['score'] ?? 0) : (is_numeric($assessment->score) ? $assessment->score : 0);
        } elseif ($assessment->type === 'Wellness Check') {
            $max = 36;
            $total = is_array($assessment->score) ? ($assessment->score['score'] ?? 0) : (is_numeric($assessment->score) ? $assessment->score : 0);
        } else {
            $max = 0;
            $total = 0;
        }
    @endphp
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="fw-bold mb-0 d-flex align-items-center gap-2 university-brand">
                <i class="bi bi-clipboard-data"></i> Assessment Summary
            </h2>
            <div class="d-flex gap-2">
                <a href="{{ route('counselor.assessments.index') }}" class="btn btn-outline-secondary shadow-sm"><i class="bi bi-arrow-left"></i> Back to List</a>
            </div>
        </div>

        {{-- College info removed from header to avoid duplication with hero card --}}

        @includeIf('counselor.assessments.partials.summary', ['assessment' => $assessment, 'scores' => $scores])
    </div>
</div>

<style>
    :root {
        --primary-green: #1f7a2d;
        --primary-green-2: #13601f;
        --accent-green: #2e7d32;
        --light-green: #eaf5ea;
        --accent-orange: #FFCB05;
        --text-dark: #16321f;
        --text-light: #6c757d;
        --bg-light: #f6fbf6;
        --shadow: 0 10px 30px rgba(0,0,0,0.08);
        --forest-green: var(--primary-green);
        --forest-green-dark: var(--primary-green-2);
        --forest-green-light: var(--accent-green);
        --forest-green-lighter: var(--light-green);
        --yellow-maize: var(--accent-orange);
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
    
    .home-zoom {
        zoom: 0.85;
    }
    @supports not (zoom: 1) {
        .home-zoom {
            transform: scale(0.85);
            transform-origin: top center;
        }
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
        box-shadow: 2px 0 18px rgba(0,0,0,0.08);
        overflow-y: auto;
        padding-bottom: 1rem;
    }
    
    .main-dashboard-content {
        background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%);
        min-height: 100vh;
        padding: 1rem 1.5rem;
        margin-left: 240px;
        transition: margin-left 0.2s;
    }
    
    .assessment-summary-page { max-width: 1100px; }
    .university-brand { color: #237728; letter-spacing: 1px; font-weight: 700; }
    .card { border-radius: 1rem; box-shadow: 0 8px 30px rgba(14,56,20,0.06); }
    .card-header { background: linear-gradient(90deg, rgba(35,119,40,0.08), rgba(35,119,40,0.02)); border-bottom: none; color: #1f7a2d; font-weight: 700; }
    h2, h3, .fw-bold { color: #1f7a2d; }
    
    .nav-tabs { border-bottom: 1px solid #e0e0e0; }
    .nav-tabs .nav-link {
        color: #666;
        padding: 0.75rem 1rem;
        font-weight: 600;
        border: none !important;
        border-bottom: 3px solid transparent !important;
        background: transparent;
        transition: all 0.3s ease;
    }
    .nav-tabs .nav-link:hover {
        color: #1f7a2d;
        border-bottom-color: rgba(31, 122, 45, 0.3) !important;
    }
    .nav-tabs .nav-link.active {
        background: transparent;
        border-bottom: 3px solid #1f7a2d !important;
        color: #1f7a2d;
    }
    
    .tab-content > .tab-pane { min-height: 220px; }
    .assessment-summary-page .avatar-large { width: 96px; height: 96px; }
    .card .progress { background: #eef7ee; height: 12px; border-radius: 8px; }
    .progress-bar { border-radius: 8px; }
    .score-badge { font-size: 0.95rem; padding: 0.45rem 0.6rem; }
    .badge.bg-primary { background-color: #237728 !important; }
    .badge.bg-danger { background-color: #d9534f !important; }
    .btn-outline-primary { border-color: rgba(35,119,40,0.15); color: #235; }
    .table thead th { background: #f6fbf6; color: #1f7a2d; font-weight:700; }
    .table td, .table th { padding: 0.75rem; vertical-align: middle; }
    .dass-score-sheet { border-radius: 0.6rem; overflow: hidden; }
    @media (max-width: 900px) { .assessment-summary-page { max-width: 100%; padding-left: 12px; padding-right: 12px; } .avatar-large { width: 72px; height: 72px; } .nav-tabs .nav-link { padding: 0.45rem 0.6rem; font-size: 0.95rem; } }
</style>

@endsection