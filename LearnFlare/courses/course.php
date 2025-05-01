<?php
session_start();
require_once '../utils/check_session.php';
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userId = $_SESSION['user_id'] ?? null;
$username = $_SESSION['username'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - LearnFlare</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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
                <?php if ($isLoggedIn): ?>
                    <li><a href="mycourses.php">My Courses</a></li>
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

    <div class="container">
        <div id="course-details" class="course-detail">
            <!-- Course details will be populated via JavaScript -->
            <p>Loading course details...</p>
        </div>
    </div>

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
                if (dropdown.classList.contains("show")) {
                    dropdown.classList.remove("show");
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Get course ID from URL
            const urlParams = new URLSearchParams(window.location.search);
            const courseId = urlParams.get('id');
            
            if (!courseId) {
                document.getElementById('course-details').innerHTML = '<p class="error">Invalid course ID</p>';
                return;
            }
            
            // PHP already provides login state
            const isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;
            const userId = <?php echo $userId ? $userId : 'null'; ?>;
            
            // Fetch course details
            fetch(`get_course.php?id=${courseId}`)
                .then(response => response.json())
                .then(course => {
                    if (course.error) {
                        document.getElementById('course-details').innerHTML = `<p class="error">${course.error}</p>`;
                        return;
                    }
                    
                    // Update document title
                    document.title = `${course.title} - LearnFlare`;
                    
                    // Check if user is enrolled in this course
                    if (isLoggedIn) {
                        checkEnrollmentStatus(courseId)
                            .then(isEnrolled => {
                                displayCourseDetails(course, isLoggedIn, isEnrolled);
                            })
                            .catch(error => {
                                console.error('Error checking enrollment status:', error);
                                displayCourseDetails(course, isLoggedIn, false);
                            });
                    } else {
                        displayCourseDetails(course, isLoggedIn, false);
                    }
                })
                .catch(error => {
                    console.error('Error fetching course details:', error);
                    document.getElementById('course-details').innerHTML = '<p class="error">Failed to load course details. Please try again later.</p>';
                });
            
            // Function to check if user is enrolled in a course
            function checkEnrollmentStatus(courseId) {
                return fetch(`check_enrollment.php?course_id=${courseId}`)
                    .then(response => response.json())
                    .then(data => {
                        return data.enrolled === true;
                    })
                    .catch(error => {
                        console.error('Error checking enrollment status:', error);
                        return false;
                    });
            }
            
            // Function to display course details with proper button
            function displayCourseDetails(course, isLoggedIn, isEnrolled) {
                const courseDetailsHTML = `
                    <div class="course-header">
                        <h1>${course.title}</h1>
                        <div class="course-meta">
                            <p><strong>Instructor:</strong> ${course.instructor}</p>
                            <p><strong>Duration:</strong> ${course.duration || '8 weeks'}</p>
                            <p><strong>Level:</strong> ${course.level || 'Intermediate'}</p>
                            <p><strong>Last Updated:</strong> ${course.updated_at || 'March 2025'}</p>
                            <p><strong>Students Enrolled:</strong> ${course.students || '1,250+'}</p>
                            <p><strong>Rating:</strong> ${course.rating || '4.8'} ⭐</p>
                        </div>
                    </div>
                    <div class="course-content">
                        <h2>About This Course</h2>
                        <div class="course-description">
                            <p>${course.description}</p>
                        </div>
                        
                        <h2>What You'll Learn</h2>
                        <ul class="course-outcomes">
                            <li>Master the core concepts and techniques covered in this curriculum</li>
                            <li>Apply your knowledge to real-world projects and scenarios</li>
                            <li>Build confidence in your skills through hands-on practice</li>
                            <li>Develop a professional portfolio to showcase your new abilities</li>
                            ${course.outcomes ? course.outcomes.map(outcome => `<li>${outcome}</li>`).join('') : ''}
                        </ul>
                        
                        <h2>Prerequisites</h2>
                        <p>${course.prerequisites || 'Basic understanding of the subject matter is recommended but not required. This course is designed to accommodate learners at various skill levels.'}</p>
                        
                        <h2>Course Format</h2>
                        <p>This course includes video lectures, reading materials, hands-on exercises, quizzes, and a final project to ensure a comprehensive learning experience.</p>
                    </div>
                    <div class="course-actions">
                        ${isLoggedIn ? 
                            (isEnrolled ? 
                                `<a href="mycourses.php" class="btn btn-primary">Continue Learning</a>` : 
                                `<button id="enroll-btn" class="btn btn-primary" data-course-id="${course.course_id}">Enroll Now</button>`
                            ) : 
                            `<a href="../auth/login.php" class="btn btn-primary">Login to Enroll</a>`
                        }
                    </div>
                `;
                
                document.getElementById('course-details').innerHTML = courseDetailsHTML;
                
                // Add event listener to enroll button if it exists
                const enrollBtn = document.getElementById('enroll-btn');
                if (enrollBtn) {
                    enrollBtn.addEventListener('click', function() {
                        const courseId = this.getAttribute('data-course-id');
                        enrollInCourse(courseId);
                    });
                }
            }
            
            // Function to handle course enrollment
            function enrollInCourse(courseId) {
                fetch('enroll.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `course_id=${courseId}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Successfully enrolled in the course!');
                        window.location.href = 'mycourses.php';
                    } else {
                        alert(data.error || 'Failed to enroll. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error enrolling in course:', error);
                    alert('An error occurred. Please try again later.');
                });
            }
        });
    </script>
</body>
</html>