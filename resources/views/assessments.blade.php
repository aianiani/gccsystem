@extends('layouts.app')

@section('content')
    <style>
        /* Homepage theme variables */
        :root {
            --primary-green: #1f7a2d;
            --forest-green: var(--primary-green);
        }

        .home-zoom {
            zoom: 0.85;
        }

        .assessment-header {
            color: #2d5016;
            font-weight: 700;
            font-size: 1.75rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .assessment-subtitle {
            color: #3d5c2d;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .assessment-cards-row {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .assessment-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
            padding: 1.5rem 1.25rem;
            width: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
            transition: box-shadow 0.2s;
            position: relative;
        }

        .assessment-card:hover {
            box-shadow: 0 8px 32px rgba(44, 80, 22, 0.13);
        }

        /* Year badge to guide students */
        .year-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .badge-1st {
            background: #e3f2fd;
            color: #0d47a1;
        }

        .badge-2nd {
            background: #e8f5e9;
            color: #1b5e20;
        }

        .badge-3rd {
            background: #fff3e0;
            color: #e65100;
        }

        .badge-4th {
            background: #f3e5f5;
            color: #4a148c;
        }

        .assessment-icon {
            font-size: 2rem;
            color: #2d5016;
            margin-bottom: 0.75rem;
        }

        .assessment-title {
            font-size: 1.15rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            text-align: center;
        }

        .assessment-desc {
            color: #3d5c2d;
            font-size: 1rem;
            margin-bottom: 1rem;
            text-align: center;
            min-height: 3rem;
            /* Align buttons */
        }

        .assessment-btn {
            background: #2d9a36;
            color: #fff;
            font-weight: 700;
            font-size: 1rem;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 0;
            width: 100%;
            margin-top: auto;
            transition: background 0.2s;
        }

        .assessment-btn:hover {
            background: #237728;
            color: #fff;
        }

        /* Form container styles */
        .assessment-form-container {
            display: none;
            /* hidden by default */
            max-width: 700px;
            margin: 0 auto;
        }

        .form-card {
            background: #f8f9fa;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
            overflow: hidden;
        }

        .form-header {
            position: sticky;
            top: 0;
            z-index: 10;
            background: #f8f9fa;
            padding: 1.5rem;
            border-bottom: 1px solid #e0e0e0;
        }

        .question-item {
            background: #fff;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid #e0e0e0;
        }

        .option-radio {
            display: flex;
            align-items: center;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .option-radio:hover {
            background: #f1f8e9;
        }

        .option-radio input {
            margin-right: 10px;
            transform: scale(1.2);
        }
    </style>

    <div class="home-zoom">
        <div class="d-flex">
            <!-- Sidebar (Simplified for brevity, assuming existing sidebar structure is handled by layout/include if not, use the previous one) -->
            <div class="custom-sidebar d-none d-md-block">
                <!-- reusing existing sidebar structure/styles from previous file view -->
                <div class="sidebar-logo mb-4">
                    <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo"
                        style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 0.75rem auto; display: block;">
                    <h3 style="text-align:center; font-size: 1.1rem; color: #f4d03f;">CMU Guidance</h3>
                </div>
                <nav class="sidebar-nav flex-grow-1">
                    <a href="{{ route('profile') }}"
                        class="sidebar-link{{ request()->routeIs('profile') ? ' active' : '' }}"><i
                            class="bi bi-person"></i> Profile</a>
                    <a href="{{ route('dashboard') }}"
                        class="sidebar-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i
                            class="bi bi-house-door"></i> Dashboard</a>
                    <a href="{{ route('appointments.index') }}" class="sidebar-link"><i class="bi bi-calendar-check"></i>
                        Appointments</a>
                    <a href="{{ route('assessments.index') }}" class="sidebar-link active"><i
                            class="bi bi-clipboard-data"></i> Assessments</a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="main-dashboard-content flex-grow-1" id="mainContent">
                <div class="container py-1">
                    <div class="assessment-header">Student Assessments</div>
                    <div class="assessment-subtitle">
                        Select the assessment corresponding to your year level.
                    </div>

                    <!-- Card Selection Grid -->
                    <div class="assessment-cards-row" id="assessment-cards">

                        <!-- 1st Year: GRIT -->
                        <div class="assessment-card">
                            <span class="year-badge badge-1st">1st Year</span>
                            <div class="assessment-icon"><i class="bi bi-lightning-charge"></i></div>
                            <div class="assessment-title">GRIT Scale</div>
                            <div class="assessment-desc">Measure your passion and perseverance for long-term goals.</div>
                            <button class="assessment-btn" onclick="openAssessment('grit')">START GRIT TEST</button>
                        </div>

                        <!-- 2nd Year: DASS-42 -->
                        <!-- Redirects to dedicated page -->
                        <div class="assessment-card">
                            <span class="year-badge badge-2nd">2nd Year</span>
                            <div class="assessment-icon"><i class="bi bi-activity"></i></div>
                            <div class="assessment-title">DASS-42</div>
                            <div class="assessment-desc">Depression, Anxiety, and Stress Scale assessment.</div>
                            <a href="{{ route('assessments.dass42') }}"
                                class="assessment-btn text-decoration-none text-center">START DASS-42</a>
                        </div>

                        <!-- 3rd Year: NEO -->
                        <div class="assessment-card">
                            <span class="year-badge badge-3rd">3rd Year</span>
                            <div class="assessment-icon"><i class="bi bi-person-lines-fill"></i></div>
                            <div class="assessment-title">NEO Personality</div>
                            <div class="assessment-desc">Understand your personality traits (Big Five).</div>
                            <button class="assessment-btn" onclick="openAssessment('neo')">START NEO TEST</button>
                        </div>

                        <!-- 4th Year: WVI -->
                        <div class="assessment-card">
                            <span class="year-badge badge-4th">4th Year</span>
                            <div class="assessment-icon"><i class="bi bi-briefcase"></i></div>
                            <div class="assessment-title">Work Values</div>
                            <div class="assessment-desc">Identify what matters most to you in your career.</div>
                            <button class="assessment-btn" onclick="openAssessment('wvi')">START WVI TEST</button>
                        </div>

                    </div>

                    <!-- FORMS (Hidden by default) -->

                    <!-- GRIT FORM -->
                    <div id="grit-form-container" class="assessment-form-container">
                        <form method="POST" action="{{ route('assessments.grit.submit') }}" class="form-card">
                            @csrf
                            <div class="form-header text-center">
                                <h3>GRIT Scale</h3>
                                <p class="text-muted mb-0">Please respond to the following statements truthfully.</p>
                            </div>
                            <div class="p-4">
                                @foreach($grit_questions as $idx => $q)
                                    <div class="question-item">
                                        <p class="fw-bold mb-3">{{ $idx + 1 }}. {{ $q }}</p>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach(['Not at all like me', 'Not much like me', 'Somewhat like me', 'Mostly like me', 'Very much like me'] as $key => $label)
                                                <label class="option-radio">
                                                    <input type="radio" name="grit_answers[{{ $idx }}]" value="{{ $key + 1 }}"
                                                        required>
                                                    {{ $label }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <label class="form-label mt-3">Comments (Optional)</label>
                                <textarea class="form-control mb-4" name="student_comment" rows="2"></textarea>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="closeAssessment()">Cancel</button>
                                    <button type="submit" class="btn btn-success px-5">Submit GRIT Scale</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- NEO FORM -->
                    <div id="neo-form-container" class="assessment-form-container">
                        <form method="POST" action="{{ route('assessments.neo.submit') }}" class="form-card">
                            @csrf
                            <div class="form-header text-center">
                                <h3>NEO Personality Inventory</h3>
                                <p class="text-muted mb-0">Rate how accurately each statement describes you.</p>
                            </div>
                            <div class="p-4">
                                @foreach($neo_questions as $idx => $q)
                                    <div class="question-item">
                                        <p class="fw-bold mb-3">{{ $idx + 1 }}. {{ $q }}</p>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach(['Strongly Disagree', 'Disagree', 'Neutral', 'Agree', 'Strongly Agree'] as $key => $label)
                                                <label class="option-radio">
                                                    <input type="radio" name="neo_answers[{{ $idx }}]" value="{{ $key + 1 }}"
                                                        required>
                                                    {{ $label }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <label class="form-label mt-3">Comments (Optional)</label>
                                <textarea class="form-control mb-4" name="student_comment" rows="2"></textarea>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="closeAssessment()">Cancel</button>
                                    <button type="submit" class="btn btn-success px-5">Submit NEO Test</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- WVI FORM -->
                    <div id="wvi-form-container" class="assessment-form-container">
                        <form method="POST" action="{{ route('assessments.wvi.submit') }}" class="form-card">
                            @csrf
                            <div class="form-header text-center">
                                <h3>Work Values Inventory (WVI)</h3>
                                <p class="text-muted mb-0">How important are these values to you in your career?</p>
                            </div>
                            <div class="p-4">
                                @foreach($wvi_questions as $idx => $q)
                                    <div class="question-item">
                                        <p class="fw-bold mb-3">{{ $idx + 1 }}. {{ $q }}</p>
                                        <div class="d-flex flex-wrap gap-3">
                                            @foreach(['Unimportant', 'Of Little Importance', 'Moderately Important', 'Important', 'Very Important'] as $key => $label)
                                                <label class="option-radio">
                                                    <input type="radio" name="wvi_answers[{{ $idx }}]" value="{{ $key + 1 }}"
                                                        required>
                                                    {{ $label }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <label class="form-label mt-3">Comments (Optional)</label>
                                <textarea class="form-control mb-4" name="student_comment" rows="2"></textarea>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="closeAssessment()">Cancel</button>
                                    <button type="submit" class="btn btn-success px-5">Submit WVI</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if(session('show_thank_you'))
        <div class="modal fade show" id="thankYouModal" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);"
            aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title w-100 text-center">Assessment Completed</h5>
                    </div>
                    <div class="modal-body text-center">
                        <p class="mb-4">Thank you for completing the <strong>{{ session('last_assessment_type') }}</strong>.</p>
                        <p class="text-muted small mb-4">Your results have been submitted to the guidance counselor review.</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-success px-4">Back to Dashboard</a>
                        <button type="button" class="btn btn-outline-secondary px-4 ms-2"
                            onclick="document.getElementById('thankYouModal').style.display='none'">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        function openAssessment(type) {
            document.getElementById('assessment-cards').style.display = 'none';
            // Hide all forms first
            document.querySelectorAll('.assessment-form-container').forEach(el => el.style.display = 'none');
            // Show selected form
            document.getElementById(type + '-form-container').style.display = 'block';
            window.scrollTo(0, 0);
        }

        function closeAssessment() {
            document.querySelectorAll('.assessment-form-container').forEach(el => el.style.display = 'none');
            document.getElementById('assessment-cards').style.display = 'flex';
        }
    </script>
@endsection