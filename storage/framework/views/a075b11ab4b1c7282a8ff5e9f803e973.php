<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'Assessment Completed',
    'heading' => 'Assessment Completed Successfully',
]); ?>
<h2>Hello <?php echo e($user->name); ?>,</h2>

<p>Thank you for completing the <strong><?php echo e($assessment->type); ?></strong> assessment.</p>

<p>Your responses have been successfully recorded and will be reviewed by our counseling team.</p>

<div style="background: #f8f9fa; padding: 15px; border-radius: 8px; margin: 20px 0;">
    <p style="margin: 0;"><strong>Assessment Details:</strong></p>
    <ul style="margin: 10px 0 0 0; padding-left: 20px;">
        <li><strong>Assessment Type:</strong> <?php echo e($assessment->type); ?></li>
        <li><strong>Completed On:</strong> <?php echo e($assessment->created_at->format('F d, Y \a\t h:i A')); ?></li>
        <li><strong>Status:</strong> Submitted</li>
    </ul>
</div>

<p><strong>What happens next?</strong></p>
<ul>
    <li>Your assessment results will be reviewed by our counseling team</li>
    <li>A counselor may reach out to you if follow-up is needed</li>
    <li>You can view your assessment history in your dashboard</li>
    <li>Feel free to schedule an appointment to discuss your results</li>
</ul>

<div class="button-center">
    <a href="<?php echo e(route('dashboard')); ?>" class="button">
        View Your Dashboard
    </a>
</div>

<p style="font-size: 13px; color: #888; margin-top: 30px;">
    If you have any questions or concerns about your assessment, please don't hesitate to contact the CMU Guidance and
    Counseling Center.
</p>

<p style="font-size: 13px; color: #888;">
    <strong>Need Support?</strong><br>
    Our counselors are here to help. You can schedule an appointment or reach out to us anytime.
</p>
<?php echo $__env->renderComponent(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/assessment-completed.blade.php ENDPATH**/ ?>