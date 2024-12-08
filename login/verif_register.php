<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/server.php';


$referer = strtok($_SERVER['HTTP_REFERER'], '?');

// var_dump($_POST);
// die();
if (!validateMandatoryParams($_POST, ['username', 'email', 'password', 'confirm_password'])) {
    returnError("Missing required fields", $referer, 400);
}

$db = getDatabaseConnection();
$collection = $db->spotify->users;


// Username validation
if (strlen($_POST['username']) < 3 || strlen($_POST['username']) > 20) {
    returnError("Username must be between 3 and 20 characters", $referer, 400);
}


// Email validation
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    returnError("Invalid email format", $referer, 400);
}


// Password validation
if (strlen($_POST['password']) < 8) {
    returnError("Password must be at least 8 characters long", $referer, 400);
}

if (!preg_match('/[A-Z]/', $_POST['password'])) {
    returnError("Password must contain at least one uppercase letter", $referer, 400);
}
if (!preg_match('/[0-9]/', $_POST['password'])) {
    returnError("Password must contain at least one number", $referer, 400);
}
// Password confirmation validation
if ($_POST['password'] !== $_POST['confirm_password']) {
    returnError("Passwords do not match", $referer, 400);
}

// Check if username is already taken
$username = $_POST['username'];

$usernameExists = $collection->findOne(['username' => $username]);

if ($usernameExists) {
    returnError("Username is already taken", $referer, 400);
}

// Check if email is already taken
$email = $_POST['email'];

$emailExists = $collection->findOne(['email' => $email]);

if ($emailExists) {
    returnError("Email is already taken", $referer, 400);
}

// Hash password
$password = $_POST['password'];
$salt = 'Chui un mec cool';
$password_hash = hash('sha256', $password . $salt);

// Insert user into database

$result = $collection->insertOne([
    'username' => $username,
    'email' => $email,
    'password' => $password_hash
]);


if ($result->getInsertedCount()) {
    header('location: /login/login.php');
} else {
    returnError("Failed to register user", $referer, 500);
}
