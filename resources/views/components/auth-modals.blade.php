@guest
<!-- Auth Modals -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane" style="color:#fff;">
                    <div class="text-center">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width:70px;height:70px;border-radius:50%; background:#fff; object-fit:cover;" class="mb-3">
                        <h5 class="fw-bold mb-3">CMU Guidance and<br> Counseling Center</h5>
                        <ul class="list-unstyled text-start mx-auto" style="max-width:260px;">
                            <li class="mb-3 d-flex align-items-center"><span class="num-badge">1</span><span>Easy appointment scheduling with university counselors</span></li>
                            <li class="mb-3 d-flex align-items-center"><span class="num-badge">2</span><span>Access to mental health resources and information</span></li>
                            <li class="d-flex align-items-center"><span class="num-badge">3</span><span>Secure and confidential counseling services</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width:35px;height:35px;border-radius:50%; background:#fff; object-fit:cover;" class="me-2 d-lg-none">
                            <h6 class="mb-0 text-muted d-lg-none" style="font-size:0.9rem;">CMU Guidance & Counseling Center</h6>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="tabs-wrapper">
                        <ul class="nav nav-tabs mb-1" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="tab-login" data-bs-toggle="tab" data-bs-target="#pane-login" type="button" role="tab" aria-controls="pane-login" aria-selected="true">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="tab-signup" data-bs-toggle="tab" data-bs-target="#pane-signup" type="button" role="tab" aria-controls="pane-signup" aria-selected="false">
                                    <i class="fas fa-user-plus me-2"></i>Sign Up
                                </button>
                            </li>
                        </ul>
                        <div id="authTabIndicator"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pane-login" role="tabpanel" aria-labelledby="tab-login">
                            <form id="modalLoginForm" method="POST" action="{{ url('/login') }}">
                                @csrf
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" required autocomplete="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" class="form-control" required autocomplete="current-password" placeholder="Password" id="loginPassword">
                                        <button class="btn btn-outline-secondary btn-eye" type="button" id="toggleLoginPassword" style="border-radius:0 12px 12px 0;" aria-label="Show password"><i class="fas fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                        <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    <a href="#" class="small tiny-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">Forgot Password?</a>
                                </div>
                                <button type="submit" class="btn w-100 btn-auth-primary" style="padding: 12px 20px; font-size: 0.95rem; font-weight: 600; border: none; box-shadow: 0 4px 12px rgba(15, 94, 29, 0.25), 0 1px 3px rgba(0,0,0,0.1);">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pane-signup" role="tabpanel" aria-labelledby="tab-signup">
                            <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data" id="signupForm">
                                @csrf
                                
                                <div id="signupStep1">
                                    <h6 class="mb-3 text-muted"><i class="fas fa-user me-2"></i>Name Information</h6>
                                    <div class="mb-3">
                                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="first_name" class="form-control" required placeholder="e.g., Juan" autocomplete="given-name">
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Middle Name</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="middle_name" class="form-control" placeholder="Optional" autocomplete="additional-name">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                            <input type="text" name="last_name" class="form-control" required placeholder="e.g., Dela Cruz" autocomplete="family-name">
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="step-navigation">
                                        <div></div>
                                        <button type="button" class="btn btn-auth-primary" id="goToStep2">
                                            Next <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="signupStep2" class="d-none">
                                    <h6 class="mb-3 text-muted"><i class="fas fa-phone me-2"></i>Contact Information</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            <input type="tel" name="contact_number" class="form-control" required placeholder="e.g., 09XXXXXXXXX" pattern="[0-9]{10,11}" autocomplete="tel">
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Home Address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            <input type="text" name="address" class="form-control" required placeholder="House/Street, Barangay, City/Province" autocomplete="address-line1">
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="step-navigation">
                                        <button type="button" class="btn btn-outline-secondary" id="backToStep1">
                                            <i class="fas fa-arrow-left me-2"></i>Back
                                        </button>
                                        <button type="button" class="btn btn-auth-primary" id="goToStep3">
                                            Next <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="signupStep3" class="d-none">
                                    <h6 class="mb-3 text-muted"><i class="fas fa-key me-2"></i>Account Credentials</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" class="form-control" required autocomplete="email" placeholder="Enter your email">
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" name="password" class="form-control" required autocomplete="new-password" placeholder="Create a password" id="signupPassword">
                                            <button class="btn btn-outline-secondary btn-eye" type="button" id="toggleSignupPassword" style="border-radius:0 12px 12px 0;" aria-label="Show password"><i class="fas fa-eye"></i></button>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                        <div class="form-text">
                                            <small class="text-muted">Password must be at least 8 characters long</small>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Confirm your password" id="signupPasswordConfirm">
                                            <button class="btn btn-outline-secondary btn-eye" type="button" id="toggleSignupPasswordConfirm" style="border-radius:0 12px 12px 0;" aria-label="Show password"><i class="fas fa-eye"></i></button>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="step-navigation">
                                        <button type="button" class="btn btn-outline-secondary" id="backToStep2">
                                            <i class="fas fa-arrow-left me-2"></i>Back
                                        </button>
                                        <button type="button" class="btn btn-auth-primary" id="goToStep4">
                                            Next <i class="fas fa-arrow-right ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="signupStep4" class="d-none">
                                    <h6 class="mb-3 text-muted"><i class="fas fa-graduation-cap me-2"></i>Student Information</h6>
                                    <div class="mb-3">
                                        <label class="form-label">Student ID <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                            <input type="text" name="student_id" class="form-control" required placeholder="e.g., 2021-12345">
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-md-7">
                                            <label class="form-label">College <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-university"></i></span>
                                                <select class="form-select" name="college" id="collegeSelect" required>
                                                    <option value="" selected disabled>Select college</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Year Level <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                                <select class="form-select" name="year_level" required>
                                                    <option value="" selected disabled>Select</option>
                                                    <option>1st Year</option>
                                                    <option>2nd Year</option>
                                                    <option>3rd Year</option>
                                                    <option>4th Year</option>
                                                    <option>5th Year</option>
                                                </select>
                                            </div>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Course / Program <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                            <select class="form-select" name="course" id="courseSelect" required>
                                                <option value="" selected disabled>Select course</option>
                                            </select>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Attach COR (PDF/JPG/PNG) <span class="text-danger">*</span></label>
                                        <input class="form-control" type="file" name="cor_file" accept=".pdf,image/*" required>
                                        <div class="form-text">
                                            <small class="text-muted">Max 5MB. Used for verification by the counselor.</small>
                                        </div>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    <div class="step-navigation">
                                        <button type="button" class="btn btn-outline-secondary" id="backToStep3">
                                            <i class="fas fa-arrow-left me-2"></i>Back
                                        </button>
                                        <button type="submit" class="btn btn-auth-primary" style="padding: 12px 20px; font-size: 0.95rem; font-weight: 600; border: none; box-shadow: 0 4px 12px rgba(15, 94, 29, 0.25), 0 1px 3px rgba(0,0,0,0.1);">
                                            <i class="fas fa-user-plus me-2"></i>Complete Sign Up
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane" style="color:#fff;">
                    <div class="text-center">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width:90px;height:90px;border-radius:50%; background:#fff; object-fit:cover;" class="mb-3">
                        <h5 class="fw-bold mb-3">Reset your password</h5>
                        <p class="small mb-0">We'll email you a secure link to create a new password.</p>
                    </div>
                </div>
                <div class="col-lg-7 p-4">
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <h5 class="mb-3" style="color:#0f5e1d;">Forgot Password</h5>
                    <p class="small text-muted">Enter your email address and we'll send you a link to reset your password.</p>
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" required autocomplete="email" placeholder="Enter your email">
                            </div>
                        </div>
                        <button type="submit" class="btn w-100 fw-bold btn-auth-primary">Send Reset Link</button>
                    </form>
                    <div class="text-center mt-3 small">
                        <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal" class="tiny-link">Back to Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resend Verification Modal -->
<div class="modal fade" id="resendVerificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header" style="border-bottom: none;">
                <h5 class="modal-title" style="color: var(--primary-green);">Resend Verification Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 pt-0">
                <p class="small text-muted">Enter your email to resend the verification link.</p>
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required autocomplete="email">
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold" style="background: var(--primary-green); border: none; border-radius: 10px;">Resend Email</button>
                </form>
                <div class="text-center mt-3 small">
                    <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal" style="color: var(--accent-green); text-decoration: none;">Back to Sign In</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Two-Factor Authentication Modal -->
<div class="modal fade" id="twoFactorModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane" style="color:#fff;">
                    <div class="text-center">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width:90px;height:90px;border-radius:50%; background:#fff; object-fit:cover;" class="mb-3">
                        <h5 class="fw-bold mb-2">Two-Factor Verification</h5>
                        <p class="small mb-0">Enter the 6-digit code we sent to your email or phone to continue.</p>
                    </div>
                </div>
                <div class="col-lg-7 p-4">
                    <div class="d-flex justify-content-end align-items-center mb-3">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <h5 class="mb-3" style="color:#0f5e1d;">Two-Factor Authentication</h5>
                    <form id="modal2faForm" method="POST" action="{{ route('2fa.verify') }}">
                        @csrf
                        <div class="otp-box mb-3">
                            <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                            <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                            <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                            <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                            <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                            <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                            <input type="hidden" name="code" id="otpHidden" />
                        </div>
                        <button type="submit" class="btn w-100 fw-bold btn-auth-primary">Verify</button>
                    </form>
                    <div class="d-flex justify-content-between align-items-center mt-3 small">
                        <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal" class="tiny-link">Back to Sign In</a>
                        <form method="POST" action="{{ route('2fa.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 tiny-link">Resend code</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endguest


