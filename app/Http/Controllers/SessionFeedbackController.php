<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\SessionFeedback;
use Illuminate\Http\Request;

class SessionFeedbackController extends Controller
{
    // Show feedback form for a specific appointment
    public function create($appointmentId)
    {
        if (auth()->user()->role !== 'student') {
            return redirect()->back()->with('error', 'Access denied.');
        }

        $appointment = Appointment::where('student_id', auth()->id())
            ->where('id', $appointmentId)
            ->where('status', 'completed')
            ->with(['counselor', 'sessionNotes'])
            ->firstOrFail();

        // Check if feedback already exists
        $existingFeedback = SessionFeedback::where('appointment_id', $appointmentId)->first();

        if ($existingFeedback) {
            return redirect()->route('appointments.completedWithNotes')
                ->with('info', 'You have already provided feedback for this session.');
        }

        // Calculate session number (count of completed appointments for this student up to this one)
        $sessionNumber = Appointment::where('student_id', auth()->id())
            ->where('status', 'completed')
            ->where('scheduled_at', '<=', $appointment->scheduled_at)
            ->count();

        return view('session-feedback.create', compact('appointment', 'sessionNumber'));
    }

    // Store feedback for a specific appointment
    public function store(Request $request, $appointmentId)
    {
        if (auth()->user()->role !== 'student') {
            return redirect()->back()->with('error', 'Access denied.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'required|string|max:1000',
        ]);

        // Check if appointment exists and belongs to the student
        $appointment = Appointment::where('student_id', auth()->id())
            ->where('id', $appointmentId)
            ->where('status', 'completed')
            ->firstOrFail();

        // Check if feedback already exists
        $existingFeedback = SessionFeedback::where('appointment_id', $appointmentId)->first();
        if ($existingFeedback) {
            return redirect()->route('appointments.completedWithNotes')
                ->with('error', 'You have already provided feedback for this session.');
        }

        // Create the feedback
        SessionFeedback::create([
            'appointment_id' => $appointmentId,
            'rating' => $request->rating,
            'comments' => $request->comments,
            'reviewed_by_counselor' => false,
        ]);

        return redirect()->route('appointments.completedWithNotes')
            ->with('success', 'Thank you for your feedback! Your counselor will review it.');
    }

    // Show feedback details for counselors and admins
    public function show($feedbackId)
    {
        if (auth()->user()->isAdmin()) {
            // Admins can view any feedback
            $feedback = SessionFeedback::with(['appointment.student', 'appointment.counselor', 'appointment.sessionNotes'])
                ->findOrFail($feedbackId);
        } else {
            // Counselors can only view their own feedback
            if (auth()->user()->role !== 'counselor') {
                return redirect()->back()->with('error', 'Access denied.');
            }

            $feedback = SessionFeedback::whereHas('appointment', function ($query) {
                $query->where('counselor_id', auth()->id());
            })
                ->with(['appointment.student', 'appointment.sessionNotes'])
                ->findOrFail($feedbackId);
        }

        // Calculate session number for the student up to this appointment
        $sessionNumber = Appointment::where('student_id', $feedback->appointment->student_id)
            ->where('status', 'completed')
            ->where('scheduled_at', '<=', $feedback->appointment->scheduled_at)
            ->count();

        return view('session-feedback.show', compact('feedback', 'sessionNumber'));
    }

    // List all feedback for the counselor
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'counselor') {
            return redirect()->back()->with('error', 'Access denied.');
        }

        $query = SessionFeedback::whereHas('appointment', function ($query) {
            $query->where('counselor_id', auth()->id());
        })->with(['appointment.student']);

        // Filter by student name
        if ($request->filled('student')) {
            $query->whereHas('appointment.student', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->student . '%');
            });
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Standardized per_page
        $perPage = (int) $request->input('per_page', 10);
        $perPage = in_array($perPage, [10, 20, 30, 50, 100]) ? $perPage : 10;

        $feedbacks = $query->latest()
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('counselor.feedback.index', compact('feedbacks'));
    }

    // Bulk Delete Feedback
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:session_feedback,id'
        ]);

        $ids = $request->ids;

        // Ensure counselor only deletes feedback for THEIR appointments
        SessionFeedback::whereIn('id', $ids)
            ->whereHas('appointment', function ($q) {
                $q->where('counselor_id', auth()->id());
            })->delete();

        return redirect()->back()->with('success', count($ids) . ' feedback entries deleted successfully.');
    }
}