<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMU Guidance & Counseling Center</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/auth-modal.css') }}" rel="stylesheet">
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

        html {
            scroll-behavior: smooth;
        }

        :root {
            --primary-green: #228B22;
            /* Forest Green */
            --accent-green: #2e7d32;
            /* Complementary Green */
            --light-green: #eaf5ea;
            /* Light Green Tint */
            --accent-orange: #FFCB05;
            /* Maize Yellow */
            --text-dark: #2c3e50;
            --text-light: #6c757d;
            --bg-light: #f8f9fa;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
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
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
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
        .navbar-reveal-zone:hover+.navbar {
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
            border: 1px solid rgba(0, 0, 0, 0.06);
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
            border-color: rgba(0, 0, 0, 0.08);
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
            box-shadow: 0 6px 16px rgba(34, 139, 34, 0.2);
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

        /* Modern Horizontal Announcements */
        .announcements-carousel {
            margin: 2rem 0;
        }

        .announcements-container {
            background: white;
            border-radius: 20px;
            box-shadow: var(--shadow);
            overflow: hidden;
            position: relative;
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }

        .announcements-track {
            transition: transform 0.5s ease-in-out;
            display: flex;
        }

        .announcement-slide {
            flex-shrink: 0;
            width: 100%;
            min-width: 100%;
            position: relative;
        }

        .announcement-card-horizontal {
            background: white;
            border-radius: 20px;
            padding: 0;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .announcement-content {
            display: flex;
            align-items: center;
            min-height: 200px;
            padding: 2rem;
            position: relative;
        }

        .announcement-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-right: 2rem;
            min-width: 120px;
        }

        .announcement-icon-large {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--accent-green), var(--primary-green));
            color: white;
            font-size: 2rem;
            box-shadow: 0 8px 25px rgba(34, 139, 34, 0.25);
            margin-bottom: 1rem;
        }

        .announcement-meta {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        }

        .announcement-date {
            display: inline-block;
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            background: rgba(255, 203, 5, 0.15);
            color: #8a6d00;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-new {
            display: inline-block;
            padding: 0.3rem 0.6rem;
            border-radius: 20px;
            background: var(--accent-orange);
            color: #1a1a1a;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .announcement-body {
            flex: 1;
            padding-left: 1rem;
        }

        .announcement-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .announcement-excerpt {
            font-size: 1.1rem;
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .announcement-action {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--accent-green);
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
            border: 2px solid var(--accent-green);
            border-radius: 25px;
            transition: all 0.3s ease;
            background: rgba(34, 139, 34, 0.05);
        }

        .announcement-action:hover {
            background: var(--accent-green);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(34, 139, 34, 0.3);
        }

        /* External Navigation Controls */
        .announcement-controls-external {
            margin: 2rem 0;
        }

        .announcement-nav {
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
            box-shadow: 0 4px 15px rgba(34, 139, 34, 0.3);
        }

        .announcement-nav:hover {
            background: var(--accent-green);
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(34, 139, 34, 0.4);
        }

        .announcement-nav:active {
            transform: scale(0.95);
        }

        .announcement-nav:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .announcement-counter {
            background: rgba(34, 139, 34, 0.1);
            color: var(--primary-green);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
            border: 1px solid rgba(34, 139, 34, 0.2);
        }

        /* Dots Indicator */
        .announcement-dots {
            margin-top: 2rem;
        }

        .announcement-dots .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(34, 139, 34, 0.3);
            margin: 0 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .announcement-dots .dot.active {
            background: var(--primary-green);
            transform: scale(1.2);
        }

        .announcement-dots .dot:hover {
            background: var(--accent-green);
            transform: scale(1.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .announcements-carousel {
                margin: 1rem 0;
            }

            .announcements-container {
                margin: 0;
                max-width: 100%;
                width: 100%;
            }

            .announcement-content {
                flex-direction: column;
                text-align: center;
                padding: 1.5rem;
                min-height: auto;
            }

            .announcement-header {
                margin-right: 0;
                margin-bottom: 1.5rem;
            }

            .announcement-body {
                padding-left: 0;
            }

            .announcement-title {
                font-size: 1.5rem;
            }

            .announcement-excerpt {
                font-size: 1rem;
            }

            .announcement-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                margin: 0 0.5rem;
            }

            .announcement-controls-external {
                margin: 1rem 0;
                padding: 0 1rem;
            }

            .announcement-counter {
                font-size: 0.8rem;
                padding: 0.4rem 0.8rem;
            }
        }

        @media (max-width: 480px) {
            .announcements-container {
                margin: 0 0.5rem;
                max-width: calc(100% - 1rem);
            }

            .announcement-content {
                padding: 1rem;
            }

            .announcement-title {
                font-size: 1.3rem;
            }

            .announcement-excerpt {
                font-size: 0.9rem;
            }

            .announcement-icon-large {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .announcement-action {
                font-size: 0.9rem;
                padding: 0.6rem 1.2rem;
            }
        }

        .feature-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            text-align: center;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
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
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
            height: 100%;
            position: relative;
            border: 1px solid rgba(0, 0, 0, 0.06);
        }

        .counselor-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
        }

        .counselor-image {
            height: 230px;
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
            padding: 1.5rem 1.5rem 1.25rem;
        }

        .counselor-card h5 {
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.35rem;
        }

        .counselor-role {
            color: var(--text-light);
            font-style: italic;
            margin-bottom: .85rem;
        }

        .specialization {
            background: transparent;
            padding: 0;
            border-radius: 0;
            margin-bottom: .75rem;
            border-left: none;
        }

        .specialization strong {
            color: var(--text-dark);
            margin-right: .25rem;
        }

        .spec-links {
            color: var(--accent-green);
            text-decoration: underline;
            text-decoration-thickness: 1px;
            text-underline-offset: 3px;
        }

        .specialization strong {
            color: var(--primary-green);
        }

        .availability {
            background: transparent;
            padding-top: .75rem;
            border-radius: 0;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.08);
        }

        .availability strong {
            display: block;
            margin-bottom: .35rem;
        }

        /* New counselor embellishments */
        .counselor-card::after {
            content: '';
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0) 60%, rgba(34, 139, 34, 0.06) 100%);
            opacity: .7;
        }

        .counselor-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: rgba(255, 203, 5, .95);
            color: #1a1a1a;
            font-weight: 800;
            padding: .35rem .6rem;
            border-radius: 999px;
            font-size: .75rem;
            z-index: 2;
            box-shadow: 0 6px 16px rgba(0, 0, 0, .08);
        }

        .counselor-image .shine {
            position: absolute;
            inset: 0;
            background: radial-gradient(120% 60% at -10% -30%, rgba(255, 255, 255, .35) 0%, rgba(255, 255, 255, 0) 60%);
        }

        .counselor-meta {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: .75rem;
            color: var(--text-light);
            font-size: .9rem;
        }

        .counselor-meta i {
            color: var(--accent-green);
        }

        .counselor-actions {
            display: flex;
            gap: .5rem;
            margin-top: 1rem;
        }

        .btn-counselor-primary {
            background: var(--primary-green);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .55rem .9rem;
            font-weight: 600;
            box-shadow: 0 6px 16px rgba(34, 139, 34, 0.18);
        }

        .btn-counselor-primary:hover {
            filter: brightness(.95);
        }

        .btn-counselor-ghost {
            background: #fff;
            color: var(--primary-green);
            border: 1px solid rgba(34, 139, 34, .25);
            border-radius: 10px;
            padding: .55rem .9rem;
            font-weight: 600;
        }

        .btn-counselor-ghost:hover {
            background: var(--light-green);
        }

        /* Testimonials */
        .testimonials {
            padding: 5rem 0;
            background: var(--bg-light);
        }

        .testimonials .container {
            max-width: 1000px;
        }

        .testimonials-carousel {
            position: relative;
        }

        .testimonials-container {
            position: relative;
            overflow: hidden;
            border-radius: 20px;
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }

        .testimonials-track {
            transition: transform 0.5s ease-in-out;
            display: flex;
        }

        .testimonial-slide {
            padding: 0;
            flex-shrink: 0;
            width: 100%;
            min-width: 100%;
            position: relative;
            overflow: hidden;
        }

        .testimonial-card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            margin: 0;
            box-shadow: var(--shadow);
            position: relative;
            transition: all 0.3s ease;
            height: 100%;
            width: 100%;
            box-sizing: border-box;
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
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
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

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
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
            .testimonials .container {
                max-width: 100%;
                padding: 0 1rem;
            }

            .testimonials-container {
                max-width: 100%;
                margin: 0;
                width: 100%;
            }

            .testimonials-track {
                width: 100% !important;
            }

            .testimonial-slide {
                width: 100% !important;
                flex-shrink: 0;
            }

            .testimonial-card {
                margin: 0;
                padding: 2rem;
                width: 100%;
            }

            .testimonial-nav {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }

            .testimonial-prev {
                left: 10px;
            }

            .testimonial-next {
                right: 10px;
            }

            .testimonial-text {
                font-size: 1rem;
            }

            .testimonial-author {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 992px) {
            .testimonial-slide {
                width: 50% !important;
            }
        }

        @media (max-width: 480px) {
            .testimonials .container {
                padding: 0 0.5rem;
            }

            .testimonials-container {
                margin: 0;
                border-radius: 15px;
            }

            .testimonial-card {
                padding: 1.5rem;
                border-radius: 15px;
            }

            .testimonial-text {
                font-size: 0.9rem;
                line-height: 1.5;
            }

            .testimonial-author {
                font-size: 0.85rem;
            }

            .testimonial-nav {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }

            .testimonial-prev {
                left: 5px;
            }

            .testimonial-next {
                right: 5px;
            }

            .testimonial-dots {
                margin-top: 1rem;
            }

            .dot {
                width: 10px;
                height: 10px;
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

        /* Anchor offset for fixed navbar */
        #home,
        #counselors,
        #services,
        #contact {
            scroll-margin-top: 90px;
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

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                            <p class="text-center mx-auto">Your mental health matters. Connect with professional
                                counselors, access valuable resources, and take control of your well-being journey with
                                our comprehensive support system.</p>
                            <div class="hero-buttons justify-content-center d-flex flex-wrap">
                                <a href="{{ auth()->check() ? route('appointments.create') : route('login') }}"
                                    class="btn btn-primary-custom" aria-label="Book appointment">
                                    <i class="fas fa-calendar-plus me-2"></i>Book Appointment
                                </a>
                                <a href="{{ auth()->check() ? route('chat') : route('login') }}"
                                    class="btn btn-secondary-custom" aria-label="Start chat">
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
                    <h2 style="color: var(--primary-green);">Latest Announcements</h2>
                    <div class="section-divider" style="background: var(--accent-orange);"></div>
                    <p>Stay updated with our latest news and important information</p>
                </div>

                <div class="announcements-carousel position-relative">
                    <div class="announcements-container overflow-hidden rounded-4">
                        <div class="announcements-track d-flex" id="announcementsTrack">
                            @forelse($announcements as $index => $announcement)
                                <div class="announcement-slide flex-shrink-0" style="width: 100%;">
                                    <div class="announcement-card-horizontal">
                                        <div class="announcement-content">
                                            <div class="announcement-header">
                                                <div class="announcement-icon-large">
                                                    <i class="fas fa-bullhorn"></i>
                                                </div>
                                                <div class="announcement-meta">
                                                    <span
                                                        class="announcement-date">{{ optional($announcement->created_at)->format('M d, Y') }}</span>
                                                    @if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14)))
                                                        <span class="badge-new">NEW</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="announcement-body">
                                                <h3 class="announcement-title">{{ $announcement->title }}</h3>
                                                <p class="announcement-excerpt">
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($announcement->content ?? $announcement->body ?? ''), 200) }}
                                                </p>
                                                <a href="{{ route('announcements.show', $announcement) }}"
                                                    class="announcement-action"
                                                    aria-label="Read more about {{ $announcement->title }}">
                                                    <span>Read Full Announcement</span>
                                                    <i class="fas fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="announcement-slide flex-shrink-0" style="width: 100%;">
                                    <div class="announcement-card-horizontal">
                                        <div class="announcement-content">
                                            <div class="announcement-header">
                                                <div class="announcement-icon-large">
                                                    <i class="fas fa-bullhorn"></i>
                                                </div>
                                            </div>
                                            <div class="announcement-body text-center">
                                                <h3 class="announcement-title">No announcements yet</h3>
                                                <p class="announcement-excerpt">Please check back later for updates and
                                                    center news.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Dots Indicator -->
                    @if($announcements && count($announcements) > 1)
                        <div class="announcement-dots text-center mt-4">
                            @foreach($announcements as $index => $announcement)
                                <span class="dot {{ $index === 0 ? 'active' : '' }}" data-slide="{{ $index }}"></span>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Navigation Controls - Outside the section -->
                @if($announcements && count($announcements) > 1)
                    <div class="announcement-controls-external d-flex justify-content-center align-items-center mt-4">
                        <button type="button" class="announcement-nav announcement-prev" id="announcementPrev"
                            aria-label="Previous announcement">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <div class="mx-4">
                            <span class="announcement-counter">
                                <span id="currentSlide">1</span> / <span id="totalSlides">{{ count($announcements) }}</span>
                            </span>
                        </div>
                        <button type="button" class="announcement-nav announcement-next" id="announcementNext"
                            aria-label="Next announcement">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                @else
                    <!-- Debug info for no announcements -->
                    <div class="text-center mt-4">
                        <small class="text-muted">Debug:
                            {{ $announcements ? count($announcements) : 'No announcements variable' }} announcements
                            found</small>
                        <br>
                        <small class="text-muted">Navigation controls only appear when there are 2+ announcements</small>
                    </div>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('announcements.index') }}" class="btn btn-success px-4 py-2 fw-bold"
                        style="background: var(--primary-green); border: none; border-radius: 10px; box-shadow: 0 6px 18px rgba(34,139,34,0.18);">
                        <i class="fas fa-list me-2"></i>View all announcements
                    </a>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="services" class="features py-5" style="background: var(--bg-light);">
            <div class="container">
                <div class="section-header">
                    <h2 style="color: var(--primary-green);">Our Services</h2>
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
                            <p>Book appointments seamlessly with our intuitive online system. Choose your preferred time
                                and counselor with just a few clicks.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-comments"></i>
                            </div>
                            <h5>Live Chat Support</h5>
                            <p>Get immediate assistance through our secure real-time chat system. Available 24/7 for
                                crisis support and general guidance.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5>100% Confidential</h5>
                            <p>All sessions and communications are strictly confidential. Your privacy and trust are our
                                top priorities.</p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h5>Resource Library</h5>
                            <p>Access comprehensive self-help materials, guides, and tools designed to support your
                                mental health journey.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Counselors Section -->
        <section id="counselors" class="counselors py-5" style="background: var(--bg-light);">
            <div class="container">
                <div class="section-header">
                    <h2 style="color: var(--primary-green);">Meet Our Counselors</h2>
                    <div class="section-divider" style="background: var(--accent-orange);"></div>
                    <p>Experienced, licensed professionals dedicated to supporting your mental health and academic
                        success</p>
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
                                    <strong>Specializes in:</strong> Academic Stress, Anxiety Disorders, Depression
                                    Management
                                </div>
                                <p class="text-muted">15+ years of experience helping students overcome academic
                                    challenges and develop healthy coping strategies.</p>
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
                                    <strong>Specializes in:</strong> Career Planning, Graduate School Prep, Professional
                                    Development
                                </div>
                                <p class="text-muted">Expert in helping students identify career paths aligned with
                                    their strengths and aspirations.</p>
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
                                    <strong>Specializes in:</strong>
                                    <span class="spec-links">Self‑Esteem</span>,
                                    <span class="spec-links">Relationships</span>,
                                    <span class="spec-links">Life Transitions</span>
                                </div>
                                <p class="text-muted">Dr. Wilson focuses on helping students build healthy relationships
                                    and develop strong self‑confidence.</p>
                                <div class="availability">
                                    <strong>Availability:</strong><br>
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
                    <h2 style="color: var(--primary-green);">Student Experiences</h2>
                    <div class="section-divider" style="background: var(--accent-orange);"></div>
                    <p>Hear from students who have benefited from our services</p>
                </div>

                <div class="testimonials-carousel position-relative">
                    <div class="testimonials-container overflow-hidden">
                        <div class="testimonials-track d-flex" id="testimonialsTrack">
                            <!-- Testimonial 1 -->
                            <div class="testimonial-slide flex-shrink-0" style="width: 100%;">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">"The counseling services at CMU helped me manage my
                                        anxiety before exams. Dr. Smith provided practical techniques that I still use
                                        today."</p>
                                    <div class="testimonial-author">Jamie C. <span class="testimonial-role">- Computer
                                            Science, Senior</span></div>
                                </div>
                            </div>

                            <!-- Testimonial 2 -->
                            <div class="testimonial-slide flex-shrink-0" style="width: 100%;">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">"When I was struggling with career decisions, Prof. Doe
                                        helped me identify my strengths and explore options I hadn't considered before."
                                    </p>
                                    <div class="testimonial-author">Alex M. <span class="testimonial-role">- Business
                                            Administration, Junior</span></div>
                                </div>
                            </div>

                            <!-- Testimonial 3 -->
                            <div class="testimonial-slide flex-shrink-0" style="width: 100%;">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">"The chat support was there for me during a late‑night
                                        study session when I was overwhelmed. Just having someone to talk to made all
                                        the difference."</p>
                                    <div class="testimonial-author">Taylor W. <span class="testimonial-role">-
                                            Engineering, Sophomore</span></div>
                                </div>
                            </div>

                            <!-- Testimonial 4 -->
                            <div class="testimonial-slide flex-shrink-0" style="width: 100%;">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">"I was dealing with family issues that affected my
                                        studies. The counseling center provided a safe space to process my emotions and
                                        develop coping strategies."</p>
                                    <div class="testimonial-author">Maria S. <span class="testimonial-role">- Nursing,
                                            Graduate</span></div>
                                </div>
                            </div>

                            <!-- Testimonial 5 -->
                            <div class="testimonial-slide flex-shrink-0" style="width: 100%;">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">"The group therapy sessions helped me connect with other
                                        students facing similar challenges. We formed a support network that continues
                                        even after graduation."</p>
                                    <div class="testimonial-author">David L. <span class="testimonial-role">-
                                            Psychology, Senior</span></div>
                                </div>
                            </div>

                            <!-- Testimonial 6 -->
                            <div class="testimonial-slide flex-shrink-0" style="width: 100%;">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">"As an international student, I felt isolated and
                                        homesick. The counselors helped me adjust to campus life and build meaningful
                                        friendships. CMU feels like home now."</p>
                                    <div class="testimonial-author">Ahmed K. <span class="testimonial-role">-
                                            Information Technology, Junior</span></div>
                                </div>
                            </div>

                            <!-- Testimonial 7 -->
                            <div class="testimonial-slide flex-shrink-0" style="width: 100%;">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">"I struggled with time management and academic pressure.
                                        The study skills workshops and one‑on‑one sessions with counselors transformed
                                        my approach to learning."</p>
                                    <div class="testimonial-author">Sarah P. <span class="testimonial-role">- Education,
                                            Sophomore</span></div>
                                </div>
                            </div>

                            <!-- Testimonial 8 -->
                            <div class="testimonial-slide flex-shrink-0" style="width: 100%;">
                                <div class="testimonial-card">
                                    <p class="testimonial-text">"The career counseling helped me discover my passion for
                                        research. I'm now pursuing a master's degree and working as a research
                                        assistant."</p>
                                    <div class="testimonial-author">Michael R. <span class="testimonial-role">- Biology,
                                            Graduate</span></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Arrows -->
                    <button type="button" class="testimonial-nav testimonial-prev" id="testimonialPrev"
                        aria-label="Previous testimonials">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="testimonial-nav testimonial-next" id="testimonialNext"
                        aria-label="Next testimonials">
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
                                <p>If you're experiencing persistent stress, anxiety, sadness, or having trouble coping
                                    with academic or personal challenges, counseling can help. There's no problem too
                                    small or too big to discuss with a professional counselor. Trust your instincts - if
                                    you feel you could benefit from support, we're here to help.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span>Is counseling completely confidential?</span>
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="faq-answer" style="display: none;">
                                <p>Yes, all sessions and communications are strictly confidential. Information is only
                                    shared if there is imminent danger to yourself or others, or as required by law.
                                    Your privacy and trust are fundamental to our therapeutic relationship.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span>How many counseling sessions can I have?</span>
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="faq-answer" style="display: none;">
                                <p>As a CMU student, you're entitled to 10 free counseling sessions per academic year.
                                    Additional sessions can be arranged based on your specific needs and our
                                    availability. We believe in providing adequate support for your mental health
                                    journey.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span>What if I need to cancel or reschedule an appointment?</span>
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="faq-answer" style="display: none;">
                                <p>Please provide at least 24 hours notice if you need to cancel or reschedule your
                                    appointment. You can easily manage your appointments through our online portal or by
                                    calling our office directly. This helps us serve other students who may need
                                    immediate support.</p>
                            </div>
                        </div>

                        <div class="faq-item">
                            <button class="faq-question" type="button">
                                <span>Is crisis support available outside office hours?</span>
                                <i class="fas fa-plus"></i>
                            </button>
                            <div class="faq-answer" style="display: none;">
                                <p>Yes, we provide 24/7 crisis support through our emergency hotline and chat system. If
                                    you're experiencing a mental health crisis, don't hesitate to reach out immediately.
                                    We also have partnerships with local emergency services for urgent situations.</p>
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
                                    <div class="text-muted small">Office of Student Affairs<br>Central Mindanao
                                        University<br>Musuan, Maramag, Bukidnon</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="bg-white rounded-4 shadow-sm p-4 h-100 text-center">
                                    <div class="mb-2" style="font-size: 2rem; color: var(--primary-green);">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <h5 class="fw-bold mb-2" style="color: var(--primary-green);">Office Hours</h5>
                                    <div class="text-muted small">Monday-Friday: 8:00 AM - 5:00 PM<br>Saturday: 9:00 AM
                                        - 12:00 PM<br>Sunday: Closed</div>
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
                                    <div class="text-muted small">Office: (088) 356-0802<br>Emergency: (088) 356-0803
                                    </div>
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
                                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    title="CMU Office of Student Affairs Location">
                                </iframe>
                                <div class="position-absolute top-0 end-0 m-3">
                                    <a href="https://maps.google.com/?q=Central+Mindanao+University+Musuan+Maramag+Bukidnon"
                                        target="_blank" class="btn btn-success btn-sm fw-bold"
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
    <!-- SweetAlert2 for login feedback -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Detect Chrome browser
        const isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);

        // Global error handler to suppress Bootstrap modal errors (especially for Chrome)
        window.addEventListener('error', function (e) {
            // Suppress Bootstrap modal initialization errors
            if (e.message && (
                e.message.includes('backdrop') ||
                e.message.includes('Modal') ||
                e.message.includes('Cannot read properties of undefined') ||
                e.message.includes('Cannot read properties of null') ||
                e.message.includes('defaultPrevented') ||
                e.message.includes('FOCUSTRAP')
            )) {
                // Check if it's related to a modal that doesn't exist
                const stack = e.error && e.error.stack ? e.error.stack : '';
                if (stack.includes('modal') || stack.includes('Modal') || stack.includes('FOCUSTRAP')) {
                    e.preventDefault();
                    return true; // Suppress the error
                }
            }
        }, true);

        // Chrome-specific: Ensure modals work by waiting for DOM to be fully ready
        if (isChrome) {
            // Wait a bit longer for Chrome to fully initialize
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function () {
                    setTimeout(function () {
                        // Force re-initialization of Bootstrap modals in Chrome
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            // Re-initialize any modals that might have failed
                            document.querySelectorAll('.modal[data-bs-toggle]').forEach(function (modal) {
                                try {
                                    bootstrap.Modal.getOrCreateInstance(modal);
                                } catch (e) {
                                    // Silently fail
                                }
                            });
                        }
                    }, 100);
                });
            }
        }

        // Fix Bootstrap Modal initialization errors in Chrome
        // This must run immediately after Bootstrap loads
        (function () {
            if (typeof bootstrap === 'undefined' || !bootstrap.Modal) {
                // Wait for Bootstrap to load
                const checkBootstrap = setInterval(function () {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        clearInterval(checkBootstrap);
                        fixModalInitialization();
                    }
                }, 10);
                // Timeout after 5 seconds
                setTimeout(function () {
                    clearInterval(checkBootstrap);
                }, 5000);
            } else {
                fixModalInitialization();
            }

            function fixModalInitialization() {
                // Store original constructor and method
                const OriginalModal = bootstrap.Modal;
                const originalGetOrCreateInstance = bootstrap.Modal.getOrCreateInstance;
                const ModalPrototype = OriginalModal.prototype;

                // CRITICAL: Patch show method to handle null events
                if (ModalPrototype.show) {
                    const originalShow = ModalPrototype.show;
                    ModalPrototype.show = function (relatedTarget) {
                        // Ensure relatedTarget is valid if provided
                        if (relatedTarget !== undefined && relatedTarget !== null && !relatedTarget.nodeType) {
                            // If it's not a valid element, treat it as undefined
                            relatedTarget = undefined;
                        }
                        try {
                            return originalShow.call(this, relatedTarget);
                        } catch (e) {
                            // If show fails, try manual show
                            if (this._element) {
                                this._element.classList.add('show');
                                this._element.style.display = 'block';
                                this._element.setAttribute('aria-hidden', 'false');
                                document.body.classList.add('modal-open');
                                if (!document.querySelector('.modal-backdrop')) {
                                    const backdrop = document.createElement('div');
                                    backdrop.className = 'modal-backdrop fade show';
                                    document.body.appendChild(backdrop);
                                }
                            }
                            return;
                        }
                    };
                }

                // CRITICAL: Patch FocusTrap to handle undefined trapElement
                if (bootstrap.FocusTrap) {
                    const OriginalFocusTrap = bootstrap.FocusTrap;

                    // Patch FocusTrap constructor to handle missing trapElement
                    const originalFocusTrapConstructor = OriginalFocusTrap;
                    bootstrap.FocusTrap = function (config) {
                        // Ensure config exists
                        if (!config) {
                            config = {};
                        }
                        // If trapElement is missing but focus is enabled, provide a fallback
                        if (config.focus !== false && !config.trapElement) {
                            // Use body as fallback - better than undefined
                            config.trapElement = document.body;
                        }
                        // Call original constructor with safe config
                        try {
                            return new originalFocusTrapConstructor(config);
                        } catch (e) {
                            // Return a minimal focus trap if creation fails
                            return {
                                activate: function () { },
                                deactivate: function () { },
                                pause: function () { },
                                unpause: function () { },
                                _config: config
                            };
                        }
                    };
                    // Copy static methods and prototype
                    Object.setPrototypeOf(bootstrap.FocusTrap, OriginalFocusTrap);
                    Object.assign(bootstrap.FocusTrap, OriginalFocusTrap);
                }

                // CRITICAL: Patch the _initializeBackDrop method directly to prevent the error
                if (ModalPrototype._initializeBackDrop) {
                    const originalInitBackdrop = ModalPrototype._initializeBackDrop;
                    ModalPrototype._initializeBackDrop = function () {
                        // Ensure _config exists and has backdrop property
                        if (!this._config) {
                            this._config = {};
                        }
                        if (this._config.backdrop === undefined) {
                            // Get backdrop from element or default
                            const element = this._element;
                            if (element) {
                                const backdropValue = element.getAttribute('data-bs-backdrop') ||
                                    element.getAttribute('data-backdrop') ||
                                    'static';
                                this._config.backdrop = backdropValue === 'true' ? true :
                                    backdropValue === 'false' ? false :
                                        backdropValue;
                            } else {
                                this._config.backdrop = 'static';
                            }
                        }
                        // Now safely call original method
                        try {
                            return originalInitBackdrop.call(this);
                        } catch (e) {
                            // Silently fail if backdrop initialization fails
                            return;
                        }
                    };
                }

                // CRITICAL: Patch _initializeFocusTrap to ensure trapElement is set
                if (ModalPrototype._initializeFocusTrap) {
                    const originalInitFocusTrap = ModalPrototype._initializeFocusTrap;
                    ModalPrototype._initializeFocusTrap = function () {
                        // Ensure _config and focus are set
                        if (!this._config) {
                            this._config = {};
                        }
                        if (this._config.focus === undefined) {
                            this._config.focus = true;
                        }
                        // Ensure trapElement is set if focus is enabled
                        if (this._config.focus && !this._config.trapElement) {
                            this._config.trapElement = this._element || document.body;
                        }
                        // Call original method
                        try {
                            return originalInitFocusTrap.call(this);
                        } catch (e) {
                            // Create a dummy focus trap if initialization fails
                            this._focustrap = {
                                activate: function () { },
                                deactivate: function () { },
                                pause: function () { },
                                unpause: function () { },
                                _config: { trapElement: this._element || document.body }
                            };
                            return;
                        }
                    };
                }

                // Patch the constructor to ensure _config is always set
                const originalConstructor = OriginalModal;
                bootstrap.Modal = function (element, config) {
                    // CRITICAL: Check if element exists and is valid BEFORE anything else
                    if (!element) {
                        // Return a dummy object to prevent errors
                        return {
                            show: function () { },
                            hide: function () { },
                            toggle: function () { },
                            dispose: function () { },
                            _element: null,
                            _config: { backdrop: 'static', keyboard: true, focus: true }
                        };
                    }

                    // Ensure element is valid
                    if (!element.classList || !element.classList.contains('modal')) {
                        return {
                            show: function () { },
                            hide: function () { },
                            toggle: function () { },
                            dispose: function () { },
                            _element: element,
                            _config: { backdrop: 'static', keyboard: true, focus: true }
                        };
                    }

                    // Ensure element is in DOM
                    if (!document.body.contains(element)) {
                        return {
                            show: function () { },
                            hide: function () { },
                            toggle: function () { },
                            dispose: function () { },
                            _element: element,
                            _config: { backdrop: 'static', keyboard: true, focus: true }
                        };
                    }

                    // Ensure data attributes exist
                    if (!element.hasAttribute('data-bs-backdrop') && !element.hasAttribute('data-backdrop')) {
                        element.setAttribute('data-bs-backdrop', 'static');
                    }

                    // Create safe config object with all required properties
                    const backdropValue = element.getAttribute('data-bs-backdrop') ||
                        element.getAttribute('data-backdrop') ||
                        'static';

                    const keyboardValue = element.getAttribute('data-bs-keyboard');
                    const keyboard = keyboardValue === null ? true : keyboardValue !== 'false';

                    const safeConfig = config || {};

                    // Always ensure backdrop is set and valid
                    if (!safeConfig.hasOwnProperty('backdrop') || safeConfig.backdrop === undefined) {
                        safeConfig.backdrop = backdropValue === 'true' ? true :
                            backdropValue === 'false' ? false :
                                backdropValue;
                    }

                    // Always ensure keyboard is set
                    if (!safeConfig.hasOwnProperty('keyboard') || safeConfig.keyboard === undefined) {
                        safeConfig.keyboard = keyboard;
                    }

                    // Always ensure focus is set
                    if (!safeConfig.hasOwnProperty('focus') || safeConfig.focus === undefined) {
                        safeConfig.focus = true;
                    }

                    // CRITICAL: Ensure trapElement is ALWAYS set if focus is enabled
                    // Bootstrap's FocusTrap requires this to be a valid DOM element
                    if (safeConfig.focus) {
                        // Always set trapElement to the modal element
                        safeConfig.trapElement = element;
                    } else {
                        // If focus is disabled, set trapElement to null explicitly
                        safeConfig.trapElement = null;
                    }

                    try {
                        // Call original constructor with safe config
                        const instance = new originalConstructor(element, safeConfig);
                        // Ensure _config is set on the instance
                        if (!instance._config) {
                            instance._config = safeConfig;
                        }
                        // Ensure _focustrap is properly initialized with trapElement
                        if (instance._focustrap) {
                            if (!instance._focustrap._config) {
                                instance._focustrap._config = {};
                            }
                            if (!instance._focustrap._config.trapElement && safeConfig.focus) {
                                instance._focustrap._config.trapElement = element;
                            }
                        }
                        return instance;
                    } catch (e) {
                        // Return dummy object on error to prevent crashes
                        return {
                            show: function () { },
                            hide: function () { },
                            toggle: function () { },
                            dispose: function () { },
                            _element: element,
                            _config: safeConfig
                        };
                    }
                };

                // Copy static methods and properties
                Object.setPrototypeOf(bootstrap.Modal, OriginalModal);
                Object.assign(bootstrap.Modal, OriginalModal);

                // Override getOrCreateInstance to use safe config
                bootstrap.Modal.getOrCreateInstance = function (element, config) {
                    // CRITICAL: Return null immediately if element doesn't exist
                    if (!element) {
                        return null;
                    }

                    // Safety checks
                    if (!element.classList || !element.classList.contains('modal')) {
                        return null;
                    }

                    if (!document.body.contains(element)) {
                        return null;
                    }

                    if (!element.querySelector('.modal-dialog')) {
                        return null;
                    }

                    // Ensure data attributes exist
                    if (!element.hasAttribute('data-bs-backdrop') && !element.hasAttribute('data-backdrop')) {
                        element.setAttribute('data-bs-backdrop', 'static');
                    }

                    // Create safe config object
                    const backdropValue = element.getAttribute('data-bs-backdrop') ||
                        element.getAttribute('data-backdrop') ||
                        'static';

                    const keyboardValue = element.getAttribute('data-bs-keyboard');
                    const keyboard = keyboardValue === null ? true : keyboardValue !== 'false';

                    const safeConfig = config || {};
                    if (!safeConfig.hasOwnProperty('backdrop') || safeConfig.backdrop === undefined) {
                        safeConfig.backdrop = backdropValue === 'true' ? true :
                            backdropValue === 'false' ? false :
                                backdropValue;
                    }
                    if (!safeConfig.hasOwnProperty('keyboard') || safeConfig.keyboard === undefined) {
                        safeConfig.keyboard = keyboard;
                    }
                    if (!safeConfig.hasOwnProperty('focus') || safeConfig.focus === undefined) {
                        safeConfig.focus = true;
                    }

                    // CRITICAL: Ensure trapElement is ALWAYS set if focus is enabled
                    if (safeConfig.focus) {
                        safeConfig.trapElement = element;
                    } else {
                        safeConfig.trapElement = null;
                    }

                    try {
                        // Try to get existing instance
                        const existing = bootstrap.Modal.getInstance(element);
                        if (existing) {
                            // Ensure existing instance has valid config
                            if (!existing._config) {
                                existing._config = safeConfig;
                            }
                            // Fix focus trap if it exists - ensure trapElement is set
                            if (existing._focustrap) {
                                if (!existing._focustrap._config) {
                                    existing._focustrap._config = {};
                                }
                                if (safeConfig.focus && !existing._focustrap._config.trapElement) {
                                    existing._focustrap._config.trapElement = element;
                                }
                            }
                            return existing;
                        }

                        // Create new instance with safe config using original method
                        const instance = originalGetOrCreateInstance.call(this, element, safeConfig);
                        // Fix focus trap after creation - ensure trapElement is set
                        if (instance && instance._focustrap) {
                            if (!instance._focustrap._config) {
                                instance._focustrap._config = {};
                            }
                            if (safeConfig.focus && !instance._focustrap._config.trapElement) {
                                instance._focustrap._config.trapElement = element;
                            }
                        }
                        return instance;
                    } catch (e) {
                        // Silently return null on error - don't log to prevent console spam
                        return null;
                    }
                };
            }
        })();
    </script>

    <!-- Custom JavaScript -->
    <script>
        // Collapse navbar on small screens after clicking an in-page link
        try {
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                if (anchor && anchor.addEventListener) {
                    anchor.addEventListener('click', function () {
                        const navCollapse = document.querySelector('#navbarNav');
                        if (navCollapse && navCollapse.classList.contains('show')) {
                            bootstrap.Collapse.getOrCreateInstance(navCollapse).hide();
                        }
                    });
                }
            });
        } catch (error) {
            console.error('Error setting up navbar collapse:', error);
        }

        // Precise scroll for fixed navbar (nav links only)
        try {
            document.querySelectorAll('.navbar a.nav-link[href^="#"]').forEach(link => {
                if (link && link.addEventListener) {
                    link.addEventListener('click', function (e) {
                        const href = this.getAttribute('href');
                        if (!href || href === '#') return;
                        const target = document.querySelector(href);
                        if (!target) return;
                        e.preventDefault();
                        const navbar = document.querySelector('.navbar');
                        const offset = navbar ? navbar.offsetHeight + 8 : 0;
                        const top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                        window.scrollTo({ top, behavior: 'smooth' });
                        // Update URL hash without jump
                        history.pushState(null, '', href);
                    });
                }
            });
        } catch (error) {
            console.error('Error setting up navbar scroll:', error);
        }

        // FAQ functionality
        try {
            document.querySelectorAll('.faq-question').forEach(button => {
                if (button && button.addEventListener) {
                    button.addEventListener('click', function () {
                        const answer = this.nextElementSibling;
                        const icon = this.querySelector('i');
                        const isOpen = answer.style.display === 'block';

                        // Close all other FAQ items
                        document.querySelectorAll('.faq-answer').forEach(item => {
                            item.style.display = 'none';
                        });
                        document.querySelectorAll('.faq-question').forEach(btn => {
                            btn.classList.remove('active');
                            const btnIcon = btn.querySelector('i');
                            if (btnIcon) {
                                btnIcon.classList.remove('fa-minus');
                                btnIcon.classList.add('fa-plus');
                            }
                        });

                        // Toggle current item
                        if (!isOpen) {
                            answer.style.display = 'block';
                            this.classList.add('active');
                            if (icon) {
                                icon.classList.remove('fa-plus');
                                icon.classList.add('fa-minus');
                            }
                        }
                    });
                }
            });
        } catch (error) {
            console.error('Error setting up FAQ functionality:', error);
        }

        // Navbar scroll effect
        window.addEventListener('scroll', function () {
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
        (function () {
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
        const newsletterForm = document.querySelector('.newsletter-form');
        if (newsletterForm && newsletterForm.addEventListener) {
            newsletterForm.addEventListener('submit', function (e) {
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
        }

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

        // Testimonials Carousel (single column like design preview)
        let currentSlide = 0;
        const track = document.getElementById('testimonialsTrack');
        const prevBtn = document.getElementById('testimonialPrev');
        const nextBtn = document.getElementById('testimonialNext');
        const carousel = document.querySelector('.testimonials-carousel');
        const container = document.querySelector('.testimonials-container');
        const slides = track ? Array.from(track.querySelectorAll('.testimonial-slide')) : [];
        const dotsContainer = document.querySelector('.testimonial-dots');
        let totalSlidesGroups = 1;
        let slideWidthPx = 0;

        function recalcCarouselMetrics() {
            if (!container || slides.length === 0) return;
            const containerWidth = container.getBoundingClientRect().width;
            // Single testimonial visible at a time
            slideWidthPx = containerWidth;
            const visibleCount = 1;
            const maxIndex = Math.max(slides.length - visibleCount, 0);
            totalSlidesGroups = maxIndex + 1;
            if (currentSlide > maxIndex) currentSlide = maxIndex;

            // Rebuild dots
            if (dotsContainer) {
                dotsContainer.innerHTML = '';
                for (let i = 0; i < totalSlidesGroups; i++) {
                    const dot = document.createElement('span');
                    dot.className = 'dot' + (i === currentSlide ? ' active' : '');
                    dot.dataset.slide = String(i);
                    dot.addEventListener('click', () => goToSlide(i));
                    dotsContainer.appendChild(dot);
                }
            }

            // Update carousel with proper containment
            updateCarousel();
        }

        function updateCarousel() {
            if (!track) return;

            // Ensure each slide takes full width
            const containerWidth = container ? container.getBoundingClientRect().width : 0;
            const slideWidth = containerWidth; // Each slide should be full width

            // Update slide widths and ensure proper containment
            slides.forEach((slide, index) => {
                slide.style.width = `${slideWidth}px`;
                slide.style.minWidth = `${slideWidth}px`;
                slide.style.flexShrink = '0';
                slide.style.position = 'relative';
                slide.style.overflow = 'hidden';

                // On mobile, show all slides but position them correctly
                if (window.innerWidth <= 768) {
                    slide.style.visibility = 'visible';
                } else {
                    // Hide all slides except current one to prevent bleeding on desktop
                    if (index !== currentSlide) {
                        slide.style.visibility = 'hidden';
                    } else {
                        slide.style.visibility = 'visible';
                    }
                }
            });

            // Update track width to accommodate all slides
            track.style.width = `${totalSlidesGroups * slideWidth}px`;
            track.style.display = 'flex';

            // Move to current slide
            track.style.transform = `translateX(-${currentSlide * slideWidth}px)`;

            // Update dots
            if (dotsContainer) {
                Array.from(dotsContainer.querySelectorAll('.dot')).forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentSlide);
                });
            }
            // Update button states
            if (prevBtn) prevBtn.style.opacity = currentSlide === 0 ? '0.5' : '1';
            if (nextBtn) nextBtn.style.opacity = currentSlide >= totalSlidesGroups - 1 ? '0.5' : '1';
        }

        function nextSlide() {
            if (!totalSlidesGroups) return;
            currentSlide = (currentSlide + 1) % totalSlidesGroups;
            updateCarousel();
        }

        function prevSlide() {
            if (!totalSlidesGroups) return;
            currentSlide = (currentSlide - 1 + totalSlidesGroups) % totalSlidesGroups;
            updateCarousel();
        }

        function goToSlide(slideIndex) {
            currentSlide = Math.max(0, Math.min(slideIndex, totalSlidesGroups - 1));
            updateCarousel();
        }

        // Event listeners
        if (nextBtn && nextBtn.addEventListener) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn && prevBtn.addEventListener) prevBtn.addEventListener('click', prevSlide);
        window.addEventListener('resize', () => {
            // Debounce minimal
            clearTimeout(window.__carouselResizeTimer);
            window.__carouselResizeTimer = setTimeout(() => {
                recalcCarouselMetrics();
                updateCarousel();
            }, 100);
        });

        // Auto-play functionality (optional)
        let autoPlayInterval;
        function startAutoPlay() {
            stopAutoPlay();
            autoPlayInterval = setInterval(() => {
                nextSlide();
            }, 5000);
        }

        function stopAutoPlay() {
            if (autoPlayInterval) clearInterval(autoPlayInterval);
        }

        // Pause auto-play on hover
        if (carousel && carousel.addEventListener) {
            carousel.addEventListener('mouseenter', stopAutoPlay);
            carousel.addEventListener('mouseleave', startAutoPlay);
        }

        // Initialize carousel
        recalcCarouselMetrics();
        startAutoPlay();

        // Announcements Carousel
        let currentAnnouncementSlide = 0;
        let announcementTrack, announcementPrevBtn, announcementNextBtn, announcementCarousel, announcementContainer, announcementSlides, announcementDotsContainer, totalAnnouncementSlides;

        function initAnnouncementCarousel() {
            announcementTrack = document.getElementById('announcementsTrack');
            announcementPrevBtn = document.getElementById('announcementPrev');
            announcementNextBtn = document.getElementById('announcementNext');
            announcementCarousel = document.querySelector('.announcements-carousel');
            announcementContainer = document.querySelector('.announcements-container');
            announcementSlides = announcementTrack ? Array.from(announcementTrack.querySelectorAll('.announcement-slide')) : [];
            announcementDotsContainer = document.querySelector('.announcement-dots');
            totalAnnouncementSlides = announcementSlides.length;

            console.log('Announcement carousel initialized:', {
                track: !!announcementTrack,
                prevBtn: !!announcementPrevBtn,
                nextBtn: !!announcementNextBtn,
                slides: totalAnnouncementSlides
            });
        }

        function updateAnnouncementCarousel() {
            if (!announcementTrack || totalAnnouncementSlides === 0) return;

            // Ensure each slide takes full width
            const containerWidth = announcementContainer ? announcementContainer.getBoundingClientRect().width : 0;
            const slideWidth = containerWidth; // Each slide should be full width

            // Update slide widths and ensure proper containment
            announcementSlides.forEach((slide, index) => {
                slide.style.width = `${slideWidth}px`;
                slide.style.minWidth = `${slideWidth}px`;
                slide.style.flexShrink = '0';
                slide.style.position = 'relative';
                slide.style.overflow = 'hidden';

                // On mobile, show all slides but position them correctly
                if (window.innerWidth <= 768) {
                    slide.style.visibility = 'visible';
                } else {
                    // Hide all slides except current one to prevent bleeding on desktop
                    if (index !== currentAnnouncementSlide) {
                        slide.style.visibility = 'hidden';
                    } else {
                        slide.style.visibility = 'visible';
                    }
                }
            });

            // Update track width to accommodate all slides
            announcementTrack.style.width = `${totalAnnouncementSlides * slideWidth}px`;
            announcementTrack.style.display = 'flex';

            // Move to current slide
            announcementTrack.style.transform = `translateX(-${currentAnnouncementSlide * slideWidth}px)`;

            console.log('Carousel update:', {
                containerWidth,
                slideWidth,
                currentSlide: currentAnnouncementSlide,
                totalSlides: totalAnnouncementSlides
            });

            // Update dots
            if (announcementDotsContainer) {
                Array.from(announcementDotsContainer.querySelectorAll('.dot')).forEach((dot, index) => {
                    dot.classList.toggle('active', index === currentAnnouncementSlide);
                });
            }

            // Update button states
            if (announcementPrevBtn) {
                announcementPrevBtn.disabled = currentAnnouncementSlide === 0;
                announcementPrevBtn.style.opacity = currentAnnouncementSlide === 0 ? '0.5' : '1';
            }
            if (announcementNextBtn) {
                announcementNextBtn.disabled = currentAnnouncementSlide >= totalAnnouncementSlides - 1;
                announcementNextBtn.style.opacity = currentAnnouncementSlide >= totalAnnouncementSlides - 1 ? '0.5' : '1';
            }

            // Update counter
            const currentSlideElement = document.getElementById('currentSlide');
            if (currentSlideElement) {
                currentSlideElement.textContent = currentAnnouncementSlide + 1;
            }
        }

        function nextAnnouncementSlide() {
            console.log('nextAnnouncementSlide called', {
                totalSlides: totalAnnouncementSlides,
                currentSlide: currentAnnouncementSlide
            });
            if (totalAnnouncementSlides === 0) {
                console.log('No slides available');
                return;
            }
            currentAnnouncementSlide = (currentAnnouncementSlide + 1) % totalAnnouncementSlides;
            console.log('New current slide:', currentAnnouncementSlide);
            updateAnnouncementCarousel();
        }

        function prevAnnouncementSlide() {
            if (totalAnnouncementSlides === 0) return;
            currentAnnouncementSlide = (currentAnnouncementSlide - 1 + totalAnnouncementSlides) % totalAnnouncementSlides;
            updateAnnouncementCarousel();
        }

        function goToAnnouncementSlide(slideIndex) {
            currentAnnouncementSlide = Math.max(0, Math.min(slideIndex, totalAnnouncementSlides - 1));
            updateAnnouncementCarousel();
        }

        // Event listeners for announcements
        function attachAnnouncementEventListeners() {
            console.log('Attaching event listeners...', {
                nextBtn: !!announcementNextBtn,
                prevBtn: !!announcementPrevBtn,
                dotsContainer: !!announcementDotsContainer
            });

            try {
                if (announcementNextBtn && announcementNextBtn.addEventListener) {
                    announcementNextBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log('Next button clicked');
                        nextAnnouncementSlide();
                    });
                    console.log('Next button listener attached');
                } else {
                    console.log('Next button not found or not ready');
                }

                if (announcementPrevBtn && announcementPrevBtn.addEventListener) {
                    announcementPrevBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        console.log('Prev button clicked');
                        prevAnnouncementSlide();
                    });
                    console.log('Prev button listener attached');
                } else {
                    console.log('Prev button not found or not ready');
                }

                // Dot navigation
                if (announcementDotsContainer && announcementDotsContainer.addEventListener) {
                    announcementDotsContainer.addEventListener('click', (e) => {
                        if (e.target.classList.contains('dot')) {
                            const slideIndex = parseInt(e.target.dataset.slide);
                            goToAnnouncementSlide(slideIndex);
                        }
                    });
                    console.log('Dots listener attached');
                } else {
                    console.log('Dots container not found or not ready');
                }
            } catch (error) {
                console.error('Error attaching event listeners:', error);
            }
        }

        // Auto-play for announcements
        let announcementAutoPlayInterval;
        function startAnnouncementAutoPlay() {
            stopAnnouncementAutoPlay();
            if (totalAnnouncementSlides > 1) {
                announcementAutoPlayInterval = setInterval(() => {
                    nextAnnouncementSlide();
                }, 6000); // 6 seconds per slide
            }
        }

        function stopAnnouncementAutoPlay() {
            if (announcementAutoPlayInterval) clearInterval(announcementAutoPlayInterval);
        }

        // Pause auto-play on hover
        function attachHoverListeners() {
            if (announcementCarousel && typeof announcementCarousel.addEventListener === 'function') {
                announcementCarousel.addEventListener('mouseenter', stopAnnouncementAutoPlay);
                announcementCarousel.addEventListener('mouseleave', startAnnouncementAutoPlay);
                console.log('Hover listeners attached');
            } else {
                console.log('Carousel element not found or not ready');
            }
        }

        // Initialize announcements carousel
        function initializeAnnouncementCarousel() {
            console.log('Initializing announcement carousel...');
            initAnnouncementCarousel();

            // Check if the announcements section exists at all
            const announcementsSection = document.getElementById('announcements');
            if (!announcementsSection) {
                console.log('Announcements section not found, skipping carousel initialization');
                return;
            }

            console.log('Announcement carousel debug:', {
                totalSlides: totalAnnouncementSlides,
                nextBtn: !!announcementNextBtn,
                prevBtn: !!announcementPrevBtn,
                track: !!announcementTrack
            });

            // Only proceed if we have slides to show
            if (totalAnnouncementSlides === 0) {
                console.log('No announcement slides found, skipping carousel initialization');
                return;
            }

            // Check if elements exist, if not, retry after a short delay
            if (!announcementNextBtn || !announcementPrevBtn) {
                console.log('Navigation buttons not ready, retrying in 100ms...');
                setTimeout(initializeAnnouncementCarousel, 100);
                return;
            }

            attachAnnouncementEventListeners();
            attachHoverListeners();
            updateAnnouncementCarousel();
            startAnnouncementAutoPlay();
            console.log('Announcement carousel fully initialized');
        }

        // Handle window resize and orientation change
        window.addEventListener('resize', () => {
            if (totalAnnouncementSlides > 0) {
                updateAnnouncementCarousel();
            }
        });

        // Handle orientation change for mobile
        window.addEventListener('orientationchange', () => {
            setTimeout(() => {
                if (totalAnnouncementSlides > 0) {
                    updateAnnouncementCarousel();
                }
            }, 100);
        });

        // Initialize when DOM is ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(initializeAnnouncementCarousel, 50);
            });
        } else {
            setTimeout(initializeAnnouncementCarousel, 50);
        }
    </script>

    <!-- Auth Modals -->
    <style>
        /* Enhanced modern styles for the auth modals */
        #loginModal .left-pane,
        #forgotPasswordModal .left-pane,
        #twoFactorModal .left-pane {
            background: linear-gradient(160deg, #0f5e1d 0%, #127a25 100%);
            min-height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Improved modal layout and responsiveness */
        #loginModal .modal-dialog {
            max-width: 900px;
            width: 900px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 0.5rem;
        }

        #loginModal .modal-content {
            box-shadow: 0 25px 80px rgba(0, 0, 0, .25);
            border: 0;
            border-radius: 20px;
            overflow: hidden;
            width: 100%;
            display: flex;
            align-items: stretch;
            animation: modalSlideIn 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        /* Enhanced modal backdrop */
        #loginModal.modal {
            --bs-modal-zindex: 1055;
        }

        #loginModal .modal-backdrop {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            transition: all 0.3s ease;
        }

        /* Additional centering for modal */
        #loginModal .modal-dialog-centered {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        /* Center the form content horizontally */
        #loginModal .col-lg-7 {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 0.75rem;
        }

        /* Ensure the row takes full width and centers content */
        #loginModal .row {
            width: 100%;
            margin: 0;
            align-items: stretch;
        }

        /* Enhanced tab styling */
        #loginModal .nav-tabs {
            border-bottom: 0;
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            margin-bottom: 0.5rem;
            padding: 0 0.5rem;
        }

        #loginModal .nav-tabs .nav-link {
            border: 0;
            color: #6b7280;
            font-weight: 600;
            font-size: 1rem;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
            position: relative;
            z-index: 1;
            padding: 0.6rem 1.25rem;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
            border: 1px solid #e9ecef;
        }

        #loginModal .nav-tabs .nav-link:hover {
            color: #0f5e1d;
            background: linear-gradient(135deg, rgba(15, 94, 29, 0.08) 0%, rgba(15, 94, 29, 0.03) 100%) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 94, 29, 0.15), 0 2px 4px rgba(0, 0, 0, 0.1);
            border-color: rgba(15, 94, 29, 0.2);
        }

        #loginModal .nav-tabs .nav-link.active,
        #loginModal .nav-tabs .nav-link.active:focus {
            color: #fff !important;
            background: linear-gradient(135deg, #0f5e1d 0%, #127a25 100%) !important;
            border: none !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 94, 29, 0.25), 0 1px 3px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        #loginModal .nav-tabs .nav-link.active:hover {
            color: #fff !important;
            background: linear-gradient(135deg, #0f5e1d 0%, #127a25 100%) !important;
            border: none !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(15, 94, 29, 0.35), 0 2px 8px rgba(0, 0, 0, 0.15);
            filter: brightness(1.08);
        }

        /* Enhanced form styling */
        #loginModal .form-control,
        #forgotPasswordModal .form-control,
        #twoFactorModal .form-control {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 10px 14px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #ffffff;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        #loginModal .form-control:focus,
        #forgotPasswordModal .form-control:focus,
        #twoFactorModal .form-control:focus {
            border-color: #0f5e1d;
            box-shadow: 0 0 0 4px rgba(15, 94, 29, .1), 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transform: translateY(-1px);
        }

        #loginModal .form-control::placeholder {
            color: #9ca3af;
            font-weight: 400;
        }

        /* Enhanced input group styling - Improved Icon Design */
        #loginModal .input-group-text,
        #forgotPasswordModal .input-group-text,
        #twoFactorModal .input-group-text {
            border-radius: 12px 0 0 12px;
            background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
            border: 2px solid #e5e7eb;
            border-right: 0;
            color: #9ca3af;
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 50px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        #loginModal .input-group:focus-within .input-group-text,
        #forgotPasswordModal .input-group:focus-within .input-group-text,
        #twoFactorModal .input-group:focus-within .input-group-text {
            background: linear-gradient(135deg, #eaf6ee 0%, #f0f9f4 100%);
            border-color: #0f5e1d;
            color: #0f5e1d;
            box-shadow: 0 2px 4px rgba(15, 94, 29, 0.1);
            transform: scale(1.02);
        }

        /* Icon hover effect */
        #loginModal .input-group:hover .input-group-text,
        #forgotPasswordModal .input-group:hover .input-group-text,
        #twoFactorModal .input-group:hover .input-group-text {
            color: #0f5e1d;
            background: linear-gradient(135deg, #f0f9f4 0%, #eaf6ee 100%);
            transform: scale(1.01);
        }


        /* Enhanced button styling */
        #loginModal .btn-auth-primary,
        #forgotPasswordModal .btn-auth-primary,
        #twoFactorModal .btn-auth-primary {
            background: linear-gradient(135deg, #0f5e1d 0%, #127a25 100%) !important;
            color: #fff !important;
            border: none !important;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(15, 94, 29, 0.25), 0 1px 3px rgba(0, 0, 0, 0.1) !important;
            position: relative;
            overflow: hidden;
        }

        /* Loading state for buttons */
        .btn.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn.loading .fa-spinner {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #loginModal .btn-auth-primary:hover,
        #forgotPasswordModal .btn-auth-primary:hover,
        #twoFactorModal .btn-auth-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(15, 94, 29, 0.35), 0 2px 8px rgba(0, 0, 0, 0.15);
            filter: brightness(1.08);
        }

        #loginModal .btn-auth-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(15, 94, 29, 0.3);
        }

        /* Force consistent button styling to match Next button */
        #loginModal .btn.w-100.btn-auth-primary,
        #loginModal .btn.btn-auth-primary {
            background: linear-gradient(135deg, #0f5e1d 0%, #127a25 100%) !important;
            color: #fff !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(15, 94, 29, 0.25), 0 1px 3px rgba(0, 0, 0, 0.1) !important;
        }

        #loginModal .btn.w-100.btn-auth-primary:hover,
        #loginModal .btn.btn-auth-primary:hover {
            background: linear-gradient(135deg, #0f5e1d 0%, #127a25 100%) !important;
            color: #fff !important;
            border: none !important;
        }

        /* Remove margin above login/signup buttons */
        #loginModal .btn.w-100.btn-auth-primary {
            margin-top: 0 !important;
        }

        /* Enhanced loading state */
        #loginModal .btn-auth-primary.loading {
            position: relative;
            color: transparent;
            pointer-events: none;
        }

        #loginModal .btn-auth-primary.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Enhanced secondary button styling */
        #loginModal .btn-outline-secondary {
            border: 2px solid #e5e7eb;
            color: #6b7280;
            border-radius: 10px;
            padding: 8px 16px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        #loginModal .btn-outline-secondary:hover {
            border-color: #0f5e1d;
            color: #0f5e1d;
            background-color: rgba(15, 94, 29, 0.05);
            transform: translateY(-1px);
        }

        /* Enhanced password toggle button */
        #loginModal .btn-eye {
            border-color: #e5e7eb;
            color: #6b7280;
            background: #f8fafc;
            border-radius: 0 12px 12px 0;
            padding: 14px 16px;
            transition: all 0.3s ease;
        }

        #loginModal .btn-eye:hover,
        #loginModal .btn-eye:focus,
        #loginModal .btn-eye:active {
            background: #0f5e1d;
            color: #fff;
            border-color: #0f5e1d;
        }

        /* Enhanced form labels */
        #loginModal .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 4px;
            font-size: 0.9rem;
            letter-spacing: 0.025em;
        }

        /* Compact form field spacing for signup steps */
        #signupStep1 .mb-3,
        #signupStep2 .mb-3,
        #signupStep3 .mb-3,
        #signupStep4 .mb-3 {
            margin-bottom: 0.75rem !important;
        }

        /* Reduce general form spacing */
        #loginModal .mb-3 {
            margin-bottom: 0.75rem !important;
        }


        /* Reduce step navigation spacing */
        #loginModal .step-navigation {
            margin-top: 1rem;
        }

        /* Compact step headers */
        #signupStep1 h6,
        #signupStep2 h6,
        #signupStep3 h6,
        #signupStep4 h6 {
            margin-bottom: 0.75rem !important;
            font-size: 0.95rem;
        }

        /* Enhanced checkbox styling */
        #loginModal .form-check-input {
            border-radius: 6px;
            border: 2px solid #e5e7eb;
            width: 18px;
            height: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        #loginModal .form-check-input:checked {
            background-color: #0f5e1d;
            border-color: #0f5e1d;
            box-shadow: 0 2px 8px rgba(15, 94, 29, 0.3);
        }

        #loginModal .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(15, 94, 29, 0.1);
        }

        #loginModal .form-check-label {
            color: #6b7280;
            font-weight: 500;
        }

        /* Enhanced link styling */
        #loginModal .tiny-link {
            color: #0f5e1d;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        #loginModal .tiny-link:hover {
            color: #127a25;
            text-decoration: underline;
            transform: translateY(-1px);
        }

        /* Enhanced left pane styling */
        #loginModal .num-badge {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%);
            color: #0f5e1d;
            font-weight: 700;
            font-size: 0.85rem;
            margin-right: 0.75rem;
            box-shadow: 0 2px 6px rgba(255, 193, 7, 0.3);
            flex-shrink: 0;
        }

        #loginModal .left-pane h5 {
            font-size: 1.2rem;
            line-height: 1.3;
            margin-bottom: 1.5rem;
        }

        #loginModal .left-pane ul li {
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            line-height: 1.3;
            display: flex;
            align-items: flex-start;
        }

        /* Enhanced step navigation */
        #loginModal .step-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
            padding-top: 0.75rem;
            border-top: 1px solid #e5e7eb;
            position: relative;
        }

        #loginModal .step-navigation::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent 0%, #0f5e1d 50%, transparent 100%);
        }


        /* Enhanced file input styling */
        #loginModal .form-control[type="file"] {
            padding: 12px 16px;
            background-color: #f8fafc;
        }

        #loginModal .form-text {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Enhanced select styling */
        #loginModal .form-select {
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            padding: 14px 16px;
            background-color: #fafafa;
            transition: all 0.3s ease;
        }

        #loginModal .form-select:focus {
            border-color: #0f5e1d;
            box-shadow: 0 0 0 4px rgba(15, 94, 29, .1);
            background-color: #fff;
        }

        /* Mobile responsiveness improvements */
        @media (max-width: 1199.98px) {
            #loginModal .modal-dialog {
                width: calc(100vw - 1rem);
                max-width: calc(100vw - 1rem);
                margin: 0 auto;
                min-height: 100vh;
                padding: 0.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #loginModal .left-pane {
                display: none !important;
            }

            #loginModal .col-lg-7 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            #loginModal .nav-tabs {
                gap: 1rem;
                margin-bottom: 1rem;
            }

            #loginModal .nav-tabs .nav-link {
                font-size: 1rem;
                padding: 0.6rem 1.2rem;
            }
        }

        @media (max-width: 575.98px) {
            #loginModal .modal-dialog {
                width: calc(100vw - 0.5rem);
                max-width: calc(100vw - 0.5rem);
                margin: 0 auto;
                min-height: 100vh;
                padding: 0.25rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            #loginModal .col-lg-7 {
                padding: 1.5rem !important;
            }

            #loginModal .nav-tabs {
                gap: 0.5rem;
            }

            #loginModal .nav-tabs .nav-link {
                font-size: 0.9rem;
                padding: 0.5rem 1rem;
            }

            #loginModal .form-control,
            #loginModal .form-select {
                padding: 12px 14px;
            }

            #loginModal .btn-auth-primary {
                padding: 12px 20px;
            }
        }

        /* Enhanced focus states for accessibility */
        #loginModal .nav-link:focus,
        #loginModal .btn:focus,
        #loginModal .form-control:focus,
        #loginModal .form-select:focus {
            outline: 2px solid #0f5e1d;
            outline-offset: 2px;
        }

        /* Loading state for buttons */
        #loginModal .btn-auth-primary.loading {
            position: relative;
            color: transparent;
        }

        #loginModal .btn-auth-primary.loading::after {
            content: "";
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Enhanced error states */
        #loginModal .form-control.is-invalid {
            border-color: #dc2626;
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
        }

        #loginModal .invalid-feedback {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            display: block;
        }

        /* Enhanced success states */
        #loginModal .form-control.is-valid {
            border-color: #0f5e1d;
            box-shadow: 0 0 0 4px rgba(15, 94, 29, 0.1);
        }

        /* OTP inputs styling */
        #twoFactorModal .otp-box {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            margin: 2rem 0;
        }

        #twoFactorModal .otp-input {
            width: 48px;
            height: 56px;
            text-align: center;
            font-size: 1.5rem;
            border-radius: 12px;
            border: 2px solid #e5e7eb;
            background-color: #fafafa;
            transition: all 0.3s ease;
        }

        #twoFactorModal .otp-input:focus {
            outline: none;
            border-color: #0f5e1d;
            box-shadow: 0 0 0 4px rgba(15, 94, 29, .1);
            background-color: #fff;
        }

        /* Tab indicator */
        #loginModal .tabs-wrapper {
            position: relative;
            padding-bottom: 10px;
        }

        #authTabIndicator {
            display: none;
        }

        /* Step Progress Indicator Styling */
        .step-progress {
            margin-bottom: 2rem;
        }

        .step-progress .d-flex {
            position: relative;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e5e7eb;
            color: #6b7280;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }

        .step-item.active .step-circle {
            background: linear-gradient(135deg, #0f5e1d 0%, #127a25 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(15, 94, 29, 0.3);
        }

        .step-item.completed .step-circle {
            background: #0f5e1d;
            color: #fff;
        }

        .step-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: #6b7280;
            text-align: center;
            transition: all 0.3s ease;
        }

        .step-item.active .step-label {
            color: #0f5e1d;
            font-weight: 600;
        }

        .step-line {
            position: absolute;
            top: 20px;
            left: 50%;
            right: 50%;
            height: 2px;
            background: #e5e7eb;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .step-item.active+.step-line,
        .step-item.completed+.step-line {
            background: #0f5e1d;
        }

        /* Mobile responsiveness for step progress */
        @media (max-width: 575.98px) {
            .step-progress {
                margin-bottom: 1.5rem;
            }

            .step-circle {
                width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }

            .step-label {
                font-size: 0.7rem;
            }

            .step-line {
                top: 16px;
            }
        }

        /* Enhanced form validation styling */
        .form-control.is-valid {
            border-color: #0f5e1d;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%230f5e1d' d='m2.3 6.73.94-.94 1.89-1.89 1.89 1.89.94.94-2.83 2.83L2.3 6.73z'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px 16px;
        }

        .form-control.is-invalid {
            border-color: #dc2626;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc2626'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath d='m5.8 4.6 1.4 1.4m0-1.4-1.4 1.4'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px 16px;
        }

        /* Enhanced password strength indicator */
        .password-strength {
            margin-top: 0.5rem;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .password-strength.weak .password-strength-bar {
            width: 25%;
            background: #dc2626;
        }

        .password-strength.fair .password-strength-bar {
            width: 50%;
            background: #f59e0b;
        }

        .password-strength.good .password-strength-bar {
            width: 75%;
            background: #3b82f6;
        }

        .password-strength.strong .password-strength-bar {
            width: 100%;
            background: #0f5e1d;
        }

        /* Enhanced loading states */
        .btn-auth-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Enhanced focus management */
        .modal.show .form-control:focus {
            z-index: 1055;
        }

        /* Enhanced error message styling */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
        }

        .alert-danger {
            background: rgba(220, 38, 38, 0.1);
            color: #dc2626;
            border-left: 4px solid #dc2626;
        }

        .alert-success {
            background: rgba(15, 94, 29, 0.1);
            color: #0f5e1d;
            border-left: 4px solid #0f5e1d;
        }

        /* Simple Progress Line Indicator */
        .progress-line-container {
            text-align: center;
        }

        .progress-line {
            width: 100%;
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #0f5e1d 0%, #127a25 100%);
            border-radius: 2px;
            transition: width 0.5s ease;
            width: 25%;
        }

        .progress-text {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
        }

        /* Progress states for different steps */
        .progress-fill.step-1 {
            width: 25%;
        }

        .progress-fill.step-2 {
            width: 50%;
        }

        .progress-fill.step-3 {
            width: 75%;
        }

        .progress-fill.step-4 {
            width: 100%;
        }

        /* Enhanced file upload styling */
        .form-control[type="file"] {
            cursor: pointer;
        }

        .form-control[type="file"]:hover {
            background-color: #f8fafc;
        }

        /* Enhanced file upload input styling */
        .form-control[type="file"] {
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 0 12px 12px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            transition: all 0.3s ease;
        }

        .form-control[type="file"]:hover {
            background: linear-gradient(135deg, #f0f9f4 0%, #eaf6ee 100%);
            border-color: #0f5e1d;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(15, 94, 29, 0.15);
        }

        .form-control[type="file"]:focus {
            border-color: #0f5e1d;
            box-shadow: 0 0 0 4px rgba(15, 94, 29, .1), 0 2px 8px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }

        /* File upload input group styling */
        .input-group .form-control[type="file"] {
            border-left: 0;
        }

        /* Enhanced select dropdown styling */
        .form-select {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        }

        .form-select:focus {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%230f5e1d' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
        }
    </style>
    @guest
        <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane"
                            style="color:#fff;">
                            <div class="text-center">
                                <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                                    style="width:70px;height:70px;border-radius:50%; background:#fff; object-fit:cover;"
                                    class="mb-3">
                                <h5 class="fw-bold mb-3">CMU Guidance and<br> Counseling Center</h5>
                                <ul class="list-unstyled text-start mx-auto" style="max-width:260px;">
                                    <li class="mb-3 d-flex align-items-center"><span class="num-badge">1</span><span>Easy
                                            appointment scheduling with university counselors</span></li>
                                    <li class="mb-3 d-flex align-items-center"><span class="num-badge">2</span><span>Access
                                            to mental health resources and information</span></li>
                                    <li class="d-flex align-items-center"><span class="num-badge">3</span><span>Secure and
                                            confidential counseling services</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-7 p-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                                        style="width:35px;height:35px;border-radius:50%; background:#fff; object-fit:cover;"
                                        class="me-2 d-lg-none">
                                    <h6 class="mb-0 text-muted d-lg-none" style="font-size:0.9rem;">CMU Guidance &
                                        Counseling Center</h6>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="tabs-wrapper">
                                <ul class="nav nav-tabs mb-1" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="tab-login" data-bs-toggle="tab"
                                            data-bs-target="#pane-login" type="button" role="tab" aria-controls="pane-login"
                                            aria-selected="true">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab-signup" data-bs-toggle="tab"
                                            data-bs-target="#pane-signup" type="button" role="tab"
                                            aria-controls="pane-signup" aria-selected="false">
                                            <i class="fas fa-user-plus me-2"></i>Sign Up
                                        </button>
                                    </li>
                                </ul>
                                <div id="authTabIndicator"></div>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="pane-login" role="tabpanel"
                                    aria-labelledby="tab-login">
                                    <form id="modalLoginForm" method="POST" action="{{ url('/login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                <input type="email" name="email" class="form-control" required
                                                    autocomplete="email" placeholder="Email Address">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                <input type="password" name="password" class="form-control" required
                                                    autocomplete="current-password" placeholder="Password"
                                                    id="loginPassword">
                                                <button class="btn btn-outline-secondary btn-eye" type="button"
                                                    id="toggleLoginPassword" style="border-radius:0 12px 12px 0;"
                                                    aria-label="Show password"><i class="fas fa-eye"></i></button>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                            <a href="#" class="small tiny-link" data-bs-toggle="modal"
                                                data-bs-target="#forgotPasswordModal" data-bs-dismiss="modal">Forgot
                                                Password?</a>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-auth-primary">
                                                <i class="fas fa-sign-in-alt me-2"></i>Login
                                            </button>
                                        </div>
                                    </form>

                                </div>
                                <div class="tab-pane fade" id="pane-signup" role="tabpanel" aria-labelledby="tab-signup">
                                    <form enctype="multipart/form-data" id="signupForm"
                                        data-ajax-url="{{ url('/register') }}">
                                        @csrf

                                        <!-- Simple Progress Line Indicator -->
                                        <div class="progress-line-container mb-4">
                                            <div class="progress-line">
                                                <div class="progress-fill" id="progressFill"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span id="progressText">Step 1 of 4</span>
                                            </div>
                                        </div>

                                        <div id="signupStep1">
                                            <h6 class="mb-3 text-muted"><i class="fas fa-user me-2"></i>Name Information
                                            </h6>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="first_name" class="form-control" required
                                                        placeholder="First Name *" autocomplete="given-name">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="middle_name" class="form-control"
                                                        placeholder="Middle Name (Optional)" autocomplete="additional-name">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="last_name" class="form-control" required
                                                        placeholder="Last Name *" autocomplete="family-name">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                                    <select class="form-select" name="gender" id="genderSelect" required>
                                                        <option value="" selected disabled>Select Gender *</option>
                                                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>
                                                            Male</option>
                                                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                        <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer
                                                            not to say</option>
                                                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other (please specify)</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3" id="genderOtherField" style="display: none;">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                    <input type="text" name="gender_other" class="form-control"
                                                        placeholder="Please specify your gender" id="genderOtherInput"
                                                        value="{{ old('gender_other') }}">
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
                                            <h6 class="mb-3 text-muted"><i class="fas fa-phone me-2"></i>Contact Information
                                            </h6>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="tel" name="contact_number" class="form-control" required
                                                        placeholder="Contact Number * (e.g., 09XXXXXXXXX)"
                                                        pattern="[0-9]{10,11}" autocomplete="tel">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-map-marker-alt"></i></span>
                                                    <input type="text" name="address" class="form-control" required
                                                        placeholder="Home Address * (House/Street, Barangay, City/Province)"
                                                        autocomplete="address-line1">
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
                                            <h6 class="mb-3 text-muted"><i class="fas fa-key me-2"></i>Account Credentials
                                            </h6>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    <input type="email" name="email" class="form-control" required
                                                        autocomplete="email" placeholder="Email Address *">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    <input type="password" name="password" class="form-control" required
                                                        autocomplete="new-password"
                                                        placeholder="Password * (min 8 characters)" id="signupPassword">
                                                    <button class="btn btn-outline-secondary btn-eye" type="button"
                                                        id="toggleSignupPassword" style="border-radius:0 12px 12px 0;"
                                                        aria-label="Show password"><i class="fas fa-eye"></i></button>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                                <div class="form-text">
                                                    <small class="text-muted">Password must be at least 8 characters
                                                        long</small>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        required autocomplete="new-password"
                                                        placeholder="Confirm Password *" id="signupPasswordConfirm">
                                                    <button class="btn btn-outline-secondary btn-eye" type="button"
                                                        id="toggleSignupPasswordConfirm"
                                                        style="border-radius:0 12px 12px 0;" aria-label="Show password"><i
                                                            class="fas fa-eye"></i></button>
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
                                            <h6 class="mb-3 text-muted"><i class="fas fa-graduation-cap me-2"></i>Student
                                                Information</h6>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                    <input type="text" name="student_id" class="form-control" required
                                                        placeholder="Student ID * (e.g., 2021-12345)">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-7">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-university"></i></span>
                                                        <select class="form-select" name="college" id="collegeSelect"
                                                            required>
                                                            <option value="" selected disabled>College *</option>
                                                        </select>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i
                                                                class="fas fa-layer-group"></i></span>
                                                        <select class="form-select" name="year_level" required>
                                                            <option value="" selected disabled>Year Level *</option>
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
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-graduation-cap"></i></span>
                                                    <select class="form-select" name="course" id="courseSelect" required>
                                                        <option value="" selected disabled>Course / Program *</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                                    <input class="form-control" type="file" name="cor_file"
                                                        accept=".pdf,image/*" required>
                                                </div>
                                                <div class="form-text">
                                                    <div class="alert alert-info d-flex align-items-center mt-2"
                                                        style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); border: 1px solid #2196f3; border-radius: 8px;">
                                                        <i class="fas fa-info-circle me-2" style="color: #2196f3;"></i>
                                                        <div>
                                                            <strong>Certificate of Registration (COR) Required</strong><br>
                                                            <small class="text-muted">Upload your COR in PDF, JPG, or PNG
                                                                format (Max 5MB). This will be used for verification by the
                                                                counselor.</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="step-navigation">
                                                <button type="button" class="btn btn-outline-secondary" id="backToStep3">
                                                    <i class="fas fa-arrow-left me-2"></i>Back
                                                </button>
                                                <button type="button" class="btn btn-auth-primary" id="signupSubmitBtn">
                                                    <i class="fas fa-check me-2"></i>
                                                    Submit
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
    @endguest

    @guest
        <!-- Forgot Password Modal -->
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane"
                            style="color:#fff;">
                            <div class="text-center">
                                <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                                    style="width:90px;height:90px;border-radius:50%; background:#fff; object-fit:cover;"
                                    class="mb-3">
                                <h5 class="fw-bold mb-3">Reset your password</h5>
                                <p class="small mb-0">We’ll email you a secure link to create a new password.</p>
                            </div>
                        </div>
                        <div class="col-lg-7 p-4">
                            <div class="d-flex justify-content-end align-items-center mb-3">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <h5 class="mb-3" style="color:#0f5e1d;">Forgot Password</h5>
                            <p class="small text-muted">Enter your email address and we'll send you a link to reset your
                                password.</p>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" name="email" class="form-control" required autocomplete="email"
                                            placeholder="Email Address">
                                    </div>
                                </div>
                                <button type="submit" class="btn w-100 fw-bold btn-auth-primary">Send Reset Link</button>
                            </form>
                            <div class="text-center mt-3 small">
                                <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                    class="tiny-link">Back to Sign In</a>
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
                            <button type="submit" class="btn btn-success w-100 fw-bold"
                                style="background: var(--primary-green); border: none; border-radius: 10px;">Resend
                                Email</button>
                        </form>
                        <div class="text-center mt-3 small">
                            <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                style="color: var(--accent-green); text-decoration: none;">Back to Sign In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Two-Factor Authentication Modal -->
        <div class="modal fade" id="twoFactorModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane"
                            style="color:#fff;">
                            <div class="text-center">
                                <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
                                    style="width:90px;height:90px;border-radius:50%; background:#fff; object-fit:cover;"
                                    class="mb-3">
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
                                <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                    class="tiny-link">Back to Sign In</a>
                                <div class="d-flex align-items-center">
                                    <form method="POST" action="{{ route('2fa.resend') }}" id="resend2faForm">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 tiny-link" id="resend2faBtn">Resend
                                            code</button>
                                    </form>
                                    <span id="resendTimer" class="ms-3 text-muted small"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- @endguest moved to after JavaScript so modals work for everyone --}}

        <script>
            // Auto-open relevant modal based on session flash
            document.addEventListener('DOMContentLoaded', function () {
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

                // Sign up multi-step navigation is now handled by the enhanced signup functionality

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

                // Helper function to safely get or create modal instance
                // Note: Bootstrap Modal.getOrCreateInstance is already patched earlier in the page
                function safeGetModalInstance(element) {
                    if (!element) return null;
                    if (typeof bootstrap === 'undefined' || !bootstrap.Modal) return null;

                    // Check if element has modal class structure
                    if (!element.classList.contains('modal')) return null;

                    // Ensure element is in the DOM
                    if (!document.body.contains(element)) return null;

                    // Ensure element has required modal structure (modal-dialog child)
                    if (!element.querySelector('.modal-dialog')) return null;

                    try {
                        // Use the overridden getOrCreateInstance which has error handling
                        return bootstrap.Modal.getOrCreateInstance(element);
                    } catch (e) {
                        console.warn('Could not create modal instance:', e);
                        return null;
                    }
                }

                // Helper function to safely show modal
                function safeShowModal(elementId) {
                    const element = document.getElementById(elementId);
                    if (!element) return false;

                    const instance = safeGetModalInstance(element);
                    if (instance) {
                        try {
                            instance.show();
                            return true;
                        } catch (e) {
                            console.warn('Could not show modal:', e);
                            return false;
                        }
                    }
                    return false;
                }

                // Helper function to safely hide modal
                function safeHideModal(elementId) {
                    const element = document.getElementById(elementId);
                    if (!element) return false;

                    const instance = safeGetModalInstance(element);
                    if (instance) {
                        try {
                            instance.hide();
                            return true;
                        } catch (e) {
                            console.warn('Could not hide modal:', e);
                            return false;
                        }
                    }
                    return false;
                }

                // AJAX login -> intercept 2FA redirect and open modal instead
                const loginForm = document.getElementById('modalLoginForm');
                if (loginForm) {
                    loginForm.addEventListener('submit', async function (e) {
                        e.preventDefault();
                        const submitBtn = loginForm.querySelector('button[type="submit"]');
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Logging in...';

                        try {
                            const formData = new FormData(loginForm);
                            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                            const resp = await fetch(loginForm.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': csrfToken || '',
                                    'Accept': 'application/json'
                                },
                                body: formData,
                                credentials: 'include'
                            });

                            const data = await resp.json();
                            console.log('Login response:', data);

                            // Handle 2FA required
                            if (data.status === '2fa_required') {
                                console.log('2FA required, showing modal');
                                safeHideModal('loginModal');
                                setTimeout(() => {
                                    const twoFactorModal = document.getElementById('twoFactorModal');
                                    if (twoFactorModal && window.bootstrap) {
                                        bootstrap.Modal.getOrCreateInstance(twoFactorModal).show();
                                    }
                                }, 300);
                                return;
                            }

                            // Handle success
                            if (data.status === 'success') {
                                if (window.Swal) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Login Successful!',
                                        text: data.message || 'Welcome back!',
                                        timer: 2000
                                    }).then(() => {
                                        window.location.href = data.redirect || '/dashboard';
                                    });
                                } else {
                                    window.location.href = data.redirect || '/dashboard';
                                }
                                return;
                            }

                            // Handle error
                            const errorMsg = data.message || 'Login failed. Please try again.';
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Login Failed',
                                    text: errorMsg
                                });
                            } else {
                                alert(errorMsg);
                            }

                        } catch (err) {
                            console.error('Login error:', err);
                            const msg = 'Network error. Please check your connection and try again.';
                            if (window.Swal) {
                                Swal.fire({ icon: 'error', title: 'Error', text: msg });
                            } else {
                                alert(msg);
                            }
                        } finally {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login';
                        }
                    });
                }

                // Old AJAX handler removed - logic moved to enhanceFormSubmission

                // AJAX 2FA verify to avoid navigation (enhanced: paste support, UI, resend timer)
                const twofaForm = document.getElementById('modal2faForm');
                if (twofaForm) {
                    // OTP input handling — supports typing, backspace navigation, and paste of full code
                    const otpInputs = Array.from(document.querySelectorAll('#twoFactorModal .otp-input'));
                    const otpHidden = document.getElementById('otpHidden');
                    const verifyBtn = twofaForm.querySelector('button[type="submit"]');

                    const updateHidden = () => { if (otpHidden) otpHidden.value = otpInputs.map(i => i.value).join(''); };

                    otpInputs.forEach((input, idx) => {
                        // Ensure input attributes for accessibility and paste
                        input.setAttribute('autocomplete', 'one-time-code');
                        input.setAttribute('inputmode', 'numeric');
                        input.dataset.index = String(idx);

                        input.addEventListener('input', (e) => {
                            input.value = input.value.replace(/\D/g, '').slice(0, 1);
                            if (input.value && idx < otpInputs.length - 1) otpInputs[idx + 1].focus();
                            updateHidden();
                            // enable verify only when all digits present
                            if (verifyBtn) verifyBtn.disabled = otpInputs.some(i => !i.value);
                        });

                        input.addEventListener('keydown', (e) => {
                            if (e.key === 'Backspace' && !input.value && idx > 0) {
                                otpInputs[idx - 1].focus();
                            }
                            // allow navigation with arrow keys
                            if (e.key === 'ArrowLeft' && idx > 0) otpInputs[idx - 1].focus();
                            if (e.key === 'ArrowRight' && idx < otpInputs.length - 1) otpInputs[idx + 1].focus();
                        });

                        // Paste handler: distribute pasted digits starting at this input
                        input.addEventListener('paste', (e) => {
                            e.preventDefault();
                            const paste = (e.clipboardData || window.clipboardData).getData('text') || '';
                            const digits = paste.replace(/\D/g, '').slice(0, otpInputs.length - idx).split('');
                            for (let i = 0; i < digits.length; i++) {
                                otpInputs[idx + i].value = digits[i];
                            }
                            const nextPos = Math.min(idx + digits.length, otpInputs.length - 1);
                            otpInputs[nextPos].focus();
                            updateHidden();
                            if (verifyBtn) verifyBtn.disabled = otpInputs.some(i => !i.value);
                        });
                    });

                    // Initialize verify button state
                    if (verifyBtn) verifyBtn.disabled = otpInputs.some(i => !i.value);

                    // Resend timer and AJAX resend
                    const resendForm = document.getElementById('resend2faForm');
                    const resendBtn = document.getElementById('resend2faBtn');
                    const resendTimerEl = document.getElementById('resendTimer');
                    let resendSeconds = 300; // 5 minutes default
                    let resendInterval = null;

                    const startResendTimer = (seconds = 300) => {
                        clearInterval(resendInterval);
                        resendSeconds = seconds;
                        if (resendBtn) resendBtn.disabled = true;
                        const tick = () => {
                            if (!resendTimerEl) return;
                            const mm = String(Math.floor(resendSeconds / 60)).padStart(2, '0');
                            const ss = String(resendSeconds % 60).padStart(2, '0');
                            resendTimerEl.textContent = `You can resend in ${mm}:${ss}`;
                            if (resendSeconds <= 0) {
                                clearInterval(resendInterval);
                                resendTimerEl.textContent = '';
                                if (resendBtn) resendBtn.disabled = false;
                            }
                            resendSeconds -= 1;
                        };
                        tick();
                        resendInterval = setInterval(tick, 1000);
                    };

                    // If there's an existing resend form on the page but with different markup, try to wire it
                    if (resendForm) {
                        resendForm.addEventListener('submit', async function (e) {
                            e.preventDefault();
                            if (resendBtn) resendBtn.disabled = true;
                            try {
                                const fd = new FormData(resendForm);
                                const resp = await fetch(resendForm.action, {
                                    method: 'POST',
                                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                                    body: fd,
                                    credentials: 'same-origin'
                                });
                                if (resp.ok) {
                                    // start timer and notify user
                                    startResendTimer(120);
                                    try { const data = await resp.json(); if (data && data.message) alert(data.message); else alert('Verification code resent.'); } catch { alert('Verification code resent.'); }
                                } else {
                                    try { const data = await resp.json(); alert(data.message || 'Unable to resend code'); } catch { alert('Unable to resend code'); }
                                }
                            } catch (err) {
                                console.error(err);
                                alert('Network error. Please try again.');
                            } finally {
                                // leave timer to control enabling
                            }
                        });
                    }

                    // Start a timer when the modal is shown (prevent immediate resend)
                    const twoFactorModalEl = document.getElementById('twoFactorModal');
                    if (twoFactorModalEl) {
                        twoFactorModalEl.addEventListener('shown.bs.modal', function () {
                            startResendTimer(300);
                            // focus first input
                            setTimeout(() => { otpInputs[0]?.focus(); }, 120);
                        });
                        twoFactorModalEl.addEventListener('hidden.bs.modal', function () {
                            // clear inputs when closing
                            otpInputs.forEach(i => i.value = '');
                            updateHidden();
                            if (resendTimerEl) resendTimerEl.textContent = '';
                            clearInterval(resendInterval);
                            if (resendBtn) resendBtn.disabled = false;
                        });
                    }

                    twofaForm.addEventListener('submit', async function (e) {
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
                                try { const data = await resp.json(); msg = data.message || msg; } catch { }
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

                // Enhanced Signup Form Functionality
                // Declare these in outer scope so they can be accessed by modal event handlers
                let enhanceStepNavigation, validateStep, updateStepProgress;

                function initializeEnhancedSignup() {
                    console.log('=== initializeEnhancedSignup START ===');

                    // Gender "Other" field toggle
                    const genderSelect = document.getElementById('genderSelect');
                    const genderOtherField = document.getElementById('genderOtherField');
                    const genderOtherInput = document.getElementById('genderOtherInput');

                    if (genderSelect && genderOtherField) {
                        genderSelect.addEventListener('change', function () {
                            if (this.value === 'other') {
                                genderOtherField.style.display = 'block';
                                if (genderOtherInput) {
                                    genderOtherInput.setAttribute('required', 'required');
                                }
                            } else {
                                genderOtherField.style.display = 'none';
                                if (genderOtherInput) {
                                    genderOtherInput.removeAttribute('required');
                                    genderOtherInput.value = '';
                                }
                            }
                        });

                        // Check on page load if "other" is already selected
                        if (genderSelect.value === 'other') {
                            genderOtherField.style.display = 'block';
                            if (genderOtherInput) {
                                genderOtherInput.setAttribute('required', 'required');
                            }
                        }
                    }

                    // Step Progress Management
                    updateStepProgress = function (currentStep) {
                        const progressFill = document.getElementById('progressFill');
                        const progressText = document.getElementById('progressText');

                        if (progressFill) {
                            progressFill.className = `progress-fill step-${currentStep}`;
                        }

                        if (progressText) {
                            progressText.textContent = `Step ${currentStep} of 4`;
                        }
                    };

                    // Enhanced Form Validation
                    validateStep = function (stepElement) {
                        let isValid = true;
                        const requiredFields = stepElement.querySelectorAll('input[required], select[required]');

                        requiredFields.forEach(field => {
                            const feedback = field.closest('.mb-3')?.querySelector('.invalid-feedback');

                            // Clear previous validation
                            field.classList.remove('is-invalid', 'is-valid');
                            if (feedback) feedback.textContent = '';

                            // Validate field
                            if (!field.value.trim() && field.type !== 'file') {
                                field.classList.add('is-invalid');
                                if (feedback) feedback.textContent = 'This field is required';
                                isValid = false;
                            } else if (field.type === 'file' && field.files.length === 0) {
                                field.classList.add('is-invalid');
                                if (feedback) feedback.textContent = 'This field is required';
                                isValid = false;
                            } else {
                                field.classList.add('is-valid');

                                // Additional validation for specific fields
                                if (field.type === 'email') {
                                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                                    if (!emailRegex.test(field.value)) {
                                        field.classList.remove('is-valid');
                                        field.classList.add('is-invalid');
                                        if (feedback) feedback.textContent = 'Please enter a valid email address';
                                        isValid = false;
                                    }
                                }

                                if (field.type === 'tel') {
                                    const phoneRegex = /^09\d{9}$/;
                                    if (!phoneRegex.test(field.value)) {
                                        field.classList.remove('is-valid');
                                        field.classList.add('is-invalid');
                                        if (feedback) feedback.textContent = 'Please enter a valid 11-digit phone number starting with 09';
                                        isValid = false;
                                    }
                                }

                                // Password confirmation matching
                                if (field.name === 'password_confirmation') {
                                    const passwordField = document.getElementById('signupPassword');
                                    if (passwordField && field.value !== passwordField.value) {
                                        field.classList.remove('is-valid');
                                        field.classList.add('is-invalid');
                                        if (feedback) feedback.textContent = 'Passwords do not match';
                                        isValid = false;
                                    }
                                }

                                // File upload validation (size and type)
                                if (field.type === 'file' && field.files.length > 0) {
                                    const file = field.files[0];
                                    const maxSize = 5 * 1024 * 1024; // 5MB
                                    const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'];

                                    if (file.size > maxSize) {
                                        field.classList.remove('is-valid');
                                        field.classList.add('is-invalid');
                                        if (feedback) feedback.textContent = 'File size must be less than 5MB';
                                        isValid = false;
                                    } else if (!allowedTypes.includes(file.type)) {
                                        field.classList.remove('is-valid');
                                        field.classList.add('is-invalid');
                                        if (feedback) feedback.textContent = 'File must be PDF, JPG, or PNG';
                                        isValid = false;
                                    }
                                }
                            }
                        });

                        return isValid;
                    }


                        ;


                    // Password Strength Indicator
                    function addPasswordStrengthIndicator() {
                        const passwordField = document.getElementById('signupPassword');
                        if (!passwordField) return;

                        const strengthContainer = document.createElement('div');
                        strengthContainer.className = 'password-strength';
                        strengthContainer.innerHTML = '<div class="password-strength-bar"></div>';

                        const parentDiv = passwordField.closest('.mb-3');
                        if (parentDiv) {
                            parentDiv.appendChild(strengthContainer);
                        }

                        passwordField.addEventListener('input', function () {
                            const password = this.value;
                            const strengthBar = strengthContainer.querySelector('.password-strength-bar');

                            let strength = 'weak';
                            if (password.length >= 8) {
                                if (password.match(/[a-z]/) && password.match(/[A-Z]/) && password.match(/[0-9]/) && password.match(/[^a-zA-Z0-9]/)) {
                                    strength = 'strong';
                                } else if (password.match(/[a-z]/) && password.match(/[A-Z]/) && password.match(/[0-9]/)) {
                                    strength = 'good';
                                } else if (password.match(/[a-z]/) && password.match(/[A-Z]/)) {
                                    strength = 'fair';
                                }
                            }

                            strengthContainer.className = `password-strength ${strength}`;
                        });
                    }

                    // Password Confirmation Validation
                    function addPasswordConfirmationValidation() {
                        const passwordField = document.getElementById('signupPassword');
                        const confirmField = document.getElementById('signupPasswordConfirm');

                        if (!passwordField || !confirmField) return;

                        confirmField.addEventListener('input', function () {
                            const password = passwordField.value;
                            const confirmation = this.value;
                            const feedback = this.closest('.mb-3')?.querySelector('.invalid-feedback');

                            this.classList.remove('is-invalid', 'is-valid');
                            if (feedback) feedback.textContent = '';

                            if (confirmation && password !== confirmation) {
                                this.classList.add('is-invalid');
                                if (feedback) feedback.textContent = 'Passwords do not match';
                            } else if (confirmation && password === confirmation) {
                                this.classList.add('is-valid');
                            }
                        });
                    }

                    // Enhanced Step Navigation (per-button listeners reattached on modal show)
                    enhanceStepNavigation = function () {
                        console.log('enhanceStepNavigation called');

                        // helper to safely attach a click handler by replacing the button (removes old listeners)
                        function attach(id, handler) {
                            const btn = document.getElementById(id);
                            console.log(`Attaching listener to ${id}, button found:`, !!btn);
                            if (!btn) return;
                            const cloned = btn.cloneNode(true);
                            btn.parentNode.replaceChild(cloned, btn);
                            cloned.addEventListener('click', handler);
                        }

                        attach('goToStep2', function () {
                            console.log('goToStep2 clicked!');
                            const step1 = document.getElementById('signupStep1');
                            const step2 = document.getElementById('signupStep2');
                            console.log('step1:', !!step1, 'step2:', !!step2);
                            if (validateStep(step1)) {
                                console.log('Step 1 validation passed, moving to step 2');
                                step1.classList.add('d-none');
                                step2.classList.remove('d-none');
                                updateStepProgress(2);
                                const firstField = step2.querySelector('input, select');
                                if (firstField) firstField.focus();
                            } else {
                                console.log('Step 1 validation failed');
                            }
                        });

                        attach('backToStep1', function () {
                            const step1 = document.getElementById('signupStep1');
                            const step2 = document.getElementById('signupStep2');
                            step2.classList.add('d-none');
                            step1.classList.remove('d-none');
                            updateStepProgress(1);
                        });

                        attach('goToStep3', function () {
                            const step2 = document.getElementById('signupStep2');
                            const step3 = document.getElementById('signupStep3');
                            if (validateStep(step2)) {
                                step2.classList.add('d-none');
                                step3.classList.remove('d-none');
                                updateStepProgress(3);
                                const firstField = step3.querySelector('input, select');
                                if (firstField) firstField.focus();
                            }
                        });

                        attach('backToStep2', function () {
                            const step2 = document.getElementById('signupStep2');
                            const step3 = document.getElementById('signupStep3');
                            step3.classList.add('d-none');
                            step2.classList.remove('d-none');
                            updateStepProgress(2);
                        });

                        attach('goToStep4', function () {
                            const step3 = document.getElementById('signupStep3');
                            const step4 = document.getElementById('signupStep4');
                            if (validateStep(step3)) {
                                step3.classList.add('d-none');
                                step4.classList.remove('d-none');
                                updateStepProgress(4);
                                const firstField = step4.querySelector('input, select');
                                if (firstField) firstField.focus();
                            }
                        });

                        attach('backToStep3', function () {
                            const step3 = document.getElementById('signupStep3');
                            const step4 = document.getElementById('signupStep4');
                            step4.classList.add('d-none');
                            step3.classList.remove('d-none');
                            updateStepProgress(3);
                        });
                    }

                        ;

                    // Real-time Field Validation
                    function addRealTimeValidation() {
                        const inputs = document.querySelectorAll('#signupForm input, #signupForm select');
                        inputs.forEach(input => {
                            input.addEventListener('blur', function () {
                                const feedback = this.closest('.mb-3')?.querySelector('.invalid-feedback');

                                if (this.hasAttribute('required') && !this.value.trim()) {
                                    this.classList.add('is-invalid');
                                    if (feedback) feedback.textContent = 'This field is required';
                                } else if (this.value.trim()) {
                                    this.classList.remove('is-invalid');
                                    this.classList.add('is-valid');
                                    if (feedback) feedback.textContent = '';
                                }
                            });
                        });
                    }

                    // Enhanced Form Submission
                    function enhanceFormSubmission() {
                        const signupForm = document.getElementById('signupForm');
                        if (!signupForm) return;

                        signupForm.addEventListener('submit', async function (e) {
                            console.log('Signup form submission started');
                            e.preventDefault(); // Always prevent default for AJAX

                            // Validate all steps before submission
                            const step1 = document.getElementById('signupStep1');
                            const step2 = document.getElementById('signupStep2');
                            const step3 = document.getElementById('signupStep3');
                            const step4 = document.getElementById('signupStep4');

                            let allValid = true;

                            // Validate each step
                            if (!validateStep(step1)) allValid = false;
                            if (!validateStep(step2)) allValid = false;
                            if (!validateStep(step3)) allValid = false;
                            if (!validateStep(step4)) allValid = false;

                            if (!allValid) {
                                console.log('Form validation failed');
                                // Show the first invalid step
                                if (step1.querySelector('.is-invalid')) {
                                    step1.classList.remove('d-none');
                                    step2.classList.add('d-none');
                                    step3.classList.add('d-none');
                                    step4.classList.add('d-none');
                                    updateStepProgress(1);
                                } else if (step2.querySelector('.is-invalid')) {
                                    step1.classList.add('d-none');
                                    step2.classList.remove('d-none');
                                    step3.classList.add('d-none');
                                    step4.classList.add('d-none');
                                    updateStepProgress(2);
                                } else if (step3.querySelector('.is-invalid')) {
                                    step1.classList.add('d-none');
                                    step2.classList.add('d-none');
                                    step3.classList.remove('d-none');
                                    step4.classList.add('d-none');
                                    updateStepProgress(3);
                                } else if (step4.querySelector('.is-invalid')) {
                                    step1.classList.add('d-none');
                                    step2.classList.add('d-none');
                                    step3.classList.add('d-none');
                                    step4.classList.remove('d-none');
                                    updateStepProgress(4);
                                }
                                return false;
                            }

                            console.log('Form validation passed, submitting via AJAX...');

                            const submitBtn = this.querySelector('button[type="submit"]') || document.getElementById('signupSubmitBtn');
                            const originalBtnText = submitBtn ? submitBtn.innerHTML : '';

                            if (submitBtn) {
                                submitBtn.disabled = true;
                                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Registering...';
                            }

                            try {
                                const formData = new FormData(signupForm);
                                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                const url = signupForm.dataset.ajaxUrl || '/register';

                                const resp = await fetch(url, {
                                    method: 'POST',
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'X-CSRF-TOKEN': csrfToken || '',
                                        'Accept': 'application/json'
                                    },
                                    body: formData,
                                    credentials: 'include'
                                });

                                const contentType = resp.headers.get('content-type');
                                    let data;
                                    if (contentType && contentType.includes('application/json')) {
                                        data = await resp.json();
                                    } else {
                                        const text = await resp.text();
                                        console.error('Non-JSON response:', text);
                                        throw new Error('Server returned an invalid response format (not JSON).');
                                    }

                                    console.log('Registration response:', data);

                                    if (resp.ok || data.status === 'success') {
                                        safeHideModal('loginModal');
                                        if (window.Swal) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Registration Successful!',
                                                html: 'Please check your email to verify your account. A verification link has been sent to your email address.',
                                                confirmButtonText: 'OK, got it',
                                                allowOutsideClick: false
                                            }).then(() => {
                                                window.location.href = '/';
                                            });
                                        } else {
                                            alert('Registration successful! Please check your email.');
                                            window.location.href = '/';
                                        }
                                    } else {
                                        const errorMsg = data.message || 'Registration failed.';

                                        // Display field-specific errors
                                        if (data.errors) {
                                            Object.keys(data.errors).forEach(key => {
                                                const input = signupForm.querySelector(`[name="${key}"]`);
                                                if (input) {
                                                    input.classList.add('is-invalid');
                                                    const feedback = input.closest('.mb-3')?.querySelector('.invalid-feedback');
                                                    if (feedback) feedback.textContent = data.errors[key][0];

                                                    // If the input is in a hidden step, we might want to switch to it, 
                                                    // but for now let's just mark it invalid so if they go back they see it.
                                                }
                                            });
                                        }

                                        if (window.Swal) {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Registration Failed',
                                                text: errorMsg
                                            });
                                        } else {
                                            alert(errorMsg);
                                        }
                                    }
                                } catch (err) {
                                    console.error('Registration error:', err);
                                    if (window.Swal) {
                                        Swal.fire({ icon: 'error', title: 'Error', text: 'Network error. Please try again.' });
                                    } else {
                                        alert('Network error. Please try again.');
                                    }
                                } finally {
                                    if (submitBtn) {
                                        submitBtn.disabled = false;
                                        submitBtn.innerHTML = originalBtnText;
                                    }
                                }
                            });

                            // Ensure the Submit button triggers the form submit event
                            const doneBtn = document.getElementById('signupSubmitBtn');
                            if (doneBtn) {
                                // Remove existing listeners by cloning (if any)
                                const newBtn = doneBtn.cloneNode(true);
                                doneBtn.parentNode.replaceChild(newBtn, doneBtn);

                                newBtn.addEventListener('click', function () {
                                    signupForm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                                });
                            }
                        }

                        // Initialize all enhancements
                        addPasswordStrengthIndicator();
                        addPasswordConfirmationValidation();
                        enhanceStepNavigation();
                        addRealTimeValidation();
                        enhanceFormSubmission();

                        // Initialize step progress
                        updateStepProgress(1);
                    }

                    // Initialize enhanced signup when DOM is ready
                    console.log('Checking if should initialize signup..., readyState:', document.readyState);
                    if (document.readyState === 'loading') {
                        console.log('DOM still loading, adding event listener');
                        document.addEventListener('DOMContentLoaded', function () {
                            console.log('DOMContentLoaded fired, initializing signup');
                            initializeEnhancedSignup();
                        });
                    } else {
                        console.log('DOM already ready, initializing signup immediately');
                        initializeEnhancedSignup();
                    }

                    // Enhanced Modal Behavior
                    function enhanceModalBehavior() {
                        const loginModal = document.getElementById('loginModal');
                        if (!loginModal) return;

                        // Reset form when modal is hidden
                        loginModal.addEventListener('hidden.bs.modal', function () {
                            const forms = this.querySelectorAll('form');
                            forms.forEach(form => {
                                form.reset();
                                // Clear validation states
                                const inputs = form.querySelectorAll('input, select');
                                inputs.forEach(input => {
                                    input.classList.remove('is-invalid', 'is-valid');
                                });
                                const feedbacks = form.querySelectorAll('.invalid-feedback');
                                feedbacks.forEach(feedback => {
                                    feedback.textContent = '';
                                });
                            });

                            // Reset to first step
                            const step1 = document.getElementById('signupStep1');
                            const step2 = document.getElementById('signupStep2');
                            const step3 = document.getElementById('signupStep3');
                            const step4 = document.getElementById('signupStep4');

                            if (step1 && step2 && step3 && step4) {
                                step1.classList.remove('d-none');
                                step2.classList.add('d-none');
                                step3.classList.add('d-none');
                                step4.classList.add('d-none');
                                updateStepProgress(1);
                            }
                        });

                        // Focus management
                        loginModal.addEventListener('shown.bs.modal', function () {
                            const activeTab = this.querySelector('.nav-link.active');
                            if (activeTab) {
                                const targetPane = this.querySelector(activeTab.getAttribute('data-bs-target'));
                                const firstInput = targetPane?.querySelector('input, select');
                                if (firstInput) {
                                    setTimeout(() => firstInput.focus(), 100);
                                }
                            }
                            // Reattach step navigation handlers when modal is shown (fixes lost listeners)
                            try { enhanceStepNavigation(); } catch (e) { console.error('enhanceStepNavigation error', e); }
                        });
                    }

                    // Initialize modal enhancements
                    enhanceModalBehavior();

                    // Let Bootstrap handle modal opening naturally via data-bs-toggle
                    // Only add a fallback handler if Bootstrap fails
                    // Don't interfere with Bootstrap's native event handling
                });
            </script>

    @endguest

    <script>
        // Open login/register modal if redirected here via legacy /login or /register routes
        document.addEventListener('DOMContentLoaded', function () {
            try {
                const params = new URLSearchParams(window.location.search);
                const showLogin = params.get('showLogin');
                const showRegister = params.get('showRegister');
                const show2fa = params.get('show2fa');

                // Check for server-side session flag to show 2FA modal
                const show2faModal = @json(session('show_2fa_modal', false));
                console.log('show2faModal from session:', show2faModal);
                console.log('show2fa from URL:', show2fa);

                if (showLogin || showRegister || show2fa || show2faModal) {
                    const modalEl = document.getElementById('loginModal');
                    if (modalEl && window.bootstrap && bootstrap.Modal) {
                        const m = bootstrap.Modal.getOrCreateInstance(modalEl);
                        m.show();
                    }
                    if (showRegister) {
                        // Activate the signup tab inside the modal if present
                        setTimeout(function () {
                            const signupTab = document.getElementById('tab-signup');
                            if (signupTab) signupTab.click();
                        }, 200);
                    }
                    // If show2fa or show2faModal, activate the 2FA pane
                    if (show2fa || show2faModal) {
                        console.log('Attempting to show 2FA modal!');
                        setTimeout(function () {
                            const twoFactorModal = document.getElementById('twoFactorModal');
                            const loginModal = document.getElementById('loginModal');

                            console.log('twoFactorModal element:', twoFactorModal);
                            console.log('loginModal element:', loginModal);

                            // Close login modal if open
                            if (loginModal && window.bootstrap && bootstrap.Modal) {
                                const loginModalInstance = bootstrap.Modal.getInstance(loginModal);
                                if (loginModalInstance) {
                                    console.log('Hiding login modal');
                                    loginModalInstance.hide();
                                }
                            }

                            // Open 2FA modal
                            if (twoFactorModal && window.bootstrap && bootstrap.Modal) {
                                console.log('Opening 2FA modal');
                                const twoFactorModalInstance = bootstrap.Modal.getOrCreateInstance(twoFactorModal);
                                twoFactorModalInstance.show();
                            } else {
                                console.error('Cannot open 2FA modal - element not found or Bootstrap not available');
                            }
                        }, 300);
                    }
                }
            } catch (e) {
                console.error('Error opening modal:', e);
            }
        });
    </script>
    {{-- Registration success popup using SweetAlert --}}
    @if(session('registration_success_message'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.Swal) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful!',
                        html: '{{ session('registration_success_message') }}',
                        confirmButtonText: 'OK, got it',
                        allowOutsideClick: false
                    });
                } else {
                    alert('{{ session('registration_success_message') }}');
                }
            });
        </script>
    @endif
</body>

</html>