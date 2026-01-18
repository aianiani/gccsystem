<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'New Appointment Booked',
    'heading' => 'New Appointment Booked',
]); ?>
<h2>Hello <?php echo e($counselor->name); ?>,</h2>

<p>A new appointment has been booked with you.</p>

<div class="info-box">
    <p><strong>Student:</strong> <?php echo e($student->name); ?></p>
    <p><strong>Date:</strong> <?php echo e($appointment->scheduled_at->format('F d, Y')); ?></p>
    <p><strong>Time:</strong> <?php echo e($appointment->scheduled_at->format('g:i A')); ?></p>
    <p><strong>Type:</strong> <?php echo e(ucfirst($appointment->type)); ?></p>
    <?php if($appointment->reason): ?>
        <p><strong>Reason:</strong> <?php echo e($appointment->reason); ?></p>
    <?php endif; ?>
    <p><strong>Reference Number:</strong> <?php echo e($appointment->reference_number); ?></p>
</div>

<p>Please review and respond to this appointment request.</p>

<div class="button-center">
    <a href="<?php echo e(url('/counselor/appointments/' . $appointment->id)); ?>" class="button">
        View Appointment Details
    </a>
</div>

<p style="font-size: 13px; color: #888;">
    You can accept or decline this appointment from your dashboard.
</p>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/appointments/booked.blade.php ENDPATH**/ ?>