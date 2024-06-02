<?php
session_start(); // Start the session

require_once('mail/database.php');

// Check if session variables are set and not empty
if (!empty($_SESSION['fname']) && !empty($_SESSION['lname']) && !empty($_SESSION['email']) && !empty($_SESSION['password']) ) {
    // Get the current date and time
    $currentDateTime = date('Y-m-d H:i:s');

    // Prepare the SQL statement with placeholders
    $query = $mysqli->prepare('INSERT INTO users (fname, lname, mail, password, created_at) VALUES (?, ?, ?, ?, ?)');

    // Bind parameters to the placeholders
    $query->bind_param('sssss', $_SESSION['fname'], $_SESSION['lname'], $_SESSION['email'], $_SESSION['password'], $currentDateTime);

    // Execute the query
    $query->execute();

    // Check for success
    if ($query->affected_rows > 0) {
        echo '<script>alert("Account created successfully");</script>';
        echo '<script>window.location.href="../../pages/login.php";</script>';
    } else {
        // Handle error
        echo "Error creating account: " . $mysqli->error;
    }

    // Close the statement
    $query->close();
} else {
    // Handle empty session variables
    echo "Error: One or more session variables are empty.";
}
?>
