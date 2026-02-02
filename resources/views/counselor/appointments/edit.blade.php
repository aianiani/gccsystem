@extends('layouts.app')

@section('content')
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

            /* Map to common names */
            --forest-green: var(--primary-green);
            --forest-green-dark: var(--primary-green-2);
            --forest-green-light: var(--accent-green);
            --forest-green-lighter: var(--light-green);
            --yellow-maize: var(--accent-orange);
            --yellow-maize-light: #fef9e7;
            --white: #ffffff;
            --gray-50: var(--bg-light);
            --gray-100: #eef6ee;
            --gray-200: #e9ecef;
            --gray-600: var(--text-light);
            --gray-800: #343a40;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
            --shadow-lg: 0 18px 50px rgba(0, 0, 0, 0.12);
            --hero-gradient: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-green-2) 100%);
        }

        .home-zoom {
            zoom: 75%;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top left;
                width: 133.33%;
            }
        }

        body {
            background: linear-gradient(180deg, #f6fbf6 0%, #ffffff 30%) !important;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .page-header {
            background: var(--hero-gradient);
            color: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow-lg);
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(60px);
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
            line-height: 1.1;
            color: var(--yellow-maize);
        }

        .edit-card {
            background: white;
            border-radius: 16px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--gray-100);
            overflow: hidden;
        }

        .edit-card-header {
            background: var(--forest-green-lighter);
            color: var(--forest-green);
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-100);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .edit-card-body {
            padding: 2rem;
        }

        .form-label {
            color: var(--forest-green);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid #ced4da;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 4px rgba(31, 122, 45, 0.1);
        }

        .student-info-box {
            background: var(--gray-50);
            border-radius: 12px;
            padding: 1rem;
            border: 1px solid var(--gray-100);
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .student-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: var(--hero-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.25rem;
        }

        .btn-primary-custom {
            background: var(--hero-gradient);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 6px rgba(31, 122, 45, 0.2);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(31, 122, 45, 0.3);
            color: white;
        }

        .btn-secondary-custom {
            background: white;
            border: 1px solid #ced4da;
            color: var(--text-dark);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-secondary-custom:hover {
            background: var(--gray-50);
            color: var(--text-dark);
            transform: translateY(-1px);
        }

        /* Sidebar integration */
        .main-dashboard-content {
            margin-left: 240px;
        }
    </style>

    <div class="d-flex home-zoom">
        @include('counselor.sidebar')

        <div class="main-dashboard-content flex-grow-1">
            <div class="container-fluid py-4">
                <div class="page-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h1 class="mb-2">
                                <i class="bi bi-calendar-check me-2"></i>
                                Reschedule Appointment
                            </h1>
                            <p class="mb-0 opacity-75">Update appointment details for {{ $appointment->student->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="edit-card">
                            <div class="edit-card-header">
                                <i class="bi bi-pencil-square fs-5"></i>
                                <span class="fs-5">Edit Details</span>
                            </div>
                            <div class="edit-card-body">
                                <form method="POST" action="{{ route('counselor.appointments.update', $appointment->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="mb-4">
                                        <label class="form-label">Student</label>
                                        <div class="student-info-box">
                                            <div class="student-avatar">
                                                {{ strtoupper(substr($appointment->student->name ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-bold">{{ $appointment->student->name }}</h6>
                                                <p class="mb-0 text-muted small">{{ $appointment->student->email }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @php
                                        $start = $appointment->scheduled_at;
                                        $availability = \App\Models\Availability::where('user_id', $appointment->counselor_id)
                                            ->where('start', $start)
                                            ->first();
                                        $end = $availability ? \Carbon\Carbon::parse($availability->end) : $start->copy()->addMinutes(30);
                                    @endphp

                                    <div class="mb-4">
                                        <label for="scheduled_at" class="form-label">Date & Time</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-end-0">
                                                <i class="bi bi-calendar-event text-success"></i>
                                            </span>
                                            <input type="datetime-local" name="scheduled_at" id="scheduled_at"
                                                class="form-control border-start-0 ps-0"
                                                value="{{ old('scheduled_at', $appointment->scheduled_at ? $appointment->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                                                required>
                                        </div>
                                        <div class="form-text text-muted mt-2">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Current Slot: <strong>{{ $start->format('M d, Y - g:i A') }}</strong> to
                                            <strong>{{ $end->format('g:i A') }}</strong>
                                        </div>
                                        @error('scheduled_at')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Nature of Problem</label>
                                        {{-- Use the list of options from the create view or a shared constant --}}
                                        <select name="nature_of_problem" class="form-control">
                                            @foreach(['Academic', 'Family', 'Personal / Emotional', 'Social', 'Psychological', 'Other'] as $option)
                                                <option value="{{ $option }}" {{ old('nature_of_problem', $appointment->nature_of_problem ?? '') == $option ? 'selected' : '' }}>
                                                    {{ $option }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label">Appointment Type</label>
                                        <select name="appointment_type" id="appointment_type" class="form-control"
                                            onchange="toggleReferralFields()">
                                            @foreach(['Walk-in', 'Called-in', 'Referral'] as $type)
                                                <option value="{{ $type }}" {{ old('appointment_type', $appointment->appointment_type ?? '') == $type ? 'selected' : '' }}>
                                                    {{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="referral_fields"
                                        style="display: {{ old('appointment_type', $appointment->appointment_type ?? '') === 'Referral' ? 'block' : 'none' }};">
                                        <div class="mb-4">
                                            <label class="form-label">Referrer Name</label>
                                            <input type="text" name="referrer_name" class="form-control"
                                                value="{{ old('referrer_name', $appointment->referrer_name ?? '') }}"
                                                placeholder="e.g. Prof. Cruz">
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label">Reason for Referral</label>
                                            <textarea name="referral_reason" class="form-control"
                                                rows="2">{{ old('referral_reason', $appointment->referral_reason ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea name="notes" id="notes" class="form-control" rows="4"
                                            placeholder="Add any notes about this rescheduling...">{{ old('notes', $appointment->notes) }}</textarea>
                                        @error('notes')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                                        <a href="{{ route('counselor.appointments.index') }}"
                                            class="btn btn-secondary-custom">
                                            Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary-custom">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        function toggleReferralFields() {
            const type = document.getElementById('appointment_type').value;
            const fields = document.getElementById('referral_fields');
            if (type === 'Referral') {
                fields.style.display = 'block';
            } else {
                fields.style.display = 'none';
            }
        }
    </script>
@endsection