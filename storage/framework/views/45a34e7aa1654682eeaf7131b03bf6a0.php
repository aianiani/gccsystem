<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'Appointment Completed',
    'heading' => 'Thank You',
]); ?>
<h2>Hello <?php echo e($student->name); ?>,</h2>

<p>Thank you for attending your counseling session with <?php echo e($counselor->name); ?>.</p>

<div class="info-box">
    <p><strong>Session Date:</strong> <?php echo e($appointment->scheduled_at->format('F d, Y')); ?></p>
    <p><strong>Counselor:</strong> <?php echo e($counselor->name); ?></p>
    <p><strong>Reference Number:</strong> <?php echo e($appointment->reference_number); ?></p>
</div>

<p>We hope the session was helpful. Your mental health and well-being are important to us.</p>

<p><strong>What's next?</strong></p>
<ul>
    <li>Review your session notes in your dashboard</li>
    <li>Book a follow-up appointment if recommended</li>
    <li>Reach out if you have any questions</li>
</ul>

<div class="button-center">
    <a href="<?php echo e(url('/appointments/create')); ?>" class="button">
        Book Follow-up Appointment
    </a>
</div>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/appointments/completed.blade.php ENDPATH**/ ?>