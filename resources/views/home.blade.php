<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMU Guidance & Counseling Center</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #1a1a1a;
            overflow-x: hidden;
        }

        :root {
            --primary-green: #2d5a3d;
            --accent-green: #4CAF50;
            --light-green: #e8f5e8;
            --accent-orange: #ff9800;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --bg-light: #f8f9fa;
            --shadow: 0 10px 30px rgba(0,0,0,0.1);
            --shadow-hover: 0 20px 40px rgba(0,0,0,0.15);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-green);
            border-radius: 4px;
        }

        /* Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary-green) !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .navbar-brand img {
            height: 45px;
            border-radius: 8px;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            padding: 0.5rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            background: var(--light-green);
            transform: translateY(-2px);
        }

        .nav-link.active {
            background: var(--primary-green);
            color: white !important;
        }

        .btn-auth {
            background: linear-gradient(135deg, var(--accent-orange), #ff7043);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 152, 0, 0.3);
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.4);
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, var(--primary-green) 0%, #1a4d2a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,0 1000,300 1000,1000 0,700"/></svg>');
            background-size: cover;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            animation: fadeInUp 1s ease-out;
        }

        .hero p {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            max-width: 600px;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--accent-green), #45a049);
            border: none;
            border-radius: 25px;
            padding: 1rem 2.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 6px 20px rgba(76, 175, 80, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.4);
        }

        .btn-secondary-custom {
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 25px;
            padding: 1rem 2.5rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-secondary-custom:hover {
            background: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-3px);
        }

        .hero-badge {
            position: absolute;
            top: 20%;
            right: 10%;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: float 6s ease-in-out infinite;
        }

        .hero-badge h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-orange);
            margin-bottom: 0.5rem;
        }

        .hero-badge p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            margin: 0;
        }

        /* Features Section */
        .features {
            padding: 5rem 0;
            background: var(--bg-light);
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.05);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-green), var(--accent-orange));
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-hover);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-green), var(--primary-green));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1);
        }

        .feature-card h5 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 1rem;
            font-size: 1.25rem;
        }

        .feature-card p {
            color: var(--text-light);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Counselors Section */
        .counselors {
            padding: 5rem 0;
            background: white;
        }

        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .section-divider {
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-green), var(--accent-orange));
            margin: 0 auto 1rem;
            border-radius: 2px;
        }

        .section-header p {
            font-size: 1.1rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        .counselor-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
        }

        .counselor-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .counselor-image {
            height: 250px;
            background: linear-gradient(135deg, var(--primary-green), var(--accent-green));
            position: relative;
            overflow: hidden;
        }

        .counselor-image::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 200"><circle cx="100" cy="100" r="80" fill="rgba(255,255,255,0.1)"/></svg>');
            background-size: cover;
            background-position: center;
        }

        .counselor-card .card-body {
            padding: 2rem;
        }

        .counselor-card h5 {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .counselor-role {
            color: var(--accent-orange);
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .specialization {
            background: var(--light-green);
            padding: 0.75rem 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            border-left: 4px solid var(--accent-green);
        }

        .specialization strong {
            color: var(--primary-green);
        }

        .availability {
            background: var(--bg-light);
            padding: 1rem;
            border-radius: 10px;
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* Testimonials */
        .testimonials {
            padding: 5rem 0;
            background: var(--bg-light);
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem;
            box-shadow: var(--shadow);
            position: relative;
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .testimonial-card::before {
            content: '"';
            position: absolute;
            top: -10px;
            left: 20px;
            font-size: 4rem;
            color: var(--accent-green);
            font-weight: 700;
        }

        .testimonial-text {
            font-style: italic;
            font-size: 1.1rem;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .testimonial-author {
            font-weight: 600;
            color: var(--primary-green);
        }

        .testimonial-role {
            color: var(--text-light);
            font-size: 0.9rem;
        }

        /* FAQ Section */
        .faq {
            padding: 5rem 0;
            background: white;
        }

        .faq-item {
            background: white;
            border-radius: 15px;
            margin-bottom: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .faq-question {
            background: none;
            border: none;
            padding: 1.5rem 2rem;
            width: 100%;
            text-align: left;
            font-weight: 600;
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-question:hover {
            background: var(--light-green);
        }

        .faq-question i {
            color: var(--accent-green);
            transition: transform 0.3s ease;
        }

        .faq-question.active i {
            transform: rotate(45deg);
        }

        .faq-answer {
            padding: 0 2rem 1.5rem;
            color: var(--text-light);
            line-height: 1.6;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, var(--primary-green), #1a4d2a);
            color: white;
            padding: 3rem 0 1rem;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.02)" points="0,0 1000,200 1000,1000 0,800"/></svg>');
            background-size: cover;
        }

        .footer-content {
            position: relative;
            z-index: 2;
        }

        .newsletter {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            margin-bottom: 3rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .newsletter h4 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .newsletter-form {
            display: flex;
            gap: 1rem;
            max-width: 500px;
            margin: 1.5rem auto 0;
        }

        .newsletter-form input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
        }

        .newsletter-form button {
            background: var(--accent-orange);
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        .newsletter-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 152, 0, 0.4);
        }

        .footer-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-section h6 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--accent-orange);
        }

        .footer-section a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .footer-section a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            margin-bottom: 0;
        }

        .social-links a:hover {
            background: var(--accent-orange);
            transform: translateY(-2px);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero-badge {
                display: none;
            }
            
            .feature-card {
                margin-bottom: 2rem;
            }
            
            .newsletter-form {
                flex-direction: column;
            }
            
            .footer-links {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--primary-green), var(--accent-green)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.5rem;">C</div>
                <span>CMU Guidance & Counseling</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#counselors">Counselors</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-3">
                        <a href="/login" class="btn btn-auth">
                            <i class="fas fa-user-circle me-2"></i>Sign In
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100" style="min-height: 70vh;">
                <div class="col-lg-8 text-center mt-4">
                    <div class="hero-content">
                        <h1 class="mt-4">Empowering Students Through Accessible Counseling</h1>
                        <p class="text-center mx-auto">Your mental health matters. Connect with professional counselors, access valuable resources, and take control of your well-being journey with our comprehensive support system.</p>
                        <div class="hero-buttons justify-content-center d-flex flex-wrap">
                            <a href="#" class="btn btn-primary-custom">
                                <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                            </a>
                            <a href="#" class="btn btn-secondary-custom">
                                <i class="fas fa-comments me-2"></i>Start Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="hero-badge d-none d-lg-block">
            <h3>24/7</h3>
            <p>Crisis Support<br>Available</p>
        </div>

        <div class="hero-badge d-none d-lg-block">
            <h3>24/7</h3>
            <p>Crisis Support<br>Available</p>
        </div>

    </section>

    <!-- Features Section -->
    <section id="services" class="features">
        <div class="container">
            <div class="section-header">
                <h2>Why Choose Our Services</h2>
                <div class="section-divider"></div>
                <p>We provide comprehensive mental health support tailored to student needs</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5>Easy Scheduling</h5>
                        <p>Book appointments seamlessly with our intuitive online system. Choose your preferred time and counselor with just a few clicks.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5>Live Chat Support</h5>
                        <p>Get immediate assistance through our secure real-time chat system. Available 24/7 for crisis support and general guidance.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5>100% Confidential</h5>
                        <p>All sessions and communications are strictly confidential. Your privacy and trust are our top priorities.</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <h5>Resource Library</h5>
                        <p>Access comprehensive self-help materials, guides, and tools designed to support your mental health journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Counselors Section -->
    <section id="counselors" class="counselors">
        <div class="container">
            <div class="section-header">
                <h2>Meet Our Professional Team</h2>
                <div class="section-divider"></div>
                <p>Experienced, licensed professionals dedicated to supporting your mental health and academic success</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="counselor-card">
                        <div class="counselor-image">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-user-md text-white" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Dr. Mary Smith</h5>
                            <div class="counselor-role">Licensed Clinical Psychologist</div>
                            <div class="specialization">
                                <strong>Specializes in:</strong> Academic Stress, Anxiety Disorders, Depression Management
                            </div>
                            <p class="text-muted">15+ years of experience helping students overcome academic challenges and develop healthy coping strategies.</p>
                            <div class="availability">
                                <strong>Available:</strong><br>
                                Mon & Wed: 9:00 AM - 4:00 PM<br>
                                Fri: 10:00 AM - 2:00 PM
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="counselor-card">
                        <div class="counselor-image">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-user-tie text-white" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Prof. John Doe</h5>
                            <div class="counselor-role">Career Development Specialist</div>
                            <div class="specialization">
                                <strong>Specializes in:</strong> Career Planning, Graduate School Prep, Professional Development
                            </div>
                            <p class="text-muted">Expert in helping students identify career paths aligned with their strengths and aspirations.</p>
                            <div class="availability">
                                <strong>Available:</strong><br>
                                Tue & Thu: 10:00 AM - 5:00 PM
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <div class="counselor-card">
                        <div class="counselor-image">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-user-graduate text-white" style="font-size: 4rem;"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5>Dr. Sarah Wilson</h5>
                            <div class="counselor-role">Personal Development Coach</div>
                            <div class="specialization">
                                <strong>Specializes in:</strong> Self-Esteem Building, Relationship Counseling, Life Transitions
                            </div>
                            <p class="text-muted">Passionate about helping students build confidence and develop healthy relationships.</p>
                            <div class="availability">
                                <strong>Available:</strong><br>
                                Mon & Fri: 11:00 AM - 6:00 PM<br>
                                Wed: 9:00 AM - 3:00 PM
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <h2>Student Success Stories</h2>
                <div class="section-divider"></div>
                <p>Real experiences from students who have benefited from our counseling services</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <p class="testimonial-text">The counseling services at CMU helped me manage my anxiety before exams. Dr. Smith provided practical techniques that I still use today. I'm now more confident and focused.</p>
                        <div class="testimonial-author">Jamie C.</div>
                        <div class="testimonial-role">Computer Science, Senior</div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <p class="testimonial-text">When I was struggling with career decisions, Prof. Doe helped me identify my strengths and explore options I hadn't considered before. The career planning sessions were transformative.</p>
                        <div class="testimonial-author">Alex M.</div>
                        <div class="testimonial-role">Business Administration, Junior</div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="testimonial-card">
                        <p class="testimonial-text">The 24/7 chat support was there for me during a late-night study session when I was overwhelmed. Just having someone to talk to made all the difference in my mental health journey.</p>
                        <div class="testimonial-author">Taylor W.</div>
                        <div class="testimonial-role">Engineering, Sophomore</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq">
        <div class="container">
            <div class="section-header">
                <h2>Frequently Asked Questions</h2>
                <div class="section-divider"></div>
                <p>Find answers to common questions about our counseling services</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>How do I know if I need counseling?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="faq-answer" style="display: none;">
                            <p>If you're experiencing persistent stress, anxiety, sadness, or having trouble coping with academic or personal challenges, counseling can help. There's no problem too small or too big to discuss with a professional counselor. Trust your instincts - if you feel you could benefit from support, we're here to help.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Is counseling completely confidential?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="faq-answer" style="display: none;">
                            <p>Yes, all sessions and communications are strictly confidential. Information is only shared if there is imminent danger to yourself or others, or as required by law. Your privacy and trust are fundamental to our therapeutic relationship.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>How many counseling sessions can I have?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="faq-answer" style="display: none;">
                            <p>As a CMU student, you're entitled to 10 free counseling sessions per academic year. Additional sessions can be arranged based on your specific needs and our availability. We believe in providing adequate support for your mental health journey.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>What if I need to cancel or reschedule an appointment?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="faq-answer" style="display: none;">
                            <p>Please provide at least 24 hours notice if you need to cancel or reschedule your appointment. You can easily manage your appointments through our online portal or by calling our office directly. This helps us serve other students who may need immediate support.</p>
                        </div>
                    </div>
                    
                    <div class="faq-item">
                        <button class="faq-question" type="button">
                            <span>Is crisis support available outside office hours?</span>
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="faq-answer" style="display: none;">
                            <p>Yes, we provide 24/7 crisis support through our emergency hotline and chat system. If you're experiencing a mental health crisis, don't hesitate to reach out immediately. We also have partnerships with local emergency services for urgent situations.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contact" class="py-5" style="background: var(--bg-light);">
        <div class="container">
            <div class="section-header">
                <h2 style="color: var(--primary-green);">Contact Us</h2>
                <div class="section-divider" style="background: var(--accent-orange);"></div>
                <p>Get in touch with our team</p>
            </div>
            <div class="row g-4">
                <!-- Contact Info Cards -->
                <div class="col-lg-4">
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                                <div class="mb-2" style="font-size: 2rem; color: var(--primary-green);">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h5 class="fw-bold mb-2" style="color: var(--primary-green);">Visit Us</h5>
                                <div class="text-muted small">Student Center, Room 301<br>CMU Campus<br>Central Avenue, City</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                                <div class="mb-2" style="font-size: 2rem; color: var(--primary-green);">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h5 class="fw-bold mb-2" style="color: var(--primary-green);">Office Hours</h5>
                                <div class="text-muted small">Monday-Friday: 8:00 AM - 6:00 PM<br>Saturday: 9:00 AM - 1:00 PM<br>Sunday: Closed</div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                                <div class="mb-2" style="font-size: 2rem; color: var(--primary-green);">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h6 class="fw-bold mb-2" style="color: var(--primary-green);">Call Us</h6>
                                <div class="text-muted small">Office: (555) 123-4567<br>Emergency: (555) 987-6543</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                                <div class="mb-2" style="font-size: 2rem; color: var(--primary-green);">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h6 class="fw-bold mb-2" style="color: var(--primary-green);">Email Us</h6>
                                <div class="text-muted small">counseling@cmu.edu<br>appointments@cmu.edu</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="bg-white rounded-4 shadow-sm p-5 h-100">
                        <h4 class="fw-bold mb-4" style="color: var(--primary-green);">Send Us a Message</h4>
                        <form>
                            <div class="mb-3">
                                <label for="contactName" class="form-label">Your Name</label>
                                <input type="text" class="form-control" id="contactName" placeholder="Enter your name">
                            </div>
                            <div class="mb-3">
                                <label for="contactEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="contactEmail" placeholder="Enter your email">
                            </div>
                            <div class="mb-3">
                                <label for="contactSubject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="contactSubject" placeholder="Subject">
                            </div>
                            <div class="mb-3">
                                <label for="contactMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="contactMessage" rows="5" placeholder="Type your message..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success px-4 py-2 fw-bold" style="background: var(--primary-green); border: none; border-radius: 8px; box-shadow: 0 4px 15px rgba(45,90,61,0.1);">SEND MESSAGE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <!-- Newsletter Section -->
                <div class="newsletter">
                    <h4>Stay Connected with Mental Health Resources</h4>
                    <p>Subscribe to receive the latest wellness tips, mental health resources, and updates about our services.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Enter your email address" required>
                        <button type="submit">
                            <i class="fas fa-paper-plane me-2"></i>Subscribe
                        </button>
                    </form>
                </div>
                
                <!-- Footer Links -->
                <div class="footer-links">
                    <div class="footer-section">
                        <h6>Quick Links</h6>
                        <a href="#home">Home</a>
                        <a href="#counselors">Our Counselors</a>
                        <a href="#services">Services</a>
                        <a href="#resources">Resources</a>
                        <a href="#contact">Contact Us</a>
                    </div>
                    
                    <div class="footer-section">
                        <h6>Student Resources</h6>
                        <a href="#">Mental Health Toolkit</a>
                        <a href="#">Academic Support</a>
                        <a href="#">Crisis Resources</a>
                        <a href="#">Wellness Programs</a>
                        <a href="#">Study Groups</a>
                    </div>
                    
                    <div class="footer-section">
                        <h6>Support Services</h6>
                        <a href="#">Individual Counseling</a>
                        <a href="#">Group Therapy</a>
                        <a href="#">Career Counseling</a>
                        <a href="#">Academic Coaching</a>
                        <a href="#">Peer Support</a>
                    </div>
                    
                    <div class="footer-section">
                        <h6>Important Information</h6>
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms of Service</a>
                        <a href="#">Confidentiality Agreement</a>
                        <a href="#">Accessibility Statement</a>
                        <a href="#">Emergency Contacts</a>
                    </div>
                    
                    <div class="footer-section">
                        <h6>Connect With Us</h6>
                        <p>Follow us for daily wellness tips and mental health awareness</p>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" aria-label="Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" aria-label="Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Copyright -->
                <div class="text-center py-3 mt-4" style="border-top: 1px solid rgba(255,255,255,0.1);">
                    <p class="mb-2">&copy; 2025 CMU Guidance & Counseling Center. All rights reserved.</p>
                    <p class="mb-0 small">
                        <a href="#" class="text-white-50 me-3">Emergency: (088) 123-4567</a>
                        <a href="#" class="text-white-50 me-3">Crisis Text: 741741</a>
                        <a href="#" class="text-white-50">Campus Safety: (088) 987-6543</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // FAQ functionality
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', function() {
                const answer = this.nextElementSibling;
                const icon = this.querySelector('i');
                const isOpen = answer.style.display === 'block';
                
                // Close all other FAQ items
                document.querySelectorAll('.faq-answer').forEach(item => {
                    item.style.display = 'none';
                });
                document.querySelectorAll('.faq-question').forEach(btn => {
                    btn.classList.remove('active');
                    btn.querySelector('i').classList.remove('fa-minus');
                    btn.querySelector('i').classList.add('fa-plus');
                });
                
                // Toggle current item
                if (!isOpen) {
                    answer.style.display = 'block';
                    this.classList.add('active');
                    icon.classList.remove('fa-plus');
                    icon.classList.add('fa-minus');
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.15)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            }
        });

        // Newsletter form submission
        document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            if (email) {
                // Show success message
                const button = this.querySelector('button');
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check me-2"></i>Subscribed!';
                button.style.background = 'var(--accent-green)';
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.style.background = 'var(--accent-orange)';
                    this.reset();
                }, 2000);
            }
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.feature-card, .counselor-card, .testimonial-card, .faq-item').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>
</html>