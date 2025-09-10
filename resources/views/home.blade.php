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
            --primary-green: #228B22; /* Forest Green */
            --accent-green: #2e7d32; /* Complementary Green */
            --light-green: #eaf5ea;  /* Light Green Tint */
            --accent-orange: #FFCB05; /* Maize Yellow */
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
            transform: translateY(0);
            opacity: 1;
            transition: transform 0.25s ease, opacity 0.25s ease, background 0.3s ease, box-shadow 0.3s ease;
            z-index: 1042;
        }

        /* Hide-on-scroll behavior */
        .navbar.nav-hidden {
            transform: translateY(-100%);
            opacity: 0;
        }

        /* Hover-to-reveal navbar */
        .navbar-reveal-zone {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 12px;
            z-index: 1041;
        }

        .navbar:hover,
        .navbar:focus-within,
        .navbar-reveal-zone:hover + .navbar {
            transform: translateY(0);
            opacity: 1;
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
            background: linear-gradient(135deg, var(--primary-green) 0%, #0f3d1e 100%);
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

        /* Announcements (enhanced) */
        #announcements .announcement-card {
            background: white;
            border-radius: 16px;
            border: 1px solid rgba(0,0,0,0.06);
            box-shadow: var(--shadow);
            padding: 1.5rem;
            height: 100%;
            position: relative;
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        #announcements .announcement-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
        }

        #announcements .announcement-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(0,0,0,0.08);
        }

        #announcements .announcement-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--accent-green), var(--primary-green));
            color: white;
            box-shadow: 0 6px 16px rgba(34,139,34,0.2);
            margin-bottom: 1rem;
        }

        #announcements .announcement-title {
            color: var(--text-dark);
            font-weight: 700;
            margin-bottom: .25rem;
        }

        #announcements .announcement-meta {
            display: flex;
            align-items: center;
            gap: .5rem;
            margin-bottom: .75rem;
        }

        #announcements .announcement-date {
            display: inline-block;
            padding: .25rem .6rem;
            border-radius: 999px;
            background: rgba(255, 203, 5, 0.15);
            color: #8a6d00;
            font-size: .8rem;
            font-weight: 600;
        }

        #announcements .badge-new {
            display: inline-block;
            padding: .25rem .5rem;
            border-radius: 999px;
            background: var(--accent-orange);
            color: #1a1a1a;
            font-size: .72rem;
            font-weight: 700;
        }

        #announcements .announcement-excerpt {
            color: var(--text-light);
        }

        #announcements .announcement-action {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: var(--accent-green);
            text-decoration: none;
            font-weight: 600;
        }

        #announcements .announcement-action:hover {
            color: var(--primary-green);
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

        .testimonials-carousel {
            position: relative;
        }

        .testimonials-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
        }

        .testimonials-track {
            transition: transform 0.5s ease-in-out;
        }

        .testimonial-slide {
            padding: 0 1rem;
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            margin: 1rem;
            box-shadow: var(--shadow);
            position: relative;
            transition: all 0.3s ease;
            height: 100%;
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

        /* Navigation Arrows */
        .testimonial-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-green);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 4px 15px rgba(34, 139, 34, 0.3);
        }

        .testimonial-nav:hover {
            background: var(--accent-green);
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 20px rgba(34, 139, 34, 0.4);
        }

        .testimonial-nav:active {
            transform: translateY(-50%) scale(0.95);
        }

        .testimonial-prev {
            left: -25px;
        }

        .testimonial-next {
            right: -25px;
        }

        /* Dots Indicator */
        .testimonial-dots {
            margin-top: 2rem;
        }

        .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(34, 139, 34, 0.3);
            margin: 0 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dot.active {
            background: var(--primary-green);
            transform: scale(1.2);
        }

        .dot:hover {
            background: var(--accent-green);
            transform: scale(1.1);
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
            background: linear-gradient(135deg, var(--primary-green), #0f3d1e);
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

            /* Testimonials responsive */
            .testimonial-slide {
                width: 100% !important;
            }

            .testimonial-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .testimonial-prev {
                left: -20px;
            }

            .testimonial-next {
                right: -20px;
            }

            .testimonial-card {
                margin: 0.5rem;
                padding: 2rem;
            }
        }

        @media (max-width: 992px) {
            .testimonial-slide {
                width: 50% !important;
            }
        }
        
        
        
        /* Page Zoom */
        .home-zoom {
            zoom: 0.85;
        }
        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.85);
                transform-origin: top center;
            }
        }
    </style>
</head>
<body>
    <div class="home-zoom">
    <!-- Navigation -->
    <div class="navbar-reveal-zone" aria-hidden="true"></div>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" role="navigation" aria-label="Primary">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" aria-label="CMU Guidance & Counseling home">
                <img src="{{ asset('images/logo.jpg') }}" alt="CMU Logo">
                <span>CMU Guidance & Counseling Center</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                        <a href="#" class="btn btn-auth" data-bs-toggle="modal" data-bs-target="#loginModal">
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
                            <a href="{{ auth()->check() ? route('appointments.create') : route('login') }}" class="btn btn-primary-custom" aria-label="Book appointment">
                                <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                            </a>
                            <a href="{{ auth()->check() ? route('chat') : route('login') }}" class="btn btn-secondary-custom" aria-label="Start chat">
                                <i class="fas fa-comments me-2"></i>Start Chat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Announcements Section -->
    <section id="announcements" class="py-5" style="background: var(--bg-light);">
        <div class="container">
            <div class="section-header">
                <h2 style="color: var(--primary-green);">Announcements</h2>
                <div class="section-divider" style="background: var(--accent-orange);"></div>
                <p>Latest updates and important information from our center</p>
            </div>

            <div class="row g-4">
                @forelse($announcements as $announcement)
                <div class="col-lg-4 col-md-6">
                    <div class="announcement-card h-100 position-relative">
                        <div class="announcement-icon"><i class="fas fa-bullhorn"></i></div>
                        <h5 class="announcement-title">{{ $announcement->title }}</h5>
                        <div class="announcement-meta">
                            <span class="announcement-date">{{ optional($announcement->created_at)->format('M d, Y') }}</span>
                            @if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14)))
                                <span class="badge-new">NEW</span>
                            @endif
                        </div>
                        <p class="announcement-excerpt mb-4">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->content ?? $announcement->body ?? ''), 160) }}</p>
                        <a href="{{ route('announcements.show', $announcement) }}" class="announcement-action stretched-link" aria-label="Read more about {{ $announcement->title }}">
                            <span>Read more</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="bg-white rounded-4 shadow-sm p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center announcement-icon" style="margin-bottom: .75rem;">
                            <i class="fas fa-bullhorn"></i>
                        </div>
                        <h5 class="fw-bold mb-2" style="color: var(--text-dark);">No announcements yet</h5>
                        <p class="mb-0 text-muted">Please check back later for updates and center news.</p>
                    </div>
                </div>
                @endforelse
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('announcements.index') }}" class="btn btn-success px-4 py-2 fw-bold" style="background: var(--primary-green); border: none; border-radius: 10px; box-shadow: 0 6px 18px rgba(34,139,34,0.18);">
                    <i class="fas fa-list me-2"></i>View all announcements
                </a>
            </div>
        </div>
    </section>

    <!-- Counselors Section -->
    <section id="counselors" class="counselors py-5" style="background: var(--bg-light);">
        <div class="container">
            <div class="section-header">
                <h2 style="color: var(--primary-green);">Meet Our Professional Team</h2>
                <div class="section-divider" style="background: var(--accent-orange);"></div>
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
    <section class="testimonials py-5" style="background: white;">
        <div class="container">
            <div class="section-header">
                <h2 style="color: var(--primary-green);">Student Success Stories</h2>
                <div class="section-divider" style="background: var(--accent-orange);"></div>
                <p>Real experiences from students who have benefited from our counseling services</p>
            </div>
            
            <div class="testimonials-carousel position-relative">
                <div class="testimonials-container overflow-hidden">
                    <div class="testimonials-track d-flex" id="testimonialsTrack">
                        <!-- Testimonial 1 -->
                        <div class="testimonial-slide flex-shrink-0" style="width: 33.333%;">
                            <div class="testimonial-card">
                                <p class="testimonial-text">The counseling services at CMU helped me manage my anxiety before exams. Dr. Smith provided practical techniques that I still use today. I'm now more confident and focused.</p>
                                <div class="testimonial-author">Jamie C.</div>
                                <div class="testimonial-role">Computer Science, Senior</div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 2 -->
                        <div class="testimonial-slide flex-shrink-0" style="width: 33.333%;">
                            <div class="testimonial-card">
                                <p class="testimonial-text">When I was struggling with career decisions, Prof. Doe helped me identify my strengths and explore options I hadn't considered before. The career planning sessions were transformative.</p>
                                <div class="testimonial-author">Alex M.</div>
                                <div class="testimonial-role">Business Administration, Junior</div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 3 -->
                        <div class="testimonial-slide flex-shrink-0" style="width: 33.333%;">
                            <div class="testimonial-card">
                                <p class="testimonial-text">The 24/7 chat support was there for me during a late-night study session when I was overwhelmed. Just having someone to talk to made all the difference in my mental health journey.</p>
                                <div class="testimonial-author">Taylor W.</div>
                                <div class="testimonial-role">Engineering, Sophomore</div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 4 -->
                        <div class="testimonial-slide flex-shrink-0" style="width: 33.333%;">
                            <div class="testimonial-card">
                                <p class="testimonial-text">I was dealing with family issues that affected my studies. The counseling center provided a safe space to process my emotions and develop coping strategies. I graduated with honors!</p>
                                <div class="testimonial-author">Maria S.</div>
                                <div class="testimonial-role">Nursing, Graduate</div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 5 -->
                        <div class="testimonial-slide flex-shrink-0" style="width: 33.333%;">
                            <div class="testimonial-card">
                                <p class="testimonial-text">The group therapy sessions helped me connect with other students facing similar challenges. We formed a support network that continues even after graduation.</p>
                                <div class="testimonial-author">David L.</div>
                                <div class="testimonial-role">Psychology, Senior</div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 6 -->
                        <div class="testimonial-slide flex-shrink-0" style="width: 33.333%;">
                            <div class="testimonial-card">
                                <p class="testimonial-text">As an international student, I felt isolated and homesick. The counselors helped me adjust to campus life and build meaningful friendships. CMU feels like home now.</p>
                                <div class="testimonial-author">Ahmed K.</div>
                                <div class="testimonial-role">Information Technology, Junior</div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 7 -->
                        <div class="testimonial-slide flex-shrink-0" style="width: 33.333%;">
                            <div class="testimonial-card">
                                <p class="testimonial-text">I struggled with time management and academic pressure. The study skills workshops and one-on-one sessions with counselors transformed my approach to learning.</p>
                                <div class="testimonial-author">Sarah P.</div>
                                <div class="testimonial-role">Education, Sophomore</div>
                            </div>
                        </div>
                        
                        <!-- Testimonial 8 -->
                        <div class="testimonial-slide flex-shrink-0" style="width: 33.333%;">
                            <div class="testimonial-card">
                                <p class="testimonial-text">The career counseling helped me discover my passion for research. I'm now pursuing a master's degree and working as a research assistant. Thank you, CMU counseling!</p>
                                <div class="testimonial-author">Michael R.</div>
                                <div class="testimonial-role">Biology, Graduate</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Navigation Arrows -->
                <button class="testimonial-nav testimonial-prev" id="testimonialPrev" aria-label="Previous testimonials">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="testimonial-nav testimonial-next" id="testimonialNext" aria-label="Next testimonials">
                    <i class="fas fa-chevron-right"></i>
                </button>
                
                <!-- Dots Indicator -->
                <div class="testimonial-dots text-center mt-4">
                    <span class="dot active" data-slide="0"></span>
                    <span class="dot" data-slide="1"></span>
                    <span class="dot" data-slide="2"></span>
                    <span class="dot" data-slide="3"></span>
                    <span class="dot" data-slide="4"></span>
                    <span class="dot" data-slide="5"></span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="services" class="features py-5" style="background: var(--bg-light);">
        <div class="container">
            <div class="section-header">
                <h2 style="color: var(--primary-green);">Why Choose Our Services</h2>
                <div class="section-divider" style="background: var(--accent-orange);"></div>
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


    <!-- FAQ Section -->
    <section class="faq py-5" style="background: white;">
        <div class="container">
            <div class="section-header">
                <h2 style="color: var(--primary-green);">Frequently Asked Questions</h2>
                <div class="section-divider" style="background: var(--accent-orange);"></div>
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
                <p>Visit our Guidance and Counseling Center at CMU</p>
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
                                <div class="text-muted small">Office of Student Affairs<br>Central Mindanao University<br>Musuan, Maramag, Bukidnon</div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                                <div class="mb-2" style="font-size: 2rem; color: var(--primary-green);">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h5 class="fw-bold mb-2" style="color: var(--primary-green);">Office Hours</h5>
                                <div class="text-muted small">Monday-Friday: 8:00 AM - 5:00 PM<br>Saturday: 9:00 AM - 12:00 PM<br>Sunday: Closed</div>
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
                                <div class="text-muted small">Office: (088) 356-0802<br>Emergency: (088) 356-0803</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                                <div class="mb-2" style="font-size: 2rem; color: var(--primary-green);">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <h6 class="fw-bold mb-2" style="color: var(--primary-green);">Email Us</h6>
                                <div class="text-muted" style="font-size: 0.95rem; line-height: 1.8;">
                                    <div>gcc@cmu.edu.ph</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Map Location -->
                <div class="col-lg-8">
                    <div class="bg-white rounded-4 shadow-sm overflow-hidden h-100">
                        <div class="p-4 border-bottom">
                            <h4 class="fw-bold mb-2" style="color: var(--primary-green);">
                                <i class="fas fa-map-marked-alt me-2"></i>Our Location
                            </h4>
                            <p class="text-muted mb-0">Central Mindanao University - Office of Student Affairs</p>
                        </div>
                        <div class="position-relative" style="height: 400px;">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2873.3071768702684!2d125.04851375433854!3d7.857984169928984!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x32ff183d356de2b7%3A0xabf652a12386c983!2sCMU%20Office%20of%20Student%20Affairs!5e0!3m2!1sen!2sph!4v1757472964019!5m2!1sen!2sph" 
                                width="100%" 
                                height="100%" 
                                style="border:0;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade"
                                title="CMU Office of Student Affairs Location">
                            </iframe>
                            <div class="position-absolute top-0 end-0 m-3">
                                <a href="https://maps.google.com/?q=Central+Mindanao+University+Musuan+Maramag+Bukidnon" 
                                   target="_blank" 
                                   class="btn btn-success btn-sm fw-bold" 
                                   style="background: var(--primary-green); border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(34,139,34,0.3);">
                                    <i class="fas fa-external-link-alt me-1"></i>Open in Maps
                                </a>
                            </div>
                        </div>
                        <div class="p-4 bg-light">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3" style="color: var(--primary-green);">
                                            <i class="fas fa-walking" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <small class="fw-bold text-dark">Walking Distance</small>
                                            <div class="text-muted small">5-10 minutes from main gate</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3" style="color: var(--primary-green);">
                                            <i class="fas fa-car" style="font-size: 1.2rem;"></i>
                                        </div>
                                        <div>
                                            <small class="fw-bold text-dark">Parking Available</small>
                                            <div class="text-muted small">Student Center parking area</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                
                
                <!-- Footer Links -->
                <div class="footer-links">
                    <div class="footer-section">
                        <h6>Quick Links</h6>
                        <a href="#home">Home</a>
                        <a href="#counselors">Our Counselors</a>
                        <a href="#services">Services</a>
                        <a href="{{ route('resources') }}">Resources</a>
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
    </div>

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

        // Hide navbar when scrolled, show on hover via CSS
        (function() {
            const navbar = document.querySelector('.navbar');
            const toggleHidden = () => {
                if (window.scrollY > 5) {
                    navbar.classList.add('nav-hidden');
                } else {
                    navbar.classList.remove('nav-hidden');
                }
            };
            toggleHidden();
            window.addEventListener('scroll', toggleHidden);
        })();

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

        // Testimonials Carousel
        let currentSlide = 0;
        const totalSlides = 6; // Number of slide groups (8 testimonials / 3 per slide = ~3 groups, but we'll show 6 groups for smooth scrolling)
        const track = document.getElementById('testimonialsTrack');
        const prevBtn = document.getElementById('testimonialPrev');
        const nextBtn = document.getElementById('testimonialNext');
        const dots = document.querySelectorAll('.dot');

        function updateCarousel() {
            const slideWidth = 100 / 3; // 3 slides visible at once
            const translateX = -currentSlide * slideWidth;
            track.style.transform = `translateX(${translateX}%)`;
            
            // Update dots
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
            
            // Update button states
            prevBtn.style.opacity = currentSlide === 0 ? '0.5' : '1';
            nextBtn.style.opacity = currentSlide === totalSlides - 1 ? '0.5' : '1';
        }

        function nextSlide() {
            if (currentSlide < totalSlides - 1) {
                currentSlide++;
                updateCarousel();
            }
        }

        function prevSlide() {
            if (currentSlide > 0) {
                currentSlide--;
                updateCarousel();
            }
        }

        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            updateCarousel();
        }

        // Event listeners
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => goToSlide(index));
        });

        // Auto-play functionality (optional)
        let autoPlayInterval;
        function startAutoPlay() {
            autoPlayInterval = setInterval(() => {
                if (currentSlide < totalSlides - 1) {
                    nextSlide();
                } else {
                    currentSlide = 0;
                    updateCarousel();
                }
            }, 5000); // Change slide every 5 seconds
        }

        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }

        // Start auto-play
        startAutoPlay();

        // Pause auto-play on hover
        const carousel = document.querySelector('.testimonials-carousel');
        if (carousel) {
            carousel.addEventListener('mouseenter', stopAutoPlay);
            carousel.addEventListener('mouseleave', startAutoPlay);
        }

        // Initialize carousel
        updateCarousel();
    </script>
    
    <!-- Auth Modals -->
    <style>
        /* Scoped modern styles for the auth modals */
        #loginModal .left-pane, #forgotPasswordModal .left-pane, #twoFactorModal .left-pane {
            background: linear-gradient(160deg, #0f5e1d 0%, #127a25 100%);
        }
        #loginModal .nav-tabs {
            border-bottom: 0;
            display: flex;
            justify-content: center;
            gap: 1.25rem;
        }
        #loginModal .nav-tabs .nav-link {
            border: 0;
            color: #344054;
            font-weight: 700;
            background-color: transparent !important;
            position: relative;
            z-index: 1;
        }
        #loginModal .nav-tabs .nav-link { padding-bottom: .5rem; }
        #loginModal .nav-tabs .nav-link.active,
        #loginModal .nav-tabs .nav-link.active:focus,
        #loginModal .nav-tabs .nav-link.active:hover {
            color: #0f5e1d !important;
            background-color: transparent !important;
            border-bottom: 3px solid #0f5e1d !important;
        }
        /* Remove any pseudo underline if present from earlier loads */
        #loginModal .nav-tabs .nav-link::after { content: none !important; }
        #loginModal .modal-content, #forgotPasswordModal .modal-content, #twoFactorModal .modal-content {
            box-shadow: 0 20px 60px rgba(0,0,0,.2);
            border: 0;
        }
        #loginModal .form-control, #forgotPasswordModal .form-control, #twoFactorModal .form-control {
            border-radius: 12px;
            border: 1px solid #e6e8ec;
            padding: 12px 14px;
        }
        #loginModal .form-control:focus, #forgotPasswordModal .form-control:focus, #twoFactorModal .form-control:focus {
            border-color: #b8e1c2;
            box-shadow: 0 0 0 .25rem rgba(15,94,29,.15);
        }
        #loginModal .input-group-text, #forgotPasswordModal .input-group-text, #twoFactorModal .input-group-text {
            border-radius: 12px 0 0 12px;
            background: #f3f5f7;
            border: 1px solid #e6e8ec;
            color: #0f5e1d;
        }
        #loginModal .btn-auth-primary, #forgotPasswordModal .btn-auth-primary, #twoFactorModal .btn-auth-primary {
            background: #0f5e1d;
            color: #fff;
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
        }
        #loginModal .btn-auth-primary:focus,
        #loginModal .btn-auth-primary:active,
        #loginModal .btn-auth-primary:disabled,
        #forgotPasswordModal .btn-auth-primary:focus,
        #forgotPasswordModal .btn-auth-primary:active,
        #forgotPasswordModal .btn-auth-primary:disabled,
        #twoFactorModal .btn-auth-primary:focus,
        #twoFactorModal .btn-auth-primary:active,
        #twoFactorModal .btn-auth-primary:disabled {
            background: #0f5e1d !important;
            color: #fff !important;
            border: none !important;
        }
        #loginModal .btn-auth-primary:hover, #forgotPasswordModal .btn-auth-primary:hover, #twoFactorModal .btn-auth-primary:hover { filter: brightness(.95); }
        #loginModal .tiny-link, #forgotPasswordModal .tiny-link, #twoFactorModal .tiny-link { color: var(--accent-green); text-decoration: none; }
        /* numbered bullets on left pane */
        #loginModal .num-badge { width: 32px; height: 32px; border-radius: 50% !important; display: inline-flex; align-items: center; justify-content: center; background:#ffc107; color:#0f5e1d; font-weight: 800; margin-right: .75rem; }
        /* otp inputs */
        #twoFactorModal .otp-box { display:flex; gap:.5rem; justify-content:center; }
        #twoFactorModal .otp-input { width: 42px; height: 48px; text-align:center; font-size:1.25rem; border-radius: 10px; border:1px solid #e6e8ec; }
        #twoFactorModal .otp-input:focus { outline: none; border-color:#0f5e1d; box-shadow: 0 0 0 .2rem rgba(15,94,29,.12); }
        /* green toggle buttons (Show/Hide) */
        #loginModal .btn-eye { border-color: #0f5e1d; color: #0f5e1d; background: #eaf6ee; }
        #loginModal .btn-eye:hover,
        #loginModal .btn-eye:focus,
        #loginModal .btn-eye:active { background: #0f5e1d; color: #fff; border-color: #0f5e1d; }
        /* tab indicator */
        #loginModal .tabs-wrapper { position: relative; padding-bottom: 10px; }
        #authTabIndicator { display:none; }
    </style>
    @guest
    <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-4 left-pane" style="color:#fff;">
                        <div class="text-center">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width:90px;height:90px;border-radius:50%; background:#fff; object-fit:cover;" class="mb-3">
                            <h5 class="fw-bold mb-3">CMU Guidance and<br> Counseling Center</h5>
                            <ul class="list-unstyled text-start mx-auto" style="max-width:260px;">
                                <li class="mb-3 d-flex align-items-center"><span class="num-badge">1</span><span>Easy appointment scheduling with university counselors</span></li>
                                <li class="mb-3 d-flex align-items-center"><span class="num-badge">2</span><span>Access to mental health resources and information</span></li>
                                <li class="d-flex align-items-center"><span class="num-badge">3</span><span>Secure and confidential counseling services</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7 p-4">
                        <div class="d-flex justify-content-end align-items-center mb-3">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="tabs-wrapper">
                            <ul class="nav nav-tabs mb-3" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="tab-login" data-bs-toggle="tab" data-bs-target="#pane-login" type="button" role="tab">Login</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="tab-signup" data-bs-toggle="tab" data-bs-target="#pane-signup" type="button" role="tab">Sign Up</button>
                                </li>
                            </ul>
                            <div id="authTabIndicator"></div>
                        </div>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="pane-login" role="tabpanel" aria-labelledby="tab-login">
                                <form id="modalLoginForm" method="POST" action="{{ url('/login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" class="form-control" required autocomplete="email" placeholder="Enter your email">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                            <input type="password" name="password" class="form-control" required autocomplete="current-password" placeholder="Enter your password" id="loginPassword">
                                            <button class="btn btn-outline-secondary btn-eye" type="button" id="toggleLoginPassword" style="border-radius:0 12px 12px 0;" aria-label="Show password"><i class="fas fa-eye"></i></button>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <a href="#" class="small tiny-link" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">Forgot Password?</a>
                                    </div>
                                    <button type="submit" class="btn w-100 fw-bold btn-auth-primary">Login</button>
                                </form>
                                
                            </div>
                            <div class="tab-pane fade" id="pane-signup" role="tabpanel" aria-labelledby="tab-signup">
                                <form method="POST" action="{{ url('/register') }}" enctype="multipart/form-data" id="signupForm">
                                    @csrf
                                    
                                    <div id="signupStep1">
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label">First Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="first_name" class="form-control" required placeholder="e.g., Juan">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Middle Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="middle_name" class="form-control" placeholder="Optional">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Last Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="last_name" class="form-control" required placeholder="e.g., Dela Cruz">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Contact Number</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                <input type="tel" name="contact_number" class="form-control" required placeholder="e.g., 09XXXXXXXXX" pattern="[0-9]{10,11}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Home Address</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                <input type="text" name="address" class="form-control" required placeholder="House/Street, Barangay, City/Province">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-auth-primary" id="goToStep2">Next</button>
                                        </div>
                                    </div>
                                    <div id="signupStep2" class="d-none">
                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" name="email" class="form-control" required autocomplete="email" placeholder="Enter your email">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" name="password" class="form-control" required autocomplete="new-password" placeholder="Create a password" id="signupPassword">
                                                <button class="btn btn-outline-secondary btn-eye" type="button" id="toggleSignupPassword" style="border-radius:0 12px 12px 0;" aria-label="Show password"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" name="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Confirm your password" id="signupPasswordConfirm">
                                                <button class="btn btn-outline-secondary btn-eye" type="button" id="toggleSignupPasswordConfirm" style="border-radius:0 12px 12px 0;" aria-label="Show password"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-secondary" id="backToStep1">Back</button>
                                            <button type="button" class="btn btn-auth-primary" id="goToStep3">Next</button>
                                        </div>
                                    </div>
                                    <div id="signupStep3" class="d-none">
                                        <div class="mb-3">
                                            <label class="form-label">Student ID</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                <input type="text" name="student_id" class="form-control" required placeholder="e.g., 2021-12345">
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-md-7">
                                                <label class="form-label">College</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-university"></i></span>
                                                    <select class="form-select" name="college" id="collegeSelect" required>
                                                        <option value="" selected disabled>Select college</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Year Level</label>
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
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <label class="form-label">Course / Program</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                                <select class="form-select" name="course" id="courseSelect" required>
                                                    <option value="" selected disabled>Select course</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3 mt-3">
                                            <label class="form-label">Attach COR (PDF/JPG/PNG)</label>
                                            <input class="form-control" type="file" name="cor_file" accept=".pdf,image/*" required>
                                            <div class="form-text">Max 5MB. Used for verification by the counselor.</div>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <button type="button" class="btn btn-outline-secondary" id="backToStep2">Back</button>
                        					<button type="submit" class="btn btn-auth-primary">Sign Up</button>
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
    @endguest

    @guest
    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-4 left-pane" style="color:#fff;">
                        <div class="text-center">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" style="width:90px;height:90px;border-radius:50%; background:#fff; object-fit:cover;" class="mb-3">
                            <h5 class="fw-bold mb-3">Reset your password</h5>
                            <p class="small mb-0">We’ll email you a secure link to create a new password.</p>
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
    <div class="modal fade" id="twoFactorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 overflow-hidden">
                <div class="row g-0">
                    <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-4 left-pane" style="color:#fff;">
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

    <script>
        // Auto-open relevant modal based on session flash
        document.addEventListener('DOMContentLoaded', function() {
            // Tab indicator alignment
            // Use simple active border underline to avoid disappearing indicator
            const loginTabBtn = document.getElementById('tab-login');
            const signupTabBtn = document.getElementById('tab-signup');
            if (loginTabBtn && signupTabBtn) {
                const updateBorders = () => {
                    loginTabBtn.classList.toggle('active', document.getElementById('pane-login').classList.contains('active'));
                    signupTabBtn.classList.toggle('active', document.getElementById('pane-signup').classList.contains('active'));
                };
                loginTabBtn.addEventListener('shown.bs.tab', updateBorders);
                signupTabBtn.addEventListener('shown.bs.tab', updateBorders);
                setTimeout(updateBorders, 0);
            }
            // Password visibility toggles
            const toggle = (btnId, inputId) => {
                const btn = document.getElementById(btnId);
                const input = document.getElementById(inputId);
                if (!btn || !input) return;
                btn.addEventListener('click', () => {
                    const showing = input.type === 'text';
                    input.type = showing ? 'password' : 'text';
                    const icon = btn.querySelector('i');
                    if (icon) icon.className = showing ? 'fas fa-eye' : 'fas fa-eye-slash';
                    btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
                });
            };
            toggle('toggleLoginPassword', 'loginPassword');
            toggle('toggleSignupPassword', 'signupPassword');
            toggle('toggleSignupPasswordConfirm', 'signupPasswordConfirm');

            // Sign up multi-step
            const step1 = document.getElementById('signupStep1');
            const step2 = document.getElementById('signupStep2');
            const step3 = document.getElementById('signupStep3');
            const goToStep2 = document.getElementById('goToStep2');
            const backToStep1 = document.getElementById('backToStep1');
            const goToStep3 = document.getElementById('goToStep3');
            const backToStep2 = document.getElementById('backToStep2');
            if (step1 && step2 && goToStep2 && backToStep1) {
                goToStep2.addEventListener('click', () => {
                    // simple front-end validation for step1 required fields
                    const required = step1.querySelectorAll('input[required], select[required]');
                    for (const field of required) {
                        if (!field.value) { field.focus(); return; }
                    }
                    step1.classList.add('d-none');
                    step2.classList.remove('d-none');
                });
                backToStep1.addEventListener('click', () => {
                    step2.classList.add('d-none');
                    step1.classList.remove('d-none');
                });
            }
            if (step2 && step3 && goToStep3 && backToStep2) {
                goToStep3.addEventListener('click', () => {
                    const required = step2.querySelectorAll('input[required], select[required]');
                    for (const field of required) {
                        if (!field.value) { field.focus(); return; }
                    }
                    step2.classList.add('d-none');
                    step3.classList.remove('d-none');
                });
                backToStep2.addEventListener('click', () => {
                    step3.classList.add('d-none');
                    step2.classList.remove('d-none');
                });
            }

            // College/Course mapping
            const collegeToCourses = {
                'College of Agriculture': [
                    'BS in Agriculture - Agronomy',
                    'BS in Agriculture - Agricultural Economics',
                    'BS in Agriculture - Agricultural Education',
                    'BS in Agriculture - Agricultural Extension',
                    'BS in Agriculture - Animal Science',
                    'BS in Agriculture - Entomology',
                    'BS in Agriculture - Horticulture',
                    'BS in Agriculture - Plant Pathology',
                    'BS in Agriculture - Soil Science',
                    'BS in Agribusiness Management (Crop Enterprise)',
                    'BS in Agribusiness Management (Livestock Enterprise)',
                    'BS in Development Communication'
                ],
                'College of Arts and Sciences': [
                    'BA in English',
                    'BA in History',
                    'BA in Political Science',
                    'BA in Psychology',
                    'BA in Sociology',
                    'BS in Biology',
                    'BS in Chemistry',
                    'BS in Mathematics',
                    'BS in Physics'
                ],
                'College of Business and Management': [
                    'BS in Accountancy (5 years)',
                    'BS in Accounting Technology (4 years)',
                    'Certificate in Accounting Technology (2 years)',
                    'BSBA - Marketing Management',
                    'BSBA - Financial Management',
                    'BSBA - Operations Management',
                    'BS in Office Administration',
                    'BS in Entrepreneurship'
                ],
                'College of Education': [
                    'BSEd - Biology',
                    'BSEd - English',
                    'BSEd - Filipino',
                    'BSEd - General Science',
                    'BSEd - Mathematics',
                    'BSEd - Physical Education',
                    'BSEd - Physics',
                    'Bachelor of Physical Education (BPEd)'
                ],
                'College of Engineering': [
                    'BS in Agricultural and Biosystems Engineering',
                    'BS in Civil Engineering',
                    'BS in Electrical Engineering',
                    'BS in Information Technology',
                    'BS in Mechanical Engineering'
                ],
                'College of Forestry': [
                    'BS in Environmental Science',
                    'BS in Forestry'
                ],
                'College of Human Ecology': [
                    'BS in Home Economics - Home Economics Education',
                    'BS in Home Economics - Food Business Management (Food Service)',
                    'BS in Home Economics - Food Business Management (Food Processing)',
                    'BS in Food Technology',
                    'BS in Nutrition and Dietetics',
                    'BS in Hotel and Restaurant Management'
                ],
                'College of Nursing': [
                    'BS in Nursing'
                ],
                'College of Veterinary Medicine': [
                    'Doctor of Veterinary Medicine'
                ],
                'College of Information Sciences and Computing': [
                    'BS in Information Technology'
                ]
            };

            const collegeSelect = document.getElementById('collegeSelect');
            const courseSelect = document.getElementById('courseSelect');
            if (collegeSelect && courseSelect) {
                // Populate colleges
                for (const college of Object.keys(collegeToCourses)) {
                    const opt = document.createElement('option');
                    opt.value = college; opt.textContent = college;
                    collegeSelect.appendChild(opt);
                }
                const populateCourses = () => {
                    courseSelect.innerHTML = '<option value="" disabled selected>Select course</option>';
                    const selected = collegeSelect.value;
                    const courses = collegeToCourses[selected] || [];
                    for (const c of courses) {
                        const opt = document.createElement('option');
                        opt.value = c; opt.textContent = c;
                        courseSelect.appendChild(opt);
                    }
                };
                collegeSelect.addEventListener('change', populateCourses);
            }

            const status = @json(session('status'));
            if (status && typeof status === 'string') {
                // If password reset email sent or verification resent, briefly toast could be shown.
                // Optionally, open login modal after actions
            }

            // AJAX login -> intercept 2FA redirect and open modal instead
            const loginForm = document.getElementById('modalLoginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const submitBtn = loginForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    try {
                        const formData = new FormData(loginForm);
                        const resp = await fetch(loginForm.action, {
                            method: 'POST',
                            headers: { 'X-Requested-With': 'XMLHttpRequest' },
                            body: formData,
                            redirect: 'manual',
                            credentials: 'same-origin'
                        });
                        // If server attempts redirect (opaqueredirect), assume 2FA and open modal
                        if (resp.type === 'opaqueredirect') {
                            const loginModalEl = document.getElementById('loginModal');
                            if (loginModalEl) bootstrap.Modal.getOrCreateInstance(loginModalEl).hide();
                            const twoFaEl = document.getElementById('twoFactorModal');
                            if (twoFaEl) bootstrap.Modal.getOrCreateInstance(twoFaEl).show();
                            return;
                        }
                        // If redirected somewhere else (e.g., dashboard), go there
                        if (resp.redirected) {
                            window.location.href = resp.url;
                            return;
                        }
                        if (resp.ok) {
                            // Some apps return 204/200 on success; reload
                            window.location.reload();
                        } else {
                            // Attempt to read validation errors
                            let msg = 'Login failed';
                            try { const data = await resp.json(); msg = (data.message || Object.values(data.errors||{})[0]?.[0]) || msg; } catch {}
                            alert(msg);
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Network error. Please try again.');
                    } finally {
                        submitBtn.disabled = false;
                    }
                });
            }

            // AJAX 2FA verify to avoid navigation
            const twofaForm = document.getElementById('modal2faForm');
            if (twofaForm) {
                // OTP input handling
                const otpInputs = Array.from(document.querySelectorAll('#twoFactorModal .otp-input'));
                const otpHidden = document.getElementById('otpHidden');
                const updateHidden = () => { if (otpHidden) otpHidden.value = otpInputs.map(i => i.value).join(''); };
                otpInputs.forEach((input, idx) => {
                    input.addEventListener('input', () => {
                        input.value = input.value.replace(/\D/g, '').slice(0,1);
                        if (input.value && idx < otpInputs.length - 1) otpInputs[idx+1].focus();
                        updateHidden();
                    });
                    input.addEventListener('keydown', (e) => {
                        if (e.key === 'Backspace' && !input.value && idx > 0) {
                            otpInputs[idx-1].focus();
                        }
                    });
                });

                twofaForm.addEventListener('submit', async function(e) {
                    e.preventDefault();
                    const submitBtn = twofaForm.querySelector('button[type="submit"]');
                    submitBtn.disabled = true;
                    try {
                        updateHidden();
                        const formData = new FormData(twofaForm);
                        const resp = await fetch(twofaForm.action, {
                            method: 'POST',
                            headers: { 'X-Requested-With': 'XMLHttpRequest' },
                            body: formData,
                            credentials: 'same-origin'
                        });
                        if (resp.ok || resp.redirected) {
                            window.location.href = resp.redirected ? resp.url : window.location.href;
                        } else {
                            let msg = 'Invalid authentication code';
                            try { const data = await resp.json(); msg = data.message || msg; } catch {}
                            alert(msg);
                        }
                    } catch (err) {
                        console.error(err);
                        alert('Network error. Please try again.');
                    } finally {
                        submitBtn.disabled = false;
                    }
                });
            }
        });
    </script>
</body>
</html>