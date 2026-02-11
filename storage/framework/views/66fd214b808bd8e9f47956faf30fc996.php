<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'Reschedule Confirmed',
    'heading' => 'Reschedule Confirmed',
]); ?>
<h2>Hello <?php echo e($recipient->name); ?>,</h2>

<p>The rescheduled appointment has been confirmed.</p>

<div class="info-box">
    <p><strong><?php echo e($isStudent ? 'Counselor' : 'Student'); ?>:</strong> <?php echo e($otherParty->name); ?></p>
    <p><strong>Date:</strong> <?php echo e($appointment->scheduled_at->format('F d, Y')); ?></p>
    <p><strong>Time:</strong> <?php echo e($appointment->scheduled_at->format('g:i A')); ?></p>
    <p><strong>Type:</strong> <?php echo e(ucfirst($appointment->type)); ?></p>
    <p><strong>Reference Number:</strong> <?php echo e($appointment->reference_number); ?></p>
</div>

<p>Please update your calendar with the new appointment time.</p>

<div class="button-center">
    <a href="<?php echo e(url('/appointments/' . $appointment->id)); ?>" class="button">
        View Appointment Details
    </a>
</div>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/appointments/reschedule_accepted.blade.php ENDPATH**/ ?>