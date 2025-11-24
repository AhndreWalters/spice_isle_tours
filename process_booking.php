<?php
session_start();
include 'config/database.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $tour = trim($_POST['tour']);
    $date = trim($_POST['date']);
    $message = trim($_POST['message']);
    
    // Basic validation
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Full name is required.";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }
    
    if (empty($tour)) {
        $errors[] = "Please select a tour.";
    }
    
    if (empty($date)) {
        $errors[] = "Please select a date.";
    }
    
    // If no errors, save to database
    if (empty($errors)) {
        try {
            // Get user ID if logged in, otherwise use NULL
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
            
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, name, email, phone, tour, date, message, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            
            if ($stmt->execute([$user_id, $name, $email, $phone, $tour, $date, $message])) {
                // Success - redirect back with success message
                $_SESSION['booking_success'] = "Your booking has been submitted successfully! We'll contact you soon.";
                header("Location: booking.php");
                exit;
            } else {
                $errors[] = "Failed to save booking. Please try again.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
    
    // If there are errors, store them in session and redirect back
    if (!empty($errors)) {
        $_SESSION['booking_errors'] = $errors;
        $_SESSION['form_data'] = $_POST; // Save form data to repopulate
        header("Location: booking.php");
        exit;
    }
} else {
    // If someone tries to access this page directly
    header("Location: booking.php");
    exit;
}
?>