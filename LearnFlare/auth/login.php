<?php
session_start();
require_once '../config/db.php';

// Check if form is submitted for login processing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    // Validate input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Please fill in all fields";
        header("Location: login.php");
        exit;
    }
    
    try {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        // For debugging purposes
        if (!$user) {
            error_log("Login attempt: No user found with username: $username");
        }
        
        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Password is correct, create session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;
            
            // Update last login time - MySQL syntax
            try {
                $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE user_id = ?");
                $updateStmt->execute([$user['user_id']]);
            } catch (PDOException $e) {
                // Non-critical error, just log it
                error_log("Failed to update last login: " . $e->getMessage());
            }
            
            // Redirect to homepage
            header("Location: ../index.php");
            exit;
        } else {
            // Invalid credentials
            $_SESSION['error'] = "Invalid username or password";
            header("Location: login.php");
            exit;
        }
    } catch (PDOException $e) {
        // Log error for debugging
        error_log("Login error: " . $e->getMessage());
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: login.php");
        exit;
    }
}

// If user is already logged in, redirect to homepage
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: ../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LearnFlare</title>
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
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <li><a href="../courses/mycourses.php">My Courses</a></li>
                    <li class="dropdown">
                        <div class="user-profile" onclick="toggleDropdown(event)">
                            <div class="user-icon"><?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?></div>
                            <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </div>
                        <div id="userDropdown" class="dropdown-content">
                            <a href="logout.php">Log Out</a>
                        </div>
                    </li>
                <?php else: ?>
                    <li><a href="login.php" class="active">Login</a></li>
                    <li><a href="signup.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Login to LearnFlare</h2>
            
            <!-- Display error or success messages directly from session -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($_SESSION['error']); ?></div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['success']); ?></div>
                <?php unset($_SESSION['success']); ?>
            <?php endif; ?>
            
            <form id="login-form" action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Enter your username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <a href="signup.php" class="form-link">Don't have an account? Sign up</a>
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
                if (dropdown && dropdown.classList.contains("show")) {
                    dropdown.classList.remove("show");
                }
            }
        }
    </script>
</body>
</html>