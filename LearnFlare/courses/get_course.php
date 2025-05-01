<?php
require_once '../config/db.php';

// Check if course ID is provided
if (!isset($_GET['id'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Course ID is required']);
    exit;
}

$courseId = $_GET['id'];

try {
    // Fetch course details
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE course_id = ?");
    $stmt->execute([$courseId]);
    $course = $stmt->fetch();
    
    if (!$course) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Course not found']);
        exit;
    }
    
    // Return course details as JSON
    header('Content-Type: application/json');
    echo json_encode($course);
} catch (PDOException $e) {
    // Return error as JSON
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
}
?>