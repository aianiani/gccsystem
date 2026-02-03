<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'Appointment Reminder',
    'heading' => 'Upcoming Appointment Reminder',
]); ?>
<h2>Hello <?php echo e($user->name); ?>,</h2>

<p>This is a friendly reminder about your upcoming counseling appointment.</p>

<div class="info-box">
    <p><strong><?php echo e($isStudent ? 'Counselor' : 'Student'); ?>:</strong> <?php echo e($otherParty->name); ?></p>
    <p><strong>Date:</strong> <?php echo e($date); ?></p>
    <p><strong>Time:</strong> <?php echo e($time); ?></p>
    <p><strong>Type:</strong> <?php echo e(ucfirst($appointment->appointment_type)); ?></p>
    <p><strong>Reference Number:</strong> <?php echo e($appointment->reference_number); ?></p>
</div>

<?php if($isStudent): ?>
    <p><strong>Preparation tips:</strong></p>
    <ul>
        <li>Arrive on time for your appointment</li>
        <li>Bring any relevant documents or notes</li>
        <li>Prepare questions you'd like to discuss</li>
    </ul>
<?php endif; ?>

<div class="button-center">
    <a href="<?php echo e(url('/appointments/' . $appointment->id)); ?>" class="button">
        View Appointment Details
    </a>
</div>

<p style="font-size: 13px; color: #888;">
    If you need to reschedule or cancel, please do so as soon as possible.
</p>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/appointments/reminder.blade.php ENDPATH**/ ?>