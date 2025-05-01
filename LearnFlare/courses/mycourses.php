<?php
session_start();
require_once '../utils/check_session.php';
// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Not logged in, redirect to login page
    header("Location: ../auth/login.php");
    exit;
}

$username = $_SESSION['username'];
$userId = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - LearnFlare</title>
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
        
        /* New styles for enhanced My Courses page */
        .dashboard-container {
            display: grid;
            grid-template-columns: 1fr 3fr;
            gap: 30px;
            margin: 40px 0;
        }
        
        .sidebar {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            position: sticky;
            top: 20px;
            height: fit-content;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 10px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background-color: #007BFF;
            color: white;
        }
        
        .course-filters {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin: 2rem 0;
        }
        
        .filter-btn {
            padding: 0.75rem 1.5rem;
            background: var(--bg-elevated);
            border: 1px solid rgba(155, 89, 182, 0.1);
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-secondary);
        }
        
        .filter-btn:hover, .filter-btn.active {
            background: var(--accent-gradient);
            color: white;
            border-color: transparent;
        }
        
        .search-box {
            margin-bottom: 20px;
            display: flex;
        }
        
        .search-box input {
            flex: 1;
            padding: 12px;
            background: var(--bg-elevated);
            border: 1px solid rgba(155, 89, 182, 0.1);
            border-right: none;
            border-radius: 8px 0 0 8px;
            outline: none;
            color: var(--text-primary);
        }
        
        .search-box input::placeholder {
            color: var(--text-secondary);
        }
        
        .search-box button {
            padding: 12px 20px;
            background: var(--accent-gradient);
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .search-box button:hover {
            opacity: 0.9;
        }
        
        .course-card {
            display: flex;
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
        }
        
        .course-image {
            flex: 0 0 200px;
            background-color: #ddd;
            background-position: center;
            background-size: cover;
        }
        
        .course-details {
            flex: 1;
            padding: 20px;
            position: relative;
        }
        
        .course-title {
            font-size: 1.3rem;
            margin-bottom: 10px;
        }
        
        .course-instructor {
            color: #666;
            margin-bottom: 15px;
        }
        
        .progress-bar {
            height: 8px;
            background-color: #f1f1f1;
            border-radius: 4px;
            margin-top: 20px;
            overflow: hidden;
        }
        
        .progress {
            height: 100%;
            background-color: #4CAF50;
        }
        
        .course-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
            color: #666;
            font-size: 0.9rem;
        }
        
        .course-actions {
            position: absolute;
            right: 20px;
            bottom: 20px;
            display: flex;
            gap: 10px;
        }
        
        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: bold;
            margin-right: 10px;
            color: white;
        }
        
        .badge-in-progress {
            background-color: #FFC107;
        }
        
        .badge-completed {
            background-color: #4CAF50;
        }
        
        .badge-not-started {
            background-color: #F44336;
        }
        
        .course-stats-container {
            background: var(--bg-elevated);
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            border: 1px solid rgba(155, 89, 182, 0.1);
            transition: all 0.3s ease;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .course-stats-container:hover {
            box-shadow: var(--hover-shadow);
            border-color: rgba(155, 89, 182, 0.3);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 2rem;
            margin-top: 1.5rem;
        }
        
        .stat-card {
            text-align: center;
            padding: 1.5rem;
            background: var(--bg-secondary);
            border-radius: 12px;
            border: 1px solid rgba(155, 89, 182, 0.1);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: rgba(155, 89, 182, 0.3);
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.5rem;
        }
        
        .stat-label {
            font-size: 1rem;
            color: var(--text-secondary);
        }
        
        .no-courses {
            text-align: center;
            padding: 50px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .no-courses h3 {
            margin-bottom: 15px;
            color: #333;
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
            margin-bottom: 1rem;
        }

        .hero p {
            color: var(--text-secondary);
        }

        .main-content {
            padding: 3rem 0;
            background: var(--bg-primary);
            min-height: calc(100vh - 400px);
        }

        .card {
            background: var(--bg-elevated);
            border-radius: 12px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(155, 89, 182, 0.1);
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .card:hover {
            transform: translateY(-5px);
            border-color: rgba(155, 89, 182, 0.3);
            box-shadow: var(--hover-shadow);
        }

        .card-content {
            position: relative;
        }

        .card-title {
            color: var(--text-primary);
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .card-instructor {
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .card-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .card-meta {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
            color: var(--text-secondary);
        }

        .card-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .recommended-section {
            background: var(--bg-secondary);
            padding: 4rem 0;
        }

        .recommended-section .section-title {
            color: var(--text-primary);
            text-align: center;
            margin-bottom: 1rem;
        }

        .recommended-section p {
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 2rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--accent-gradient);
            color: white;
            border: none;
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid rgba(155, 89, 182, 0.2);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid currentColor;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--hover-shadow);
        }

        .no-courses {
            text-align: center;
            padding: 3rem;
            background: var(--bg-elevated);
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            border: 1px solid rgba(155, 89, 182, 0.1);
            max-width: 600px;
            margin: 2rem auto;
        }

        .no-courses h3 {
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .no-courses p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .badge-in-progress {
            background: linear-gradient(135deg, #FFC107, #FF9800);
            color: #1a1a1a;
        }

        .badge-completed {
            background: linear-gradient(135deg, #4CAF50, #45a049);
            color: white;
        }

        .badge-not-started {
            background: linear-gradient(135deg, #f44336, #d32f2f);
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            width: 100%;
        }

        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0;
        }

        .search-box {
            max-width: 1200px;
            margin: 0 auto 2rem;
        }

        .course-filters {
            max-width: 1200px;
            margin: 0 auto 2rem;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .main-content {
            padding: 3rem 0;
            background: var(--bg-primary);
            min-height: calc(100vh - 400px);
        }

        .main-content .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #enrolled-courses {
            max-width: 1200px;
            margin: 0 auto;
            width: 100%;
        }

        #enrolled-courses .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            width: 100%;
        }

        .card {
            width: 100%;
            margin: 0;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            #enrolled-courses .course-grid {
                grid-template-columns: 1fr;
            }
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
            <a href="../index.php" class="logo">Learn<span>Flare</span></a>
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="../public/about.php">About Us</a></li>
                <li><a href="../public/contact.php">Contact</a></li>
                <li><a href="mycourses.php" class="active">My Courses</a></li>
                <li class="dropdown">
                    <div class="user-profile" onclick="toggleDropdown(event)">
                        <div class="user-icon"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                        <span><?php echo htmlspecialchars($username); ?></span>
                    </div>
                    <div id="userDropdown" class="dropdown-content">

                        <a href="../auth/logout.php">Log Out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <div class="container">
            <h1>My Learning Dashboard</h1>
            <p>Track your progress, manage your courses, and continue your learning journey</p>
        </div>
    </section>

    <div class="main-content">
        <div class="course-stats-container">
            <h2>Your Learning Stats</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number" id="total-courses">0</div>
                    <div class="stat-label">Total Courses</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="in-progress">0</div>
                    <div class="stat-label">In Progress</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number" id="completed">0</div>
                    <div class="stat-label">Completed</div>
                </div>
            </div>
        </div>
        
        <div class="container">
            

            <div id="enrolled-courses">
                <p>Loading your courses...</p>
            </div>
        </div>
    </div>

    <section class="recommended-section">
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

        document.addEventListener('DOMContentLoaded', function() {
            // User ID is already available through PHP
            const userId = <?php echo $userId; ?>;
            let allCourses = [];
            
            // Fetch enrolled courses
            fetch('get_enrolled_courses.php')
                .then(response => response.json())
                .then(courses => {
                    const enrolledCoursesContainer = document.getElementById('enrolled-courses');
                    
                    if (courses.error) {
                        enrolledCoursesContainer.innerHTML = `<p class="error">${courses.error}</p>`;
                        return;
                    }
                    
                    if (courses.length === 0) {
                        showNoCourses(enrolledCoursesContainer);
                        return;
                    }
                    
                    // Store all courses for filtering later
                    allCourses = courses;
                    
                    // Clear loading message
                    enrolledCoursesContainer.innerHTML = '';
                    
                    // Update course stats
                    updateCourseStats(courses);
                    
                    // Display enrolled courses
                    displayCourses(courses, enrolledCoursesContainer);
                    
                    // Load recommendations after a short delay
                    setTimeout(loadRecommendations, 500);
                })
                .catch(error => {
                    console.error('Error fetching enrolled courses:', error);
                    document.getElementById('enrolled-courses').innerHTML = '<p class="error">Failed to load your courses. Please try again later.</p>';
                });
            
            // Course search functionality
            const searchInput = document.getElementById('course-search');
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                
                if (searchTerm === '') {
                    displayCourses(allCourses, document.getElementById('enrolled-courses'));
                    return;
                }
                
                const filteredCourses = allCourses.filter(course => {
                    return course.title.toLowerCase().includes(searchTerm) || 
                           course.instructor.toLowerCase().includes(searchTerm) ||
                           course.description.toLowerCase().includes(searchTerm);
                });
                
                displayCourses(filteredCourses, document.getElementById('enrolled-courses'));
            });
            
            // Course filter functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    
                    // Add active class to clicked button
                    this.classList.add('active');
                    
                    // Get filter value
                    const filter = this.getAttribute('data-filter');
                    
                    if (filter === 'all') {
                        displayCourses(allCourses, document.getElementById('enrolled-courses'));
                        return;
                    }
                    
                    // Filter courses based on their status
                    const filteredCourses = allCourses.filter(course => {
                        if (filter === 'in-progress' && course.progress > 0 && course.progress < 100) return true;
                        if (filter === 'completed' && course.progress === 100) return true;
                        if (filter === 'not-started' && course.progress === 0) return true;
                        return false;
                    });
                    
                    displayCourses(filteredCourses, document.getElementById('enrolled-courses'));
                });
            });
        });
        
        function loadRecommendations() {
            // This would normally be a backend request
            // For now, we'll simulate some recommendations
            const recommendedCourses = [
                {
                    course_id: 101,
                    title: "Advanced JavaScript Concepts",
                    instructor: "John Doe",
                    description: "Take your JavaScript skills to the next level with advanced topics like closures, prototypes, and asynchronous programming.",
                    rating: 4.8,
                    students: 3500,
                    image: "course1.jpg"
                },
                {
                    course_id: 102,
                    title: "Data Science Fundamentals",
                    instructor: "Sarah Parker",
                    description: "Learn the core concepts of data science including data analysis, visualization, and machine learning basics.",
                    rating: 4.7,
                    students: 2800,
                    image: "course2.jpg"
                },
                {
                    course_id: 103,
                    title: "UX/UI Design Principles",
                    instructor: "Michael Chen",
                    description: "Master the principles of good user experience and interface design for websites and applications.",
                    rating: 4.9,
                    students: 4200,
                    image: "course3.jpg"
                }
            ];
            
            const recommendedContainer = document.getElementById('recommended-courses');
            recommendedContainer.innerHTML = '';
            
            recommendedCourses.forEach(course => {
                const courseCard = document.createElement('div');
                courseCard.className = 'card';
                
                courseCard.innerHTML = `
                    <div class="card-content">
                        <h3 class="card-title">${course.title}</h3>
                        <p class="card-instructor">Instructor: ${course.instructor}</p>
                        <p class="card-description">${course.description.substring(0, 100)}...</p>
                        <div class="card-meta">
                            <span class="card-rating">⭐ ${course.rating}</span>
                            <span class="card-students">👥 ${course.students.toLocaleString()} students</span>
                        </div>
                        <a href="course.php?id=${course.course_id}" class="btn btn-secondary">View Details</a>
                    </div>
                `;
                
                recommendedContainer.appendChild(courseCard);
            });
        }
        
        function displayCourses(courses, container) {
            // Clear container
            container.innerHTML = '';
            
            if (courses.length === 0) {
                container.innerHTML = '<p>No courses match your search or filter.</p>';
                return;
            }
            
            // Create a grid container
            const gridContainer = document.createElement('div');
            gridContainer.className = 'course-grid';
            container.appendChild(gridContainer);
            
            courses.forEach(course => {
                // Determine course status and badge
                let statusBadge = '';
                let progress = course.progress || Math.floor(Math.random() * 101); // For demo purposes
                
                if (progress === 100) {
                    statusBadge = '<span class="badge badge-completed">Completed</span>';
                } else if (progress > 0) {
                    statusBadge = '<span class="badge badge-in-progress">In Progress</span>';
                } else {
                    statusBadge = '<span class="badge badge-not-started">Not Started</span>';
                }
                
                const courseCard = document.createElement('div');
                courseCard.className = 'card';
                
                courseCard.innerHTML = `
                    <div class="card-content">
                        ${statusBadge}
                        <h3 class="card-title">${course.title}</h3>
                        <p class="card-instructor">Instructor: ${course.instructor}</p>
                        <p class="card-description">${course.description.substring(0, 100)}...</p>
                        <div class="card-actions" style="margin-top: 15px; display: flex; gap: 10px; flex-wrap: wrap;">
                            <a href="course.php?id=${course.course_id}" class="btn btn-secondary">View Course</a>
                            <button onclick="markAsComplete(${course.course_id})" class="btn btn-primary">Mark as Complete</button>
                            <button onclick="removeCourse(${course.course_id})" class="btn btn-outline" style="color: #f44336; border-color: #f44336;">Remove</button>
                        </div>
                    </div>
                `;
                
                gridContainer.appendChild(courseCard);
            });
        }
        
        function updateCourseStats(courses) {
            // Calculate stats from courses
            const totalCourses = courses.length;
            let inProgress = 0;
            let completed = 0;
            
            courses.forEach(course => {
                let progress = course.progress || Math.floor(Math.random() * 101); // For demo purposes
                if (progress === 100) {
                    completed++;
                } else if (progress > 0) {
                    inProgress++;
                }
            });
            
            // Update stats display
            document.getElementById('total-courses').textContent = totalCourses;
            document.getElementById('in-progress').textContent = inProgress;
            document.getElementById('completed').textContent = completed;
        }
        
        function showNoCourses(container) {
            container.innerHTML = `
                <div class="no-courses">
                    <h3>You haven't enrolled in any courses yet</h3>
                    <p>Start your learning journey today by exploring our course catalog.</p>
                    <a href="../index.php#courses" class="btn btn-primary">Explore Courses</a>
                </div>
            `;
            
            // Set stats to zero
            document.getElementById('total-courses').textContent = '0';
            document.getElementById('in-progress').textContent = '0';
            document.getElementById('completed').textContent = '0';
        }
        
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

        // Function to mark a course as complete
        function markAsComplete(courseId) {
            if (!confirm('Are you sure you want to mark this course as complete? This will remove it from your enrolled courses.')) {
                return;
            }
            
            fetch('mark_as_complete.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `course_id=${courseId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Refresh the courses list after marking as complete
                    alert('Course marked as complete successfully!');
                    
                    // Update stats - increment completed count and remove from enrolled courses
                    const completedElement = document.getElementById('completed');
                    let completedCount = parseInt(completedElement.textContent);
                    completedElement.textContent = completedCount + 1;
                    
                    // Remove the course from the allCourses array
                    allCourses = allCourses.filter(course => course.course_id != courseId);
                    
                    // Refresh the display
                    const enrolledCoursesContainer = document.getElementById('enrolled-courses');
                    if (allCourses.length === 0) {
                        showNoCourses(enrolledCoursesContainer);
                    } else {
                        displayCourses(allCourses, enrolledCoursesContainer);
                    }
                    
                    // Update total courses count
                    document.getElementById('total-courses').textContent = allCourses.length;
                } else {
                    alert(data.error || 'Failed to mark course as complete. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error marking course as complete:', error);
                alert('An error occurred. Please try again later.');
            });
        }
        
        // Function to remove a course
        function removeCourse(courseId) {
            if (!confirm('Are you sure you want to remove this course? This action cannot be undone.')) {
                return;
            }
            
            fetch('remove_course.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `course_id=${courseId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Course removed successfully!');
                    
                    // Remove the course from the allCourses array
                    allCourses = allCourses.filter(course => course.course_id != courseId);
                    
                    // Refresh the display
                    const enrolledCoursesContainer = document.getElementById('enrolled-courses');
                    if (allCourses.length === 0) {
                        showNoCourses(enrolledCoursesContainer);
                    } else {
                        displayCourses(allCourses, enrolledCoursesContainer);
                    }
                    
                    // Update total courses count and in-progress count if needed
                    document.getElementById('total-courses').textContent = allCourses.length;
                    
                    // Recalculate in-progress courses
                    let inProgressCount = allCourses.filter(course => {
                        let progress = course.progress || 0;
                        return progress > 0 && progress < 100;
                    }).length;
                    
                    document.getElementById('in-progress').textContent = inProgressCount;
                } else {
                    alert(data.error || 'Failed to remove course. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error removing course:', error);
                alert('An error occurred. Please try again later.');
            });
        }
    </script>
</body>
</html>