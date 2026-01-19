<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'Appointment Approved',
    'heading' => 'Appointment Approved',
]); ?>
<h2>Hello <?php echo e($student->name); ?>,</h2>

<p>Great news! Your appointment request has been approved by <?php echo e($counselor->name); ?>.</p>

<div class="info-box">
    <p><strong>Counselor:</strong> <?php echo e($counselor->name); ?></p>
    <p><strong>Date:</strong> <?php echo e($appointment->scheduled_at->format('F d, Y')); ?></p>
    <p><strong>Time:</strong> <?php echo e($appointment->scheduled_at->format('g:i A')); ?></p>
    <p><strong>Type:</strong> <?php echo e(ucfirst($appointment->type)); ?></p>
    <p><strong>Reference Number:</strong> <?php echo e($appointment->reference_number); ?></p>
</div>

<p><strong>What to expect:</strong></p>
<ul>
    <li>Please arrive on time for your appointment</li>
    <li>Bring any relevant documents or notes</li>
    <li>Feel free to prepare questions you'd like to discuss</li>
</ul>

<div class="button-center">
    <a href="<?php echo e(url('/appointments/' . $appointment->id)); ?>" class="button">
        View Appointment Details
    </a>
</div>

<p style="font-size: 13px; color: #888;">
    If you need to reschedule or cancel, please do so at least 24 hours in advance.
</p>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/appointments/accepted.blade.php ENDPATH**/ ?>