<?php
// Start session and include functions
require_once 'config/database.php';
require_once 'includes/functions.php';

secureSessionStart();

// Check if user needs to login for this page
requireLogin();
?>