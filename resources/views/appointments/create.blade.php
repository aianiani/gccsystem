@extends('layouts.app')

@section('content')
<div class="scheduler-container">
    <!-- Back Button -->
    <div class="back-button-container" style="margin-bottom: 1rem;">
        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary back-btn" style="display: inline-flex; align-items: center;">
            <i class="bi bi-arrow-left" style="margin-right: 0.5rem;"></i>
            Back to Dashboard
        </a>
    </div>
    
    <!-- Progress Header -->
    <div class="scheduler-header">
        <h2><i class="bi bi-calendar-plus me-2"></i>Schedule Your Counseling Session</h2>
        <div class="scheduler-nav">
            <button class="nav-step active" data-step="1">
                <i class="bi bi-person-badge"></i>
                Select Counselor
            </button>
            <button class="nav-step" data-step="2">
                <i class="bi bi-calendar-alt"></i>
                Select Date
            </button>
            <button class="nav-step" data-step="3">
                <i class="bi bi-clock"></i>
                Select Time
            </button>
            <button class="nav-step" data-step="4">
                <i class="bi bi-check-circle"></i>
                Confirm
            </button>
        </div>
    </div>

    <!-- Step 1: Counselor Selection -->
    <div class="step-content" id="step-1" style="display: block;">
        <div class="counselor-selection-wrapper">
            <div class="counselor-selection-header">
                <h3>Select Your Counselor</h3>
                <p>Choose a counselor to view their available dates and times</p>
            </div>
            <div class="counselor-grid">
                @foreach($counselors as $counselor)
                <div class="counselor-card" data-counselor-id="{{ $counselor->id }}">
                    <div class="counselor-avatar">
                        <img src="{{ $counselor->avatar_url ?? 'https://via.placeholder.com/80x80/228B22/FFFFFF?text=' . substr($counselor->name, 0, 2) }}" alt="{{ $counselor->name }}">
                    </div>
                    <div class="counselor-info">
                        <h4>{{ $counselor->name }}</h4>
                        <p class="specialization">{{ $counselor->specialization ?? 'General Counseling' }}</p>
                        <div class="counselor-stats">
                            <span class="stat">
                                <i class="bi bi-star-fill"></i>
                                4.8
                            </span>
                            <span class="stat">
                                <i class="bi bi-people"></i>
                                150+ sessions
                            </span>
                        </div>
                    </div>
                    <div class="counselor-select">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Step 2: Date Selection -->
    <div class="step-content" id="step-2" style="display: none;">
        <div class="calendar-wrapper">
            <div class="calendar-header">
                <h3>Select Date</h3>
                <p>Choose a date for your appointment</p>
            </div>
            <div class="calendar-container">
                <div class="calendar-nav">
                    <button class="calendar-nav-btn" id="prevMonth">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <h4 id="currentMonth">July 2025</h4>
                    <button class="calendar-nav-btn" id="nextMonth">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
                <div class="calendar-grid">
                    <div class="calendar-weekdays">
                        <div>Sun</div>
                        <div>Mon</div>
                        <div>Tue</div>
                        <div>Wed</div>
                        <div>Thu</div>
                        <div>Fri</div>
                        <div>Sat</div>
                    </div>
                    <div class="calendar-days" id="calendarDays">
                        <!-- Calendar days will be generated here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Step 3: Time Selection -->
    <div class="step-content" id="step-3" style="display: none;">
        <div class="time-slots-wrapper">
            <div class="time-slots-header">
                <div class="time-slots-title">Available Time Slots</div>
                <div class="selected-counselor-info">
                    <i class="bi bi-person-badge me-2"></i>
                    <span id="selectedCounselorName">Select a counselor</span>
                    <span class="selected-date" id="selectedDate"></span>
                </div>
            </div>
            <div class="time-slots-grid" id="timeSlotsGrid">
                <!-- Time slots will be loaded here -->
            </div>
            <div class="time-slots-loading" id="timeSlotsLoading" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Loading available time slots...</p>
            </div>
        </div>
    </div>

    <!-- Step 4: Confirmation -->
    <div class="step-content" id="step-4" style="display: none;">
        <div class="appointment-summary">
            <div class="summary-header">
                <div class="summary-title">Appointment Summary</div>
                <button class="btn-outline" id="editAppointment" type="button">
                    <i class="bi bi-pencil"></i>
                    Edit
                </button>
            </div>
            <div class="summary-details">
                <div class="summary-item">
                    <i class="bi bi-calendar"></i>
                    <div>
                        <div class="label">Date</div>
                        <div class="value" id="summaryDate">Select a date</div>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="bi bi-clock"></i>
                    <div>
                        <div class="label">Time</div>
                        <div class="value" id="summaryTime">Select a time</div>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="bi bi-person-badge"></i>
                    <div>
                        <div class="label">Counselor</div>
                        <div class="value" id="summaryCounselor">Select a counselor</div>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="bi bi-info-circle"></i>
                    <div>
                        <div class="label">Session Type</div>
                        <select id="appointmentType" class="form-select">
                            <option value="Initial Consultation">Initial Consultation</option>
                            <option value="Follow-up Session">Follow-up Session</option>
                            <option value="Emergency Session">Emergency Session</option>
                            <option value="Regular Check-in">Regular Check-in</option>
                        </select>
                    </div>
                </div>
                <div class="summary-item">
                    <i class="bi bi-journal-text"></i>
                    <div>
                        <div class="label">Notes (Optional)</div>
                        <textarea id="appointmentNotes" class="form-control" rows="3" 
                            placeholder="Any specific concerns or topics you'd like to discuss..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="appointmentConfirmModal" tabindex="-1" aria-labelledby="appointmentConfirmModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="appointmentConfirmModalLabel">Confirm Appointment Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <ul class="list-group">
              <li class="list-group-item"><strong>Counselor:</strong> <span id="modalCounselor"></span></li>
              <li class="list-group-item"><strong>Date:</strong> <span id="modalDate"></span></li>
              <li class="list-group-item"><strong>Time:</strong> <span id="modalTime"></span></li>
              <li class="list-group-item"><strong>Session Type:</strong> <span id="modalType"></span></li>
              <li class="list-group-item"><strong>Notes:</strong> <span id="modalNotes"></span></li>
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-primary" id="confirmSubmitAppointment">Confirm & Submit</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="scheduler-actions">
        <button class="btn btn-outline" id="backButton" type="button">
            <i class="bi bi-arrow-left"></i>
            Back
        </button>
        <button class="btn btn-primary" id="nextButton" type="button">
            <span id="nextButtonText">Next</span>
            <i class="bi bi-arrow-right" id="nextButtonIcon"></i>
        </button>
    </div>
</div>

<!-- Hidden form for submission -->
<form action="{{ route('appointments.store') }}" method="POST" id="appointment-form" style="display: none;">
    @csrf
    <input type="hidden" name="counselor_id" id="formCounselorId">
    <input type="hidden" name="scheduled_at" id="formScheduledAt">
    <input type="hidden" name="notes" id="formNotes">
</form>

<style>
    :root {
        --forest-green: #228B22;
        --forest-green-light: #32CD32;
        --forest-green-dark: #006400;
        --yellow-maize: #FFDB58;
        --yellow-maize-light: #FFF8DC;
        --yellow-maize-dark: #DAA520;
        --white: #FFFFFF;
        --light-gray: #F8F9FA;
        --text-dark: #2C3E50;
        --success: #28a745;
        --warning: #ffc107;
        --danger: #dc3545;
        --info: #17a2b8;
        --border-color: #e9ecef;
    }

    .scheduler-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
        background: var(--light-gray);
        min-height: 100vh;
    }

    /* Header Styles */
    .scheduler-header {
        background: var(--white);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .scheduler-header h2 {
        color: var(--forest-green);
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 1.8rem;
    }

    .scheduler-nav {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .nav-step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: 2px solid var(--border-color);
        background: var(--white);
        color: var(--text-dark);
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .nav-step.active {
        background: var(--forest-green);
        color: var(--white);
        border-color: var(--forest-green);
    }

    .nav-step:hover:not(.active) {
        border-color: var(--forest-green);
        color: var(--forest-green);
    }

    /* Step Content Styles */
    .step-content {
        background: var(--white);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    /* Counselor Selection Styles */
    .counselor-selection-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .counselor-selection-header h3 {
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .counselor-selection-header p {
        color: #6c757d;
        margin: 0;
    }

    .counselor-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .counselor-card {
        display: flex;
        align-items: center;
        padding: 1.5rem;
        border: 2px solid var(--border-color);
        border-radius: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    .counselor-card:hover {
        border-color: var(--forest-green);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    }

    .counselor-card.selected {
        border-color: var(--forest-green);
        background: linear-gradient(135deg, #f8fff8 0%, #f0fff0 100%);
    }

    .counselor-avatar {
        margin-right: 1rem;
    }

    .counselor-avatar img {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--forest-green);
    }

    .counselor-info {
        flex: 1;
    }

    .counselor-info h4 {
        margin: 0 0 0.25rem 0;
        color: var(--text-dark);
        font-weight: 600;
    }

    .specialization {
        color: #6c757d;
        margin: 0 0 0.5rem 0;
        font-size: 0.9rem;
    }

    .counselor-stats {
        display: flex;
        gap: 1rem;
    }

    .stat {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.8rem;
        color: #6c757d;
    }

    .stat i {
        color: var(--yellow-maize);
    }

    .counselor-select {
        position: absolute;
        top: 1rem;
        right: 1rem;
        color: var(--forest-green);
        font-size: 1.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .counselor-card.selected .counselor-select {
        opacity: 1;
    }

    /* Calendar Styles */
    .calendar-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .calendar-header h3 {
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .calendar-header p {
        color: #6c757d;
        margin: 0;
    }

    .calendar-container {
        max-width: 500px;
        margin: 0 auto;
    }

    .calendar-nav {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--light-gray);
        border-radius: 10px;
    }

    .calendar-nav h4 {
        margin: 0;
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
        min-width: 150px;
        text-align: center;
    }

    .calendar-nav-btn {
        background: var(--white);
        border: 2px solid var(--forest-green);
        font-size: 1.2rem;
        color: var(--forest-green);
        cursor: pointer;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-weight: 600;
        min-width: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .calendar-nav-btn:hover {
        background: var(--forest-green);
        color: var(--white);
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(34, 139, 34, 0.2);
    }

    .calendar-nav-btn:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(34, 139, 34, 0.2);
    }

    .calendar-grid {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        overflow: hidden;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background: var(--forest-green);
        color: var(--white);
        font-weight: 600;
        text-align: center;
        padding: 0.75rem 0;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background: var(--white);
    }

    .calendar-day {
        padding: 1rem 0.5rem;
        text-align: center;
        cursor: pointer;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
    }

    .calendar-day:hover {
        background: var(--light-gray);
    }

    .calendar-day.available {
        background: var(--yellow-maize-light);
        color: var(--text-dark);
    }

    .calendar-day.selected {
        background: var(--forest-green);
        color: var(--white);
    }

    .calendar-day.disabled {
        color: #ccc;
        cursor: not-allowed;
    }

    /* Time Slots Styles */
    .time-slots-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .time-slots-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .selected-counselor-info {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .time-slots-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
    }

    .time-slot {
        padding: 1rem;
        border: 2px solid var(--border-color);
        border-radius: 10px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--white);
    }

    .time-slot:hover {
        border-color: var(--forest-green);
        transform: translateY(-2px);
    }

    .time-slot.selected {
        background: var(--forest-green);
        color: var(--white);
        border-color: var(--forest-green);
    }

    .time-slot.disabled {
        background: #f8f9fa;
        color: #ccc;
        cursor: not-allowed;
    }

    /* Summary Styles */
    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--border-color);
    }

    .summary-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .summary-details {
        display: grid;
        gap: 1.5rem;
    }

    .summary-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        background: var(--light-gray);
    }

    .summary-item i {
        color: var(--forest-green);
        font-size: 1.2rem;
        margin-top: 0.25rem;
    }

    .summary-item .label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .summary-item .value {
        color: #6c757d;
    }

    /* Loading States */
    .time-slots-loading {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .spinner-border {
        width: 2rem;
        height: 2rem;
        margin-bottom: 1rem;
    }

    /* Action Buttons */
    .scheduler-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 0;
    }

    .btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-outline {
        background: var(--white);
        color: var(--forest-green);
        border: 2px solid var(--forest-green);
    }

    .btn-outline:hover {
        background: var(--forest-green);
        color: var(--white);
    }

    .btn-primary {
        background: var(--forest-green);
        color: var(--white);
    }

    .btn-primary:hover {
        background: var(--forest-green-dark);
        transform: translateY(-1px);
    }

    .btn-primary:disabled {
        background: #6c757d;
        cursor: not-allowed;
        transform: none;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .scheduler-container {
            padding: 1rem;
        }
        
        .scheduler-nav {
            flex-direction: column;
        }
        
        .counselor-grid {
            grid-template-columns: 1fr;
        }
        
        .time-slots-grid {
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        }
        
        .scheduler-actions {
            flex-direction: column;
            gap: 1rem;
        }
    }
</style>

<script>
// Make these variables global
let selectedCounselor = null;
let selectedDate = null;
let selectedTime = null;
let selectedSlot = null; // Store the full slot object

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM Content Loaded - Appointment Scheduler');
    
    let currentStep = 1;
    
    // Simple step navigation
    function showStep(step) {
        console.log('Showing step:', step);
        
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(el => {
            el.style.display = 'none';
        });
        
        // Show the target step
        const stepElement = document.getElementById(`step-${step}`);
        if (stepElement) {
            stepElement.style.display = 'block';
            console.log('Step element displayed');
        }
        
        // Update navigation
        document.querySelectorAll('.nav-step').forEach(el => {
            el.classList.remove('active');
        });
        
        const navStep = document.querySelector(`[data-step="${step}"]`);
        if (navStep) {
            navStep.classList.add('active');
        }
        
        currentStep = step;
        updateButtons();
        updateActionButtonsForStep(step); // Call the new function here
    }
    
    function updateButtons() {
        const backBtn = document.getElementById('backButton');
        const nextBtn = document.getElementById('nextButton');
        
        if (backBtn) {
            backBtn.style.display = currentStep === 1 ? 'none' : 'block';
        }
        
        if (nextBtn) {
            nextBtn.disabled = !canProceed();
        }
    }
    
    function canProceed() {
        switch(currentStep) {
            case 1: return selectedCounselor !== null;
            case 2: return selectedDate !== null;
            case 3: return selectedTime !== null;
            case 4: return true;
            default: return false;
        }
    }
    
    // Counselor selection
    console.log('Setting up counselor selection...');
    const counselorCards = document.querySelectorAll('.counselor-card');
    console.log('Found counselor cards:', counselorCards.length);
    
    counselorCards.forEach((card, index) => {
        console.log(`Setting up card ${index}:`, card);
        
        card.addEventListener('click', function(e) {
            console.log('Counselor card clicked!');
            alert('Counselor card clicked!'); // Test alert
            
            e.preventDefault();
            e.stopPropagation();
            
            // Remove selection from all cards
            document.querySelectorAll('.counselor-card').forEach(c => {
                c.classList.remove('selected');
            });
            
            // Select this card
            this.classList.add('selected');
            
            // Store counselor data
            selectedCounselor = {
                id: this.dataset.counselorId,
                name: this.querySelector('h4').textContent
            };
            
            console.log('Selected counselor:', selectedCounselor);
            
            // Update counselor info immediately
            updateCounselorInfo();
            
            // Proceed to next step and load available dates
            showStep(2);
            loadAvailableDates();
            updateButtons();
        });
    });
    
    // Navigation buttons
    const backButton = document.getElementById('backButton');
    const nextButton = document.getElementById('nextButton');
    
    if (backButton) {
        backButton.addEventListener('click', function() {
            console.log('Back button clicked');
            if (currentStep > 1) {
                showStep(currentStep - 1);
            }
        });
    }
    
    // Edit appointment
    const editAppointmentBtn = document.getElementById('editAppointment');
    if (editAppointmentBtn) {
        editAppointmentBtn.addEventListener('click', function() {
            console.log('Edit button clicked');
            showStep(1);
            // Reset selections
            selectedCounselor = null;
            selectedDate = null;
            selectedTime = null;
            selectedSlot = null; // Reset selectedSlot
            document.querySelectorAll('.counselor-card').forEach(c => {
                c.classList.remove('selected');
            });
            updateButtons();
        });
    }
    
    // Load available dates for selected counselor
    function loadAvailableDates() {
        if (!selectedCounselor) {
            console.log('No counselor selected, skipping date loading');
            return;
        }
        
        console.log('Loading available dates for counselor:', selectedCounselor.id);
        
        fetch(`/appointments/available-slots/${selectedCounselor.id}`)
            .then(res => res.json())
            .then(slots => {
                console.log('Received slots:', slots);
                // Extract unique dates from slots
                const availableDates = [...new Set(slots.map(slot => 
                    slot.start.split('T')[0]
                ))].sort();
                
                console.log('Available dates:', availableDates);
                renderCalendar(availableDates);
            })
            .catch((error) => {
                console.error('Error loading available dates:', error);
                renderCalendar([]);
            });
    }
    
    // Global variables for calendar navigation
    let currentCalendarDate = new Date();
    let availableDates = [];
    
    // Initialize calendar navigation
    function initializeCalendarNavigation() {
        const prevBtn = document.getElementById('prevMonth');
        const nextBtn = document.getElementById('nextMonth');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                currentCalendarDate.setMonth(currentCalendarDate.getMonth() - 1);
                renderCalendar(availableDates);
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                currentCalendarDate.setMonth(currentCalendarDate.getMonth() + 1);
                renderCalendar(availableDates);
            });
        }
    }
    
    // Dynamic calendar rendering
    function renderCalendar(dates) {
        const calendarDays = document.getElementById('calendarDays');
        if (!calendarDays) {
            console.log('Calendar days element not found');
            return;
        }
        
        // Store available dates globally
        availableDates = dates || [];
        
        const currentMonth = currentCalendarDate.getMonth();
        const currentYear = currentCalendarDate.getFullYear();
        const today = new Date();
        
        // Update month display
        const monthElement = document.getElementById('currentMonth');
        if (monthElement) {
            monthElement.textContent = currentCalendarDate.toLocaleDateString('en-US', { 
                month: 'long', 
                year: 'numeric' 
            });
        }
        
        // Clear calendar
        calendarDays.innerHTML = '';
        
        // Get first day of month and number of days
        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const startDate = new Date(firstDay);
        startDate.setDate(startDate.getDate() - firstDay.getDay());
        
        // Generate calendar days
        for (let i = 0; i < 42; i++) {
            const date = new Date(startDate);
            date.setDate(startDate.getDate() + i);
            
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = date.getDate();
            
            // Check if date is in current month
            if (date.getMonth() !== currentMonth) {
                dayElement.classList.add('disabled');
            } else if (date >= today) {
                // Check if date is available (use local date, not UTC)
                const dateStr = date.toLocaleDateString('en-CA'); // Returns YYYY-MM-DD format
                if (availableDates.includes(dateStr)) {
                    dayElement.classList.add('available');
                    dayElement.addEventListener('click', () => selectDate(date));
                } else {
                    dayElement.classList.add('disabled');
                }
            } else {
                // Past dates
                dayElement.classList.add('disabled');
            }
            
            // Highlight selected date
            if (selectedDate && date.toDateString() === selectedDate.toDateString()) {
                dayElement.classList.add('selected');
            }
            
            calendarDays.appendChild(dayElement);
        }
    }
    
    function selectDate(date) {
        console.log('Date selected:', date);
        selectedDate = date;
        
        // Update visual selection
        document.querySelectorAll('.calendar-day').forEach(day => {
            day.classList.remove('selected');
        });
        event.target.classList.add('selected');
        
        // Update counselor name in time selection step
        updateCounselorInfo();
        
        // Proceed to next step
        showStep(3);
        loadTimeSlots();
        updateButtons();
    }
    
    // Load time slots for selected date
    function loadTimeSlots() {
        if (!selectedCounselor || !selectedDate) {
            console.log('Missing counselor or date');
            return;
        }
        
        console.log('Loading time slots for date:', selectedDate);
        
        const loading = document.getElementById('timeSlotsLoading');
        const grid = document.getElementById('timeSlotsGrid');
        
        if (loading) loading.style.display = 'block';
        if (grid) grid.innerHTML = '';
        
        // Format date for API (use local date, not UTC)
        const dateStr = selectedDate.toLocaleDateString('en-CA'); // Returns YYYY-MM-DD format
        
        fetch(`/appointments/available-slots/${selectedCounselor.id}`)
            .then(res => res.json())
            .then(slots => {
                if (loading) loading.style.display = 'none';
                
                console.log('All slots received:', slots);
                console.log('Looking for date:', dateStr);
                
                const daySlots = slots.filter(slot => {
                    const slotDate = slot.start.split('T')[0];
                    console.log('Checking slot:', slot, 'date part:', slotDate, 'matches:', slotDate === dateStr);
                    return slotDate === dateStr;
                });
                
                console.log('Filtered time slots for date:', daySlots);
                
                if (!grid) return;
                
                if (daySlots.length === 0) {
                    grid.innerHTML = '<div class="text-center text-muted">No available slots for this date</div>';
                    return;
                }
                
                // Sort slots by time
                daySlots.sort();
                
                daySlots.forEach(slot => {
                    const timeSlot = document.createElement('div');
                    timeSlot.className = 'time-slot';
                    if (slot.booked) {
                        timeSlot.classList.add('disabled');
                    }
                    // Parse the availability slot start and end times
                    const startDate = new Date(slot.start.replace('T', ' '));
                    const endDate = new Date(slot.end.replace('T', ' '));
                    const startTimeStr = startDate.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true,
                        timeZone: 'Asia/Manila' // Use Philippine timezone
                    });
                    const endTimeStr = endDate.toLocaleTimeString('en-US', {
                        hour: 'numeric',
                        minute: '2-digit',
                        hour12: true,
                        timeZone: 'Asia/Manila' // Use Philippine timezone
                    });
                    timeSlot.textContent = `${startTimeStr} - ${endTimeStr}`;
                    if (!slot.booked) {
                        timeSlot.addEventListener('click', () => selectTimeSlot(timeSlot, slot));
                    }
                    grid.appendChild(timeSlot);
                });
            })
            .catch((error) => {
                console.error('Error loading time slots:', error);
                if (loading) loading.style.display = 'none';
                if (grid) grid.innerHTML = '<div class="text-center text-danger">Error loading time slots</div>';
            });
    }
    
    function selectTimeSlot(element, slot) {
        console.log('Time slot selected:', slot);
        
        document.querySelectorAll('.time-slot').forEach(el => {
            el.classList.remove('selected');
        });
        element.classList.add('selected');
        // Save the full slot object
        selectedSlot = slot;
        // For form submission, still use slot.start (with timezone)
        let slotWithTZ = slot.start;
        if (!slotWithTZ.endsWith('+08:00')) {
            slotWithTZ = slotWithTZ + '+08:00';
        }
        selectedTime = slotWithTZ;
        
        // Proceed to confirmation step
        showStep(4);
        updateSummary();
        updateButtons();
    }
    
    // Update counselor info in time selection step
    function updateCounselorInfo() {
        if (selectedCounselor) {
            const selectedCounselorName = document.getElementById('selectedCounselorName');
            if (selectedCounselorName) {
                selectedCounselorName.textContent = selectedCounselor.name;
            }
        }
        
        if (selectedDate) {
            const selectedDateElement = document.getElementById('selectedDate');
            if (selectedDateElement) {
                selectedDateElement.textContent = 
                    `- ${selectedDate.toLocaleDateString('en-US', { 
                        month: 'long', 
                        day: 'numeric', 
                        year: 'numeric' 
                    })}`;
            }
        }
    }
    
    // Update summary with selected data
    function updateSummary() {
        if (selectedDate) {
            const summaryDate = document.getElementById('summaryDate');
            if (summaryDate) {
                summaryDate.textContent = selectedDate.toLocaleDateString('en-US', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
            }
        }
        
        if (selectedSlot) {
            const summaryTime = document.getElementById('summaryTime');
            if (summaryTime) {
                // Parse as Asia/Manila time
                const slotStart = new Date(selectedSlot.start + (selectedSlot.start.endsWith('+08:00') ? '' : '+08:00'));
                const slotEnd = new Date(selectedSlot.end + (selectedSlot.end.endsWith('+08:00') ? '' : '+08:00'));
                const startTimeStr = slotStart.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true,
                    timeZone: 'Asia/Manila'
                });
                const endTimeStr = slotEnd.toLocaleTimeString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit',
                    hour12: true,
                    timeZone: 'Asia/Manila'
                });
                summaryTime.textContent = `${startTimeStr} - ${endTimeStr}`;
            }
        }
        
        if (selectedCounselor) {
            const summaryCounselor = document.getElementById('summaryCounselor');
            const selectedCounselorName = document.getElementById('selectedCounselorName');
            if (summaryCounselor) summaryCounselor.textContent = selectedCounselor.name;
            if (selectedCounselorName) selectedCounselorName.textContent = selectedCounselor.name;
        }
        
        if (selectedDate) {
            const selectedDateElement = document.getElementById('selectedDate');
            if (selectedDateElement) {
                selectedDateElement.textContent = 
                    `- ${selectedDate.toLocaleDateString('en-US', { 
                        month: 'long', 
                        day: 'numeric', 
                        year: 'numeric' 
                    })}`;
            }
        }
    }
    
    // Initialize
    updateButtons();
    initializeCalendarNavigation();
    console.log('Appointment scheduler initialized');
});

// Replace Next button with Submit on last step
function updateActionButtonsForStep(step) {
    var nextBtn = document.getElementById('nextButton');
    if (step === 4) {
        nextBtn.innerHTML = '<span>Submit Appointment</span><i class="bi bi-check-circle ms-2"></i>';
        nextBtn.type = 'button';
        nextBtn.onclick = function(e) {
            e.preventDefault();
            // Only open the confirmation modal, do NOT submit the form or trigger AJAX
            document.getElementById('modalCounselor').textContent = document.getElementById('summaryCounselor').textContent;
            document.getElementById('modalDate').textContent = document.getElementById('summaryDate').textContent;
            document.getElementById('modalTime').textContent = document.getElementById('summaryTime').textContent;
            document.getElementById('modalType').textContent = document.getElementById('appointmentType').value;
            document.getElementById('modalNotes').textContent = document.getElementById('appointmentNotes').value || 'None';
            var bsModal = new bootstrap.Modal(document.getElementById('appointmentConfirmModal'));
            bsModal.show();
        };
    } else {
        nextBtn.innerHTML = '<span id="nextButtonText">Next</span><i class="bi bi-arrow-right" id="nextButtonIcon"></i>';
        nextBtn.onclick = null;
    }
}

// Add event listener for modal confirmation
// Remove success modal logic, redirect to dashboard on success

document.addEventListener('DOMContentLoaded', function() {
    // Prevent any form submission
    document.addEventListener('submit', function(event) {
        event.preventDefault();
    }, true);

    var confirmBtn = document.getElementById('confirmSubmitAppointment');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function(event) {
            event.preventDefault();
            // Populate the hidden form with the selected data
            document.getElementById('formCounselorId').value = selectedCounselor.id;
            document.getElementById('formScheduledAt').value = selectedTime;
            document.getElementById('formNotes').value = document.getElementById('appointmentNotes').value || '';
            // Submit the form via AJAX
            const form = document.getElementById('appointment-form');
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(async response => {
                let data;
                try {
                    data = await response.json();
                } catch (e) {
                    // Not JSON, likely an error page
                    alert('There was a server error or you are not logged in. Please refresh and try again.');
                    return;
                }
                // Hide the confirmation modal
                const confirmModal = bootstrap.Modal.getInstance(document.getElementById('appointmentConfirmModal'));
                if (confirmModal) confirmModal.hide();
                // Redirect to dashboard on success
                if (data.success) {
                    window.location.href = "{{ route('dashboard') }}";
                } else {
                    alert(data.error || 'There was an error booking your appointment.');
                }
            })
            .catch(error => {
                alert('There was an error booking your appointment. Please try again.');
                console.error('Error:', error);
            });
        });
    }
});
</script>
@endsection 