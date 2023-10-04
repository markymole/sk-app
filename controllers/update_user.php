<?php
require_once '../config/autoload.php';

$user = new Users();

if (isset($_SESSION['user_id']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['barangay']) && isset($_POST['role']) && isset($_POST['gender'])) {
    $userId = $_SESSION['user_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $barangay = $_POST['barangay'];
    $role = $_POST['role'];
    $gender = $_POST['gender'];

    if ($user->updateUserInfo($userId, $firstName, $lastName, $username, $barangay, $role, $gender, $email)) {
        $response = ['success' => true];
    } else {
        $response = ['success' => false];
    }

    // Send JSON response back to the client
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    $response = ['success' => false];
    header('Content-Type: application/json');
    echo json_encode($response);
}
