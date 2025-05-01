<?php
session_start();
require_once '../utils/check_session.php';
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - LearnFlare</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .user-profile {
            display: flex;
            align-items: center;
            margin-left: 20px;
            cursor: pointer;
            position: relative;
        }
        .user-icon {
            width: 38px;
            height: 38px;
            background: var(--accent-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 10px;
            transition: all 0.3s;
            box-shadow: 0 2px 10px rgba(142, 68, 173, 0.3);
        }
        .user-profile:hover .user-icon {
            transform: scale(1.08);
            box-shadow: 0 4px 15px rgba(142, 68, 173, 0.5);
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: fixed;
            background: var(--bg-elevated);
            min-width: 180px;
            box-shadow: var(--card-shadow);
            z-index: 9999;
            border-radius: 8px;
            border: 1px solid rgba(155, 89, 182, 0.2);
            overflow: hidden;
        }
        .dropdown-content a {
            color: var(--text-primary);
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }
        .dropdown-content a:hover {
            background: rgba(142, 68, 173, 0.1);
            border-left-color: var(--accent-tertiary);
            color: var(--accent-light);
        }
        .show {display: block;}
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 2rem;
        }
        
        .team-member {
            text-align: center;
            background-color: #f9f9f9;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
        }
        
        .team-member-icon {
            width: 120px;
            height: 120px;
            background-color: #007BFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 2rem;
            margin: 0 auto 15px;
        }
        
        .team-member h3 {
            margin: 10px 0 5px;
            color: #333;
        }
        
        /* New styles for enhanced About page */
        .mission-vision-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .mission-card {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .mission-card:hover {
            transform: translateY(-5px);
        }
        
        .mission-icon {
            font-size: 2.5rem;
            color: #007BFF;
            margin-bottom: 20px;
        }
        
        .timeline {
            position: relative;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
        }
        
        .timeline::after {
            content: '';
            position: absolute;
            width: 6px;
            background: var(--accent-gradient);
            top: 0;
            bottom: 0;
            left: 50%;
            margin-left: -3px;
            border-radius: 3px;
        }
        
        .timeline-item {
            padding: 10px 50px;
            position: relative;
            width: 50%;
            box-sizing: border-box;
        }
        
        .timeline-item::after {
            content: '';
            position: absolute;
            width: 25px;
            height: 25px;
            right: -12px;
            background: var(--bg-elevated);
            border: 4px solid var(--accent-tertiary);
            top: 15px;
            border-radius: 50%;
            z-index: 1;
        }
        
        .timeline-left {
            left: 0;
            text-align: right;
        }
        
        .timeline-right {
            left: 50%;
            text-align: left;
        }
        
        .timeline-right::after {
            left: -12px;
        }
        
        .timeline-content {
            background: var(--bg-elevated);
            border-radius: 12px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(155, 89, 182, 0.1);
            transition: all 0.3s ease;
        }
        
        .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
            border-color: rgba(155, 89, 182, 0.3);
        }
        
        .timeline-date {
            font-weight: bold;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
        }
        
        .stats-section {
            background: var(--accent-gradient);
            padding: 60px 0;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .stats-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M0,0 L100,100" stroke="rgba(255,255,255,0.1)" stroke-width="1"/><path d="M100,0 L0,100" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></svg>');
            opacity: 0.2;
            z-index: 0;
        }

        .stats-container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 3rem;
            margin: 2rem auto;
            max-width: 1200px;
            padding: 0 1rem;
            position: relative;
            z-index: 1;
        }

        .stat-item {
            flex: 1;
            min-width: 200px;
            max-width: 250px;
            text-align: center;
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: white;
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        @media (max-width: 768px) {
            .stats-container {
                flex-wrap: wrap;
                gap: 2rem;
            }
            
            .stat-item {
                flex: 1 1 40%;
                min-width: 150px;
            }
        }
        
        .partnership-section {
            padding: 60px 0;
            background-color: #f8f9fa;
        }
        
        .partners-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin-top: 40px;
        }
        
        .partner-logo {
            height: 70px;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        
        .partner-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }
        
        .values-section {
            padding: 60px 0;
        }
        
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .value-card {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .value-card:hover {
            transform: translateY(-5px);
        }
        
        .value-icon {
            font-size: 2.5rem;
            color: #007BFF;
            margin-bottom: 20px;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .team-member {
            text-align: center;
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .team-member:hover {
            transform: translateY(-5px);
        }
        
        .team-member-icon {
            width: 150px;
            height: 150px;
            background-color: #007BFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 3rem;
            margin: 0 auto 20px;
        }
        
        .team-role {
            color: #666;
            margin-top: 5px;
            font-style: italic;
        }
        
        .testimonial-section {
            padding: 60px 0;
            background-color: #f0f7ff;
        }
        
        .testimonial-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 40px;
        }
        
        .testimonial-card {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .testimonial-text {
            font-style: italic;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .testimonial-author {
            font-weight: bold;
        }
        
        .awards-section {
            padding: 60px 0;
        }
        
        .awards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
            margin-top: 40px;
            text-align: center;
        }
        
        .award-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .award-icon {
            font-size: 2.5rem;
            color: goldenrod;
            margin-bottom: 15px;
        }
        
        .award-year {
            font-weight: bold;
            color: #666;
            margin-top: 10px;
        }

        .mission-card, .value-card, .team-member, .testimonial-card, .award-card {
            background: var(--bg-elevated);
            border-radius: 12px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            transition: all 0.4s ease;
            border: 1px solid rgba(155, 89, 182, 0.1);
        }

        .mission-card:hover, .value-card:hover, .team-member:hover, .testimonial-card:hover, .award-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
            border-color: rgba(155, 89, 182, 0.3);
        }

        .mission-icon, .value-icon, .award-icon {
            font-size: 2.5rem;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 20px;
        }

        .team-member-icon {
            width: 120px;
            height: 120px;
            background: var(--accent-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin: 0 auto 15px;
            box-shadow: 0 2px 10px rgba(142, 68, 173, 0.3);
        }

        .testimonial-section, .partnership-section, .values-section {
            background: var(--bg-secondary);
            padding: 60px 0;
        }

        .hero {
            background: var(--bg-secondary);
            padding: 60px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero h1 {
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .hero p {
            color: var(--text-secondary);
            max-width: 800px;
            margin: 0 auto;
        }

        .mission-card h2, .value-card h3, .team-member h3, .award-card h3 {
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .mission-card p, .value-card p, .testimonial-text {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .testimonial-author {
            color: var(--text-primary);
            font-weight: 600;
        }

        .award-year {
            color: var(--text-secondary);
            font-weight: 500;
            margin-top: 10px;
        }

        .partner-logo {
            height: 70px;
            filter: brightness(0.8) opacity(0.7);
            transition: all 0.3s ease;
        }

        .partner-logo:hover {
            filter: brightness(1) opacity(1);
        }

        .section-title {
            text-align: center;
            color: var(--text-primary);
            margin: 0 auto 2.5rem;
            width: 100%;
            display: block;
            position: static;
        }

        .stats-section .section-title {
            color: white;
        }

        .section-title:after {
            content: '';
            position: absolute;
            width: 70px;
            height: 3px;
            background: var(--accent-gradient);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 3px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
            text-align: center;
        }

        .team-section {
            padding: 4rem 0;
            text-align: center;
            background: var(--bg-secondary);
            border-radius: 12px;
            margin: 2rem auto;
            
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2.5rem;
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .suggestions {
            margin: 4rem 0;
            text-align: center;
            background: var(--bg-secondary);
            padding: 4rem 2rem;
            border-radius: 12px;
        }

        .suggestions p {
            color: var(--text-secondary);
            max-width: 800px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }

        .suggestions .btn-primary {
            background: var(--accent-gradient);
            color: white;
            padding: 1rem 2rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            box-shadow: 0 4px 15px rgba(142, 68, 173, 0.3);
        }

        .suggestions .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(142, 68, 173, 0.4);
        }

        .footer {
            background: var(--bg-elevated);
            color: var(--text-secondary);
            padding: 50px 0 20px;
            margin-top: 4rem;
        }

        .footer h3, .footer h4 {
            color: var(--text-primary);
            margin-bottom: 1.5rem;
        }

        .footer p {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer a:hover {
            color: var(--accent-light);
        }

        .footer .social-links a {
            font-size: 1.25rem;
            color: var(--text-secondary);
            transition: all 0.3s;
        }

        .footer .social-links a:hover {
            color: var(--accent-light);
            transform: translateY(-2px);
        }

        .section-title-wrapper {
            width: 100%;
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .section-title {
            color: var(--text-primary);
            display: inline-block;
            position: relative;
            margin: 0 auto;
        }

        .stats-section .section-title-wrapper {
            margin-bottom: 3rem;
        }

        .stats-section .section-title {
            color: white;
        }

        .team-section .section-title-wrapper {
            margin-bottom: 3rem;
        }

        .stats-section h2.section-title {
            color: white;
            display: block;
            text-align: center;
            width: 100%;
            position: static;
            transform: none;
            left: auto;
            margin: 0 auto 2rem;
        }

        .team-section h2.section-title {
            display: block;
            text-align: center;
            width: 100%;
            position: static;
            transform: none;
            left: auto;
            margin: 0 auto 2rem;
        }

        .section-title-container {
            width: 100%;
            text-align: center;
            margin-bottom: 2rem;
        }

        .stats-section .container, 
        .team-section.container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stats-container,
        .team-grid {
            width: 100%;
        }

        .stats-section h2, .team-section h2 {
            display: block;
            width: 100%;
            text-align: center;
            margin: 0 auto 2.5rem;
            position: relative;
            left: auto;
            transform: none;
            color: var(--text-primary);
        }

        .stats-section h2 {
            color: white;
        }

        .stats-section .container, .team-section.container {
            text-align: center;
        }

        .section-title:after {
            left: 50%;
            transform: translateX(-50%);
        }

        .stats-section h2,
        .team-section h2 {
            color: var(--text-primary);
            text-align: center;
            margin: 0 auto 2.5rem;
            font-size: 2rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .stats-section h2 {
            color: white;
        }

        .stats-section h2::after,
        .team-section h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background: var(--accent-gradient);
            border-radius: 3px;
        }

        .container h2 {
            text-align: center;
            width: 100%;
            margin: 0 auto 2.5rem;
            font-size: 2rem;
            position: relative;
            padding-bottom: 1.5rem;
            color: var(--text-primary);
        }

        .stats-section h2 {
            color: white;
        }

        .container h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 3px;
            background: var(--accent-gradient);
            border-radius: 3px;
        }
    </style>
</head>
<body>
<nav class="navbar">
        <div class="container">
            <a href="../index.php" class="logo">Learn<span>Flare</span></a>
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="about.php" class = "active">About Us</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if ($isLoggedIn): ?>
                    <li><a href="../courses/mycourses.php">My Courses</a></li>
                    <li class="dropdown">
                        <div class="user-profile" onclick="toggleDropdown(event)">
                            <div class="user-icon"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                            <span><?php echo htmlspecialchars($username); ?></span>
                        </div>
                        <div id="userDropdown" class="dropdown-content">
                            <a href="../auth/logout.php">Log Out</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li><a href="../auth/login.php">Login</a></li>
                    <li><a href="../auth/signup.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>


    <section class="hero" style="background: linear-gradient(135deg, rgba(142, 68, 173, 0.3), rgba(155, 89, 182, 0.1));">
        <div class="container">
            <h1>About LearnFlare</h1>
            <p>Lighting the path to knowledge and skills development through focused learning experiences</p>
        </div>
    </section>

    <section class="container">
        <div class="mission-vision-grid">
            <div class="mission-card">
                <div class="mission-icon">🚀</div>
                <h2>Our Mission</h2>
                <p>At LearnFlare, we believe that education should be accessible to everyone. Our mission is to provide high-quality learning experiences that help people develop new skills, advance their careers, and achieve their goals.</p>
                <p>We're committed to creating a platform where learners can connect with expert instructors and engage with carefully crafted course content designed for maximum efficiency and real-world application.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">👁️</div>
                <h2>Our Vision</h2>
                <p>We envision a world where anyone, anywhere can transform their life through learning. We aim to be the most efficient path to quality education that empowers individuals to reach their full potential.</p>
                <p>By 2030, we aim to positively impact the lives of 1 million learners through our focused, high-quality educational content and supportive learning community.</p>
            </div>
            <div class="mission-card">
                <div class="mission-icon">🧭</div>
                <h2>Our Approach</h2>
                <p>We believe in learning that gets straight to the point. Our courses are designed to be efficient, eliminating fluff while ensuring you gain practical, applicable skills.</p>
                <p>Every course on LearnFlare undergoes a rigorous quality assurance process to ensure it meets our high standards for both content and instructional design.</p>
            </div>
        </div>
    </section>

    <section class="container values-section">
        <h2 class="section-title">Our Core Values</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">🎯</div>
                <h3>Focus</h3>
                <p>We eliminate unnecessary content and distractions, focusing only on what truly matters for your learning journey.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Community</h3>
                <p>We foster a supportive environment where learners can connect, collaborate, and grow together.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">⚡</div>
                <h3>Efficiency</h3>
                <p>We optimize the learning experience to help you achieve your goals in the most time-effective manner possible.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🔍</div>
                <h3>Quality</h3>
                <p>We maintain rigorous standards for our content, ensuring you receive the best possible education.</p>
            </div>
        </div>
    </section>

    

    <section class="team-section container">
        <h2>Our Team</h2>
        <div class="team-grid">
            <div class="team-member">
                <div class="team-member-icon">AG</div>
                <h3>Adarsh Kumar Goutam</h3>
            </div>
            <div class="team-member">
                <div class="team-member-icon">NK</div>
                <h3>Navneet Kumar</h3>
            </div>
            <div class="team-member">
                <div class="team-member-icon">AR</div>
                <h3>Aman Raj</h3>
            </div>
            <div class="team-member">
                <div class="team-member-icon">AR</div>
                <h3>Ankur Raj</h3>
            </div>
        </div>
    </section>

    <section class="testimonial-section">
        <div class="container">
            <h2 class="section-title">What Industry Leaders Say</h2>
            <div class="testimonial-grid">
                <div class="testimonial-card">
                    <p class="testimonial-text">"LearnFlare has revolutionized how we approach employee skill development. Their focused learning model has increased our team's productivity and innovation."</p>
                    <p class="testimonial-author">- Rachel Chen, Director of Learning & Development, TechGlobal</p>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"As someone who's been in education for over 20 years, I'm impressed by LearnFlare's approach to efficient learning. They're truly changing the online education landscape."</p>
                    <p class="testimonial-author">- Dr. Michael Johnson, Education Innovation Researcher</p>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"LearnFlare's platform offers what many others don't: focused, practical training that translates directly to workplace skills. They understand what today's workforce needs."</p>
                    <p class="testimonial-author">- Sarah Williams, Talent Acquisition Manager, InnovateCorp</p>
                </div>
            </div>
        </div>
    </section>

    <section class="awards-section container">
        <h2 class="section-title">Our Recognitions</h2>
        <div class="awards-grid">
            <div class="award-card">
                <div class="award-icon">🏆</div>
                <h3>Best EdTech Startup</h3>
                <p class="award-year">2024</p>
            </div>
            <div class="award-card">
                <div class="award-icon">🏅</div>
                <h3>Excellence in Online Education</h3>
                <p class="award-year">2024</p>
            </div>
            <div class="award-card">
                <div class="award-icon">🌟</div>
                <h3>Innovation in Learning Design</h3>
                <p class="award-year">2023</p>
            </div>
            <div class=" award-card">
                <div class="award-icon">🎓</div>
                <h3>Impact in Skill Development</h3>
                <p class="award-year">2023</p>
            </div>
        </div>
    </section>

    <section class="container">
        <div class="suggestions" style="margin: 3rem 0;">
            <h2 class="section-title">Join Our Community</h2>
            <p style="text-align: center; max-width: 800px; margin: 0 auto 30px;">Become part of the LearnFlare community and connect with fellow learners, instructors, and industry professionals.</p>
            <div style="text-align: center;">
                <a href="../auth/signup.php" class="btn btn-primary">Join LearnFlare Today</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; margin-bottom: 40px;">
                <div>
                    <h3>LearnFlare</h3>
                    <p>Brighten your future through focused learning experiences with our carefully crafted courses designed to help you gain practical skills efficiently.</p>
                    <div style="margin-top: 15px;">
                        <ul class="social-links" style="display: flex; gap: 15px; list-style: none; padding: 0;">
                            <li><a href="#" style="font-size: 20px; text-decoration: none;">📱</a></li>
                            <li><a href="#" style="font-size: 20px;text-decoration: none;">💻</a></li>
                            <li><a href="#" style="font-size: 20px;text-decoration: none;">📧</a></li>
                            <li><a href="#" style="font-size: 20px;text-decoration: none;">📸</a></li>
                        </ul>
                    </div>
                </div>
                <div>
                    <h4>Quick Links</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;text-decoration: none;"><a href="../index.php">Home</a></li>
                        <li style="margin-bottom: 10px;text-decoration: none;"><a href="../public/about.php">About Us</a></li>
                        <li style="margin-bottom: 10px;text-decoration: none;"><a href="../index.php#courses">Explore Courses</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Support</h4>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 10px;text-decoration: none;"><a href="#">Help Center</a></li>
                        <li style="margin-bottom: 10px;text-decoration: none;"><a href="#">Terms of Service</a></li>
                        <li style="margin-bottom: 10px;text-decoration: none;"><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contact Us</h4>
                    <p style="margin-bottom: 10px;text-decoration: none;"><strong>Address:</strong> 123 Street, Education City</p>
                    <p style="margin-bottom: 10px;text-decoration: none;"><strong>Phone:</strong> (123) 456-7890</p>
                    <p style="margin-bottom: 10px;text-decoration: none;"><strong>Email:</strong> info@learnflare.com</p>

                </div>
            </div>
            <div style="border-top: 1px solid #444; padding-top: 20px; text-align: center;">
                <p>&copy; 2025 LearnFlare. All rights reserved.</p>
            </div>
        </div>
    </footer>


    <script src="../assets/js/main.js"></script>
    <script>
        function toggleDropdown(event) {
            event.stopPropagation();
            var dropdown = document.getElementById("userDropdown");
            dropdown.classList.toggle("show");
            
            // Position the dropdown relative to the clicked element
            if (dropdown.classList.contains("show")) {
                var rect = event.target.getBoundingClientRect();
                dropdown.style.top = (rect.bottom + 5) + 'px';
                dropdown.style.left = (rect.right - dropdown.offsetWidth) + 'px';
            }
        }
        
        // Close the dropdown when clicking anywhere else
        window.onclick = function(event) {
            if (!event.target.matches('.user-profile') && 
                !event.target.matches('.user-icon') && 
                !event.target.matches('.user-profile span')) {
                var dropdown = document.getElementById("userDropdown");
                if (dropdown && dropdown.classList.contains("show")) {
                    dropdown.classList.remove("show");
                }
            }
        }
    </script>
</body>
</html>