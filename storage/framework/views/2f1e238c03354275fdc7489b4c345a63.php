<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'Appointment Rescheduled',
    'heading' => 'Appointment Rescheduled',
]); ?>
<h2>Hello <?php echo e($recipient->name); ?>,</h2>

<p>An appointment has been rescheduled. Please review the new details below.</p>

<div class="info-box">
    <p><strong>Previous Date:</strong> <?php echo e($originalDate->format('F d, Y')); ?></p>
    <p><strong>Previous Time:</strong> <?php echo e($originalDate->format('g:i A')); ?></p>
    <div class="divider"></div>
    <p><strong>New Date:</strong> <?php echo e($appointment->scheduled_at->format('F d, Y')); ?></p>
    <p><strong>New Time:</strong> <?php echo e($appointment->scheduled_at->format('g:i A')); ?></p>
    <?php if($rescheduleReason): ?>
        <div class="divider"></div>
        <p><strong>Reason:</strong> <?php echo e($rescheduleReason); ?></p>
    <?php endif; ?>
</div>

<?php if($requiresConfirmation): ?>
    <p>Please confirm if you can attend at the new time.</p>

    <div class="button-center">
        <a href="<?php echo e(url('/appointments/' . $appointment->id)); ?>" class="button">
            Confirm Appointment
        </a>
    </div>
<?php else: ?>
    <p>This reschedule has been confirmed.</p>

    <div class="button-center">
        <a href="<?php echo e(url('/appointments/' . $appointment->id)); ?>" class="button">
            View Appointment Details
        </a>
    </div>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/appointments/rescheduled.blade.php ENDPATH**/ ?>