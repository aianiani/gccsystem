<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMU Guidance & Counseling Center</title>
    <link href="<?php echo e(asset('vendor/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/fontawesome/css/all.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/fonts/inter/inter.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendor/sweetalert2/sweetalert2.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/auth-modal.css')); ?>" rel="stylesheet">
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
            margin-left: 1.5rem;
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
            padding-top: 100px;
            /* Added padding to prevent navbar overlap */
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
            padding-left: 1.5rem;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            animation: fadeInUp 1s ease-out;
        }

        .hero-description {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            line-height: 1.6;
            animation: fadeInUp 1s ease-out 0.2s both;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeInUp 1s ease-out 0.4s both;
        }

        /* Hero Illustration Styling */
        .hero-illustration {
            position: relative;
            animation: fadeInRight 1s ease-out 0.3s both;
            max-width: 500px;
            margin-left: auto;
        }

        @media (max-width: 768px) {
            .hero-illustration {
                margin-left: auto;
                margin-right: auto;
            }
        }

        .hero-illustration img {
            width: 100%;
            height: auto;
            filter: drop-shadow(0 20px 60px rgba(0, 0, 0, 0.2));
            animation: float 6s ease-in-out infinite;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .btn-primary-custom {
            background: var(--yellow-maize, #f4d03f);
            color: var(--forest-green, #2d5016);
            border: none;
            border-radius: 25px;
            padding: 1rem 2.5rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(244, 208, 63, 0.4);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(244, 208, 63, 0.6);
            background: #ffe066;
            /* Slightly lighter yellow */
            color: var(--forest-green, #2d5016);
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
            transform: translateY(-3px) scale(1.02);
            color: white;
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
        #announcements {
            position: relative;
            background: linear-gradient(180deg, var(--bg-light) 0%, #ffffff 100%);
        }

        .announcements-carousel {
            margin: 2rem 0;
            padding: 1rem 0;
            /* Add padding for shadow visibility */
        }

        .announcements-container {
            background: transparent;
            /* Changed from white to transparent to allow card shadows */
            border-radius: 0;
            box-shadow: none;
            overflow: visible;
            /* Allow hover effects to overflow */
            position: relative;
            width: 100%;
            margin: 0 auto;
        }

        .announcements-track {
            transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
            display: flex;
            gap: 0;
            /* Slides dictate spacing */
        }

        .announcement-slide {
            flex-shrink: 0;
            width: 100%;
            min-width: 100%;
            position: relative;
            padding: 0 5px;
            /* Tiny padding to prevent clipping */
        }

        .announcement-card-horizontal {
            background: white;
            border-radius: 24px;
            padding: 0;
            width: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        /* Hover effect for the whole card */
        .announcement-card-horizontal:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }

        .announcement-content {
            display: flex;
            align-items: stretch;
            position: relative;
            width: 100%;
            height: 100%;
        }

        /* Top decorative line */
        .announcement-card-horizontal::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-green), var(--accent-orange));
            z-index: 10;
        }

        .announcement-image-col {
            position: relative;
            min-height: 500px;
            overflow: hidden;
        }

        .announcement-image-col img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .announcement-card-horizontal:hover .announcement-image-col img {
            transform: scale(1.05);
        }

        /* Overlay for image to make text readable if needed, but here mainly for polish */
        .announcement-image-col::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0) 70%, rgba(0, 0, 0, 0.05) 100%);
            pointer-events: none;
        }

        .announcement-text-col {
            padding: 3.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: white;
            position: relative;
        }

        /* Decorative background pattern for text column */
        .announcement-text-col::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle at top right, var(--light-green) 0%, transparent 70%);
            opacity: 0.6;
            pointer-events: none;
        }

        .announcement-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .announcement-date {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background: rgba(255, 203, 5, 0.1);
            color: #bfa005;
            /* Darker yellow for text */
            font-size: 0.9rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .announcement-date i {
            font-size: 1rem;
        }

        .badge-new {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            background: linear-gradient(135deg, #ff6b6b, #ee5253);
            color: white;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 10px rgba(238, 82, 83, 0.3);
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .announcement-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1.25rem;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        .announcement-excerpt {
            font-size: 1.15rem;
            color: #555;
            line-height: 1.7;
            margin-bottom: 2.5rem;
            font-weight: 400;
        }

        .announcement-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.05rem;
            padding: 1rem 2rem;
            background: var(--primary-green);
            border-radius: 50px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-shadow: 0 4px 15px rgba(34, 139, 34, 0.25);
            align-self: flex-start;
        }

        .announcement-action i {
            transition: transform 0.3s ease;
        }

        .announcement-action:hover {
            background: #1a6b1a;
            /* Darker green */
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(34, 139, 34, 0.4);
        }

        .announcement-action:hover i {
            transform: translateX(4px);
        }

        /* Fallback / No Image / Text Only Layout specifically */
        .announcement-card-no-image {
            background: white;
            padding: 0;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .announcement-card-no-image .announcement-content.text-only {
            padding: 3rem;
            width: 100%;
            margin: 0;
            text-align: left;
            flex-direction: column;
        }

        .announcement-card-no-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23228b22' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 1;
            z-index: 0;
            pointer-events: none;
            mask-image: linear-gradient(to top left, black, transparent);
            -webkit-mask-image: linear-gradient(to top left, black, transparent);
        }

        /* Mini Gallery Grid */
        .announcement-gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 10px;
            margin: 1.5rem 0 2rem;
            width: 100%;
        }

        .announcement-gallery-item {
            aspect-ratio: 1;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .announcement-gallery-item:hover {
            transform: scale(1.05);
            z-index: 2;
        }

        .announcement-gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* External Navigation Controls (Polished) */
        .announcement-controls-external {
            margin-top: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            position: relative;
            z-index: 10;
        }

        .announcement-nav {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: white;
            color: var(--primary-green);
            border: 2px solid rgba(34, 139, 34, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .announcement-nav:hover {
            background: var(--primary-green);
            color: white;
            transform: scale(1.1);
            border-color: var(--primary-green);
            box-shadow: 0 8px 20px rgba(34, 139, 34, 0.3);
        }

        .announcement-counter {
            font-family: 'Inter', sans-serif;
            font-weight: 700;
            color: var(--text-light);
            font-size: 1rem;
            letter-spacing: 2px;
        }

        .announcement-counter span {
            color: var(--text-dark);
        }

        /* Dots Indicator */
        .announcement-dots {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .announcement-dots .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #cbd5e1;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .announcement-dots .dot.active {
            width: 30px;
            border-radius: 20px;
            background: var(--primary-green);
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .announcement-card-horizontal {
                display: flex;
                flex-direction: column;
                height: auto;
            }

            .announcement-image-col {
                height: 250px;
                min-height: 250px;
                order: -1;
            }

            .announcement-text-col {
                padding: 2rem;
            }

            .announcement-title {
                font-size: 1.75rem;
                margin-bottom: 1rem;
            }

            .announcement-content.text-only {
                padding: 2rem !important;
                flex-direction: column !important;
                min-height: auto !important;
            }

            .announcement-content.text-only>.d-flex {
                flex-direction: column !important;
                gap: 1.5rem !important;
            }

            .gallery-sidebar {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                order: 2;
                /* Move below text on mobile */
            }

            .announcement-gallery-grid {
                grid-template-columns: repeat(4, 1fr) !important;
                /* Fixed grid for mobile */
                gap: 8px !important;
                margin: 1rem 0 !important;
            }
        }

        @media (max-width: 480px) {
            .announcement-text-col {
                padding: 1.5rem;
            }

            .announcement-title {
                font-size: 1.4rem;
            }

            .announcement-excerpt {
                font-size: 0.95rem;
                margin-bottom: 1.5rem;
            }

            .announcement-meta {
                gap: 0.5rem;
                margin-bottom: 1rem;
            }

            .announcement-date,
            .badge-new {
                padding: 0.4rem 0.8rem;
                font-size: 0.75rem;
            }

            .announcement-action {
                width: 100%;
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }

            .announcement-nav {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .announcement-controls-external {
                gap: 0.75rem;
                margin-top: 1.5rem;
            }

            .announcement-gallery-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                /* Smaller grid for very small screens */
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

            /* General container reset for mobile */
            .container-fluid {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            .navbar-brand {
                margin-left: 0;
                font-size: 1rem;
            }

            /* Fix Hero Spacing */
            .hero {
                padding-top: 130px;
                /* Increased to push content down (User Request) */
            }

            .hero-title {
                font-size: 2rem;
                /* Reduced from 2.5rem */
            }

            .hero-description {
                font-size: 1rem;
            }

            .hero-content {
                text-align: center !important;
                padding-left: 0;
            }

            .hero-buttons {
                justify-content: center;
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

            /* Adjust button sizes for mobile */
            .btn-primary-custom,
            .btn-secondary-custom {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
                width: 100%;
                /* Full width buttons on mobile look better */
                display: flex;
                justify-content: center;
            }
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
        #announcements,
        #counselors,
        #faq,
        #contact {
            scroll-margin-top: 90px;
        }

        /* Daily Motivation Badge */
        .daily-quote-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 8px 16px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.95rem;
            color: white;
            font-weight: 500;
            max-width: 100%;
            margin-bottom: 1rem;
            animation: fadeInDown 0.8s ease-out;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .quote-text {
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.3px;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hero Carousel & Controls */
        .hero-carousel {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .carousel-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: auto;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
            pointer-events: none;
            /* Let clicks pass through if needed, though buttons are on top */
        }

        .carousel-image.active {
            opacity: 1;
            position: relative;
            /* Keep relative to maintain container height */
            z-index: 1;
            pointer-events: auto;
        }

        /* Adjustments for absolute positioning of inactive images to prevent layout jump if they have different heights, 
           but 'relative' on active helps define container height. 
           Ideally images are same size. */

        .hero-carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(45, 80, 22, 0.4);
            /* Forest green transparent */
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
            opacity: 0;
            /* Hidden by default */
        }

        .hero-carousel:hover .hero-carousel-control {
            opacity: 1;
        }

        .hero-carousel-control:hover {
            background: rgba(45, 80, 22, 0.8);
            transform: translateY(-50%) scale(1.1);
        }

        .hero-carousel-control.prev {
            left: 0;
        }

        .hero-carousel-control.next {
            right: 0;
        }

        /* Login Modal Adjustments */
        #loginModal .nav-tabs .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        /* Seamless Input Groups (Modern Design) */
        .modal-content .input-group {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background-color: #f8fafc;
            transition: all 0.3s ease;
            overflow: hidden;
            /* Ensures child elements don't break rounded corners */
        }

        .modal-content .input-group:focus-within {
            border-color: #0f5e1d;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(15, 94, 29, 0.1);
        }

        .modal-content .input-group .input-group-text {
            background: transparent;
            border: none;
            color: #0f5e1d;
            padding-left: 1.2rem;
            padding-right: 0.5rem;
        }

        .modal-content .input-group .form-control {
            border: none;
            background: transparent;
            box-shadow: none !important;
            padding-left: 0.5rem;
            color: #334155;
            font-weight: 500;
        }

        .modal-content .input-group .form-control::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        /* Adjust button/icon at the end (like password eye) */
        .modal-content .input-group .btn {
            border: none;
            background: transparent;
            color: #64748b;
            padding-right: 1.2rem;
        }

        .modal-content .input-group .btn:hover {
            color: #0f5e1d;
        }
    </style>
</head>

<body>
    <div class="home-zoom">
        <!-- Navigation -->
        <div class="navbar-reveal-zone" aria-hidden="true"></div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" role="navigation" aria-label="Primary">
            <div class="container-fluid px-4 px-lg-5">
                <a class="navbar-brand" href="<?php echo e(route('home')); ?>" aria-label="CMU Guidance & Counseling home">
                    <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="CMU Logo">
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
                            <a class="nav-link" href="#announcements">Announcements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#counselors">Counselors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#faq">FAQs</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                        <li class="nav-item ms-3">
                            <a href="#" class="btn btn-auth" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-user-circle me-2"></i>Login
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>



        <!-- Hero Section -->
        <section id="home" class="hero">
            <div class="container-fluid h-100">
                <div class="row align-items-center h-100 g-4px-4 px-lg-5" style="min-height: 70vh;">
                    <!-- Left Column - Text Content -->
                    <div class="col-lg-7 col-md-6">
                        <div class="hero-content" style="text-align: left;">
                            <!-- Daily Motivation Badge -->
                            <div class="daily-quote-badge">
                                <span class="badge-icon">✨</span>
                                <span class="quote-text" id="dailyQuote">Loading inspiration...</span>
                            </div>

                            <h1 class="hero-title">Your Mental Health Matters</h1>
                            <p class="hero-description">Professional counseling support tailored for students. Book
                                appointments, access resources, and start your wellness journey today.</p>
                            <div class="hero-buttons d-flex flex-wrap" style="gap: 1rem;">
                                <a href="<?php echo e(auth()->check() ? route('appointments.create') : route('login')); ?>"
                                    class="btn btn-primary-custom" aria-label="Book appointment">
                                    <i class="fas fa-calendar-plus me-2"></i>Connect with Us
                                </a>
                                <a href="<?php echo e(auth()->check() ? route('chat') : route('login')); ?>"
                                    class="btn btn-secondary-custom" aria-label="Start chat">
                                    <i class="fas fa-comments me-2"></i>Let's Talk!
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Illustration Carousel -->
                    <div class="col-lg-5 col-md-6 mt-5 mt-md-0">
                        <div class="hero-illustration">
                            <div class="hero-carousel">
                                <?php $__empty_1 = true; $__currentLoopData = $heroImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <img src="<?php echo e(asset($image->image_path)); ?>"
                                        class="carousel-image <?php echo e($loop->first ? 'active' : ''); ?>"
                                        alt="<?php echo e($image->title ?? 'Counseling support image ' . ($index + 1)); ?>"
                                        data-index="<?php echo e($index); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <!-- Fallback to default image if no administrative images are set -->
                                    <img src="<?php echo e(asset('images/hero-illustration.png')); ?>" class="carousel-image active"
                                        alt="Students receiving counseling support" data-index="0">
                                <?php endif; ?>

                                <!-- Carousel Controls -->
                                <button class="hero-carousel-control prev" aria-label="Previous image">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="hero-carousel-control next" aria-label="Next image">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- Announcements Section -->
        <!-- Announcements Section -->
        <section id="announcements" class="py-5">
            <div class="container-fluid px-4 px-lg-5">
                <div class="section-header">
                    <h2 style="color: var(--primary-green);">Latest Announcements</h2>
                    <div class="section-divider" style="background: var(--accent-orange);"></div>
                    <p>Stay updated with our latest news and important information</p>
                </div>

                <div class="announcements-carousel position-relative">
                    <div class="announcements-container overflow-hidden rounded-4">
                        <div class="announcements-track" id="announcementsTrack">
                            <?php $__empty_1 = true; $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="announcement-slide">

                                    <div class="announcement-card-horizontal">
                                        <?php
                                            $homeAttachmentPath = $announcement->attachment ?? null;
                                            $homeIsImage = $homeAttachmentPath && preg_match('/\.(jpg|jpeg|png|gif|webp|bmp|svg)$/i', $homeAttachmentPath);
                                            // Check if we have gallery images
                                            $hasGallery = !empty($announcement->images) && is_array($announcement->images) && count($announcement->images) > 0;
                                        ?>

                                        <?php if($homeIsImage): ?>
                                            <!-- Layout with Featured Image (Split Image/Content) -->
                                            <div class="row g-0 h-100">
                                                <div class="col-lg-5 announcement-image-col">
                                                    <a href="<?php echo e(route('announcements.show', $announcement)); ?>"
                                                        class="d-block h-100">
                                                        <img src="<?php echo e(asset('storage/' . $homeAttachmentPath)); ?>"
                                                            alt="<?php echo e($announcement->title); ?>">
                                                    </a>
                                                </div>
                                                <div class="col-lg-7 announcement-text-col">

                                                    <div class="announcement-meta">
                                                        <span class="announcement-date">
                                                            <i class="far fa-calendar-alt"></i>
                                                            <?php echo e(optional($announcement->created_at)->format('M d, Y')); ?>

                                                        </span>
                                                        <?php if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14))): ?>
                                                            <span class="badge-new">NEW</span>
                                                        <?php endif; ?>
                                                    </div>

                                                    <h3 class="announcement-title"><?php echo e($announcement->title); ?></h3>

                                                    <p class="announcement-excerpt">
                                                        <?php echo e(\Illuminate\Support\Str::limit(strip_tags($announcement->content ?? $announcement->body ?? ''), 250)); ?>

                                                    </p>

                                                    <a href="<?php echo e(route('announcements.show', $announcement)); ?>"
                                                        class="announcement-action">
                                                        <span>Read Full Announcement</span>
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- Standard Layout (No Image) - Refactored for Flexbox Alignment -->
                                            <div class="announcement-content text-only position-relative"
                                                style="padding: 3rem; min-height: 450px;">
                                                <div class="d-flex w-100 gap-4 align-items-start">

                                                    <!-- Main Text Content -->
                                                    <div class="d-flex flex-column h-100" style="flex: 1; min-width: 0;">
                                                        <div class="announcement-meta">
                                                            <span class="announcement-date">
                                                                <i class="far fa-calendar-alt"></i>
                                                                <?php echo e(optional($announcement->created_at)->format('M d, Y')); ?>

                                                            </span>
                                                            <?php if(optional($announcement->created_at) && optional($announcement->created_at)->greaterThanOrEqualTo(now()->subDays(14))): ?>
                                                                <span class="badge-new">NEW</span>
                                                            <?php endif; ?>
                                                        </div>

                                                        <h3 class="announcement-title"><?php echo e($announcement->title); ?></h3>

                                                        <p class="announcement-excerpt mb-4">
                                                            <?php echo e(\Illuminate\Support\Str::limit(strip_tags($announcement->content ?? $announcement->body ?? ''), $hasGallery ? 400 : 800)); ?>

                                                        </p>

                                                        <a href="<?php echo e(route('announcements.show', $announcement)); ?>"
                                                            class="announcement-action mt-auto">
                                                            <span>Read Full Announcement</span>
                                                            <i class="fas fa-arrow-right"></i>
                                                        </a>
                                                    </div>

                                                    <!-- Optional Gallery Sidebar -->
                                                    <?php if($hasGallery): ?>
                                                        <div class="gallery-sidebar"
                                                            style="width: 25%; min-width: 250px; max-width: 300px; flex-shrink: 0;">
                                                            <div class="announcement-gallery-grid">
                                                                <?php $__currentLoopData = array_slice($announcement->images, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <a href="<?php echo e(route('announcements.show', $announcement)); ?>"
                                                                        class="announcement-gallery-item d-block">
                                                                        <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Gallery Image">
                                                                    </a>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php if(count($announcement->images) > 4): ?>
                                                                    <a href="<?php echo e(route('announcements.show', $announcement)); ?>"
                                                                        class="announcement-gallery-item d-flex align-items-center justify-content-center bg-light text-muted fw-bold text-decoration-none">
                                                                        +<?php echo e(count($announcement->images) - 4); ?>

                                                                    </a>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="announcement-slide">
                                    <div class="announcement-card-horizontal">
                                        <div class="announcement-card-no-image h-100">
                                            <div class="announcement-content text-only text-center align-items-center">
                                                <div class="mb-4 text-muted display-4">
                                                    <i class="fas fa-bullhorn"></i>
                                                </div>
                                                <h3 class="announcement-title">No announcements yet</h3>
                                                <p class="announcement-excerpt">Please check back later for updates and
                                                    center news.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Dots Indicator -->
                    <?php if($announcements && count($announcements) > 1): ?>
                        <div class="announcement-dots">
                            <?php $__currentLoopData = $announcements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $announcement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="dot <?php echo e($index === 0 ? 'active' : ''); ?>" data-slide="<?php echo e($index); ?>"></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Navigation Controls - External -->
                <?php if($announcements && count($announcements) > 1): ?>
                    <div class="announcement-controls-external">
                        <button type="button" class="announcement-nav announcement-prev" id="announcementPrev"
                            aria-label="Previous announcement">
                            <i class="fas fa-arrow-left"></i>
                        </button>

                        <div class="announcement-counter">
                            <span id="currentSlide">1</span> / <span id="totalSlides"><?php echo e(count($announcements)); ?></span>
                        </div>

                        <button type="button" class="announcement-nav announcement-next" id="announcementNext"
                            aria-label="Next announcement">
                            <i class="fas fa-arrow-right"></i>
                        </button>
                    </div>
                <?php endif; ?>

                <div class="text-center mt-5">
                    <a href="<?php echo e(route('announcements.index')); ?>" class="btn btn-link text-decoration-none fw-bold"
                        style="color: var(--primary-green);">
                        View All Announcements <i class="fas fa-long-arrow-alt-right ms-2"></i>
                    </a>
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
        <section id="faq" class="faq py-5" style="background: white;">
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

                            <a href="<?php echo e(route('resources')); ?>">Resources</a>
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
    <script src="<?php echo e(asset('vendor/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <!-- SweetAlert2 for login feedback -->
    <script src="<?php echo e(asset('vendor/sweetalert2/sweetalert2.min.js')); ?>"></script>
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


        // Unified Announcement Carousel Logic
        document.addEventListener('DOMContentLoaded', function () {
            // Select elements
            const track = document.getElementById('announcementsTrack');
            const container = document.querySelector('.announcements-container');
            const slides = document.querySelectorAll('.announcement-slide');
            const nextBtn = document.getElementById('announcementNext');
            const prevBtn = document.getElementById('announcementPrev');
            const dots = document.querySelectorAll('.announcement-dots .dot');
            const currentSlideEl = document.getElementById('currentSlide');
            const totalSlidesEl = document.getElementById('totalSlides');

            // State
            let currentIndex = 0;
            const totalSlides = slides.length;

            if (!track || !container || totalSlides === 0) return;

            // Update Carousel Function
            function updateCarousel() {
                const containerWidth = container.offsetWidth || window.innerWidth; // Robust fallback
                const slideWidth = containerWidth; // Each slide matches container

                // 1. Set Track Width
                track.style.width = `${totalSlides * slideWidth}px`;
                track.style.display = 'flex';
                track.style.transition = 'transform 0.5s ease-in-out';

                // 2. Size Slides
                slides.forEach(slide => {
                    slide.style.width = `${slideWidth}px`;
                    slide.style.minWidth = `${slideWidth}px`;
                    slide.style.display = 'block';
                    slide.style.visibility = 'visible';
                });

                // 3. Move Track
                track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

                // 4. Update UI
                dots.forEach((dot, idx) => dot.classList.toggle('active', idx === currentIndex));
                if (currentSlideEl) currentSlideEl.textContent = currentIndex + 1;

                // 5. Update Buttons (Always enabled for cyclical, or managed here)
                if (prevBtn) {
                    prevBtn.style.opacity = totalSlides > 1 ? '1' : '0.5';
                }
                if (nextBtn) {
                    nextBtn.style.opacity = totalSlides > 1 ? '1' : '0.5';
                }
            }

            // Next Slide Logic
            function nextSlide() {
                if (totalSlides <= 1) return;
                currentIndex = (currentIndex + 1) % totalSlides;
                updateCarousel();
            }

            // Prev Slide Logic
            function prevSlide() {
                if (totalSlides <= 1) return;
                currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
                updateCarousel();
            }

            // Event Listeners
            if (nextBtn) {
                nextBtn.onclick = (e) => { // Direct assignment to avoid duplication
                    e.preventDefault();
                    nextSlide();
                };
            }

            if (prevBtn) {
                prevBtn.onclick = (e) => {
                    e.preventDefault();
                    prevSlide();
                };
            }

            // Dot Navigation
            const dotsContainer = document.querySelector('.announcement-dots');
            if (dotsContainer) {
                dotsContainer.onclick = (e) => {
                    if (e.target.classList.contains('dot')) {
                        const index = parseInt(e.target.dataset.slide);
                        if (!isNaN(index)) {
                            currentIndex = index;
                            updateCarousel();
                        }
                    }
                };
            }

            // Resize Observer for Robustness
            const resizeObserver = new ResizeObserver(() => {
                window.requestAnimationFrame(updateCarousel);
            });
            resizeObserver.observe(container);

            // Initial Render
            // Force a small delay to ensure layout is computed
            setTimeout(updateCarousel, 50);
        });
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

        /* Progress states for different steps (3 steps) */
        .progress-fill.step-1 {
            width: 33%;
        }

        .progress-fill.step-2 {
            width: 66%;
        }

        .progress-fill.step-3 {
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

        /* Password Requirements Checklist */
        .password-requirements {
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .password-requirements .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 0.25rem;
            transition: all 0.3s ease;
        }

        .password-requirements .requirement:last-child {
            margin-bottom: 0;
        }

        .password-requirements .requirement i {
            font-size: 0.5rem;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .password-requirements .requirement.met i {
            color: #0f5e1d !important;
        }

        .password-requirements .requirement.met small {
            color: #0f5e1d;
            font-weight: 500;
        }

        /* File Preview Card */
        #filePreview .card {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        #filePreview .card:hover {
            border-color: #0f5e1d;
            box-shadow: 0 4px 12px rgba(15, 94, 29, 0.1);
        }

        /* Email Availability Feedback */
        .email-availability-feedback {
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .email-availability-feedback.available {
            color: #0f5e1d;
        }

        .email-availability-feedback.taken {
            color: #dc2626;
        }

        .email-availability-feedback.checking {
            color: #6b7280;
        }

        /* Progress Label */
        #progressLabel {
            font-size: 0.75rem;
            font-weight: 400;
        }

        /* Row gap for form fields */
        .row.g-2 {
            margin-bottom: 0.75rem;
        }

        /* Ensure eye button stays on top and aligns properly */
        .input-group .btn-eye {
            z-index: 5;
            position: relative;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            margin-left: -1px;
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
            z-index: 1;
        }

        .input-group .form-control:focus {
            z-index: 3;
        }

        .input-group:focus-within .btn-eye {
            z-index: 5;
            border-color: #0f5e1d;
        }

        /* Modal Zoom Adjustment */
        /* Modal Zoom Adjustment */
        #loginModal .modal-dialog {
            transform: scale(0.95);
            transform-origin: center top;
            transition: transform 0.3s ease-in-out;

        }

        #loginModal .modal-dialog.modal-signup-scale {
            transform: scale(0.85);
        }
    </style>
    <?php if(auth()->guard()->guest()): ?>
        <div class="modal fade" id="loginModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-3 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane"
                            style="color:#fff;">
                            <div class="text-center">
                                <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo"
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
                                    <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo"
                                        style="width:35px;height:35px;border-radius:50%; background:#fff; object-fit:cover;"
                                        class="me-2 d-lg-none">
                                    <h6 class="mb-0 text-muted d-lg-none" style="font-size:0.9rem;">CMU Guidance &
                                        Counseling Center</h6>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="tabs-wrapper">
                                <ul class="nav nav-tabs nav-justified mb-3" role="tablist">
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
                                    <form id="modalLoginForm" method="POST" action="<?php echo e(url('/login')); ?>">
                                        <?php echo csrf_field(); ?>
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
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-auth-primary w-100">
                                                <i class="fas fa-sign-in-alt me-2"></i>Login
                                            </button>
                                        </div>
                                    </form>

                                </div>
                                <div class="tab-pane fade" id="pane-signup" role="tabpanel" aria-labelledby="tab-signup">
                                    <form enctype="multipart/form-data" id="signupForm"
                                        data-ajax-url="<?php echo e(url('/register')); ?>">
                                        <?php echo csrf_field(); ?>

                                        <!-- Enhanced Progress Indicator -->
                                        <div class="progress-line-container mb-4">
                                            <div class="progress-line">
                                                <div class="progress-fill" id="progressFill"></div>
                                            </div>
                                            <div class="progress-text">
                                                <span id="progressText">Step 1 of 3</span>
                                                <span id="progressLabel" class="ms-2 text-muted small">Personal
                                                    Information</span>
                                            </div>
                                        </div>

                                        <div id="signupStep1">
                                            <h6 class="mb-3 text-muted"><i class="fas fa-user-circle me-2"></i>Personal
                                                Information
                                            </h6>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                        <input type="text" name="first_name" class="form-control" required
                                                            placeholder="First Name *" autocomplete="given-name"
                                                            id="firstNameInput">
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                        <input type="text" name="last_name" class="form-control" required
                                                            placeholder="Last Name *" autocomplete="family-name"
                                                            id="lastNameInput">
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                    <input type="text" name="middle_name" class="form-control"
                                                        placeholder="Middle Name (Optional)" autocomplete="additional-name"
                                                        id="middleNameInput">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                                    <select class="form-select" name="sex" id="sexSelect" required>
                                                        <option value="" selected disabled>Select Sex *</option>
                                                        <option value="male" <?php echo e(old('sex') == 'male' ? 'selected' : ''); ?>>
                                                            Male</option>
                                                        <option value="female" <?php echo e(old('sex') == 'female' ? 'selected' : ''); ?>>
                                                            Female</option>
                                                    </select>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                    <input type="tel" name="contact_number" class="form-control" required
                                                        placeholder="Contact Number * (0XXX-XXX-XXXX)" maxlength="13"
                                                        autocomplete="tel" id="contactNumberInput">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-map-marker-alt"></i></span>
                                                    <input type="text" name="address" class="form-control" required
                                                        placeholder="Home Address * (House/Street, Barangay, City/Province)"
                                                        autocomplete="address-line1" id="addressInput">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                                <small class="form-text text-muted">Format: House/Street, Barangay,
                                                    City/Province</small>
                                            </div>
                                            <div class="step-navigation">
                                                <div></div>
                                                <button type="button" class="btn btn-auth-primary" id="goToStep2">
                                                    Next <i class="fas fa-arrow-right ms-2"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="signupStep2" class="d-none">
                                            <h6 class="mb-3 text-muted"><i class="fas fa-user-graduate me-2"></i>Account &
                                                Student Details
                                            </h6>

                                            <!-- Email -->
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                                    <input type="email" name="email" class="form-control" required
                                                        autocomplete="email" placeholder="Email Address *" id="emailInput">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                                <div class="email-availability-feedback"></div>
                                            </div>

                                            <!-- Password with Requirements Checklist -->
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    <input type="password" name="password" class="form-control" required
                                                        autocomplete="new-password" placeholder="Password *"
                                                        id="signupPassword_v2">
                                                    <button class="btn btn-outline-secondary btn-eye" type="button"
                                                        id="toggleSignupPassword" style="border-radius:0 12px 12px 0;"
                                                        aria-label="Show password"><i class="fas fa-eye"></i></button>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                                    <input type="password" name="password_confirmation" class="form-control"
                                                        required autocomplete="new-password"
                                                        placeholder="Confirm Password *" id="signupPasswordConfirm_v2">
                                                    <button class="btn btn-outline-secondary btn-eye" type="button"
                                                        id="toggleSignupPasswordConfirm"
                                                        style="border-radius:0 12px 12px 0;" aria-label="Show password"><i
                                                            class="fas fa-eye"></i></button>
                                                </div>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <!-- Student ID -->
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                    <input type="text" name="student_id" class="form-control" required
                                                        placeholder="Student ID * (e.g., 2022302124)" pattern="[0-9]{10}"
                                                        maxlength="10" title="Student ID must be exactly 10 digits"
                                                        id="studentIdInput">
                                                </div>
                                                <div class="invalid-feedback"></div>
                                                <small class="form-text text-muted">Format: 10 digits (e.g.,
                                                    2022302124)</small>
                                            </div>

                                            <!-- College and Year Level -->
                                            <div class="row g-2 mb-3">
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
                                                            <option>6th Year</option>
                                                        </select>
                                                    </div>
                                                    <div class="invalid-feedback"></div>
                                                </div>
                                            </div>

                                            <!-- Course -->
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
                                            <h6 class="mb-3 text-muted"><i class="fas fa-file-upload me-2"></i>Verification
                                                Document
                                            </h6>
                                            <div class="mb-3">
                                                <label class="form-label">Certificate of Registration (COR) <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                                    <input class="form-control" type="file" name="cor_file"
                                                        accept=".pdf,image/*" required id="corFileInput">
                                                </div>
                                                <div class="invalid-feedback"></div>
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
                                                <!-- File Preview -->
                                                <div id="filePreview" class="mt-3" style="display: none;">
                                                    <div class="card">
                                                        <div class="card-body p-3">
                                                            <div class="text-center mb-2 d-none" id="imagePreviewContainer">
                                                                <img src="" alt="Preview" class="img-fluid rounded border"
                                                                    style="max-height: 200px;" id="imagePreview">
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-file-pdf fa-2x text-danger me-3"
                                                                    id="fileIcon"></i>
                                                                <div class="flex-grow-1 overflow-hidden me-3">
                                                                    <p class="mb-0 fw-bold text-truncate" id="fileName"
                                                                        style="max-width: 100%;"></p>
                                                                    <small class="text-muted" id="fileSize"></small>
                                                                </div>
                                                                <div class="d-flex gap-2">
                                                                    <a href="#" target="_blank"
                                                                        class="btn btn-sm btn-outline-primary" id="viewFile"
                                                                        title="View Document">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-outline-danger"
                                                                        id="removeFile" title="Remove File">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="step-navigation">
                                                <button type="button" class="btn btn-outline-secondary" id="backToStep2">
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
    <?php endif; ?>

    <?php if(auth()->guard()->guest()): ?>
        <!-- Forgot Password Modal -->
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane"
                            style="color:#fff;">
                            <div class="text-center">
                                <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo"
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
                            <form method="POST" action="<?php echo e(route('password.email')); ?>">
                                <?php echo csrf_field(); ?>
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
        <div class="modal fade" id="resendVerificationModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-4">
                    <div class="modal-header" style="border-bottom: none;">
                        <h5 class="modal-title" style="color: var(--primary-green);">Resend Verification Email</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-0">
                        <p class="small text-muted">Enter your email to resend the verification link.</p>
                        <form method="POST" action="<?php echo e(route('verification.resend')); ?>">
                            <?php echo csrf_field(); ?>
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
        <div class="modal fade" id="twoFactorModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content rounded-4 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-3 left-pane"
                            style="color:#fff;">
                            <div class="text-center">
                                <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo"
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
                            <form id="modal2faForm" method="POST" action="<?php echo e(route('2fa.verify')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="otp-box mb-3">
                                    <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                                    <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                                    <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                                    <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                                    <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                                    <input class="otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" />
                                    <input type="hidden" name="code" id="otpHidden" />
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberDevice"
                                        name="remember_device" value="1">
                                    <label class="form-check-label small text-muted" for="rememberDevice">Don't ask again on
                                        this device for 30 days</label>
                                </div>
                                <button type="submit" class="btn w-100 fw-bold btn-auth-primary">Verify</button>
                            </form>
                            <div class="d-flex justify-content-between align-items-center mt-3 small">
                                <a href="#" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal"
                                    class="tiny-link">Back to Sign In</a>
                                <div class="d-flex align-items-center">
                                    <form method="POST" action="<?php echo e(route('2fa.resend')); ?>" id="resend2faForm">
                                        <?php echo csrf_field(); ?>
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
        

        <script>
            // Auto-open relevant modal based on session flash
            document.addEventListener('DOMContentLoaded', function () {
                // Priority: Attach Login Handler immediately
                const loginForm = document.getElementById('modalLoginForm');
                if (loginForm) {
                    loginForm.addEventListener('submit', async function (e) {
                        e.preventDefault();
                        console.log('Login form submitted (handler v2)');
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
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: msg
                                });
                            } else {
                                alert(msg);
                            }
                        } finally {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = '<i class="fas fa-sign-in-alt me-2"></i>Login';
                        }
                    });
                }

                // Tab indicator alignment
                // Use simple active border underline to avoid disappearing indicator
                const loginTabBtn = document.getElementById('tab-login');
                const signupTabBtn = document.getElementById('tab-signup');
                if (loginTabBtn && signupTabBtn) {
                    const updateBorders = () => {
                        const paneLogin = document.getElementById('pane-login');
                        const paneSignup = document.getElementById('pane-signup');
                        if (paneLogin) loginTabBtn.classList.toggle('active', paneLogin.classList.contains('active'));
                        if (paneSignup) signupTabBtn.classList.toggle('active', paneSignup.classList.contains('active'));
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
                    'College of Forestry and Environmental Sciences': [
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
                        opt.value = college;
                        opt.textContent = college;
                        collegeSelect.appendChild(opt);
                    }
                    const populateCourses = () => {
                        courseSelect.innerHTML = '<option value="" disabled selected>Select course</option>';
                        const selected = collegeSelect.value;
                        const courses = collegeToCourses[selected] || [];
                        for (const c of courses) {
                            const opt = document.createElement('option');
                            opt.value = c;
                            opt.textContent = c;
                            courseSelect.appendChild(opt);
                        }
                    };
                    collegeSelect.addEventListener('change', populateCourses);
                }

                const status = <?php echo json_encode(session('status'), 15, 512) ?>;
                if (status && typeof status === 'string') {
                    // If password reset email sent or verification resent, briefly toast could be shown.
                    // Optionally, open login modal after actions
                }

                // Helper function to safely get or create modal instance
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
                            if (e.key === 'Backspace' && !input.value && idx > 0) { otpInputs[idx - 1].focus(); }
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
                                    headers: {
                                        'X-Requested-With': 'XMLHttpRequest',
                                        'Accept': 'application/json'
                                    },
                                    body: fd,
                                    credentials: 'same-origin'
                                });

                                const data = await resp.json();

                                if (resp.ok) {
                                    // start timer and notify user
                                    startResendTimer(120);
                                    alert(data.message || 'Verification code resent.');
                                } else {
                                    alert(data.message || 'Unable to resend code');
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
                        const originalText = submitBtn.innerHTML;
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';

                        try {
                            updateHidden();
                            const formData = new FormData(twofaForm);
                            const resp = await fetch(twofaForm.action, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'application/json'
                                },
                                body: formData,
                                credentials: 'same-origin'
                            });

                            const data = await resp.json();

                            if (resp.ok) { // Success (200)
                                window.location.href = data.redirect || '/dashboard';
                            } else { // Error (422, etc)
                                let msg = data.message || 'Invalid authentication code';
                                alert(msg);
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalText;
                            }
                        } catch (err) {
                            console.error(err);
                            alert('Network error. Please try again.');
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = originalText;
                        }
                    });
                }
            }); // Closing DOMContentLoaded
            // Enhanced Signup Form Functionality
            // Declare these in outer scope so they can be accessed by modal event handlers
            let enhanceStepNavigation, validateStep, updateStepProgress;

            function initializeEnhancedSignup() {
                console.log('=== initializeEnhancedSignup START ===');

                // Step Progress Management
                updateStepProgress = function (currentStep) {
                    const progressFill = document.getElementById('progressFill');
                    const progressText = document.getElementById('progressText');
                    const progressLabel = document.getElementById('progressLabel');
                    const stepLabels = { 1: 'Personal Information', 2: 'Account & Student Details', 3: 'Verification Document' };

                    if (progressFill) {
                        // Force width using !important to override any CSS specificity issues
                        const percentage = (currentStep / 3) * 100;
                        progressFill.style.setProperty('width', `${percentage}%`, 'important');
                        // Remove step classes to avoid conflict, just keep base class
                        progressFill.className = 'progress-fill';
                        progressFill.classList.add(`step-${currentStep}`);
                    }
                    if (progressText) {
                        progressText.textContent = `Step ${currentStep} of 3`;
                    }
                    if (progressLabel && stepLabels[currentStep]) {
                        progressLabel.textContent = stepLabels[currentStep];
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

                            // Password confirmation matching
                            if (field.name === 'password_confirmation') {
                                // UPDATED ID: Reference the v2 password field
                                const passwordField = document.getElementById('signupPassword_v2');
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
                };

                // Password Strength Indicator
                function addPasswordStrengthIndicator() {
                    const passwordField = document.getElementById('signupPassword');
                    if (!passwordField) return;

                    let strengthContainer = passwordField.parentElement.querySelector('.password-strength');
                    if (!strengthContainer) {
                        strengthContainer = document.createElement('div');
                        strengthContainer.className = 'password-strength';
                        strengthContainer.innerHTML = '<div class="password-strength-bar"></div>';
                        const parentDiv = passwordField.closest('.mb-3');
                        if (parentDiv) {
                            parentDiv.appendChild(strengthContainer);
                        }
                    }

                    passwordField.addEventListener('input', function () {
                        const password = this.value;
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
                    const passwordField = document.getElementById('signupPassword_v2');
                    const confirmField = document.getElementById('signupPasswordConfirm_v2');
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

                // Enhanced Step Navigation
                enhanceStepNavigation = function () {
                    console.log('enhanceStepNavigation called');
                    function attach(id, handler) {
                        const btn = document.getElementById(id);
                        if (!btn) return;
                        const cloned = btn.cloneNode(true);
                        btn.parentNode.replaceChild(cloned, btn);
                        cloned.addEventListener('click', handler);
                    }

                    attach('goToStep2', function () {
                        const step1 = document.getElementById('signupStep1');
                        const step2 = document.getElementById('signupStep2');
                        if (validateStep(step1)) {
                            step1.classList.add('d-none');
                            step2.classList.remove('d-none');
                            updateStepProgress(2);
                            const firstField = step2.querySelector('input, select');
                            if (firstField) firstField.focus();
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
                };

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
                        e.preventDefault();
                        const step1 = document.getElementById('signupStep1');
                        const step2 = document.getElementById('signupStep2');
                        const step3 = document.getElementById('signupStep3');
                        const step4 = document.getElementById('signupStep4');

                        let allValid = true;
                        if (!validateStep(step1)) allValid = false;
                        if (!validateStep(step2)) allValid = false;
                        if (!validateStep(step3)) allValid = false;
                        if (!validateStep(step4)) allValid = false;

                        if (!allValid) {
                            if (step1.querySelector('.is-invalid')) {
                                step1.classList.remove('d-none'); step2.classList.add('d-none'); step3.classList.add('d-none'); step4.classList.add('d-none'); updateStepProgress(1);
                            } else if (step2.querySelector('.is-invalid')) {
                                step1.classList.add('d-none'); step2.classList.remove('d-none'); step3.classList.add('d-none'); step4.classList.add('d-none'); updateStepProgress(2);
                            } else if (step3.querySelector('.is-invalid')) {
                                step1.classList.add('d-none'); step2.classList.add('d-none'); step3.classList.remove('d-none'); step4.classList.add('d-none'); updateStepProgress(3);
                            } else if (step4.querySelector('.is-invalid')) {
                                step1.classList.add('d-none'); step2.classList.add('d-none'); step3.classList.add('d-none'); step4.classList.remove('d-none'); updateStepProgress(4);
                            }
                            return false;
                        }

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
                                throw new Error('Server returned an invalid response format.');
                            }

                            if (resp.ok || data.status === 'success') {
                                if (window.Swal) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Registration Successful!',
                                        html: 'Please check your email to verify your account.<br><br><b>Note:</b> You must verify your email AND wait for Admin approval before you can log in.',
                                        confirmButtonText: 'OK, got it',
                                        allowOutsideClick: false
                                    }).then(() => { window.location.href = '/'; });
                                } else {
                                    alert('Registration successful! Please verify your email.');
                                    window.location.href = '/';
                                }
                            } else {
                                const errorMsg = data.message || 'Registration failed.';
                                if (data.errors) {
                                    Object.keys(data.errors).forEach(key => {
                                        const input = signupForm.querySelector(`[name="${key}"]`);
                                        if (input) {
                                            input.classList.add('is-invalid');
                                            const feedback = input.closest('.mb-3')?.querySelector('.invalid-feedback');
                                            if (feedback) feedback.textContent = data.errors[key][0];
                                        }
                                    });
                                }
                                if (window.Swal) { Swal.fire({ icon: 'error', title: 'Registration Failed', text: errorMsg }); } else { alert(errorMsg); }
                            }
                        } catch (err) {
                            console.error('Registration error:', err);
                            if (window.Swal) { Swal.fire({ icon: 'error', title: 'Error', text: 'Network error. Please try again.' }); } else { alert('Network error. Please try again.'); }
                        } finally {
                            if (submitBtn) {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalBtnText;
                            }
                        }
                    });

                    const doneBtn = document.getElementById('signupSubmitBtn');
                    if (doneBtn) {
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
                updateStepProgress(1);
            }

            // Enhanced Modal Behavior
            function enhanceModalBehavior() {
                const loginModal = document.getElementById('loginModal');
                if (!loginModal) return;

                const modalDialog = loginModal.querySelector('.modal-dialog');

                // Function to update modal scale based on active tab
                const updateModalScale = (targetId) => {
                    if (targetId === '#pane-signup') {
                        modalDialog.classList.add('modal-signup-scale');
                    } else {
                        modalDialog.classList.remove('modal-signup-scale');
                    }
                };

                // Initial check
                const activeTab = loginModal.querySelector('.nav-link.active');
                if (activeTab) {
                    updateModalScale(activeTab.getAttribute('data-bs-target'));
                }

                // Listen for tab changes
                const tabs = loginModal.querySelectorAll('[data-bs-toggle="tab"]');
                tabs.forEach(tab => {
                    tab.addEventListener('shown.bs.tab', function (event) {
                        updateModalScale(event.target.getAttribute('data-bs-target'));
                    });
                });

                // Prevent click inside modal from closing it
                const modalContent = loginModal.querySelector('.modal-content');
                if (modalContent) {
                    modalContent.addEventListener('click', function (e) {
                        e.stopPropagation();
                    });
                }

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
                        // Ensure updateStepProgress is defined before calling
                        if (typeof updateStepProgress === 'function') {
                            updateStepProgress(1);
                        }
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
                    // Reattach step navigation handlers when modal is shown
                    try {
                        if (typeof enhanceStepNavigation === 'function') {
                            enhanceStepNavigation();
                        }
                    } catch (e) {
                        console.error('enhanceStepNavigation error', e);
                    }
                });
            }
            // Let Bootstrap handle modal opening naturally via data-bs-toggle             // Only add a fallback handler if Bootstrap fails             // Don't interfere with Bootstrap's native event handling         });
        </script>

    <?php endif; ?>

    <script>
        // Open login/register modal if redirected here via legacy /login or /register routes
        document.addEventListener('DOMContentLoaded', function () {
            try {
                const params = new URLSearchParams(window.location.search);
                const showLogin = params.get('showLogin');
                const showRegister = params.get('showRegister');
                const show2fa = params.get('show2fa');

                // Check for server-side session flag to show 2FA modal
                const show2faModal = <?php echo json_encode(session('show_2fa_modal', false), 512) ?>;
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
            // Enhanced Modal Behavior
            function enhanceModalBehavior() {
                const loginModal = document.getElementById('loginModal');
                if (!loginModal) return;

                const modalDialog = loginModal.querySelector('.modal-dialog');

                // Function to update modal scale based on active tab
                const updateModalScale = (targetId) => {
                    if (targetId === '#pane-signup') {
                        modalDialog.classList.add('modal-signup-scale');
                    } else {
                        modalDialog.classList.remove('modal-signup-scale');
                    }
                };

                // Initial check
                const activeTab = loginModal.querySelector('.nav-link.active');
                if (activeTab) {
                    updateModalScale(activeTab.getAttribute('data-bs-target'));
                }

                // Listen for tab changes
                const tabs = loginModal.querySelectorAll('[data-bs-toggle="tab"]');
                tabs.forEach(tab => {
                    tab.addEventListener('shown.bs.tab', function (event) {
                        updateModalScale(event.target.getAttribute('data-bs-target'));
                    });
                });

                // Prevent click inside modal from closing it
                const modalContent = loginModal.querySelector('.modal-content');
                if (modalContent) {
                    modalContent.addEventListener('click', function (e) {
                        e.stopPropagation();
                    });
                }

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
                        // Ensure updateStepProgress is defined before calling
                        if (typeof updateStepProgress === 'function') {
                            updateStepProgress(1);
                        }
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
                    // Reattach step navigation handlers when modal is shown
                    try {
                        if (typeof enhanceStepNavigation === 'function') {
                            enhanceStepNavigation();
                        }
                    } catch (e) {
                        console.error('enhanceStepNavigation error', e);
                    }
                });
            }

            // Initialize modal enhancements
            enhanceModalBehavior();

            // Initialize enhanced signup
            // - logic is already attached via event listeners
            // initializeEnhancedSignup();

        });
    </script>
    
    <?php if(session('registration_success_message')): ?>
        <script>         document.addEventListener('DOMContentLoaded', function () { if (window.Swal) { Swal.fire({ icon: 'success', title: 'Registration Successful!', html: '<?php echo e(session('registration_success_message')); ?>', confirmButtonText: 'OK, got it', allowOutsideClick: false }); } else { alert('<?php echo e(session('registration_success_message')); ?>'); } });
        </script>
    <?php endif; ?>
    <!-- Daily Quote Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const quotes = [
                "You do not have to face everything alone.",
                "Asking for help is a strength.",
                "One message can ease the weight.",
                "It is okay to pause.",
                "Your feelings are valid.",
                "Reaching out is progress.",
                "You are allowed to rest.",
                "Small steps matter.",
                "Someone cares about you.",
                "You are not a burden.",

                "It is okay to not be okay.",
                "You deserve support.",
                "Speaking up is brave.",
                "You matter today.",
                "Healing takes time.",
                "You are not weak for needing help.",
                "Your voice deserves to be heard.",
                "You are doing your best.",
                "Connection starts with honesty.",
                "You are worthy of care.",

                "One breath at a time is enough.",
                "You are not alone in this.",
                "Your struggles are real.",
                "Help is not failure.",
                "It is okay to lean on others.",
                "You deserve understanding.",
                "Progress can be quiet.",
                "You are allowed to ask twice.",
                "Someone wants to listen.",
                "You do not have to explain everything.",

                "Rest is part of healing.",
                "Your emotions make sense.",
                "Reaching out can feel scary—and still be right.",
                "You are not behind.",
                "Support exists for you.",
                "It is okay to take space, then reconnect.",
                "You are allowed to need reassurance.",
                "Today is not permanent.",
                "You are enough as you are.",
                "You deserve patience.",

                "Talking can lighten the load.",
                "You are not too much.",
                "You deserve to be checked on.",
                "Vulnerability builds connection.",
                "You are allowed to slow down.",
                "Asking for help is self-care.",
                "You are seen, even when quiet.",
                "You are not failing.",
                "It is okay to say “I need help.”",
                "You deserve peace.",

                "One step forward still counts.",
                "You are allowed to feel deeply.",
                "Someone understands more than you think.",
                "You are not alone in your thoughts.",
                "It is okay to reach out again.",
                "You deserve compassion.",
                "You are not broken.",
                "Support is not a weakness.",
                "Your mental health matters.",
                "You are allowed to prioritize yourself.",

                "Sharing is a form of healing.",
                "You do not need to have all the answers.",
                "You deserve to be listened to.",
                "You are doing enough for today.",
                "It is okay to ask for clarity.",
                "You are not invisible.",
                "Your pain is valid.",
                "You deserve gentle days.",
                "You are allowed to seek comfort.",
                "You matter, even when struggling.",

                "Reaching out is an act of courage.",
                "You deserve emotional safety.",
                "You are not weak for feeling tired.",
                "Someone wants to support you.",
                "You are allowed to be honest.",
                "You are not a problem to fix.",
                "Healing happens in connection.",
                "You deserve care without conditions.",
                "You are allowed to say “I’m overwhelmed.”",
                "You are more than your worst days.",

                "It is okay to ask for time.",
                "You deserve understanding, not judgment.",
                "You are allowed to feel uncertain.",
                "You are not alone, even now.",
                "Support can start with one word.",
                "You deserve kindness today.",
                "You are allowed to be human.",
                "Your mental health comes first.",
                "You are worthy of help.",
                "You do not need to suffer silently.",

                "Reaching out can change everything.",
                "You deserve relief.",
                "You are not asking for too much.",
                "Your well-being matters.",
                "You are allowed to need people.",
                "You are doing better than you think.",
                "You deserve support without guilt.",
                "You are not alone in your healing.",
                "One honest conversation can help.",
                "You matter, always."
            ];

            const quoteElement = document.getElementById('dailyQuote');
            if (quoteElement) {
                // Get a random quote
                const randomQuote = quotes[Math.floor(Math.random() * quotes.length)];
                quoteElement.textContent = randomQuote;
            }
        });

        // Hero Carousel Logic
        document.addEventListener('DOMContentLoaded', function () {
            const carousel = document.querySelector('.hero-carousel');
            if (!carousel) return;

            const images = carousel.querySelectorAll('.carousel-image');
            const prevBtn = carousel.querySelector('.prev');
            const nextBtn = carousel.querySelector('.next');

            if (images.length <= 1) {
                if (prevBtn) prevBtn.style.display = 'none';
                if (nextBtn) nextBtn.style.display = 'none';
                return;
            }

            let currentIndex = 0;
            let interval;

            function showImage(index) {
                images.forEach(img => {
                    img.classList.remove('active');
                    img.style.position = 'absolute'; // Ensure inactive ones are absolute
                    img.style.opacity = '0';
                });

                // Handle wrap-around
                if (index < 0) index = images.length - 1;
                if (index >= images.length) index = 0;

                currentIndex = index;

                const activeImg = images[currentIndex];
                activeImg.classList.add('active');
                activeImg.style.position = 'relative'; // Active one is relative
                activeImg.style.opacity = '1';
            }

            function nextImage() {
                showImage(currentIndex + 1);
            }

            function prevImage() {
                showImage(currentIndex - 1);
            }

            function startAutoRotate() {
                interval = setInterval(nextImage, 5000);
            }

            function resetAutoRotate() {
                clearInterval(interval);
                startAutoRotate();
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    nextImage();
                    resetAutoRotate();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    prevImage();
                    resetAutoRotate();
                });
            }

            // Start auto-rotation
            startAutoRotate();
        });

        // ========================================
        // OPTIMIZED 3-STEP SIGNUP PROCESS
        // ========================================
        document.addEventListener('DOMContentLoaded', function () {
            const signupForm = document.getElementById('signupForm');
            if (!signupForm) return;

            // Step labels for progress indicator
            const stepLabels = {
                1: 'Personal Information',
                2: 'Account & Student Details',
                3: 'Verification Document'
            };

            // ========================================
            // AUTO-SAVE TO LOCALSTORAGE
            // ========================================
            const STORAGE_KEY = 'gcc_signup_draft';
            const STORAGE_EXPIRY = 24 * 60 * 60 * 1000; // 24 hours

            function saveFormData() {
                const formData = {
                    first_name: document.querySelector('[name="first_name"]')?.value || '',
                    middle_name: document.querySelector('[name="middle_name"]')?.value || '',
                    last_name: document.querySelector('[name="last_name"]')?.value || '',
                    gender: document.querySelector('[name="gender"]')?.value || '',
                    contact_number: document.querySelector('[name="contact_number"]')?.value || '',
                    address: document.querySelector('[name="address"]')?.value || '',
                    email: document.querySelector('[name="email"]')?.value || '',
                    student_id: document.querySelector('[name="student_id"]')?.value || '',
                    college: document.querySelector('[name="college"]')?.value || '',
                    year_level: document.querySelector('[name="year_level"]')?.value || '',
                    course: document.querySelector('[name="course"]')?.value || '',
                    timestamp: Date.now()
                };
                localStorage.setItem(STORAGE_KEY, JSON.stringify(formData));
            }

            function restoreFormData() {
                try {
                    const saved = localStorage.getItem(STORAGE_KEY);
                    if (!saved) return false;

                    const data = JSON.parse(saved);

                    // Check if data is expired
                    if (Date.now() - data.timestamp > STORAGE_EXPIRY) {
                        localStorage.removeItem(STORAGE_KEY);
                        return false;
                    }

                    // Restore field values
                    Object.keys(data).forEach(key => {
                        if (key === 'timestamp') return;
                        const field = document.querySelector(`[name="${key}"]`);
                        if (field && data[key]) {
                            field.value = data[key];
                            if (field.tagName === 'SELECT') {
                                field.dispatchEvent(new Event('change'));
                            }
                        }
                    });

                    // Show notification
                    if (window.Swal) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Draft Restored',
                            text: 'Your previous registration data has been restored.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                    return true;
                } catch (e) {
                    console.error('Error restoring form data:', e);
                    return false;
                }
            }

            // Auto-save on input
            signupForm.addEventListener('input', function (e) {
                if (e.target.type !== 'file') {
                    saveFormData();
                }
            });

            // Restore on modal open
            const loginModal = document.getElementById('loginModal');
            if (loginModal) {
                loginModal.addEventListener('shown.bs.modal', function () {
                    const signupTab = document.getElementById('tab-signup');
                    if (signupTab && signupTab.classList.contains('active')) {
                        restoreFormData();
                    }
                });
            }

            // ========================================
            // PHONE NUMBER AUTO-FORMATTING - Updated
            // ========================================
            const contactNumberInput = document.getElementById('contactNumberInput');
            if (contactNumberInput) {
                contactNumberInput.addEventListener('input', function (e) {
                    let value = e.target.value.replace(/\D/g, ''); // Remove non-digits

                    if (value.length > 11) {
                        value = value.substring(0, 11);
                    }

                    // Format as 0XXX-XXX-XXXX (11 digits total)
                    if (value.length > 4 && value.length <= 7) {
                        value = value.substring(0, 4) + '-' + value.substring(4);
                    } else if (value.length > 7) {
                        value = value.substring(0, 4) + '-' + value.substring(4, 7) + '-' + value.substring(7);
                    }

                    e.target.value = value;
                });
            }

            // ========================================
            // PASSWORD REQUIREMENTS CHECKLIST
            // ========================================
            const passwordInput = document.getElementById('signupPassword');
            const passwordRequirements = document.getElementById('passwordRequirements');

            if (passwordInput && passwordRequirements) {
                // Logic removed as per user request
            }

            // ========================================
            // FILE PREVIEW
            // ========================================
            const corFileInput = document.getElementById('corFileInput');
            const filePreview = document.getElementById('filePreview');
            const fileIcon = document.getElementById('fileIcon');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const removeFileBtn = document.getElementById('removeFile');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePreview = document.getElementById('imagePreview');
            const viewFileBtn = document.getElementById('viewFile');

            if (corFileInput && filePreview) {
                corFileInput.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Create object URL for preview
                        const objectUrl = URL.createObjectURL(file);
                        viewFileBtn.href = objectUrl;

                        // Update icon and preview based on file type
                        if (file.type === 'application/pdf') {
                            fileIcon.className = 'fas fa-file-pdf fa-2x text-danger me-3';
                            imagePreviewContainer.classList.add('d-none');
                        } else if (file.type.startsWith('image/')) {
                            fileIcon.className = 'fas fa-file-image fa-2x text-primary me-3';
                            imagePreview.src = objectUrl;
                            imagePreviewContainer.classList.remove('d-none');
                        } else {
                            // Fallback
                            fileIcon.className = 'fas fa-file fa-2x text-muted me-3';
                            imagePreviewContainer.classList.add('d-none');
                        }

                        // Update file name and size
                        fileName.textContent = file.name;
                        const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                        fileSize.textContent = `${sizeInMB} MB`;

                        // Show preview container
                        filePreview.style.display = 'block';
                    }
                });

                if (removeFileBtn) {
                    removeFileBtn.addEventListener('click', function () {
                        corFileInput.value = '';
                        filePreview.style.display = 'none';
                        imagePreview.src = '';
                        viewFileBtn.href = '#';
                        // Clean up object URL to prevent memory leaks? 
                        // Note: In a simple SPA/Modal, browsers usually handle this, but good practice.
                    });
                }
            }

            // ========================================
            // STEP NAVIGATION & PROGRESS
            // ========================================
            function updateStepProgress(currentStep) {
                const progressFill = document.getElementById('progressFill');
                const progressText = document.getElementById('progressText');
                const progressLabel = document.getElementById('progressLabel');

                if (progressFill) {
                    // Force width using !important to override any CSS specificity issues
                    const percentage = (currentStep / 3) * 100;
                    progressFill.style.setProperty('width', `${percentage}%`, 'important');

                    // Remove step classes to avoid conflict, just keep base class
                    progressFill.className = 'progress-fill';
                }

                if (progressText) {
                    progressText.textContent = `Step ${currentStep} of 3`;
                }

                if (progressLabel) {
                    progressLabel.textContent = stepLabels[currentStep] || '';
                }
            }

            function validateStep(stepElement) {
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

                        if (field.type === 'email') {
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                            if (!emailRegex.test(field.value)) {
                                field.classList.remove('is-valid');
                                field.classList.add('is-invalid');
                                if (feedback) feedback.textContent = 'Please enter a valid email address';
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

                        // File upload validation
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

            // Step navigation buttons
            const goToStep2Btn = document.getElementById('goToStep2');
            const goToStep3Btn = document.getElementById('goToStep3');
            const backToStep1Btn = document.getElementById('backToStep1');
            const backToStep2Btn = document.getElementById('backToStep2');
            const submitBtn = document.getElementById('signupSubmitBtn');

            if (goToStep2Btn) {
                goToStep2Btn.addEventListener('click', function () {
                    const step1 = document.getElementById('signupStep1');
                    const step2 = document.getElementById('signupStep2');
                    if (validateStep(step1)) {
                        step1.classList.add('d-none');
                        step2.classList.remove('d-none');
                        updateStepProgress(2);
                        step2.querySelector('input, select')?.focus();
                    }
                });
            }

            if (goToStep3Btn) {
                goToStep3Btn.addEventListener('click', function () {
                    const step2 = document.getElementById('signupStep2');
                    const step3 = document.getElementById('signupStep3');
                    if (validateStep(step2)) {
                        step2.classList.add('d-none');
                        step3.classList.remove('d-none');
                        updateStepProgress(3);
                        step3.querySelector('input, select')?.focus();
                    }
                });
            }

            if (backToStep1Btn) {
                backToStep1Btn.addEventListener('click', function () {
                    const step1 = document.getElementById('signupStep1');
                    const step2 = document.getElementById('signupStep2');
                    step2.classList.add('d-none');
                    step1.classList.remove('d-none');
                    updateStepProgress(1);
                });
            }

            if (backToStep2Btn) {
                backToStep2Btn.addEventListener('click', function () {
                    const step2 = document.getElementById('signupStep2');
                    const step3 = document.getElementById('signupStep3');
                    step3.classList.add('d-none');
                    step2.classList.remove('d-none');
                    updateStepProgress(2);
                });
            }

            // ========================================
            // FORM SUBMISSION
            // ========================================
            if (submitBtn) {
                submitBtn.addEventListener('click', async function () {
                    const step1 = document.getElementById('signupStep1');
                    const step2 = document.getElementById('signupStep2');
                    const step3 = document.getElementById('signupStep3');

                    // Validate all steps
                    if (!validateStep(step1) || !validateStep(step2) || !validateStep(step3)) {
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                text: 'Please fill in all required fields correctly.'
                            });
                        }
                        return;
                    }

                    // Show loading state
                    submitBtn.disabled = true;
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';

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

                        const data = await resp.json();

                        if (resp.ok || data.status === 'success') {
                            // Clear localStorage
                            localStorage.removeItem(STORAGE_KEY);

                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                            if (modal) modal.hide();

                            // Show success message
                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Registration Successful!',
                                    html: 'Please check your email to verify your account. After verification, please wait for the GCC administrator to approve your registration.',
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
                            // Handle errors
                            let errorMessage = data.message || 'Please correct the errors and try again.';
                            let errorHtml = '';

                            if (data.errors) {
                                errorHtml = '<div class="text-start mt-2"><ul class="mb-0 text-danger">';
                                Object.keys(data.errors).forEach(key => {
                                    // Highlight fields
                                    const input = signupForm.querySelector(`[name="${key}"]`);
                                    if (input) {
                                        input.classList.add('is-invalid');
                                        const feedback = input.closest('.mb-3')?.querySelector('.invalid-feedback');
                                        if (feedback) feedback.textContent = data.errors[key][0];
                                    }
                                    // Append to error list
                                    errorHtml += `<li>${data.errors[key][0]}</li>`;
                                });
                                errorHtml += '</ul></div>';
                            }

                            if (window.Swal) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Registration Failed',
                                    html: errorHtml || errorMessage,
                                    confirmButtonColor: '#d33'
                                });
                            } else {
                                alert(errorMessage);
                            }
                        }
                    } catch (err) {
                        console.error('Registration error:', err);
                        if (window.Swal) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Network error. Please try again.'
                            });
                        } else {
                            alert('Network error. Please try again.');
                        }
                    } finally {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalText;
                    }
                });
            }



            // ========================================
            // PASSWORD VISIBILITY TOGGLE
            // ========================================
            const toggleSignupPassword = document.getElementById('toggleSignupPassword');
            const toggleSignupPasswordConfirm = document.getElementById('toggleSignupPasswordConfirm');
            const signupPasswordInput = document.getElementById('signupPassword_v2');

            if (toggleSignupPassword && signupPasswordInput) {
                toggleSignupPassword.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const type = signupPasswordInput.type === 'password' ? 'text' : 'password';
                    signupPasswordInput.type = type;
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (type === 'text') {
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                });
            }

            const passwordConfirmInput = document.getElementById('signupPasswordConfirm_v2');
            if (toggleSignupPasswordConfirm && passwordConfirmInput) {
                toggleSignupPasswordConfirm.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const type = passwordConfirmInput.type === 'password' ? 'text' : 'password';
                    passwordConfirmInput.type = type;
                    const icon = this.querySelector('i');
                    if (icon) {
                        if (type === 'text') {
                            icon.classList.remove('fa-eye');
                            icon.classList.add('fa-eye-slash');
                        } else {
                            icon.classList.remove('fa-eye-slash');
                            icon.classList.add('fa-eye');
                        }
                    }
                });
            }
        });
    </script>
</body>

</html><?php /**PATH C:\Users\LENOVO\Laravel Projects\gccsystem\resources\views/home.blade.php ENDPATH**/ ?>