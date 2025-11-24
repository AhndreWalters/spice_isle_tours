<?php
session_start();
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $message_content = trim($_POST['message']);
    
    $errors = [];
    
    if (empty($first_name)) {
        $errors[] = "First name is required.";
    }
    
    if (empty($last_name)) {
        $errors[] = "Last name is required.";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required.";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    
    if (empty($message_content)) {
        $errors[] = "Message is required.";
    }
    
    if (empty($errors)) {
        try {
            $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
            
            $stmt = $pdo->prepare("INSERT INTO messages (user_id, first_name, last_name, phone, email, message) VALUES (?, ?, ?, ?, ?, ?)");
            
            if ($stmt->execute([$user_id, $first_name, $last_name, $phone, $email, $message_content])) {
                $_SESSION['contact_success'] = "Your message has been sent successfully! We'll get back to you soon.";
                header("Location: contact.php");
                exit;
            } else {
                $errors[] = "Failed to send message. Please try again.";
            }
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
    
    if (!empty($errors)) {
        $_SESSION['contact_errors'] = $errors;
        $_SESSION['contact_form_data'] = $_POST;
        header("Location: contact.php");
        exit;
    }
} else {
    header("Location: contact.php");
    exit;
}
?>