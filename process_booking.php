<?php
session_start();
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $tour = trim($_POST['tour']);
    $date = trim($_POST['date']);
    $message = trim($_POST['message']);
    
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
    
    if (empty($errors)) {
        try {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
            
            $stmt = $pdo->prepare("INSERT INTO bookings (user_id, name, email, phone, tour, date, message, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            
            if ($stmt->execute([$user_id, $name, $email, $phone, $tour, $date, $message])) {
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
    
    if (!empty($errors)) {
        $_SESSION['booking_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
        header("Location: booking.php");
        exit;
    }
} else {
    header("Location: booking.php");
    exit;
}
?>