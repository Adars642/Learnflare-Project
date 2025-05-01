<?php
// Include database connection
require_once '../config/db.php';
session_start();
require_once '../utils/check_session.php';
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$username = $isLoggedIn ? $_SESSION['username'] : '';

// Get search query
$query = isset($_GET['query']) ? trim($_GET['query']) : '';
$courses = [];
$error = '';

if (!empty($query)) {
    try {
        // Search for courses by title, description, or instructor
        $stmt = $pdo->prepare("
            SELECT * FROM courses 
            WHERE title LIKE ? OR description LIKE ? OR instructor LIKE ?
            ORDER BY created_at DESC
        ");
        
        $searchParam = "%" . $query . "%";
        $stmt->execute([$searchParam, $searchParam, $searchParam]);
        $courses = $stmt->fetchAll();
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - LearnFlare</title>
    <link rel="stylesheet" href="../assets/css/style.css">
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

    <div class="search-container">
        <form id="search-form" class="search-form" action="search.php" method="GET">
            <input type="text" id="search-input" name="query" class="search-input" value="<?php echo htmlspecialchars($query); ?>" placeholder="Search for courses...">
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <section class="courses">
        <div class="container">
            <h2 class="section-title">Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>
            
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php elseif (empty($courses) && !empty($query)): ?>
                <p>No courses found matching your search criteria.</p>
            <?php elseif (empty($query)): ?>
                <p>Please enter a search term.</p>
            <?php else: ?>
                <div class="course-grid">
                    <?php foreach ($courses as $course): ?>
                        <div class="card">
                            <div class="card-content">
                                <h3 class="card-title"><?php echo htmlspecialchars($course['title']); ?></h3>
                                <p class="card-instructor">Instructor: <?php echo htmlspecialchars($course['instructor']); ?></p>
                                <p class="card-description"><?php echo htmlspecialchars(substr($course['description'], 0, 100)); ?>...</p>
                                <a href="course.php?id=<?php echo $course['course_id']; ?>" class="btn btn-secondary">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 LearnFlare. All rights reserved.</p>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
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