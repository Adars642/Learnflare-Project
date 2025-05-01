<?php
session_start();
require_once '../config/db.php';

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request method']);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'You must be logged in to enroll in a course']);
    exit;
}

// Get user ID from session
$userId = $_SESSION['user_id'];

// Check if course ID is provided
if (!isset($_POST['course_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Course ID is required']);
    exit;
}

$courseId = $_POST['course_id'];

try {
    // Check if the user is already enrolled in the course
    $stmt = $pdo->prepare("SELECT * FROM enrollments WHERE user_id = ? AND course_id = ?");
    $stmt->execute([$userId, $courseId]);
    $existingEnrollment = $stmt->fetch();
    
    if ($existingEnrollment) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'You are already enrolled in this course']);
        exit;
    }
    
    // Check if the course exists
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE course_id = ?");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch();
    
    if (!$course) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Course not found']);
        exit;
    }
    
    // Enroll the user in the course with current timestamp
    $stmt = $pdo->prepare("INSERT INTO enrollments (user_id, course_id, enrolled_at) VALUES (?, ?, NOW())");
    $stmt->execute([$userId, $courseId]);
    
    // Return success response
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Successfully enrolled in the course']);
} catch (PDOException $e) {
    // Return error as JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>