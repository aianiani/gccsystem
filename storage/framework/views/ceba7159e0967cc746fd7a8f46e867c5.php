<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'Registration Approved',
    'heading' => 'Registration Approved',
]); ?>
    <h2>Hello <?php echo e($user->name); ?>,</h2>

    <p>Great news! Your registration for the CMU Guidance and Counseling Center has been <strong>approved</strong>.</p>

    <p>Your account is now active and you can access all the features of our counseling platform.</p>

    <p><strong>What you can do:</strong></p>
    <ul>
        <li>Schedule appointments with counselors</li>
        <li>Take mental health assessments</li>
        <li>View your session notes and track your progress</li>
        <li>Access counseling resources</li>
    </ul>

    <div class="button-center">
        <a href="<?php echo e(route('login')); ?>" class="button">
            Login to Your Account
        </a>
    </div>

    <p style="font-size: 13px; color: #888;">
        If you have any questions or need assistance, please contact our support team.
    </p>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/registration/approved.blade.php ENDPATH**/ ?>