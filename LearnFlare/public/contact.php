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
    <title>Contact Us - LearnFlare</title>
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


        .dropdown-content a:hover {background-color: #f1f1f1;}
        .show {display: block;}
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="../index.php" class="logo">Learn<span>Flare</span></a>
            <ul class="nav-links">
                <li><a href="../index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
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
            <h1>Get in Touch With Us</h1>
            <p>Have questions or feedback? We'd love to hear from you!</p>
        </div>
    </section>

    <div class="container" style="margin: 40px auto;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 40px;">
            <div>
                <h2 style="margin-bottom: 20px;">Contact Information</h2>
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; margin-bottom: 10px;">Address</h3>
                    <p>123 Learning Street, Education City</p>
                    <p>Anywhere, AN 12345</p>
                </div>
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; margin-bottom: 10px;">Phone</h3>
                    <p>(123) 456-7890 (Main)</p>
                    <p>(123) 456-7891 (Support)</p>
                </div>
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; margin-bottom: 10px;">Email</h3>
                    <p>info@learnflare.com</p>
                    <p>support@learnflare.com</p>
                </div>
                <div style="margin-bottom: 20px;">
                    <h3 style="font-size: 18px; margin-bottom: 10px;">Hours of Operation</h3>
                    <p>Monday - Friday: 9:00 AM - 5:00 PM</p>
                    <p>Saturday: 10:00 AM - 2:00 PM</p>
                    <p>Sunday: Closed</p>
                </div>
            </div>
            <div class="form-container" style="margin: 0;">
                <h2 class="form-title">Send Us a Message</h2>
                <form id="contact-form" action="../includes/contact_handler.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" <?php if ($isLoggedIn): ?>value="<?php echo htmlspecialchars($username); ?>"<?php endif; ?> required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" <?php if ($isLoggedIn): ?>value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>"<?php endif; ?> required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" class="form-control" placeholder="Enter subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="5" placeholder="Enter your message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </div>
        
        <div style="margin-top: 50px;">
            <h2 class="section-title" style="text-align: center; margin-bottom: 2.5rem; color: var(--text-primary);">Frequently Asked Questions</h2>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="faq-card" style="background: var(--bg-elevated); padding: 25px; border-radius: 12px; box-shadow: var(--card-shadow); border: 1px solid rgba(155, 89, 182, 0.1); transition: all 0.3s ease;">
                    <h3 style="font-size: 18px; margin-bottom: 15px; color: var(--text-primary);">How do I enroll in a course?</h3>
                    <p style="color: var(--text-secondary); line-height: 1.6;">To enroll in a course, simply navigate to the course page and click the "Enroll Now" button. You'll need to be logged in to your LearnFlare account.</p>
                </div>
                <div class="faq-card" style="background: var(--bg-elevated); padding: 25px; border-radius: 12px; box-shadow: var(--card-shadow); border: 1px solid rgba(155, 89, 182, 0.1); transition: all 0.3s ease;">
                    <h3 style="font-size: 18px; margin-bottom: 15px; color: var(--text-primary);">Is there a refund policy?</h3>
                    <p style="color: var(--text-secondary); line-height: 1.6;">Yes, we offer a 30-day money-back guarantee for all our courses if you're not satisfied with your learning experience.</p>
                </div>
                <div class="faq-card" style="background: var(--bg-elevated); padding: 25px; border-radius: 12px; box-shadow: var(--card-shadow); border: 1px solid rgba(155, 89, 182, 0.1); transition: all 0.3s ease;">
                    <h3 style="font-size: 18px; margin-bottom: 15px; color: var(--text-primary);">How long do I have access to a course?</h3>
                    <p style="color: var(--text-secondary); line-height: 1.6;">Once enrolled, you have lifetime access to your courses, including all future updates and improvements.</p>
                </div>
                <div class="faq-card" style="background: var(--bg-elevated); padding: 25px; border-radius: 12px; box-shadow: var(--card-shadow); border: 1px solid rgba(155, 89, 182, 0.1); transition: all 0.3s ease;">
                    <h3 style="font-size: 18px; margin-bottom: 15px; color: var(--text-primary);">Do you offer corporate training?</h3>
                    <p style="color: var(--text-secondary); line-height: 1.6;">Yes, we provide special packages for corporate clients. Please contact our sales team at corporate@learnflare.com for details.</p>
                </div>
            </div>
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
                if (dropdown.classList.contains("show")) {
                    dropdown.classList.remove("show");
                }
            }
        }
    </script>
</body>
</html>