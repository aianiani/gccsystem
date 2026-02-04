<?php $__env->startSection('content'); ?>
    <style>
        :root {
            --primary-green: #1f7a2d;
            --primary-green-2: #13601f;
            --accent-green: #2e7d32;
            --light-green: #eaf5ea;
            --accent-orange: #FFCB05;
            --text-dark: #16321f;
            --text-light: #6c757d;
            --bg-light: #f6fbf6;
            --shadow-sm: 0 4px 12px rgba(0, 0, 0, 0.06);
            --shadow-md: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .consent-page {
            padding: 2rem 1.5rem;
        }

        .consent-inner {
            max-width: 900px;
            margin: 0 auto;
        }

        .consent-header-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .consent-header-title {
            color: #2d5016;
            font-weight: 700;
            font-size: 1.667rem;
            margin-bottom: 0.75rem;
        }

        .consent-header-subtitle {
            color: #3d5c2d;
            font-size: 0.889rem;
        }

        .consent-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(44, 80, 22, 0.08);
            padding: 2rem;
        }

        .consent-content {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid #e0e0e0;
        }

        .consent-content h3 {
            color: #2d5016;
            font-weight: 700;
            font-size: 1.111rem;
            margin-bottom: 1.25rem;
            text-align: center;
        }

        .consent-text {
            color: #333;
            font-size: 1rem;
            line-height: 1.8;
            text-align: left;
        }

        .consent-text p {
            margin-bottom: 1rem;
        }

        .consent-checkbox {
            margin: 2rem 0;
            padding: 1.5rem;
            background: #eaf5ea;
            border-radius: 12px;
            border: 2px solid #cfe8d0;
        }

        .consent-checkbox label {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            cursor: pointer;
            font-size: 0.889rem;
            color: #2d5016;
            margin-bottom: 0;
        }

        .consent-checkbox input[type="checkbox"] {
            width: 20px;
            height: 20px;
            margin-top: 2px;
            cursor: pointer;
            flex-shrink: 0;
            accent-color: #2d9a36;
        }

        .consent-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn-consent {
            padding: 0.75rem 2rem;
            font-size: 0.889rem;
            font-weight: 600;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-consent-primary {
            background: var(--accent-orange);
            color: #1f2b10;
        }

        .btn-consent-primary:hover:not(:disabled) {
            filter: brightness(0.95);
        }

        .btn-consent-primary:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .btn-consent-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn-consent-secondary:hover {
            background: #5a6268;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.889rem;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }

        .text-danger {
            color: #dc3545;
        }

        .mt-2 {
            margin-top: 0.5rem;
        }

        /* Apply page zoom */
        @media (max-width: 768px) {
            .home-zoom {
                zoom: 1 !important;
                transform: none !important;
            }
        }

        @media (max-width: 768px) {
            .consent-page {
                padding: 1.5rem 1rem;
            }

            .consent-header-title {
                font-size: 1.5rem;
            }

            .consent-container {
                padding: 1.25rem;
                border-radius: 12px;
            }

            .consent-content {
                padding: 1rem;
            }

            .consent-checkbox {
                padding: 1rem;
            }

            .consent-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn-consent {
                width: 100%;
                padding: 0.8rem 1.5rem;
            }
        }
    </style>

    <div class="home-zoom ps-0 ps-md-4">
        <div class="consent-page">
            <div class="consent-inner">
                <div class="consent-header-section">
                    <h2 class="consent-header-title">Consent for Counseling Services</h2>
                    <p class="consent-header-subtitle">Please read and agree to proceed with counseling services</p>
                </div>

                <div class="consent-container">

                    <?php if(session('error')): ?>
                        <div class="alert alert-danger">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('success')): ?>
                        <div class="alert alert-info">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(session('info')): ?>
                        <div class="alert alert-info">
                            <?php echo e(session('info')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('consent.store')); ?>" id="consentForm">
                        <?php echo csrf_field(); ?>
                        <?php if(isset($context)): ?>
                            <input type="hidden" name="context" value="<?php echo e($context); ?>">
                        <?php endif; ?>


                        <div class="consent-content">
                            <h3>CONSENT</h3>
                            <div class="consent-text">
                                <p>I consent to avail the counseling services. For purposes of self-awareness, assessment
                                    and the like, I am therefore willing to submit information through interviews, data
                                    sheets, worksheets, and psychological tests.</p>
                                <p>Nonetheless, I would like my right to privacy and confidentiality to be appropriately
                                    upheld, except situations in which I am perceived as been abused, suicidal, or a threat
                                    to the safety of others, or in which my counselor is called to testify in court.</p>
                                <p class="mb-0">In addition, I want my right to be acknowledged when I choose to discontinue
                                    with the service that is no longer helpful in my development.</p>
                            </div>
                        </div>

                        <div class="consent-checkbox">
                            <label for="consent_agreed">
                                <input type="checkbox" name="consent_agreed" id="consent_agreed" value="1" required>
                                <span>I agree to the consent information above.</span>
                            </label>
                            <?php $__errorArgs = ['consent_agreed'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger mt-2"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="consent-actions">
                            <button type="submit" class="btn-consent btn-consent-primary" id="submitBtn" disabled>
                                Continue to Assessment
                            </button>
                            <button type="button" class="btn-consent btn-consent-secondary"
                                onclick="window.location.href='<?php echo e(route('dashboard')); ?>'">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('consent_agreed');
            const submitBtn = document.getElementById('submitBtn');
            const consentForm = document.getElementById('consentForm');
            let isSubmitting = false;

            checkbox.addEventListener('change', function () {
                submitBtn.disabled = !this.checked;
            });

            // Prevent double submission
            consentForm.addEventListener('submit', function (e) {
                if (isSubmitting) {
                    e.preventDefault();
                    return false;
                }
                isSubmitting = true;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/consent.blade.php ENDPATH**/ ?>