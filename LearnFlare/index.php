<?php
session_start();
require_once 'utils/check_session.php';
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$username = $isLoggedIn ? $_SESSION['username'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnFlare - Brighten your future with focused learning</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .user-profile {
            display: flex;
            align-items: center;
            margin-left: 20px;
            cursor: pointer;
        }
        .user-icon {
            width: 35px;
            height: 35px;
            background-color: #007BFF;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: fixed;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 9999;
            border-radius: 5px;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }
        .dropdown-content a:hover {background-color: #f1f1f1;}
        .show {display: block;}

        /* New styles for improved homepage */
        .category-section {
            padding: 60px 0;
            background-color: var(--bg-secondary);
            position: relative;
            overflow: hidden;
        }

        .category-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2.5rem;
        }

        .category-card {
            background: var(--bg-elevated);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: var(--card-shadow);
            transition: all 0.4s ease;
            border: 1px solid rgba(155, 89, 182, 0.1);
            text-align: center;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
            border-color: rgba(155, 89, 182, 0.3);
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }

        .category-card h3 {
            color: var(--text-primary);
            margin-bottom: 1rem;
            font-size: 1.4rem;
        }

        .category-card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            line-height: 1.6;
        }
        
        .stats-section {
            padding: 60px 0;
            background: var(--accent-gradient);
            position: relative;
            overflow: hidden;
        }

        .stats-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 2rem;
        }

        .stat-item {
            flex: 0 1 auto;
            text-align: center;
            padding: 1rem;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: white;
        }

        .stat-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .stats-container {
                flex-direction: row;
                flex-wrap: wrap;
            }
            
            .stat-item {
                flex: 1 1 40%;
            }
        }
        
        .stats-section .section-title {
            text-align: center;
            width: 100%;
            margin-bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
        }

        .testimonials {
            padding: 60px 0;
            background: var(--bg-secondary);
        }
        
        .testimonial-container {
            display: flex;
            overflow-x: auto;
            gap: 30px;
            padding: 20px 0;
            scroll-snap-type: x mandatory;
        }
        
        .testimonial-card {
            flex: 0 0 350px;
            background: var(--bg-elevated);
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            scroll-snap-align: start;
            border: 1px solid rgba(155, 89, 182, 0.1);
            transition: all 0.4s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--hover-shadow);
            border-color: rgba(155, 89, 182, 0.3);
        }
        
        .testimonial-text {
            color: var(--text-secondary);
            font-style: italic;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .testimonial-author {
            color: var(--text-primary);
            font-weight: bold;
        }
        
        .partners-section {
            padding: 60px 0;
            text-align: center;
        }
        
        .partners-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 40px;
            margin-top: 30px;
        }
        
        .partner-logo {
            height: 60px;
            filter: grayscale(100%);
            opacity: 0.7;
            transition: all 0.3s ease;
        }
        
        .partner-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }
        
        .partners-section .section-title {
            text-align: center;
            width: 100%;
            margin-bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .features-section {
            padding: 60px 0;
            background: var(--bg-secondary);
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }
        
        .feature-card {
            background: var(--bg-elevated);
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: all 0.4s ease;
            border: 1px solid rgba(155, 89, 182, 0.1);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--hover-shadow);
            border-color: rgba(155, 89, 182, 0.3);
        }
        
        .feature-icon {
            font-size: 2rem;
            margin-bottom: 15px;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            display: inline-block;
        }
        
        .feature-title {
            margin-bottom: 15px;
            font-size: 1.3rem;
            color: var(--text-primary);
        }
        
        .feature-card p {
            color: var(--text-secondary);
        }
        
        .cta-section {
            padding: 80px 0;
            background: var(--accent-gradient);
            text-align: center;
            position: relative;
            overflow: hidden;
            color: white;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="none"/><path d="M0,0 L100,100" stroke="rgba(255,255,255,0.1)" stroke-width="1"/><path d="M100,0 L0,100" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></svg>');
            opacity: 0.2;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .cta-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: white;
        }

        .cta-text {
            font-size: 1.2rem;
            margin-bottom: 30px;
            line-height: 1.6;
            opacity: 0.9;
        }
        
        .course-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin: 30px 0;
        }
        
        .filter-btn {
            padding: 8px 15px;
            background-color: #f1f1f1;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .filter-btn:hover, .filter-btn.active {
            background-color: #007BFF;
            color: white;
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
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="index.php" class="logo">Learn<span>Flare</span></a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="public/about.php">About Us</a></li>
                <li><a href="public/contact.php">Contact</a></li>
                <?php if (!$isLoggedIn): ?>
                    <li><a href="auth/login.php">Login</a></li>
                    <li><a href="auth/signup.php">Sign Up</a></li>
                <?php else: ?>
                    <li><a href="courses/mycourses.php">My Courses</a></li>
                    <li class="dropdown">
                        <div class="user-profile" onclick="toggleDropdown(event)">
                            <div class="user-icon"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                            <span><?php echo $username; ?></span>
                        </div>
                        <div id="userDropdown" class="dropdown-content">
                            <a href="auth/logout.php">Log Out</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1 id="typing-text"></h1>
            <p>LearnFlare offers carefully curated courses to help you master new skills and advance your career. Start, switch, or advance your career with more than 500 courses from world-class instructors and institutions.</p>
            <div style="display: flex; gap: 15px; margin-top: 20px; justify-content: center;">
                <?php if (!$isLoggedIn): ?>
                    <a href="#courses" class="btn btn-primary">Explore Courses</a>
                    <a href="auth/signup.php" class="btn btn-secondary">Join For Free</a>
                <?php else: ?>
                    <a href="#courses" class="btn btn-primary">Explore Courses</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="search-container">
        <form id="search-form" class="search-form" action="courses/search.php" method="GET">
            <input type="text" id="search-input" name="query" class="search-input" placeholder="Search for courses...">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <section class="category-section">
        <div class="container">
            <h2 class="section-title">Explore Top Categories</h2>
            <div class="category-container">
                <div class="category-card" onclick="location.href=#">
                    <div class="category-icon">💻</div>
                    <h3>Programming</h3>
                    <p>Web, Mobile, Game Development</p>
                </div>
                <div class="category-card" onclick="location.href=#">
                    <div class="category-icon">📊</div>
                    <h3>Business</h3>
                    <p>Marketing, Entrepreneurship, Finance</p>
                </div>
                <div class="category-card" onclick="location.href=#">
                    <div class="category-icon">🎨</div>
                    <h3>Design</h3>
                    <p>UX/UI, Graphic Design, 3D & Animation</p>
                </div>
                <div class="category-card" onclick="location.href=#">
                    <div class="category-icon">📈</div>
                    <h3>Data Science</h3>
                    <p>Machine Learning, AI, Analytics</p>
                </div>
            </div>
        </div>
    </section>

    <section id="courses" class="courses">
        <div class="container">
            <h2 class="section-title">Available Courses</h2>
            
            <div class="course-grid" id="course-container">
                <!-- Course cards will be loaded dynamically via PHP -->
            </div>
        </div>
    </section>

    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Why Choose LearnFlare</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3 class="feature-title">Expert Instructors</h3>
                    <p>Learn from industry professionals with real-world experience and proven expertise in their fields.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Focused Learning</h3>
                    <p>Our courses are designed for maximum efficiency, focusing on practical skills without unnecessary fluff.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3 class="feature-title">Lifetime Access</h3>
                    <p>Enroll once and access your course content forever, including all future updates.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3 class="feature-title">Learn Anywhere</h3>
                    <p>Access courses on your computer, tablet, or mobile device, online or offline.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="stats-section">
        <div class="container">
            <h2 class="section-title" style="color: white;">LearnFlare by the Numbers</h2>
            <div class="stats-container">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Courses</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50+</div>
                    <div class="stat-label">Expert Instructors</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100K+</div>
                    <div class="stat-label">Students</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">95%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials">
        <div class="container">
            <h2 class="section-title">What Our Students Say</h2>
            <div class="testimonial-container">
                <div class="testimonial-card">
                    <p class="testimonial-text">"LearnFlare completely changed my career path. Within 3 months of completing their Web Development course, I landed my dream job as a front-end developer."</p>
                    <p class="testimonial-author">- Sarah Johnson, Front-end Developer</p>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"The Data Science track gave me exactly what I needed - practical skills that I could immediately apply at work. My productivity increased by 40%!"</p>
                    <p class="testimonial-author">- Michael Chen, Data Analyst</p>
                </div>
                <div class="testimonial-card">
                    <p class="testimonial-text">"I've tried many online learning platforms, but LearnFlare stands out for its focused approach and high-quality content. No fluff, just the skills you need."</p>
                    <p class="testimonial-author">- Elena Rodriguez, UX Designer</p>
                </div>
            </div>
        </div>
    </section>

    <section class="partners-section">
        <div class="container">
            <h2 class="section-title">We Collaborate With 350+ Leading Universities and Companies</h2>
            <div class="partners-grid">
                <img src="https://d3njjcbhbojbot.cloudfront.net/api/utilities/v1/imageproxy/https://images.ctfassets.net/wp1lcwdav1p1/77hmeEJo3ZPlURCU02fD52/aa37b7f7b52285ba350acac62d8af5c1/illinois-3.png?auto=format%2Ccompress&dpr=1&h=32" alt="University Partner" class="partner-logo" onerror="this.src='https://via.placeholder.com/150x60?text=University+Partner'">
                <img src="https://d3njjcbhbojbot.cloudfront.net/api/utilities/v1/imageproxy/https://images.ctfassets.net/wp1lcwdav1p1/1c6RjBHi3Lqb9QpWxje7iA/b529f909c5230af3210ba2d47d149620/google.png?auto=format%2Ccompress&dpr=1&h=37" alt="Tech Company" class="partner-logo" onerror="this.src='https://d3njjcbhbojbot.cloudfront.net/api/utilities/v1/imageproxy/https://images.ctfassets.net/wp1lcwdav1p1/1c6RjBHi3Lqb9QpWxje7iA/b529f909c5230af3210ba2d47d149620/google.png?auto=format%2Ccompress&dpr=1&h=37'">
                <img src="https://d3njjcbhbojbot.cloudfront.net/api/utilities/v1/imageproxy/https://images.ctfassets.net/wp1lcwdav1p1/6XkOucZz6pMLV5DPvXCgCL/1777129a58b0a62b237bd28e9956afe8/duke-3.png?auto=format%2Ccompress&dpr=1&h=32" alt="Industry Leader" class="partner-logo" onerror="this.src='https://via.placeholder.com/150x60?text=Industry+Leader'">
                <img src="https://d3njjcbhbojbot.cloudfront.net/api/utilities/v1/imageproxy/https://images.ctfassets.net/wp1lcwdav1p1/3toC4I7jbWxiedfxiyNjtT/735faeaf976a9692f425f8c3a7d125dc/1000px-IBM_logo.svg.png?auto=format%2Ccompress&dpr=1&h=37" alt="Global Corporation" class="partner-logo" onerror="this.src='https://via.placeholder.com/150x60?text=Global+Corporation'">
                <img src="https://d3njjcbhbojbot.cloudfront.net/api/utilities/v1/imageproxy/https://images.ctfassets.net/wp1lcwdav1p1/4FSFmNXuDIzTvFb7n0v4mK/704ae9e0a7981fb6415f4cb4609bbbb3/stanford.svg?auto=format%2Ccompress&dpr=1&h=27" alt="Education Institute" class="partner-logo" onerror="this.src='https://via.placeholder.com/150x60?text=Education+Institute'">
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-container">
            <h2 class="cta-title">Start Learning Today</h2>
            <p class="cta-text">Join over 100,000 learners who are already advancing their careers with LearnFlare's focused learning approach.</p>
            <?php if (!$isLoggedIn): ?>
                <a href="auth/signup.php" class="btn btn-primary">Sign Up For Free</a>
            <?php else: ?>
                <a href="#courses" class="btn btn-primary">Explore Courses</a>
            <?php endif; ?>
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

    <script src="assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Typing animation for the tagline
            const typingText = document.getElementById('typing-text');
            const phrases = ["Brighten Your Future with Focused Learning", "Master New Skills", "Advance Your Career"];
            let phraseIndex = 0;
            let charIndex = 0;
            let isDeleting = false;

            function typeEffect() {
                const currentPhrase = phrases[phraseIndex];
                if (isDeleting) {
                    typingText.textContent = currentPhrase.substring(0, charIndex--);
                } else {
                    typingText.textContent = currentPhrase.substring(0, charIndex++);
                }

                if (!isDeleting && charIndex === currentPhrase.length) {
                    isDeleting = true;
                    setTimeout(typeEffect, 1000);
                } else if (isDeleting && charIndex === 0) {
                    isDeleting = false;
                    phraseIndex = (phraseIndex + 1) % phrases.length;
                    setTimeout(typeEffect, 500);
                } else {
                    setTimeout(typeEffect, isDeleting ? 50 : 100);
                }
            }

            typeEffect();

            // Filter buttons functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Get filter value
                    const filter = this.getAttribute('data-filter');
                    
                    // Here you would typically filter the courses based on the selected category
                    // For now, let's just log the filter value
                    console.log(`Filter selected: ${filter}`);
                    
                    // Reload courses with the selected filter
                    loadCourses(filter);
                });
            });

            // Fetch courses data
            function loadCourses(filter = 'all') {
                const url = filter === 'all' ? 
                    'courses/fetch_courses.php' : 
                    `courses/fetch_courses.php?filter=${filter}`;
                
                fetch(url)
                    .then(response => response.json())
                    .then(courses => {
                        const courseContainer = document.getElementById('course-container');
                        
                        if (courses.length === 0) {
                            courseContainer.innerHTML = '<p>No courses available at the moment.</p>';
                            return;
                        }
                        
                        // Clear existing courses
                        courseContainer.innerHTML = '';
                        
                        courses.forEach(course => {
                            const courseCard = document.createElement('div');
                            courseCard.className = 'card';
                            
                            // Add featured badge if course is trending or popular
                            const featuredBadge = course.is_trending || course.is_popular ? 
                                `<span class="featured-badge">${course.is_trending ? 'Trending' : 'Popular'}</span>` : '';
                            
                            courseCard.innerHTML = `
                                ${featuredBadge}
                                <div class="card-content">
                                    <h3 class="card-title">${course.title}</h3>
                                    <p class="card-instructor">Instructor: ${course.instructor}</p>
                                    <p class="card-description">${course.description.substring(0, 100)}...</p>
                                    <div class="card-meta">
                                        <span class="card-rating">⭐ ${course.rating || '4.5'}</span>
                                        <span class="card-students">👥 ${course.students || '1,200'} students</span>
                                    </div>
                                    <a href="courses/course.php?id=${course.course_id}" class="btn btn-secondary">View Details</a>
                                </div>
                            `;
                            
                            courseContainer.appendChild(courseCard);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching courses:', error);
                        document.getElementById('course-container').innerHTML = '<p>Failed to load courses. Please try again later.</p>';
                    });
            }
            
            // Initial load of courses
            loadCourses();
        });

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
                if (dropdown.classList.contains("show")) {
                    dropdown.classList.remove("show");
                }
            }
        }
    </script>
</body>
</html>