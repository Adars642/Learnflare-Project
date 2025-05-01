<?php
// Check if a session is already active before starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../utils/check_session.php';
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$username = $isLoggedIn ? $_SESSION['username'] : '';

// Determine current page for active nav highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LearnFlare - Brighten your future with focused learning</title>
    <link rel="stylesheet" href="<?php echo ROOT_URL; ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            background-color: var(--bg-elevated);
            min-width: 180px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
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
            background-color: rgba(142, 68, 173, 0.1);
            border-left-color: var(--accent-tertiary);
            color: var(--accent-light);
        }
        
        .show {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    <!-- Additional page-specific head content can be added with $extraHead -->
    <?php if (isset($extraHead)) echo $extraHead; ?>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="<?php echo ROOT_URL; ?>index.php" class="logo">Learn<span>Flare</span></a>
            <ul class="nav-links">
                <li><a href="<?php echo ROOT_URL; ?>index.php" class="<?php echo $current_page == 'index.php' ? 'active' : ''; ?>">Home</a></li>
                <li><a href="<?php echo ROOT_URL; ?>public/about.php" class="<?php echo $current_page == 'about.php' ? 'active' : ''; ?>">About Us</a></li>
                <li><a href="<?php echo ROOT_URL; ?>public/contact.php" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
                <?php if (!$isLoggedIn): ?>
                    <li><a href="<?php echo ROOT_URL; ?>auth/login.php" class="<?php echo $current_page == 'login.php' ? 'active' : ''; ?>">Login</a></li>
                    <li><a href="<?php echo ROOT_URL; ?>auth/signup.php" class="<?php echo $current_page == 'signup.php' ? 'active' : ''; ?>">Sign Up</a></li>
                <?php else: ?>
                    <li><a href="<?php echo ROOT_URL; ?>courses/mycourses.php" class="<?php echo $current_page == 'mycourses.php' ? 'active' : ''; ?>">My Courses</a></li>
                    <li class="dropdown">
                        <div class="user-profile" onclick="toggleDropdown(event)">
                            <div class="user-icon"><?php echo strtoupper(substr($username, 0, 1)); ?></div>
                            <span><?php echo $username; ?></span>
                        </div>
                        <div id="userDropdown" class="dropdown-content">
                            <a href="<?php echo ROOT_URL; ?>user/profile.php"><i class="fas fa-user-circle"></i> My Profile</a>
                            <a href="<?php echo ROOT_URL; ?>user/settings.php"><i class="fas fa-cog"></i> Settings</a>
                            <a href="<?php echo ROOT_URL; ?>auth/logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <!-- Main content starts here -->