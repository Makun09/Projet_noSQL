<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/server.php';

$referer = strtok($_SERVER['HTTP_REFERER'], '?');

// Validate that required fields are present
if (!validateMandatoryParams($_POST, ['username', 'password'])) {
    returnError("Missing required fields", $referer, 400);
}

$db = getDatabaseConnection();
$collection = $db->spotify->users;



// Get user input
$username = $_POST['username'];

// Hash password
$password = $_POST['password'];
$salt = 'Chui un mec cool';
$password_hash = hash('sha256', $password . $salt);

// Find user in database
$user = $collection->findOne([
    'username' => $username,
    'password' => $password_hash
]);


// Check if user exists and password matches
if ($user) {
    // Start session and store user information
    session_start();
    $_SESSION['user_id'] = (string)$user->_id;
    $_SESSION['username'] = $user->username;
    $_SESSION['email'] = $user->email;
    $_SESSION['is_artist']=$user->is_artist ?? false;
    $_SESSION['artist_id'] = $user->artist_id ?? null;


    // Redirect to home page or dashboard
    header('location: /index.php');
} else {
    // Return error if login fails
    returnError("Invalid username or password", $referer, 401);
}
