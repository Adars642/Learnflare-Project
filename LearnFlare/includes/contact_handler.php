<?php
session_start();
require_once '../config/db.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? trim($_POST['subject']) : '';
    $message = isset($_POST['message']) ? trim($_POST['message']) : '';
    
    // Validate input
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $_SESSION['error'] = "Please fill in all fields";
        header("Location: ../public/contact.php");
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address";
        header("Location: ../public/contact.php");
        exit;
    }
    
    try {
        // Store contact message with timestamp
        $stmt = $pdo->prepare("INSERT INTO contact_messages (name, email, subject, message, submitted_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([$name, $email, $subject, $message]);
        
        // Success message
        $_SESSION['success'] = "Your message has been sent! We'll get back to you soon.";
        header("Location: ../public/contact.php");
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: ../public/contact.php");
        exit;
    }
} else {
    // If someone tries to access this file directly
    header("Location: ../public/contact.php");
    exit;
}
?>