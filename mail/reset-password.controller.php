<?php

$token = $_GET["token"];

$token_hash = hash("sha256", $token);

$mysqli = require('../mail/database.php');

$sql = "SELECT * FROM users
        WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null) {
    echo '<script>alert("Token not found");</script>';
    echo '<script>window.location.href="forgot-password.php";</script>';
    exit;
}

if (strtotime($user["reset_token_expires_at"]) <= time()) {
    echo '<script>alert("Token has expired please enter your email again");</script>';
    echo '<script>window.location.href="forgot-password.php";</script>';
    exit;
}

?>