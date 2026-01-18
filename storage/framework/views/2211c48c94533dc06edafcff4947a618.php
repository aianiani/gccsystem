<?php $__env->startComponent('emails.layouts.base', [
    'title' => 'Two-Factor Authentication Code',
    'heading' => 'Two-Factor Authentication',
]); ?>
    <h2>Hello <?php echo e($userName); ?>,</h2>

    <p>Your Two-Factor Authentication (2FA) code is:</p>

    <div class="code-box">
        <div class="code"><?php echo e($code); ?></div>
    </div>

    <p>Please enter this code to complete your login.</p>

    <div class="info-box" style="background-color: #fff9e6; border-color: #ffd700;">
        <p style="margin: 0; font-size: 14px; color: #856404;">
            <strong>Security Notice:</strong> This code will expire in 5 minutes.
        </p>
    </div>

    <p style="font-size: 13px; color: #888;">
        If you did not request this code, you can safely ignore this email.
    </p>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/emails/twofactor/code.blade.php ENDPATH**/ ?>