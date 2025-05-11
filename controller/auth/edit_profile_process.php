<?php
// Start session to access session variables
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: ../../pages/login.php");
    exit();
}

// Include file koneksi database
require_once '../../config/conn.php';

// Initialize variables for error handling
$errors = [];
$success_message = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get current user ID from session
    $user_id = $_SESSION['user_id'];
    
    // Get form data and sanitize
    $username = trim(htmlspecialchars($_POST['username']));
    $email = trim(htmlspecialchars($_POST['email']));
    $name = trim(htmlspecialchars($_POST['name']));
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate form data
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    // Check if username or email already exists (but not for current user)
    $check_query = "SELECT * FROM users WHERE (username = ? OR email = ?) AND id != ?";
    $check_stmt = $conn->prepare($check_query);
    $check_stmt->bind_param("ssi", $username, $email, $user_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['username'] == $username) {
                $errors[] = "Username already exists";
            }
            if ($row['email'] == $email) {
                $errors[] = "Email already exists";
            }
        }
    }
    
    // Get current user data for password verification
    $user_query = "SELECT * FROM users WHERE id = ?";
    $user_stmt = $conn->prepare($user_query);
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_data = $user_stmt->get_result()->fetch_assoc();
    
    // Process password change if requested
    $password_updated = false;
    if (!empty($new_password)) {
        // Verify current password
        if (empty($current_password) || !password_verify($current_password, $user_data['password'])) {
            $errors[] = "Current password is incorrect";
        }
        
        // Validate new password
        if (strlen($new_password) < 8) {
            $errors[] = "New password must be at least 8 characters long";
        }
        
        // Check if new password and confirmation match
        if ($new_password !== $confirm_password) {
            $errors[] = "New password and confirmation do not match";
        }
        
        $password_updated = true;
    }
    
    // Update profile if no errors
    if (empty($errors)) {
        // Begin transaction
        $conn->begin_transaction();
        
        try {
            // Update user data in database
            if ($password_updated) {
                // Update with new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE users SET username = ?, email = ?, name = ?, password = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("ssssi", $username, $email, $name, $hashed_password, $user_id);
            } else {
                // Update without changing password
                $update_query = "UPDATE users SET username = ?, email = ?, name = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("sssi", $username, $email, $name, $user_id);
            }
            
            $update_stmt->execute();
            
            // Commit transaction
            $conn->commit();
            
            // Update session variables
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $name;
            
            $success_message = "Profile updated successfully";
            
            // Redirect to profile page with success message
            $_SESSION['success_message'] = $success_message;
            header("Location: ../../pages/edit-profile.php");
            exit();
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $conn->rollback();
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}

// If there are errors, store them in session and redirect back to edit profile page
if (!empty($errors)) {
    $_SESSION['profile_errors'] = $errors;
    header("Location: ../../pages/edit-profile.php");
    exit();
}
?>