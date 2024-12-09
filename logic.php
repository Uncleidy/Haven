<?php
session_start();

// Include the database connection
require_once 'db.php';

// Initialize variables
$policy_found = false;
$policy_error = ''; // Store error message
$login_error = ''; // Admin login error

// Handle the policy check logic after form submission
if (isset($_POST['check_policy'])) {
    $name = $_POST['name'] ?? '';
    $postcode = $_POST['postcode'] ?? '';

    // Query to check if a policy exists for the given name and postcode
    $stmt = $conn->prepare("SELECT * FROM policies WHERE name = ? AND postcode = ?");
    $stmt->bind_param("ss", $name, $postcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Policy found, fetch the result
        $policy = $result->fetch_assoc();
        $policy_found = true;
    } else {
        // No policy found
        $policy_error = "No valid policy found for the provided details.";
    }

    // Close the statement
    $stmt->close();
}

// Admin login functionality
if (isset($_POST['admin_login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Admin credentials check
    if ($username === 'admin' && $password === 'password123') {
        $_SESSION['admin_logged_in'] = true;
        header("Location: index.php?admin_dashboard");
        exit;
    } else {
        $login_error = "Invalid username or password.";
    }
}
?>
